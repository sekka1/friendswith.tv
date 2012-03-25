<?php 
class RecsController extends AppController {
	
	public $uses = array('Rec');
	
	function index(){
		//$this->paginate['Rec']['order'] = array('created'=>-1);
		$conditions = array();
		$recs = $this->Rec->find('all',compact('conditions'));
		$this->set(compact('recs'));
	}

	function create($show_id, $user_to_id, $time_code = null){
		$this->autoRender = false;
		$user_from_id = $this->Auth->user('id');
		if($this->request->isPost()){
			$this->Rec->create();
			$rec = array();
			$rec['show_id'] = $show_id;
			$rec['user_from_id'] = $user_from_id;
			$rec['user_to_id'] = $user_to_id;
			$rec['time_code'] = $time_code;
			if($this->Rec->save($rec)){
				echo '1';
			}else{
				echo '0';
			}
		}
	}
}
?>