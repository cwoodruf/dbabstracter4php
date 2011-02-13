<?php
class FileModel extends FilesEntity {
	# note that you can change the status of a message from the phone interface by renaming it 
	# with a "deleted.gsm" instead of a ".gsm"
	public function messages($clientid) {
		return $this->getall(array("where clientid='%u' order by created desc", $clientid));
	}

	public function notcalled($interval) {
		try {
			if (!preg_match('#^\d (?:day|month|week)$#', $interval)) 
				throw new Exception("Bad interval $interval in FileModel::notcalled!");

			$this->run(
				"select id,name,email,status,phone,taken,latestfiles.created ".
				"from (select max(created) as created, clientid,callerid from files ".
				       "group by clientid,callerid) as latestfiles ".
				"join clients on (latestfiles.clientid=clients.id) ".
				"join phones on (phones.phone=latestfiles.callerid) ".
				"where id <> 0 and latestfiles.created < now() - interval %s ".
				"and phones.returned is null order by latestfiles.created, name, email, status",
				$interval
			);
			return $this->resultarray();

		} catch(Exception $e) {
			$this->err($e);
			if (!QUIET) die("Error: ".$this->err()."<br>\n".$this->query());
			return false;
		}
	}


	public function newmessages($interval=null) {
		if (!preg_match('#^\d (?:month|week|day)$#', $interval)) return;
		$join = "join clients on (clients.id=files.clientid)";
		if (!$interval) 
			return $this->getall("$join order by created desc");

		return $this->getall(array(
			"$join where files.created > now() - interval %s ".
			"order by files.created desc", 
			$interval
		));
	}

	public function getclients($search) {
		try {
			if (!$search) 
				throw new Exception("FileModel::getclients: nothing to search for!");

			$this->run(
				"select id,name,email,status,files.created,filename,iscallback ".
				"from files join clients on (files.clientid=clients.id) ".
				"where filename like '%%.gsm' ".
				"and lcase(concat(name,email,status,files.created)) like '%%%s%%' ".
				"order by files.created desc, name, email, status ",
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
