<?php

namespace Models;

use App\log;
use config;
use Exception;
use PDO;

abstract class Model
{
    protected $table = '';
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host='.config\db::$host.';dbname='.config\db::$database, config\db::$name, config\db::$pass);
        } catch (PDOException $e) {
            throw new Exception('cant connect to database '.$e->getMessage(), $e->getCode());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    private function execute(string $query, array $inputs)
    {
        $stm = $this->pdo->prepare($query);
        $sth = $stm->execute($inputs);
        if (!$sth) {
            log::queryError(implode(' ', $stm->errorInfo()), $stm->errorCode());
            throw new Exception('Sorry it looks like something went wrong please contact us', '0300');
        }

        return $stm;
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

    public function get(array $columns, array $conditions = null)
    {
        $query = 'select '.implode($columns, ',')." from $this->table";
        $inputs = [];
        if (!is_null($conditions)) {
            $query .= ' where ';
            foreach ($conditions as $key) {
                $query .= " $key[0] $key[1] $key[2] ?";
                $inputs[] = $key[3];
            }
        }
        $stm = $this->execute($query, $inputs);
        $data = $stm->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function insert(array $columns, array $inputs)
    {
        $in = implode(str_split(str_repeat('?', count($inputs))), ',');
        $query = "insert into $this->table(".implode($columns, ',').") values($in)";
        $stm = $this->execute($query, $inputs);
    }

    public function update(array $columns, array $inputs, array $conditions = null)
    {
        $query = "update $this->table set";
        foreach ($columns as $key) {
            $query .= " $key = ?,";
        }
        $query = rtrim($query, ',');
        if (!is_null($conditions)) {
            $query .= ' where';
            foreach ($conditions as $key) {
                $query .= " $key[0] $key[1] $key[2] ?";
                $inputs[] = $key[3];
            }
        }
        $stm = $this->execute($query, $inputs);
    }

    public function delete(array $conditions)
    {
        $query = "delete from $this->table where ";
        foreach ($conditions as $key) {
            $query .= " $key[0] $key[1] $key[2] ?";
            $inputs[] = $key[3];
        }
        $stm = $this->execute($query, $inputs);
    }
}
