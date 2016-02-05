<?php
namespace Lily\Core;
use PDO;

class Database
{

    public $query;

    public $con;

    private static $instance;

    private function __construct ()
    {
        try {
            $this->con = new \PDO(
                'mysql://hostname=' . HOSTNAME . ';dbname=' . DBNAME, DBUSER, 
                DBPASS, array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                ));
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }   
    }

    private function __clone ()
    {}

    public static function getInstance ()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function prepare($sql)
    {
        return $this->con->prepare($sql);
    }
    
    public function lastInsertId()
    {
        return $this->con->lastInsertId();
    }
    
    public function exec($sql)
    {
        return $this->con->exec($sql);
    }
    
    public function errorInfo()
    {
        return $this->con->errorInfo();
    }
    
    public function query($sqlStmt, $params, $className, $resultType)
    {
        $results = $this->con->prepare($sqlStmt);
        if(!empty($params)) {
            foreach ($params as $placeholder => $valueArray) {
                $results->bindParam($placeholder, $valueArray[0], $valueArray[1]);
            }
        }
        $results->execute();
        if ($results instanceof \PDOStatement) {
            if ($resultType == 2 && $className) {
                $resultSet = $results->fetchAll(PDO::FETCH_CLASS, 
                        $className);
            } elseif ($resultType == 1) {
                $resultSet = $results->fetchAll(PDO::FETCH_OBJ);
            } elseif ($resultType == 3) {
                $resultSet = $results->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $resultSet = $results->fetchAll($resultType);
            }
            if(!empty($resultSet)) {
                return $resultSet;
            } else {
                return false;
            }
        }
    }
}