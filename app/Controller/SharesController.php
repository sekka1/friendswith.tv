<?php
class SharesController extends AppController {
	public $name = 'Shares';
	function index() {
		$limit = false;
		//$order = 'Share.id ASC';
		//$conditions = array('Share.client_id'=>991);
		$shares = $this->Share->find('all',compact('limit','order','conditions'));
		$this->set('shares', $shares);
		$this->set('_serialize', 'shares');
	}
	function view($id) {
		$share = $this->Share->find('first', array(
				'conditions' => array('Share.id' => $id)
		));
		$this->set('share', $share);
		$this->set('_serialize', 'share');
	}
	function add() {
		//$this->log($this->request->data);
		$share['Share'] = $this->request->data;
		$this->Share->create();
		$this->Share->save($share);
		$share['Share']['id'] = $this->Share->id;
		$this->set('share', $share);
		$this->set('_serialize', 'share');
	}
	function edit($id) {
		$share['Share'] = $this->request->data;
		$share['Share']['id'] = $id;
		$this->Share->save($share);
		$this->set('share', $share);
		$this->set('_serialize', 'share');
	}
	function delete($id) {
		$this->Share->delete($id);
		$result = array('result' => true);
		$this->set('result', $result);
		$this->set('_serialize', 'result');
	}
}

