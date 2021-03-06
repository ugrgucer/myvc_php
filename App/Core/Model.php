<?php

namespace App\Core;

class Model{
    protected $db;
    protected $database;

    public function __construct(){
        $this->database = require(CONFIG.'database.php');
        $dsn = "mysql:host={$this->database['host']};charset=utf8;";
        $user = $this->database['username'];
        $password = $this->database['password'];
        try {
            $this->db = new \PDO($dsn, $user, $password);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
            $this->db->exec("CREATE DATABASE IF NOT EXISTS {$this->database['dbname']}");
            $this->db->exec("use {$this->database['dbname']}");
        } catch (PDOException $e) {
            throw new \Exception('Bağlantı kurulamadı: ' . $e->getMessage());
        }
    }

    public function existsTable($tableName){
        $sorgu = "SELECT COUNT(*) as sonuc FROM information_schema.tables WHERE table_schema = '{$this->database['dbname']}' AND table_name = '{$tableName}';";
        foreach ($this->db->query($sorgu) as $sonuc){
            if($sonuc[0] == 0)
               return false;
            return true;
        }
    }

    public function isUsable($token){
        $sorgu = "SELECT user_id FROM tokens WHERE token = '{$token}'";

        $obj = $this->db->query($sorgu)->fetchObject();

        if(!$obj)
            throw new \Exception("İzinsiz işlem");
        return $obj->user_id;
    }
}