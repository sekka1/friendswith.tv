<?php 
// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
	//public $useTable = 'users';

    public $name = 'User';
    public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A name is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        )
    );
    
 	function hashPasswords($data) {
         return $data;
    }

	public function beforeSave() {
	    if (isset($this->data[$this->alias]['password'])) {
	        //$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	        $this->data[$this->alias]['password'] = $this->data[$this->alias]['password'];
	    }
	    return true;
	}
    
}