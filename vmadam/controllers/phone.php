<?php
class Phone extends BaseController {
	protected $phone;
	protected $client;
	protected $ph;
	public function execute() {
		$this->ph = new PhoneModel;
		if (isset($_REQUEST['phone'])) 
			$this->phone = preg_replace('#\D#','',$_REQUEST['phone']);
		$this->doable(array(
			'lend' => 'associate',
			'return' => 'returnphone',
			'default' => 'listphones',
		));
		$this->doaction($this->actions[1]);
	}
	protected function associate() {
		$this->mustexist();
		$this->loadclient();
		# see if they have used this phone before
		$phonerec = $this->phonerec();
       		if ($phonerec and !$phonerec['returned']) {
			View::assign('error',"Phone already loaned to this client.");
		} else {
			$res = $this->ph->ins(array(
				'phone'=> $this->phone,
				'clientid' => $this->client['id'],
				'taken' => date('Y-m-d H:i:s'),
			));
			if ($res === false) {
				View::assign('error',"Error: can't make new record!");
			}
		}
		$_REQUEST['action'] = array('profile','show');
		include('index.php');
	}
	protected function returnphone() {
		$this->mustexist();
		$this->loadclient();
		$phonerec = $this->phonerec();
		$res = $this->ph->upd(
			array(
				'phone'=> $this->phone,
				'clientid' => $this->client['id'],
				'taken' => $phonerec['taken']
			),
			array(
				'returned' => date('Y-m-d H:i:s'),
			)
		);
		if ($res === false) {
			View::assign('error','Error: problem setting return date for phone!');
		}
		$_REQUEST['action'] = array('profile','show');
		include('index.php');
	}
	protected function loadclient() {
		$clientid = $_REQUEST['clientid'];
		$this->client = Run::me('ClientModel','getone',$clientid);
		if (!$this->client) {
			View::assign('error',"Error: no client for client id $clientid");
			View::wrap('error.tpl');
			exit();
		}
	}
	protected function phonerec() {
		if (!isset($this->phone)) die("need a phone number to get phonerec");
		if (!isset($this->client)) die("need a client to get phonerec");
		return $this->ph->getlast($this->phone, $this->client['id']);
	}
	protected function mustexist() {
		if (!$this->phone) {
			View::assign('error','Error: no phone number!');
			View::wrap('error.tpl');
			exit();
		}

	}
	protected function listphones() {
		View::assign('phones',$this->ph->whohas());
		View::wrap('phones.tpl');
	}
}

