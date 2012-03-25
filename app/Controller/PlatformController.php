<?php 
class PlatformController extends AppController {
	
	public $uses = array();
	
	function content($content_id){
		App::import('Libs','SDPContent');
		$contentXml = $this->sdp->getPlatformContent($content_id);
		
		//$oContent = new SDP_Content($contentXml);
		//debug($contentXml->asXML());
		//debug($contentXml);
		$content = array();
		foreach($contentXml->attributes() as $a => $b){
			$content[$a] = $b;
		}
		$this->log(var_export($contentXml,true));
		$content['title'] = $contentXml->content->title;
		$content['synopsis'] = $contentXml->content->synopsis;
		//die();
		$this->set(compact('content'));
	}
	function action(){
		$this->autoRender = false;
		$this->sdp->perform_action();
	}
}
?>