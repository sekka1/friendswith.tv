<?php 
class DeviceController extends AppController {
	
	public $uses = array('Device');
	
	public $scaffold = 'admin';
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	
	function context(){
		//$this->_sdp_init();
		$devices = $this->sdp->devices();
		//debug($this->sdp);
		//debug($devices);
		$this->set('sdp',$this->sdp); 
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
}
?>