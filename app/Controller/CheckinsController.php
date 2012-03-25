<?php 
class CheckinsController extends AppController {
	
	//public $uses = array('Rec');
	
	function index(){
		$conditions = array('user_id'=>$this->Auth->user('id'));
		$this->Checkin->find('all',compact('conditions'));
	}
	
	function create($show_id, $time_code = null){
		$this->autoRender = false;
		$user_from_id = $this->Auth->user('id');
		if($this->request->isPost()){
			$this->Checkin->create();
			$rec = array();
			$rec['show_id'] = $show_id;
			$rec['user_id'] = $user_from_id;
			$rec['time_code'] = $time_code;
			if($this->Checkin->save($rec)){
				echo '1';
			}else{
				echo '0';
			}
		}
	}
}
?>