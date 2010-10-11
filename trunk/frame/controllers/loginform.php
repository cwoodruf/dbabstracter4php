<?php
class Loginform extends Controller {
	public function execute () {
		$ldata = Login::check();

		# ajaxcheck is the quick check done in the background from the login form
		if ($this->actions[1] == 'ajaxcheck') {
			if (is_array($ldata)) {
				print 'OK';
				exit;
			} else {
				if (!QUIET) print ' Not found / bad password. '; 
				exit;
			}
		}

		if ($this->flag('login')) {
			$this->delflag('login');
			Controller::redo();
		}

		$this->flag('login',true);
		View::display('login.tpl');
	}
}

