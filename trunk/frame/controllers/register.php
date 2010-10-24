<?php
/**
 * basic login creation form - test of formgen scaffold
 */
class Register extends Controller {
	private static $LOGINMODEL = LOGINMODEL;

	public function execute() {
		$r = new self::$LOGINMODEL;

		$this->schema = $r->schema;
		$email = $_REQUEST['email'];

		switch ($this->actions[1]) {
		case 'save':
			if (!(Check::isemail($email))) {
				View::assign('errors',"Invalid email entered!");
				$this->input = $_REQUEST;
				break;
			}
			if (!(Check::validpassword($_REQUEST['password']))) {
				View::assign('errors',"Invalid password entered!");
				$this->input = $_REQUEST;
				break;
			}
			$_REQUEST['password'] = Login::encode($_REQUEST['password']);
			if ($_REQUEST['oldemail']) {
				$r->upd($_REQUEST['oldemail'], $_REQUEST);
			} else {
				$r->ins($_REQUEST);
			}
			$this->input = $r->getone($email);
			$this->input['password'] = '';
			View::assign('topmsg',"saved ".htmlentities($email));
			break;
		case 'edit':
			$ldata = Login::check();
			if ($ldata['login'] == $email) {
				$this->input = Run::me(self::$LOGINMODEL,'getone',$ldata['login']);
				$this->input['password'] = '';
				$this->hidden['oldemail'] = $ldata['login'];
			}
		default:
		}
		View::display('tools/register.tpl');
	}
}

