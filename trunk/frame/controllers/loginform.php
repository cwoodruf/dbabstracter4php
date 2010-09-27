<?php
class Loginform extends Controller {
	public function execute () {
		$ldata = Login::check();
		$controller = $this->delflag('controller');
		if ($ldata) {
			if ($this->actions[1] == 'ajaxcheck') {
				print 'OK';
				exit;
			}
			if ($controller == $this->controller) {
				$controller = DEFCONTROLLER;
			}
		}
		if ($this->flag('login')) {
			$this->delflag('login');

			if (empty($ldata)) {
				if ($this->actions[1] == 'ajaxcheck') {
					if (!QUIET) print ' Not found / bad password. '; 
					exit;
				}
			}
			$context = new $controller($this->actions);
			$context->execute();
			return;
		}
		$this->flag('login',true);
		View::display('login.tpl');
	}
}

