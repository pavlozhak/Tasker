<?php
namespace libraries\MysqlQueryLib;

class MysqlQueryLib
{
    private $pdo;
    private $querySelect = '*';
    private $queryTable;
    private $queryWhere = array();
    private $queryOrder;
    private $queryTake;
    private $queryOffset;
    private $queryString;
    private $queryResult;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function select($fields = array())
    {
        $this->querySelect = (sizeof($fields) > 0) ? implode(',', $fields) : '*';
        return $this;
    }

    public function table($table)
    {
        $this->queryTable = $table;
        return $this;
    }

    public function where($condition)
    {
        array_push($this->queryWhere, $condition);
        return $this;
    }

    public function order($field, $direction = 'DESC')
    {
        $this->queryOrder = (empty($field)) ? '' : " ORDER BY {$field} {$direction}";
        return $this;
    }

    public function take($take)
    {
        $this->queryTake = $take;
        return $this;
    }

    public function offset($offset)
    {
        $this->queryOffset = (empty($offset)) ? '' : "{$offset},";
        return $this;
    }

    public function get()
    {
        $this->queryString = "SELECT {$this->querySelect} FROM {$this->queryTable}";
        $this->queryString .= (sizeof($this->queryWhere) > 0) ? " WHERE ".implode(' AND ', $this->queryWhere) : '';
        $this->queryString .= (empty($this->queryOrder)) ? '' : $this->queryOrder;
        $this->queryString .= (empty($this->queryTake)) ? '' : " LIMIT {$this->queryOffset}{$this->queryTake}";

        $this->queryResult = $this->pdo->query($this->queryString);

        return $this;
    }

    public function toArray()
    {
        $resultArray = array();
        while ($row = $this->queryResult->fetch())
        {
            array_push($resultArray, $row);
        }
        return $resultArray;
    }

    public function insert($records = array())
    {
        $fields = array();
        $values = array();
        foreach ($records as $field=>$record)
        {
            array_push($fields, $field);
            array_push($values, '\''.$record.'\'');
        }
        $this->queryString = "INSERT INTO {$this->queryTable} (".implode(',', $fields).") VALUES (".implode(',', $values).")";
        $this->pdo->query($this->queryString);
    }

    public function update($records = array())
    {
        $this->queryString = "UPDATE {$this->queryTable} SET ";
        $setArray = array();
        foreach ($records as $field=>$record)
        {
            array_push($setArray, "{$field} = '{$record}'");
        }
        $this->queryString .= implode(',', $setArray);
        $this->queryString .= " WHERE ".implode(' AND ', $this->queryWhere);
        $this->pdo->query($this->queryString);
    }

    public function totalRows()
    {
        $this->queryString = "SELECT COUNT(*) FROM {$this->queryTable}";
        return $this->pdo->query($this->queryString)->fetchColumn();
    }
}