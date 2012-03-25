<?php 
class PlatformController extends AppController {
	
	public $uses = array();
	
	function content($content_id){

		$contentXml = $this->sdp->getPlatformContent($content_id);
		//debug($contentXml->asXML());
		//die();
		//debug($this->sdp);
		//debug($devices);
		//debug($contentXml);
		//$this->set('sdp',$this->sdp); 
		//$this->set(compact('contentXml'));
	}
	function action(){
		$this->autoRender = false;
		$this->sdp->perform_action();
	}
}
?>