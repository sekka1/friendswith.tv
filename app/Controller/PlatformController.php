<?php 
App::uses('Rovi','Lib');
class PlatformController extends AppController {
	
	public $uses = array();
	
	function index(){
		$gridschedule = false;
		//$service_id = $this->Cookie->read('service_id');
		$service_id = @$_COOKIE['service_id'];
		if(!empty($service_id)){
			$rovi = new Rovi();
			$gridschedule = $rovi->gridschedule($service_id);
			//debug($gridschedule);
			$gridschedule = json_decode($gridschedule,true);
			$gridschedule = $gridschedule['GridScheduleResult'];
			$this->Session->setFlash('Found service provider');
		}else{
			$this->Session->setFlash('Could not find service provider');
		}
		$this->set(compact('gridschedule','service_id'));
	}
	
	function _grid_rovi(){}
	function _grid_sdp(){
	}
	
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
	
	function channels()
	{
		
	}
	
	function services($zip_code=null){
		$services = false;
		if($zip_code){
			App::uses('Rovi','Lib');
			$rovi = new Rovi();
			$services = $rovi->services($zip_code);
			$services = json_decode($services,true);
			$services = $services['ServicesResult']['Services']['Service'];
		}
		$this->set(compact('services'));
	}
	
	function set_service($mso_id,$service_id){
		$this->Session->set('mso_id',$mso_id);
		$this->Session->set('service_id',$service_id);
	}
}
?>