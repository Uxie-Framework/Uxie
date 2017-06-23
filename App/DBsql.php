<?php
namespace App;

use config;
use Exception;
use mysqli;

class DBsql
{
    private $mysqli;
    private $result;

    public function __construct()
    {
        $host = config\db::$host;
        $name = config\db::$name;
        $pass = config\db::$pass;
        $database = config\db::$database;
        $this->mysqli = new mysqli($host, $name, $pass, $database);
        if ($this->mysqli->connect_errno) {
            log::query_error("can't connect to database", __FILE__);
            throw new Exception("can't connect to database", 1);
        }
    }

    public function query($query)
    {
        $this->result = $this->mysqli->query($query);
        if (!$this->result) {
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
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
        return $array;
    }

    public function fetchObject($columns, $table, $extend = false)
    {
        $array = array();
        if (!$extend) {
            $query = "select $columns from $table";
        } else {
            $query = "select $columns from $table $extend";
        }
        $result = $this->query($query);
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function fetch_object_spec($query)
    {
        $result = $this->query($query);
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function num_rows($table, $extend = false)
    {
        if (!$extend) {
            $query = "select count(0) from $table";
        } else {
            $query = "select count(0) from $table $extend";
        }
        $num = $this->query($query)->fetch_array();
        return $num[0];
    }

    public function insert(string $table, string $columns, array $values)
    {
        for ($i=0; $i < count($values); $i++) {
            $values[$i] = $this->escape_string(strip_tags($values[$i]));
            $values[$i] = "'".$values[$i]."'";
        }
        $values = implode(',', $values);
        $query = "insert into $table($columns) values($values)";
        $this->query($query);
    }

    public function update(string $table, array $columns, array $values, string $condition)
    {
        for ($i=0; $i < count($values); $i++) {
            $values[$i] = $this->escape_string(strip_tags($values[$i]));
            $values[$i] = $columns[$i]."='".$values[$i]."'";
        }
        $values = implode(',', $values);
        $query = "update $table set $values $condition";
        $this->query($query);
    }

    public function delete($table, $condition)
    {
        $query = "delete from $table $condition";
        $this->query($query);
    }
    public function __destruct()
    {
        $this->mysqli->close();
    }
}




<?php
namespace Models;

use mysqli;
use config;

/**
 *
 */
abstract class Model
{
    protected $table = '';
    protected $db;

    public function __construct()
    {
        $host = config\db::$host;
        $name = config\db::$name;
        $pass = config\db::$pass;
        $database = config\db::$database;
        $this->db = new mysqli($host, $name, $pass, $database);
        if ($this->db->connect_errno) {
            log::query_error("can't connect to database", __FILE__);
            throw new Exception("can't connect to database", 1);
        }
    }

    public function query($query)
    {
        $this->result = $this->db->query($query);
        if (!$this->result) {
            log::query_error($query, __FILE__);
            throw new Exception("Error in the query", 2);
        }
        return $this->result;
    }

    public function escape_string($value)
    {
        return $this->db->real_escape_string($value);
    }

    public function insert(string $columns, array $values)
    {
        for ($i=0; $i < count($values); $i++) {
            $values[$i] = $this->escape_string(strip_tags($values[$i]));
            $values[$i] = "'".$values[$i]."'";
        }
        $values = implode(',', $values);
        $query = "insert into $this->table($columns) values($values)";
        $this->query($query);
    }

    public function get(string $columns, string $extend = null)
    {
        $array = array();
        if (!$extend) {
            $query = "select $columns from $this->table";
        } else {
            $query = "select $columns from $this->table $extend";
        }
        $result = $this->query($query);
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function numRows(string $extend = null)
    {
        if (!$extend) {
            $query = "select count(0) from $this->table";
        } else {
            $query = "select count(0) from $this->table $extend";
        }
        $num = $this->query($query)->fetch_array();
        return $num[0];
    }

    public function delete(string $condition)
    {
        $query = "delete from $this->table $condition";
        $this->query($query);
    }
}
