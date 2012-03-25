<?php 
require_once(ROOT.DS.'vendors'.DS.'SDPWebFramework'.DS.'SDPWeb.php');
class AppController extends Controller {
	
	public $sdpLoggedIn = false;
	
	function beforeFilter(){
		$this->_sdp_init();
	}
	
	
	function _sdp_init(){
		$sdp = new SDPWeb();
		$sdp->apiKey = '148ca50aa64eca2701da74a219df81ff'; //fwt local
		$sdp->apiSecret = 'MISSING_API_SECRET';
		$sdp->perform_auth_action();
		$this->sdpLoggedIn = $sdp->loggedIn();
		$this->set('sdpLoggedIn',$this->sdpLoggedIn);
		$this->sdp = $sdp;
		$this->set(compact('sdp'));
	}
}
?>