<?php
class RecsController extends AppController {
	public $name = 'Recs';
	function index() {
		$limit = false;
		//$order = 'Rec.id ASC';
		//$conditions = array('Rec.client_id'=>991);
		$recs = $this->Rec->find('all',compact('limit','order','conditions'));
		$this->set('recs', $recs);
		$this->set('_serialize', 'recs');
	}
	function view($id) {
		$rec = $this->Rec->find('first', array(
				'conditions' => array('Rec.id' => $id)
		));
		$this->set('rec', $rec);
		$this->set('_serialize', 'rec');
	}
	function add() {
		//$this->log($this->request->data);
		$rec['Rec'] = $this->request->data;
		$this->Rec->create();
		$this->Rec->save($rec);
		$rec['Rec']['id'] = $this->Rec->id;
		$this->set('rec', $rec);
		$this->set('_serialize', 'rec');
	}
	function edit($id) {
		$rec['Rec'] = $this->request->data;
		$rec['Rec']['id'] = $id;
		$this->Rec->save($rec);
		$this->set('rec', $rec);
		$this->set('_serialize', 'rec');
	}
	function delete($id) {
		$this->Rec->delete($id);
		$result = array('result' => true);
		$this->set('result', $result);
		$this->set('_serialize', 'result');
	}
}

