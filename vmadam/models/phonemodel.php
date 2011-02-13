<?php
class PhoneModel extends PhonesRelation {

	public function getlast($phone,$clientid) {
		try {
			$this->run(
				"select * ".
				"from phones ".
				"where phone='%s' and clientid='%u' ".
				"order by taken desc limit 1 ",
				$phone, $clientid
			);
			$rec = $this->getnext();
			$this->free();
			return $rec;
		} catch(Exception $e) {
			$this->err($e);
			if (!QUIET) die("Error: ".$this->err()."<br>\n".$this->query());
			return false;
		}
	}

	public function inuse() {
		return $this->whohas("where returned = '' or returned is null ");
	}

	public function whohas($where='') {
		try {
			$this->run(
				"select id,name,email,status,phone,taken ".
				"from phones join clients on (clients.id=phones.clientid) ".
				$where.
				"order by taken desc "
			);
			return $this->resultarray();
		} catch(Exception $e) {
			$this->err($e);
			if (!QUIET) die("Error: ".$this->err()."<br>\n".$this->query());
			return false;
		}
	}

	public function phones($clientid,$limit=null) {
		if ($limit) $limit = sprintf("limit %d",$limit);
		else $limit = '';
		return $this->getall(array("where clientid='%d' order by taken desc $limit", $clientid));
	}

	public function getclients($search) {
		try {
			if (!$search) throw new Exception('PhoneModel::getclients: nothing to search for!');
			$search = strtolower($search);
			$this->run(
				"select id,name,email,status,phone,taken,returned ".
				"from clients join phones on (clients.id=phones.clientid) ".
				"where phone like '%%%s%%' ".
				"order by taken desc,name,email ",
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

