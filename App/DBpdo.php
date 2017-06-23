<?php

namespace App;

use PDO;
use config;

class DBpdo
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host='.config\db::$host.';dbname='.config\db::$database, config\db::$name, config\db::$pass);
        } catch (PDOException $e) {
            throw new Exception("cant connect to database ".$e->getMessage(), $e->getCode());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function exec($query)
    {
        try {
            $this->pdo->exec($query);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function query($query)
    {
        try {
            $result = $this->pdo->query($query);
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function get()
    {
        $stm = $this->pdo->prepare('select * from testa where name = ?');
        $stm->execute(['amine']);
        $data = $stm->fetch();
        die($data);
    }

    public function numRows($query)
    {
        try {
            $result = $this->pdo->query($query)->rowCount();
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function fetchObject($query)
    {
        try {
            $result = $this->pdo->query($query)->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function fetchObjectAll($query)
    {
        try {
            $result = $this->pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function fetchNum($query)
    {
        try {
            $result = $this->pdo->query($query)->fetch(PDO::FETCH_NUM);
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function fetchNumAll($query)
    {
        try {
            $result = $this->pdo->query($query)->fetchAll(PDO::FETCH_NUM);
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
