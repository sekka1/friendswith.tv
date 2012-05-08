<?php 
require_once(ROOT.DS.'vendors'.DS.'SDPWebFramework'.DS.'SDPWeb.php');
class AppController extends Controller {
	
	public $sdpLoggedIn = false;
	
	public $helpers = array(		
		'Form',
		'Html',
		'Js',
		'Session',
	 	'AssetCompress.AssetCompress',
		'Facebook.Facebook'
	);
	
    public $components = array(
    	'Cookie',
        'Session',
    	'RequestHandler',
        'Auth' => array(
     		'authenticate' => array(
				'Basic' => array(
					'fields' => array(
							'username' => 'email',
							'password'=>'password'
    					),
		            	'loginRedirect'=>'/pages/home',
		        		'logoutRedirect'=>'/pages/home',
            	),
        	),
        	'loginRedirect'=>'/pages/home',
        	'logoutRedirect'=>'/pages/home',
        	'authorize' => 'Controller'
        ), 
        'Facebook.Connect' => array(
			'model' => 'User',
			'modelFields' => array(
				'username' => 'email',
				'password'=>'password'
			),
		)
    );

    /**
     * (non-PHPdoc)
     * @see Controller::beforeFilter()
     */
    function beforeFilter() {
        $this->Auth->allow('display','services');
 		$this->_sdp_init();
	}
		/**
	 * 
	 * Auth Callback for Admin Security
	 * Called in AppController::beforeFilter();
	 * 
	 * @return null
	 */
   	
	
	function _sdp_init(){
		$sdp = new SDPWeb(null, SDP_API_ID, SDP_API_KEY);
		$sdp->perform_auth_action();
		$this->sdpLoggedIn = $sdp->loggedIn();
		$this->set('sdpLoggedIn',$this->sdpLoggedIn);
		$this->sdp = $sdp;
		$this->set(compact('sdp'));
	}
	
	function beforeFacebookSave(){
		$this->log('afterFacebookLogin','facebook');
			$this->Connect->authUser['User']['email'] = $this->Connect->user('email');
			return true; //Must return true or will not save.
	}
	
	function isAuthorized() {
		return true;
	}
	
	function beforeFacebookLogin($user){
		$this->log('afterFacebookLogin','facebook');
		$this->log($user,'facebook');
	    //Logic to happen before a facebook login
	}
	
	function afterFacebookLogin(){
		$this->log('afterFacebookLogin','facebook');
	    //Logic to happen after successful facebook login.
	    $this->redirect('/pages/home');
	}
	
	/**
	 * Used to get the value of a named param from the controller
	 * @param mixed $var
	 * @param mixed $default
	 * @return mixed
	 */
	function _getNamedParam($var, $default = false) {
		return (isset($this->request->params['named'][$var])) ? $this->request->params['named'][$var] : $default;
	}
}
?>