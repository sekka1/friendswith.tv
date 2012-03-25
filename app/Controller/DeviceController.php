<?php 
class DeviceController extends AppController {
	
	public $uses = array();
	
	function context(){
		//$this->_sdp_init();
		$devices = $this->sdp->devices();
		//debug($this->sdp);
		//debug($devices);
		$this->set('sdp',$this->sdp); 
		$this->set(compact('devices'));
	}
	function action(){
		$this->autoRender = false;
		$this->sdp->perform_action();
	}
}
?>