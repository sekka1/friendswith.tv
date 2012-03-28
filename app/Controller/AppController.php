<?php 
require_once(ROOT.DS.'vendors'.DS.'SDPWebFramework'.DS.'SDPWeb.php');
class AppController extends Controller {
	
	public $sdpLoggedIn = false;
	
	public $helpers = array(		
		'Form',
		'Html',
		'Js',
		'Session',
	 	'AssetCompress.AssetCompress'
	);
	
    public $components = array(
        'Session',
    	'RequestHandler',
        'Auth' 
		 => array(
            'loginRedirect' => '/mobile',
		    'loginAction' => array(
				'controller' => 'users',
				'action'     => 'login'
			),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
    		'authError'=>'Please Login',
     		'authenticate' => array(
				'Basic' => array(
                	'fields' => array('username' => 'name'),
            	),
        	)
        ), 
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
			$this->Auth->authenticate = array(
				'Basic'=> array(
					'userModel' => 'User',
					'fields' => array('username' => 'name'),
				)
			);

		}else{
			$this->Auth->authenticate = array(
				'Form'=> array(
					'userModel' => 'User',
					'fields' => array('username' => 'name'),
				)
			);
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