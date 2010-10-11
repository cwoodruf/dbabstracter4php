<?php
class Logout extends Controller {
	public function execute () {
		Login::logout();
		$context = new Index;
		$context->execute();
	}
}

