<?php
namespace classes;

use config;
use Exception;
use mysqli;

class DBsql
{

	private $mysqli;
	private $result;

	function __construct()
	{
		$host = config\db::$host;
		$name = config\db::$name;
		$pass = config\db::$pass;
		$database = config\db::$database;
		$this->mysqli = new mysqli($host,$name,$pass,$database);
		if($this->mysqli->connect_errno) {
			log::query_error("can't connect to database", __FILE__);
			throw new Exception("can't connect to database", 1);
		}
	}

	public function query($query)
	{
		$this->result = $this->mysqli->query($query);
		if(!$this->result) {
			log::query_error($query, __FILE__);
			throw new Exception("Error in the query", 2);
		}
		return $this->result;
	}

	public function escape_string($value)
	{
		return $this->mysqli->real_escape_string($value);
	}

	public function fetch_array($columns, $table, $extend = false)
	{
		$db = $this->mysqli;
		$array = array();
		if ($extend) {
			$query = "select $columns from $table $extend";
		} else {
			$query = "select $columns from $table";
		}
		$result = $db->query($query);
		var_dump($result);
		while ($row = $result->fetch_array()) {
			$array[] = $row ;
		}
		return $array;
	}

	public function fetch_assoc($columns, $table, $extend = false)
	{
		$array = array();
		if ($extend) {
			$query = "select $columns form $table $extend";
		} else {
			$query = "select $columns form $table";
		}
		$result = $this->query($query);
		while($row = $result->fetch_assoc()) {
			$array[] = $row;
		}
		return $array;
	}

	public function fetch_object($columns, $table, $extend = false)
	{
		$db = $this->mysqli;
		$array = array();
		if(!$extend){
			$query = "select $columns from $table";
		}else{
			$query = "select $columns from $table $extend";
		}
		$result = $db->query($query);
		while($row = $result->fetch_object()) {
			$array[] = $row;
		}
		return $array;
	}

	public function fetch_object_spec($query)
	{
		$result = $this->query($query);
		while($row = $result->fetch_object()) {
			$array[] = $row;
		}
		return $array;
	}

	public function num_rows($table, $extend = false)
	{
		$db = $this->mysqli;
		if(!$extend) {
			$query = "select count(0) from $table";
		}else{
			$query = "select count(0) from $table $extend";
		}
		$num = $db->query($query)->fetch_array();
		return $num[0];
	}

	public function insert($table,$columns,$values)
	{
		$db = $this->mysqli;
		$query = "insert into $table($columns) values($values)";
		$db->query($query);
	}

	function __destruct()
	{
		$this->mysqli->close();
	}

}
