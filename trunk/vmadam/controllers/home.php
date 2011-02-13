<?php
class Home extends BaseController {
	public $f;
	public $notcalledinterval;
	public $newmsginterval;
	public function execute() {
		$this->f = new FileModel;
		$this->notcalledinterval = '2 day';
		View::assign('notcalled',$this->f->notcalled($this->notcalledinterval));
		$this->newmsginterval = '1 month';
		View::assign('messages',$this->f->newmessages($this->newmsginterval));
		View::addCSS('home.css');
		View::wrap('home.tpl');
	}
}

