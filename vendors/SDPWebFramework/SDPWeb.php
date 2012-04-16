<?php

require_once 'WebRequest.php';
require_once 'SDPDevice.php';

/**
 * Class that provides a simple interface to the SDP application API
 */
class SDPWeb {

    private $web;
    public $appInterfaceURL;
    public $serverRootURL;
    public $access_token;
    public $householdId;
    public $apiKey;
    public $apiSecret;
	public $deviceId;

	private $devices;

    public function __construct($appInterfaceURL = null, $apiKey = null, $apiSecret = null) {
        $this->web = new WebRequest();
        if ($appInterfaceURL) {
            $this->appInterfaceURL = $appInterfaceURL;
        } else {
            $this->appInterfaceURL = 'https://api.sdp.nds.com/v1.1';
        }

        $offset = strpos($this->appInterfaceURL, '://');
        if ($offset) {
            $offset = strpos($this->appInterfaceURL, '/', $offset + 3);
            if ($offset)
                $this->serverRootURL = substr($this->appInterfaceURL, 0, $offset);
            else
                $this->serverRootURL = $this->appInterfaceURL;
        }
        
        $this->householdId = null;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
		$this->access_token(); // get the access token from the cookies
    }

    // Send the user to this URL so that they can log in.
    public function loginUrl() {
        return "{$this->serverRootURL}/oauth/authorize?client_id={$this->apiKey}";
    }

    public function logoutUrl() {
        return "index.php?logout=true";
    }

    // When the user has logged in and granted permission to your app, they will be
    // sent back to the application URL that you've supplied in the developer portal.
    // Get the code value from the URL ($_GET['code']) and call this method with the code.
    public function authorize($code) {
        $auth_url = "{$this->serverRootURL}/oauth/access_token?grant_type=authorization_code&code=$code&client_id=$this->apiKey&client_secret=$this->apiSecret";
        $request = new WebRequest();
        try {
            $json = $request->httpGet($auth_url);
            if ($json)
                $this->set_access_token($json);
        } catch (Exception $exception) {
            echo("Could not authorize: $exception");
        }
    }

    // If the access token has expired, this method will be called to reauthorize
    // and get a new access token. You can also call it yourself at any time.
    public function reauthorize() {
        $refresh_token = $_COOKIE['refresh_token'];
		$auth_url = "{$this->serverRootURL}/oauth/access_token?grant_type=refresh_token&refresh_token=$refresh_token&client_id=$this->apiKey&client_secret=$this->apiSecret";
		$request = new WebRequest();
        try {
            $json = $request->httpGet($auth_url);
            if ($json)
                $this->set_access_token($json);
        } catch (Exception $exception) {
            echo("Could not authorize: $exception");
        }
    }

    // Call this method to log out by clearing the access token.
    public function deauthorize() {
        setcookie('access_token', null, time() - 3600);
        setcookie('refresh_token', null, time() - 3600);

        $_COOKIE['access_token'] = null;

        $this->access_token = null;
    }

    // Returns whether the user is logged in.
    public function loggedIn() {
        return $this->access_token != null;
    }

    private function access_token() {
        if (!isset($this->access_token)) {
            if (isset($_COOKIE['access_token']) && !empty($_COOKIE['access_token'])) {
                $this->access_token = $_COOKIE['access_token'];
            } else if (isset($_COOKIE['refresh_token'])) {
				$this->reauthorize();
            }
        }

        return $this->access_token;
    }

    private function set_access_token($json) {
        $response = json_decode($json);
        $expires = time() + $response->expires_in;
        $one_month = time() + 86400 * 30;

        $this->access_token = $response->access_token;

        setcookie('access_token', $this->access_token, $expires);
        setcookie('refresh_token', $response->refresh_token, $one_month);
    }

	function perform_auth_action() {
		if (isset($_GET['code'])) {
			$this->authorize($_GET['code']);
			//header('Location: index.php');
			//exit(); // if redirecting, don't continue executing PHP or JavaScript code
		} else if (isset($_GET['logout'])) {
			$this->deauthorize();
		}
	}

	function requiresAuthorization() {
		return strpos($this->appInterfaceURL, 'app-interface') === false;
	}

	function redirectToAuthPage() {
		if ($this->requiresAuthorization() && !$this->loggedIn()) {
			header("Location: " . $this->loginUrl());
			exit(); // if redirecting, don't continue executing PHP or JavaScript code
		}
	}

    function perform_action() {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            if (isset($_GET['deviceId']))
                $deviceId = $_GET['deviceId'];

            if ($action == 'watch') {
                $channelId = $_GET['channelId'];
                $this->changeChannel($deviceId, $channelId);
            } else if ($action == 'scrub') {
                $position = $_GET['position'];
                $this->setPlayoutPosition($deviceId, $position);
            } else if ($action == 'record') {
                $this->addScheduleInfoToPlanner($deviceId, $_GET);
            } else if ($action == 'play') {
                $plannerId = $_GET['plannerId'];
                $this->playPlannerItem($deviceId, $plannerId);
            } else if ($action == 'pause') {
                $this->pause($deviceId);
            } else if ($action == 'resume') {
                $this->resume($deviceId);
            } else if ($action == 'speed') {
                $speed = $_GET['speed'];
                $this->changeSpeed($deviceId, $speed);
            } else if ($action == 'stop') {
                $this->stop($deviceId);
            } else if ($action == 'delete') {
                $plannerId = $_GET['plannerId'];
                $this->deletePlannerItem($deviceId, $plannerId);
            } else if ($action == 'keep') {
                $plannerId = $_GET['plannerId'];
                $keep = $_GET['keep'];
                $this->setPlannerKeep($deviceId, $plannerId, $keep);
            } else if ($action == 'longpoll') {
                $url = trim($_GET['url']);

                $headers = array();
				$json = array();

                $if_none_match = isset($_GET['etag']) ? $_GET['etag'] : null;
                if ($if_none_match)
                    $headers[] = "If-None-Match: $if_none_match";

                $if_modified_since = isset($_GET['lastModified']) ? $_GET['lastModified'] : null;
                if ($if_modified_since)
                    $headers[] = "If-Modified-Since: $if_modified_since";

                if ($headers)
                    $this->web->setRequestHeader($headers);
				
                try {
                    $notification = $this->longpoll($url);

                    $message = $notification->message;
                    if (isset($message)) {
                        if ($message['type'] != 'system.init') {
							$url = $message['url'];
							$urlComponents = explode('/', $url);
							if ($urlComponents[1] == 'devices')
								$deviceId = $urlComponents[2];
							else
								$deviceId = 0;

							$json['deviceId'] = "$deviceId";
							$json['context'] = contextForPlayout($message->playout);
                        }
                    }
                } catch (Exception $e) {
                    $json['error'] = "$e";
                }

                // For every message
                $etag = null;
                if (isset($this->web->headers) && array_key_exists('Etag', $this->web->headers)) {
                    $etag = urlencode($this->web->headers['Etag']);
                } else if ($if_none_match) {
                    $etag = urlencode($if_none_match);
                }
                if ($etag) {
                    $json['etag'] = $etag;
                }

                $lastModified = null;
                if (isset($this->web->headers) && array_key_exists('Last-Modified', $this->web->headers)) {
                    $lastModified = urlencode($this->web->headers['Last-Modified']);
                } else if ($if_modified_since) {
                    $lastModified = urlencode($if_modified_since);
                }
                if ($lastModified) {
                    $json['lastModified'] = $lastModified;
                }

				echo(json_encode($json));
            } else if ($action == 'unsubscribe') {
                $url = $_GET['url'];
                $this->unsubscribe($url);
            }
        }
    }

    public function getPlatformSchedule($parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/platform/schedule';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformChannels($parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/platform/channels';

        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformChannel($channelId, $parameters = null) {
        $URL = $this->appInterfaceURL . '/platform/channels/' . $channelId;
        $this->appendParametersTo($URL, $parameters);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformChannelSchedule($channelId, $parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/platform/channels/' . $channelId . '/schedule';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformChannelScheduleInstance($channelId, $instanceId, $instanceType, $parameters = null) {
        $URL = $this->appInterfaceURL . '/platform/channels/' . $channelId . '/schedule/' . $instanceType . '-' . $instanceId;
        $this->appendParametersTo($URL, $parameters);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformContentList($parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/platform/content';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformContent($contentId, $parameters = null) {
        $URL = $this->appInterfaceURL . '/platform/content/' . $contentId;
        $this->appendParametersTo($URL, $parameters);
        $key = md5($URL);
        if(($xml=Cache::read($key,'content'))!==false){
        	return new SimpleXMLElement($xml);
        }else{
        	$xml = $this->web->httpGet($URL);
        	Cache::write($key,$xml,'content');
        	return new SimpleXMLElement($xml);
        }
    }

    public function getPlatformContentChildrenList($contentId, $parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/platform/content/' . $contentId . '/content';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformContentAvailability($contentId, $parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/platform/content/' . $contentId . '/availability';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlatformAvailabilityInstance($contentId, $instanceId, $instanceType, $parameters = null) {
        $URL = $this->appInterfaceURL . '/platform/content/' . $contentId . '/availability/' . $instanceType . '-' . $instanceId;
        $this->appendParametersTo($URL, $parameters);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPeopleList($parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/people';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPerson($personId, $parameters = null) {
        $URL = $this->appInterfaceURL . '/people/' . $personId;
        $this->appendParametersTo($URL, $parameters);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPersonContent($personId, $parameters = null, $limit = 0, $offset = 0) {
        $URL = $this->appInterfaceURL . '/people/' . $personId . '/content';
        $this->appendParametersTo($URL, $parameters);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlayout($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlayoutSpeed($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout/speed';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlayoutPosition($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout/position';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlayoutVolume($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout/volume';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function changeChannel($stbId, $channelId) {
        $xml = "<?xml version=\"1.0\"?><playout><channel id=\"$channelId\"/></playout>";
        $this->putPlayout($stbId, $xml);
    }

    public function putPlayout($stbId, $xml) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout';
        $this->appendParametersTo($URL, null);
        $this->web->httpPut($URL, $xml);
        return;
    }

    public function putPlayoutSpeed($stbId, $xml) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout/speed';
        $this->appendParametersTo($URL, null);
        $this->web->httpPut($URL, $xml);
        return;
    }

    public function setPlayoutPosition($stbId, $position) {
        $xml = "<?xml version=\"1.0\"?><playout><playerState><position>$position</position></playerState></playout>";
        $this->putPlayoutPosition($stbId, $xml);
    }

    public function putPlayoutPosition($stbId, $xml) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout/position';
        $this->appendParametersTo($URL, null);
        $this->web->httpPut($URL, $xml);
        return;
    }

    public function putPlayoutVolume($stbId, $xml) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/playout/volume';
        $this->appendParametersTo($URL, null);
        $this->web->httpPut($URL, $xml);
        return;
    }

    public function getViewed($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/control/viewed';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlanner($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/planner';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getPlannerItem($stbId, $plannerInstanceId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/planner/' . $plannerInstanceId;
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return (($xml != false) && ($desiredHttpReturn == '200')) ? (new SimpleXMLElement($xml)) : null;
    }

    public function setPlannerKeep($stbId, $plannerInstanceId, $keep) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/planner/' . $plannerInstanceId;
        $this->appendParametersTo($URL, null);
        $this->web->httpPut($URL, "<plannerInstance><keep>$keep</keep></plannerInstance>");
        return;
    }

    public function addScheduleToPlanner($stbId, $schedule) {
        $scheduleId = $schedule['id'];

        $xml = "<?xml version=\"1.0\"?>
		<plannerInstance>
                    <scheduleInstance id=\"$scheduleId\" />
                    <keep>true</keep>
		</plannerInstance>";

        $this->addPlannerItem($stbId, $xml);
    }

    public function addScheduleInfoToPlanner($stbId, $scheduleInfo) {
        $scheduleId = $scheduleInfo['scheduleId'];

        $xml = "<?xml version=\"1.0\"?>
		<plannerInstance>
                    <scheduleInstance id=\"$scheduleId\" />
                    <keep>true</keep>
		</plannerInstance>";

        // echo $xml;

        $this->addPlannerItem($stbId, $xml);
    }

    public function addPlannerItem($stbId, $postXML) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/planner';
        $this->appendParametersTo($URL, null);
        $this->web->httpPost($URL, $postXML);
        return;
    }

    public function playPlannerItem($stbId, $plannerInstanceId) {
        $xml = "<?xml version=\"1.0\"?><playout><plannerInstance id=\"$plannerInstanceId\"/></playout>";
        $this->putPlayout($stbId, $xml);
    }

    public function pause($stbId) {
        $xml = "<?xml version=\"1.0\"?><playout><playerState><playbackSpeed>0.0</playbackSpeed></playerState></playout>";
        $this->putPlayoutSpeed($stbId, $xml);
    }

    public function resume($stbId) {
        $xml = "<?xml version=\"1.0\"?><playout><playerState><playbackSpeed>1.0</playbackSpeed></playerState></playout>";
        $this->putPlayoutSpeed($stbId, $xml);
    }

    public function changeSpeed($stbId, $speed) {
        $xml = "<?xml version=\"1.0\"?><playout><playerState><playbackSpeed>$speed</playbackSpeed></playerState></playout>";
        $this->putPlayoutSpeed($stbId, $xml);
    }

    public function stop($stbId) {
        $xml = "<?xml version=\"1.0\"?><playout><playerState><playbackSpeed>0.0</playbackSpeed></playerState></playout>";
        $this->putPlayoutSpeed($stbId, $xml);
    }

    public function deletePlannerItem($stbId, $plannerInstanceId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/planner/' . $plannerInstanceId;
        $this->appendParametersTo($URL, null);
        $this->web->httpDelete($URL, null);
        return;
    }

    public function deviceId() {
        if (!isset($this->deviceId)) {
            try {
                $devices = $this->getDevices(1, 0);
                $device = $devices->device;
                if ($device)
                    $this->deviceId = $device['id'];
            } catch (Exception $e) {
                return null;
            }
        }

        return $this->deviceId;
    }

	// get the list of SDP device objects
	public function devices() {
		if (!isset($this->devices)) {
			$this->devices = array();
			try {
				$deviceNodes = $this->getDevices(100, 0);
								
				if ($deviceNodes) {
					foreach ($deviceNodes as $deviceNode) {
						$deviceId = $deviceNode['id'];
						$this->devices["$deviceId"] = new SDPDevice($this, $deviceNode);
					}
				}
			} catch (Exception $e) {

			}
		}
		
		return $this->devices;
	}

	public function defaultDevice() {
		foreach ($this->devices() as $device) {
			return $device; // return the first one
		}

		return null;
	}

	public function context() {
		$devices = $this->devices();
		$context = array();

		foreach ($devices as $device) {
			$context["$device->deviceId"] = $device->context();
		}

		return $context;
	}

    public function getDevices($limit, $offset) {
        $URL = $this->appInterfaceURL . '/devices';
        $this->appendParametersTo($URL, null);
        $this->appendPaginationTo($URL, $limit, $offset);
        $xml = $this->web->httpGet($URL);
        return ($xml != false) ? (new SimpleXMLElement($xml)) : null;
    }

    public function getPresence($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/presence';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

    public function getCapabilities($stbId) {
        $URL = $this->appInterfaceURL . '/devices/' . $stbId . '/capabilities';
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpGet($URL);
        return new SimpleXMLElement($xml);
    }

	// This script can be used to subscribe to updates for all devices.
	// To subscribe to updates for a single device, call echo($device->subsribeScript());
	function subscribeScript($json = false) {
		$notificationChannel = null;
        $longpollUrl = null;
		$unsubscribeUrl = null;
		$contexts = $this->context();
		$devicesJSON = json_encode($contexts);
		
		foreach ($this->devices() as $deviceId => $device) {
			if ($device->isOn()) {
				$subscribe = $this->subscribeInstant("/devices/{$device->deviceId}/control/playout", 201);
				if (isset($subscribe->notificationChannel) && !$notificationChannel) $notificationChannel = $subscribe->notificationChannel;
				// echo "\n(" . $device->deviceId . ": " . $subscribe->notificationChannel->longpoll . ')'; // these should be the same but in fact they are different...
			}
		}

		// the longpoll and unsubscribe URLs are the same for all devices, so we only need to use the first one.
		if ($notificationChannel) {
		    $longpollUrl = urlencode($notificationChannel->longpoll);
		    $unsubscribeUrl = urlencode($notificationChannel->delete);
			
			if (!$json) {
				return "<script>\n\tlongpollUrl = '$longpollUrl';\n\tunsubscribeUrl = '$unsubscribeUrl';\n\tdevices = $devicesJSON;\n</script>";
			}
		} else if (!$json) {
			return "<script>\n\tdevices = $devicesJSON;\n</script>";
		}
		
		return array(
			'longpoll_url'		=> $longpollUrl,
			'unsubscribe_url'	=> $unsubscribeUrl,
			'devices'			=> $this->devices()
		);
	}

    public function subscribe($endpoint, $postXML, $code) {
        $URL = $this->appInterfaceURL . $endpoint;
        $this->appendParametersTo($URL, null);
        $xml = $this->web->httpPost($URL, $postXML, $code);
        // echo "\n subscribe resp[$xml]";
        return new SimpleXMLElement($xml);
    }

    public function subscribeType($endpoint, $type, $code) {
        $URL = $this->appInterfaceURL . $endpoint;
        $this->appendParametersTo($URL, null);
        $postXML = '<?xml version="1.0" encoding="utf-8"?><notificationSubscription><type>' . $type . '</type></notificationSubscription>';
        $xml = $this->web->httpPost($URL, $postXML, $code);
        return new SimpleXMLElement($xml);
    }

    public function subscribeInstant($endpoint, $code) {
        $URL = $this->appInterfaceURL . $endpoint;
        $this->appendParametersTo($URL, null);
        $postXML = '<?xml version="1.0" encoding="utf-8"?><notificationSubscription><type>Instant</type></notificationSubscription>';
        $xml = $this->web->httpPost($URL, $postXML, $code);
        return new SimpleXMLElement($xml);
    }

    public function longpoll($url) {
        $this->web->setTimeout(0);
        $this->web->getRequestHeader(true);
        $xml = $this->web->httpGet($url);
        return new SimpleXMLElement($xml);
    }

    public function unsubscribe($url) {
        $URL = $url;
        $this->appendParametersTo($URL, null); // Need oauth token
        $resp = $this->web->httpDelete($URL, null);
    }

    // Utility methods
    private function appendParametersTo(&$URL, $parameters) {
        if (!isset($parameters))
            $parameters = array();

        if ($this->access_token)
            $parameters['oauth_token'] = $this->access_token;
        if ($this->householdId)
            $parameters['householdId'] = $this->householdId;

        if (count($parameters)) {
            if ($URL[strlen($URL) - 1] != '?') {
                $URL .= '?';
            }
            foreach ($parameters as $name => $value) {
                $this->appendParameterTo($URL, $name, $value);
            }
        }
    }

    private function appendParameterTo(&$URL, $name, $value) {
        if ($value) {
            $URL .= '&' . $name . '=' . $value;
        }
    }

    private function appendPaginationTo(&$URL, $limit, $offset) {
		if ($limit > 255) $limit = 255;

        $this->appendParameterTo($URL, 'limit', $limit);
        $this->appendParameterTo($URL, 'offset', $offset);
    }
}

function imageUrl($xml) {
	$presentationMedia = $xml->presentationMedia;
	if ($presentationMedia)
		return $presentationMedia->media->uri;
	else
		return null;
}

function contextForPlayout($playout) {
	$context = array();
	$scheduleInstance = null;

	if (isset($playout->playerState)) {
		$playerState = $playout->playerState;

		$playbackSpeed = $playerState->playbackSpeed;
		if (isset($playbackSpeed)) $context['playbackSpeed'] = 1.0 * $playbackSpeed;

		$position = $playerState->position;
		if (isset($position)) {
			$position = 1.0 * $position;
			if ($position > 1000 && $position % 1000 == 0) $position = $position / 1000; // if we get milliseconds, convert to seconds
			$context['position'] = $position;
		}
	}

    if (isset($playout->scheduleInstance)) {
		$context['type'] = 'Live';

        $scheduleInstance = $playout->scheduleInstance;
    } else if (isset($playout->plannerInstance)) {
		$context['type'] = 'Disk';

		$plannerInstance = $playout->plannerInstance;
		$scheduleInstance = $plannerInstance->scheduleInstance;

        $plannerId = $plannerInstance['id'];
		if (isset($plannerId)) $context['plannerId'] = "$plannerId";
    } else {
		$context['type'] = 'Off';
	}

	if (isset($scheduleInstance)) {
        $scheduleId = $scheduleInstance['id'];
		if (isset($scheduleId)) $context['scheduleId'] = "$scheduleId";

		$duration = $scheduleInstance->duration;
		if (isset($duration)) $context['duration'] = "$duration";

		$channel = $scheduleInstance->channel;
		if (isset($channel)) {
			$channelId = $channel['id'];
			if (isset($channelId)) $context['channelId'] = "$channelId";

			$channelName = $channel->name;
			if (isset($channelName)) $context['channelName'] = "$channelName";

			$channelNumber = $channel['number'];
			if (isset($channelNumber)) $context['channelNumber'] = "$channelNumber";

			$channelImage = imageUrl($channel);
			if (isset($channelImage)) $context['channelImage'] = "$channelImage";
		}

		$content = $scheduleInstance->content;
		if (isset($content)) {
			$contentId = $content['id'];
			if (isset($contentId)) $context['contentId'] = "$contentId";

			$contentTitle = $content->title;
			if (isset($contentTitle)) $context['contentTitle'] = "$contentTitle";

			$series = $content->content;
			if (isset($series)) {
				$seriesTitle = $series->title;
				if (isset($seriesTitle)) $context['seriesTitle'] = "$seriesTitle";
			}

			$contentImage = imageUrl($content);
			if (isset($contentImage)) $context['contentImage'] = "$contentImage";
			
			$contentSynopsis = $content->synopsis;
			if (isset($contentSynopsis)) $context['contentSynopsis'] = "$contentSynopsis";
			
		}
	}

	return $context;
}

function formattedTime($position) {
    $hours = ($position / 3600) % 24;
    $minutes = ($position / 60) % 60;
    $seconds = ($position) % 60;

    $time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    return $time;
}

function formattedSpeed($speed) {
	if ($speed == 1) return 'playing';
	else if ($speed == 0) return 'paused';
	else if ($speed > 1) return 'fast forward ' . $speed . 'x';
	else if ($speed < 0) return 'reverse ' . ($speed * -1) . 'x';
	else return 'slow ' . $speed . 'x';
}

function substringToString($haystack, $needle) {
    $index = strpos($haystack, $needle);
    if ($index)
        $haystack = substr($haystack, 0, $index);
    return $haystack;
}

function javascriptLink($code, $text) {
    return "<a href=\"#\" onClick=\"$code\">$text</a>";
}

function getCookieValue($key, $default) {
    if (isset($_GET[$key])) { // if the value was passed in the URL, use the value and set the cookie
        $value = $_GET[$key];
        setcookie($key, $value, time() + 86400 * 60);
    } else if (isset($_COOKIE[$key])) { // if the value was saved in a cookie, use that
        $value = $_COOKIE[$key];
    } else { // otherwise use the default value
        $value = $default;
    }

    return $value;
}

?>
