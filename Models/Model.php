<?php

namespace Models;

use App\log;
use Exception;
use PDO;

abstract class Model
{
    protected static $table = '';
    protected $pdo;
    protected static $query;
    protected static $inputs;
    protected static $whereFlag = 'where'; // this variable is to know if where method already called

    public function __construct()
    {
        try {
            $this->pdo = new PDO(getenv('DB_CNX').':host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
        } catch (PDOException $e) {
            throw new Exception('cant connect to database '.$e->getMessage(), $e->getCode());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
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
        $statment = $this->pdo->prepare(static::$query);
        $verfierStatment = $statment->execute($this->inputs);
        if (!$verfierStatment) {
            log::queryError(implode(' ', $statment->errorInfo()), $statment->errorCode());
            throw new Exception('Sorry it looks like something went wrong please contact us', '0300');
        }
        $data = $statment->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function execute()
    {
        $statment = $this->pdo->prepare(static::$query);
        $verfierStatment = $statment->execute($this->inputs);
        if (!$verfierStatment) {
            log::queryError(implode(' ', $statment->errorInfo()), $statment->errorCode());
            throw new Exception('Sorry it looks like something went wrong please contact us', '0300');
        }
    }

    public static function select(array $columns)
    {
        static::$query = 'select '.implode($columns, ',')." from ".static::$table;
        return new static();
    }

    public static function insert(array $columns, array $inputs)
    {
        $columns = implode(',', $columns);
        $values  = implode(',', array_fill(0, count($inputs), '?'));
        static::$query .= "insert into ".static::$table."($columns) values($values)";
        static::$inputs = $inputs;
        return new static();
    }

    public static function update(array $columns, array $inputs)
    {
        $columns = implode(',', array_map(function ($value) {
            return "$value = ?";
        }, $columns));
        $values  = implode(',', array_fill(0, count($inputs), '?'));
        static::$query = "update ".static::$table." set $columns ";
        static::$inputs = $inputs;
        return new static();
    }

    public static function delete()
    {
        static::$query = 'delete from '.static::$table;
        return new staitc();
    }

    public function where(string $column, string $condition, string $input)
    {
        static::$query .= static::$whereFlag." $column $condition ? ";
        static::$whereFlag = ' and ';
        static::$inputs[] = $input;
        return $this;
    }

    public function or(string $column, string $condition, string $input)
    {
        static::$query .= " or $column $condition ? ";
        static::$inputs[] = $input;
        return $this;
    }

    public function groupBy(string $column)
    {
        static::$query .= " group by $column ";
        return $this;
    }

    public function orderBy(string $column, string $order = 'desc')
    {
        static::$query .= " order by $column $order ";
        return $this;
    }

    public function limit(int $limit, int $offset = null)
    {
        $offset = ($offset) ? ','.$offset : '';
        static::$query .= " limit $limit $offset";
        return $this;
    }
}
