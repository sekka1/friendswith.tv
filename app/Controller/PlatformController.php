<?php 
class PlatformController extends AppController {
	
	public $uses = array();
	
	function content($content_id){

		$contentXml = $this->sdp->getPlatformContent($content_id);
		//debug($contentXml->asXML());
		//debug($contentXml);
		$content = array();
		foreach($contentXml->attributes() as $a => $b){
			$content[$a] = $b;
		}
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