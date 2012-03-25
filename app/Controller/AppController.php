<?php 
require_once(ROOT.DS.'vendors'.DS.'SDPWebFramework'.DS.'SDPWeb.php');
class AppController extends Controller {
	
	public $sdpLoggedIn = false;
    public $components = array(
        'Session',
    	'RequestHandler',
        'Auth' => array(
            'loginRedirect' => '/mobile',
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
    		'authError'=>'Please Login',
            'ajaxLogin'=>'login',
     		'authenticate' => array(
            	'Form' => array(
                	'fields' => array('username' => 'name'),
            	)
        	)
        ),
    );

    /**
     * (non-PHPdoc)
     * @see Controller::beforeFilter()
     */
    function beforeFilter() {
        $this->Auth->allow('display');
 		$this->_sdp_init();
	}
	
	
	function _sdp_init(){
		$sdp = new SDPWeb();
		$sdp->apiKey = SDP_API_ID; //fwt local
		$sdp->apiSecret = SDP_API_KEY;
		$sdp->perform_auth_action();
		$this->sdpLoggedIn = $sdp->loggedIn();
		$this->set('sdpLoggedIn',$this->sdpLoggedIn);
		$this->sdp = $sdp;
		$this->set(compact('sdp'));
	}
	
	
}
?>