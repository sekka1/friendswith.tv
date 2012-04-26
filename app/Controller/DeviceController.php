<?php 
class DeviceController extends AppController {
	
	public $uses = array('Device');
	
	public $scaffold = 'admin';
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	
	function context(){
		$this->_sdp_init();
		//$devices = $this->sdp->devices();
		$devices = $this->sdp->devices();
		$this->log($devices,'devices');
		
		//debug($this->sdp);
		//debug($devices);
		//$this->log($devices,'devices');
		//$this->set('sdp',$this->sdp); 
		$this->set(compact('devices'));
	}
	
	function position(){
		if($this->request->is('get')){
			
		}else if($this->request->is('post')){
			
		}
	}
	
	function action(){
		$this->autoRender = false;
		$this->sdp->perform_action();
	}
	
	function channels($device_id){
		//$this->autoRender = false;
		//$channels = $this->sdp->getPlatformChannels(null, 200, 0);
		//debug($channels);
		
	}
}
?>