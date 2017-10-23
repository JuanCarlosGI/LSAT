<?php

class Difficulty {
	private $_db,
	$_data = array(),
	$_tableName = "difficulty";

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function getDifficulties() {
		$db = $this->_db->get($this->_tableName);

		if($db && $db->count()) {
			return $db->results();
		}

		return array();
	}

	public function getDifficulty($id) {
		$sql = "SELECT * FROM difficulty WHERE id = ?";
		if(!$this->_db->query($sql, array($id))->error()) {
			if($this->_db->count()) {
				return $this->_db->results();
			}
		}
		return array();
	}

  public function data() {
		return $this->_data;
	}

}

?>
