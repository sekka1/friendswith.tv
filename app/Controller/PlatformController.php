<?php 
class PlatformController extends AppController {
	
	public $uses = array();
	
	function content($content_id){
		App::import('Libs','SDPContent');
		$contentXml = $this->sdp->getPlatformContent($content_id);
		
		//$oContent = new SDP_Content($contentXml);
		//debug($contentXml->asXML());
		//debug($contentXml);
		$content = array('type'=>null);
		foreach($contentXml->attributes() as $a => $b){
			$content[$a] = (string) $b;
		}
		
		//$this->log(print_r($contentXml,true));
		
		switch($content['type']){
			default:
				$content['title'] = (string)$contentXml->content->title;
				$content['synopsis'] =(string) $contentXml->synopsis;
		}
		
		//yearOfRelease
		//die();
		$this->set(compact('content'));
	}
	function action(){
		$this->autoRender = false;
		$this->sdp->perform_action();
	}
	
	function _cache_content($content_id = null){
		$key=md5($this->here);
		
	}
}
?>