<?php
/**
 * basic login creation form - test of formgen scaffold
 */
class Register extends Controller {
	public function execute() {
		$r = new User;
		View::assign('schema',$r->schema);

		switch ($this->actions[1]) {
		case 'save':
			$_REQUEST['password'] = Login::encode($_REQUEST['password']);
			if ($_REQUEST['oldemail']) {
				$r->upd($_REQUEST['oldemail'], $_REQUEST);
			} else {
				$r->ins($_REQUEST);
			}
			$this->input = $r->getone($_REQUEST['email']);
			$this->input['password'] = '';
			View::assign('topmsg',"saved ".htmlentities($_REQUEST['email']));
			View::display('register.tpl');
			break;
		case 'edit':
			$ldata = Login::check();
			if ($ldata['login'] == $_REQUEST['email']) {
				$this->input = Run::me('user','getone',$ldata['login']);
				$this->input['password'] = '';
				$this->hidden['oldemail'] = $ldata['login'];
			}
		default:
			View::display('register.tpl');
		}
	}
}

