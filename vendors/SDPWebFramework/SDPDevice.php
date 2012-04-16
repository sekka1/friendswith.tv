<?php


require_once 'SDPWeb.php';

/*
 * This is a high-level wrapper that encapsulates the state of a set-top box device.
 * It uses the SDPWeb class to call the SDP application API.
 */

class SDPDevice {
	private $sdp;
	
	public $deviceId;
	public $name;
	public $status;
	public $profile;
	public $time;
	public $timezone;
	
	public $capabilities;
	public $apis;
	public $features;
	
	public $planner;
	public $playout;
	public $context;
	
	// to get an array of SDPDevice objects, call $sdp->devices().
	public function __construct($sdp, $deviceNode) { 
		$this->sdp = $sdp;
		$this->deviceId = (string) $deviceNode['id'];
		$this->name = (string) $deviceNode->name;
		
		if (isset($deviceNode->presence)) {
			$this->status = (string) $deviceNode->presence->status;
		}
		
		if (isset($deviceNode->time)) {
			$this->time = (string) $deviceNode->time->now;
			$this->timezone = (string) $deviceNode->time->zone;
		}

		if (isset($deviceNode->capabilities) && isset($deviceNode->capabilities->profile)) {
			$this->profile = (string) $deviceNode->capabilities->profile->name;
		}
	}
	
	public function isOn() {
		return "{$this->status}" == 'on';
	}
	
	public function capabilities() {
		if (!isset($this->capabilities)) {
			$this->capabilities = $this->sdp->getCapabilities($this->deviceId);
			$this->apis = $this->capabilities->apis;
			$this->features = array();
			
			foreach ($this->capabilities->features->feature as $feature) {
		        $this->features[] = $feature['type'];
		    }
		}
		
		return $this->capabilities;
	}
	
	public function features() {
		if (!isset($this->features)) $this->capabilities();
		return $this->features;
	}
	
	public function apis() {
		if (!isset($this->apis)) $this->capabilities();
		return $this->apis;
	}

	public function planner() {
		if (!isset($this->planner)) {
			$this->planner = $this->sdp->getPlanner($this->deviceId);
		}
		
		return $this->planner;
	}
	
	public function playout() {
		if (!isset($this->playout)) {
			try {
				$this->playout = $this->sdp->getPlayout($this->deviceId);
			} catch (Exception $e) {
				$this->context = array();
				$this->context['type'] = "Error";
				$this->status = 'unknown';
			}
		}
		
		return $this->playout;
	}
	
	// returns an array with relevant values from the playout
	public function context() {
		if (!isset($this->context)) {
		
			$this->context = array();
		
			if ($this->isOn()) {
				$playout = $this->playout();
				
				$this->context = contextForPlayout($playout);
				
			} else {
				$this->context['type'] = "Off";
			}
		}

		return $this->context;
	}

	public function isPlaying() {
		$context = $this->context();
		if (!isset($context) || !isset($context['playbackSpeed'])) return false;
		return $context['playbackSpeed'] == 1;
	}

	// This script can be used to subscribe to updates for this device.
	// To subscribe to updates for all devices, call echo($sdp->subsribeScript());
	public function subscribeScript() {
		if ($this->isOn()) { 
			$subscribe = $this->sdp->subscribeInstant("/devices/{$this->deviceId}/control/playout", 201);
		}

		if (isset($subscribe->notificationChannel)) {
		    $notificationChannel = $subscribe->notificationChannel;
		    $longpollUrl = urlencode($notificationChannel->longpoll);
		    $unsubscribeUrl = urlencode($notificationChannel->delete);
			$devicesContext = array("$this->deviceId" => $this->context());
			$devicesJSON = json_encode($devicesContext);

			return "<script>\n\tlongpollUrl = '$longpollUrl';\n\tunsubscribeUrl = '$unsubscribeUrl';\n\tdevices = $devicesJSON;\n</script>";
		} else {
			return '';
		}
	}

}

?>