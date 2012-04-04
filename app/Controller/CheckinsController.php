<?php 
class CheckinsController extends AppController {
	public $name = 'Checkins';
	function index() {
		$limit = false;
		//$order = 'Checkin.id ASC';
		//$conditions = array('Checkin.client_id'=>991);
		$checkins = $this->Checkin->find('all',compact('limit','order','conditions'));
		$this->set('checkins', $checkins);
		$this->set('_serialize', 'checkins');
	}
	function view($id) {
		$checkin = $this->Checkin->find('first', array(
				'conditions' => array('Checkin.id' => $id)
		));
		$this->set('checkin', $checkin);
		$this->set('_serialize', 'checkin');
	}
	function add() {
		//$this->log($this->request->data);
		$checkin['Checkin'] = $this->request->data;
		$this->Checkin->create();
		$this->Checkin->save($checkin);
		$checkin['Checkin']['id'] = $this->Checkin->id;
		$this->set('checkin', $checkin);
		$this->set('_serialize', 'checkin');
	}
	function edit($id) {
		$checkin['Checkin'] = $this->request->data;
		$checkin['Checkin']['id'] = $id;
		$this->Checkin->save($checkin);
		$this->set('checkin', $checkin);
		$this->set('_serialize', 'checkin');
	}
	function delete($id) {
		$this->Checkin->delete($id);
		$result = array('result' => true);
		$this->set('result', $result);
		$this->set('_serialize', 'result');
	}
}
