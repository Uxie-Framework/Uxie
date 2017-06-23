<?php

namespace classes;

use PDO;
use config;

class DBpdo
{
  private $db;

  function __construct()
  {
    try {
      $this->db = new PDO('mysql:host='.config\db::$host.';dbname='.config\db::$database,config\db::$name, config\db::$pass);
    } catch (PDOException $e) {
      throw new Exception("cant connect to database ".$e->getMessage(), $e->getCode());
    }
  }

  public function getPDO()
  {
    return $this->db;
  }

  public function exec($query)
  {
    try {
      $this->db->exec($query);
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function query($query)
  {
    try {
      $result = $this->db->query($query);
      return $result;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function numRows($query)
  {
    try {
      $result = $this->query($query)->rowCount();
      return $result;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function fetchObject($query)
  {
    try {
      $result = $this->db->query($query)->fetch(PDO::FETCH_OBJ);
      return $result;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function fetchObjectAll($query)
  {
    try {
      $result = $this->db->query($query)->fetchAll(PDO::FETCH_OBJ);
      return $result;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function fetchNum($query)
  {
    try {
      $result = $this->db->query($query)->fetch(PDO::FETCH_NUM);
      return $result;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function fetchNumAll($query)
  {
    try {
      $result = $this->db->query($query)->fetchAll(PDO::FETCH_NUM);
      return $result;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

}
