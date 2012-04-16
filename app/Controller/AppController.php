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
        'Session',
    	'RequestHandler',
        'Auth' => array(
     		'authenticate' => array(
				'Basic' => array(
					'fields' => array('username' => 'email','password'=>'password'),
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
		//Check for Admin Section
		/*
		if (isset($this->params['admin']) || $this->name == 'Admin') {
			//die('hAI');
		}else{
		}
		*/
        $this->Auth->allow('display');
 		$this->_sdp_init();
	}
		/**
	 * 
	 * Auth Callback for Admin Security
	 * Called in AppController::beforeFilter();
	 * 
	 * @return null
	 */
	function __setAuthAdmin(){
		//Set Auth Rules for Admin Section
		$this->Auth->allow();
		$this->Security->loginOptions = array(
			'type'=>'basic',
			'realm'=>'Admin',
			'login'=>'_authenticate_admin'
		);
		/**
		 * A reference to the object used for authentication
		 *
		 * @var object
		 * @access public
		 */
		//Hack to turn off Password Hashing
		$this->Auth->authenticate = ClassRegistry::init('User');
		$this->Auth->loginRedirect = '/admin/';
		$this->Security->requireLogin();
		//Set new admin layout
		if (isset($this->params['admin'])) {
			$this->layout = 'admin_default'; //New Layout 2010
		}
	}
	
	
		/**
	 * Sets AuthComponent settings
	 * is commented with Auth Component variables
	 * 
	 * @return unknown_type
	 */
    function __setAuth()
	{
         $this->Auth->userModel = 'User';
         $this->Auth->userScope = array('User.active' => 1);
         $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login','plugin'=>'', 'admin'=>false, 'account'=>false);
         $this->Auth->logoutRedirect = '/';
         $this->Auth->loginError = 'Login failed.  Invalid username or password.';
         $this->Auth->authError = 'Please Login.';
         $this->Auth->autoRedirect = false;
   	}
   	
	
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
}
?>