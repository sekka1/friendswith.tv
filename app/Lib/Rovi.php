<?php 
App::uses('HttpSocket','Network/Http');
class Rovi {
	
	var $apiBaseUrl = '';
	var $apiKey = '2x299srgs39qa57vrvvwaqgc';
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
			$response = $this->_request($url);
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
			$response = $this->_request($url);
			if($response){
				Cache::write($zip_code,$response,'services');
			}
		}
		return $response;    
	}
	
	function _request($url){
		$http = new HttpSocket();
		$response = $http->get($url,$this->params);
		if($response->isOk()){
			return $response->body;
		}
		return false;
	}
}
?>