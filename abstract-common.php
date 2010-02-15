<?php

/**
 * class to define entities: 
 * tables that have stand alone records 
 * these tables are assumed to only have one field that is the key
 * you can define this key in the $tables array or simply use {table name}_id 
 */
abstract class Entity extends AbstractDB {
	private $tables; 
	private $table;
	private $key;
		
	public function __construct($db,$tables,$tb) {
		$this->tables = $tables;

		parent::__construct($db);

		if ($tb and is_array($this->tables[$tb])) {
			$this->table = $tb;
			$this->schema = $tables[$tb];
			if (isset($tables[$tb]['PRIMARY KEY'])) $this->key = $tables[$tb]['PRIMARY KEY'];
			else $this->key = $tb."_id";
		}
	}

	public function ins($data) {
		try {
			if (!preg_match('#^\w+$#', $this->table)) 
				throw new Exception("missing valid table name in ins!");
			foreach ($this->schema as $field => $fdata) {
				if ($this->iskey($field,$fdata)) continue;
				if (!isset($data[$field])) continue;
				$idata[$field] = $this->quote($data['field'],"'");
			}
			$insert = "insert into {$this->table} (".implode(",",array_keys($idata)).") ".
					"values (".implode(",",array_values($idata)).")";
			$this->run($insert);
			return $this->getid();
		} catch(Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function upd($id,$data) {
		try {
			if (!preg_match('#^\w+$#', $this->table)) 
				throw new Exception("missing valid table name in upd!");
			foreach ($this->schema as $field => $fdata) {
				if ($this->iskey($field,$fdata)) continue;
				if (!isset($data[$field])) continue;
				$udata[$field] = "$field=".$this->quote($data['field'],"'");
			}
			$update = "update {$this->table} set ".implode(",", $udata)." where {$this->key}=%u";
			$this->run($update,$id);
			return $this->result;
		} catch(Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function del($id) {
		try {
			if (!preg_match('#^\w+$#', $this->table)) 
				throw new Exception("missing valid table name in upd!");
			$this->run("delete from {$this->table} where {$this->key}=%u", $id);
			return $this->result;
		} catch(Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function getall() {
		try {
			if (!preg_match('#^\w+$#', $this->table)) 
				throw new Exception("missing valid table name in upd!");
			$this->run("select * from {$this->table} order by lastname, firstname");
			return $this->resultarray();
		} catch (Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function getone($id) {
		try {
			if (!preg_match('#^\w+$#', $this->table)) 
				throw new Exception("missing valid table name in upd!");
			$this->run("select * from {$this->table} where {$this->key}=%u", $id);
			$rows = $this->resultarray();
			return $rows[0];

		} catch (Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function iskey($field,$fdata) {
		if ($field == 'PRIMARY KEY') return true;
		if ($fdata['key']) return true;
		return false;
	}
}

/**
 * class to define relations: ie tables that connect other tables together
 * with relations you need to keep track of more than one table so 
 * we need to add some functionality to handle that gracefully
 */
class Relation extends Entity {
	private $relates;

	public function __construct($db,$tables,$tb,$relates) {
		parent::__construct($db,$tables,$tb);
		if (is_array($relates)) {
			foreach($relates as $table) {
				if ($this->tables[$table]) $this->relates[] = $table;
			}
			# this should not happen but to avoid confusion ...
			if (!is_array($this->key)) {
				$this->key = array($this->key);
			}
		}
	}

	/**
	 * update delete and select operations should be defined for each relation
	 * since these are identified by more than one value $id is necessarily an array
	 */
	public function upd($id,$data) { 
		$args = $this->splitid($id);
		try {
			$args = $this->splitid($id);
			$key = array_unshift($args);
			foreach ($this->schema as $field => $fdata) {
				if ($this->iskey($field,$fdata)) continue;
				if (!isset($data[$field])) continue;
				$set[] = "$field='%s'";
				$vals[] = $value;
			}
			$query = "update {$this->table} set ".implode(",", $set)." where $key";
			$valskeys = array_merge($vals,$args);
			call_user_func_array( array($this,'run'), $valskeys );
			return $this->result;

		} catch (Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function del($id) { 
		try {
			$args = $this->splitid($id);
			$args[0] = "delete from {$this->table} where {$args[0]}";
			call_user_func_array( array($this,'run'), $args );
			return $this->result;

		} catch (Exception $e) {
			$this->err($e);
			return false;
		}
	}

	public function getone($id) { 
		try {
			$args = $this->splitid($id);
			$args[0] = "select * from {$this->table} where {$args[0]}";
			call_user_func_array( array($this,'run'), $args );
			$rows = $this->resultarray();
			return $rows[0];

		} catch (Exception $e) {
			$this->err($e);
			return false;
		}
	}

	/**
	 * process an id array in such a way that its easier to use the run method with it
	 * for basic queries 
	 * @param $id - array of primary key field names and values to look for
	 * @return an array with the field string and key values as a single array
	 *         the field string is always the 0th element in the array
	 */
	protected function splitid($id) {
		if (!is_array($id)) throw new Exception("upd: relation id is not an array");
		foreach ($this->key as $field) {
			if (empty($id[$field])) throw new Exception("del: missing $field in id!");
			$fields[] = $field."='%s'";
			$ids[] = $id[$field];
		}
		return array_merge( array( '('.implode(' and ', $fields).')' ), $ids );
	}
}

