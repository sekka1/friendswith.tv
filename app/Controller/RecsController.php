<?php 
class RecsController extends AppController {
	
	public $uses = array('Rec');
	
	function index(){
		//$this->paginate['Rec']['order'] = array('created'=>-1);
		$conditions = array();
		$recs = $this->Rec->find('all',compact('conditions'));
		$this->set(compact('recs'));
	}		
}
?>