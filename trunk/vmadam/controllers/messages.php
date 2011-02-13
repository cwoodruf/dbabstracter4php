<?php
class Messages extends BaseController {
	public function execute() {
		$this->doable(array(
			'changeclient' => 'changeclient',
			'setclient' => 'setclient',
			'default' => 'recentmsgs',
		));
		$this->doaction($this->actions[1]);
	}

	protected function changeclient() {
		$cm = new ClientModel;
		View::assign('clients',$cm->getall("where status in ('active','') order by name"));
		View::wrap('changeclient');
	}
	protected function setclient() {
		$fm = new FileModel;
		$fm->upd($_REQUEST['filename'],array('clientid' => $_REQUEST['clientid']));
		View::assign('results',"Changed client for message.");
		$this->recentmsgs();
	}

	protected function recentmsgs() {
		$_REQUEST['action'] = array('home');
		@include('index.php');
	}
}
