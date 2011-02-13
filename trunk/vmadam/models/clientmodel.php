<?php
class ClientModel extends ClientsEntity {
	public function __construct() {
		parent::__construct();
		$this->schema['id']['auto'] = true;
		$this->schema['id']['alt'] = 'New Profile';
		$this->schema['created']['static'] = true;
		$this->schema['modified']['static'] = true;
		$this->schema['new_messages']['hide'] = true;
		$this->schema['notes']['cols'] = 60;
		$this->schema['notes']['rows'] = 10;
	}
	public function getclients($search) {
		try {
			if (!$search) throw new Exception('ClientModel::getclients: nothing to search for!');
			$search = strtolower($search);
			$this->run(
				"select id,name,email,status ".
				"from clients ".
				"where lcase(concat(name,email,notes)) like '%%%s%%' ".
				"order by name,email ",
				$search
			);
			return $this->resultarray();
		} catch(Exception $e) {
			$this->err($e);
			if (!QUIET) die("Error: ".$this->err()."<br>\n".$this->query());
			return false;
		}
	}
}
