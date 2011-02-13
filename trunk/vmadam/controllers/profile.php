<?php
class Profile extends BaseController {
	protected $p;
	public function execute() {
		$this->p = new ClientModel;
		$this->schema = $this->p->schema; // for formgen
		if (isset($_REQUEST['clientid'])) {
			$this->input = $this->p->getone($_REQUEST['clientid']);
			View::assign('clientid',$this->input['id']);
		}
		$this->doable(array(
			'create' => 'create',
			'edit' => 'edit',
			'save' => 'edit',
			'show' => 'show',
			'delete' => 'confirmdel',
			'confirmdel' => 'del',
			'default' => 'profiles',
		));
		View::addCSS('profile.css');
		$this->doaction($this->actions[1]);
	}

	protected function show() {
		$this->mustexist();
		View::assign('phones',Run::me('PhoneModel','phones',$this->input['id']));
		View::assign('messages',Run::me('FileModel','messages',$this->input['id']));
		View::wrap('profileshow.tpl');
	}

	protected function create() {
		View::wrap('profile.tpl');
	}

	protected function edit() {
		if ($this->actions[1] == 'save') {
			# case where we are coming from the creat form
			if (!isset($_REQUEST['id'])) { 
				# fix some values that may be unset
				if (!in_array($_REQUEST['status'], $this->p->schema['status'])) {
					$_REQUEST['status'] = 'active';
				}
				$_REQUEST['created'] = date('Y-m-d H:i:s');

				if ($this->p->ins($_REQUEST) === false) {
					View::assign('error',"Error: ".$this->p->err());
					$this->input = $_REQUEST;
				} else {
					$_REQUEST['clientid'] = $this->p->getid();
					if ($_REQUEST['clientid'] !== false) {
						$this->input = $this->p->getone($_REQUEST['clientid']);
					} else {
						View::assign('error',"error creating client id!");
						View::wrap('error.tpl');
						exit();
					}
				}
			# case where we are just editing
			} else {
				if ($this->p->upd($_REQUEST['id'], $_REQUEST) === false) {
					View::assign('error',"Error: ".$this->p->err());
					$this->input = $_REQUEST;
				} else {
					$this->input = $this->p->getone($_REQUEST['id']);
				}
			}
		}
		$this->mustexist();
		View::wrap('profile.tpl');
	}

	protected function confirmdel() {
		$this->mustexist();
		$this->input = array(
			'confirm' => "Really delete profile for {$this->input['name']}?",
			'action' => 'profile/confirmdel',
			'what' => $this->input['clientid'],
			'submit' => 'delete',
		);
		View::wrap('tools/confirm.tpl');
	}

	protected function del() {
		$this->mustexist();
		$this->p->upd($this->input['clientid'],array('status' => 'deleted'));
		$this->input = array(
			'confirm' => "Set status for {$this->input['name']} to deleted.",
		);
		View::wrap('tools/confirm.tpl');
	}

	protected function mustexist() {
		if (!is_array($this->input)) {
			View::assign('error',"No profile specified!");
			View::wrap('error.tpl');
			exit();
		}
	}

	protected function profiles() {
		View::assign('list', $this->p->getall());
		View::wrap('profiles.tpl');
	}
}

