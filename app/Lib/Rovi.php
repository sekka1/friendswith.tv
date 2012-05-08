<?php 
App::uses('HttpSocket','Network/Http');
class Rovi {
	
	var $apiBaseUrl = '';
	var $apiKey = '2x299srgs39qa57vrvvwaqgc';
	var $apiSecret = 'M26g4bdtjY';
	var $params = array(
		'format'=>'json',
		'locale'=>'en-US',
		'apikey'=>'2x299srgs39qa57vrvvwaqgc',
		'countrycode'=>'US'
		
	);
	
	function __construct(){
		
	}
	
	function services($zip_code='94116'){
		if(($response = Cache::read($zip_code,'services'))===false){
			$url = 'http://api.rovicorp.com/TVlistings/v9/listings/services/postalcode/';
			$url .=$zip_code;
			$url .='/info';
			$response = $this->_request($url,$this->params);
			if($response){
				Cache::write($zip_code,$response,'services');
			}
		}
		return $response;    
	}
	
	function serviceDetail($service_id){
		if(($response = Cache::read($zip_code,'services'))===false){
			$url = 'http://api.rovicorp.com/TVlistings/v9/listings/services/postalcode/';
			$url .=$zip_code;
			$url .='/info';
			$response = $this->_request($url,$this->params);
			if($response){
				Cache::write($zip_code,$response,'services');
			}
		}
		return $response;    
	}
	
	function gridschedule($service_id, $params = array()){
		$defaults = array(
			'duration'=>120,
			//'sourcefilterexclude'=>'PPV,Music'
		);
		$this->params = array_merge($this->params,$defaults,$params);
		$key = 'gridschedule3'.$service_id;
		if(($response = Cache::read($key))===false){
			$url = 'http://api.rovicorp.com/TVlistings/v9/listings/gridschedule/'.$service_id.'/info';
			$this->params['sig']=$this->_signRequest();
			$response = $this->_request($url,$this->params);
			if($response){
				Cache::write($key,$response);
			}
		}
				
		return $response;
	}
	
	function _request($url, $params = array()){
		$http = new HttpSocket();
		$response = $http->get($url, $params);
		if($response->isOk()){
			return $response->body;
		}else{
			debug($response);
		}
		return false;
	}
	
	function _signRequest(){
		$signature = md5($this->apiKey.$this->apiSecret.time());
		return $signature;
	}
}
?>