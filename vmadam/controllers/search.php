<?php
class Search extends BaseController {
	public $terms;
	public $error;
	public $class;
	public $searchtype;
	public function execute() {
		$results = $this->search();
		View::assign('terms',htmlentities($this->terms));
		if ($results === false) {
			if (!$this->error) {
				$this->error = Run::me($this->class,'err');
			}
		} else {
			View::assign('results',$results);
		}
		View::assign('this',$this);
		View::wrap('searchresults.tpl');
	}

	public function search() {
		$this->terms = $_REQUEST['terms'];
		if ($this->terms) {
			switch($_REQUEST['findwhat']) {
			case 'phones':
				$this->class = 'PhoneModel';
				$this->searchtype = 'Phones';
				break;
			case 'messages':
				$this->class = 'FileModel';
				$this->searchtype = 'Messages';
				break;
			default:
				$this->class = 'ClientModel';
				$this->searchtype = 'Profiles';
			}
			return Run::me($this->class,'getclients',$this->terms);
		}
		$this->error = "Nothing to search for!";
		return false;
	}
}
