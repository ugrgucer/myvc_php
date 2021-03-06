<?php

namespace App\Migration;

use App\Core\Model;

class User extends Model{
    protected $tableName = "users";

    public function __construct(){
        parent::__construct(); 
    }

    public function create(){
       if(!$this->existsTable($this->tableName)) {
           $sorgu = "
                CREATE TABLE {$this->tableName} (
                      user_id int AUTO_INCREMENT PRIMARY KEY,
                      username varchar(50) NOT NULL UNIQUE,
                      name varchar(50) NOT NULL,
                      surname varchar(100) NOT NULL,
                      password varchar(255) NOT NULL,
                      height int NOT NULL,
                      weight int NOT NULL,
                      email varchar(100) NOT NULL,
                      age int NOT NULL,
                      target_weight int NOT NULL,
                      gender boolean default false,
                      register_date datetime default current_timestamp
                ) DEFAULT CHARACTER SET utf8;
            ";
            try{
                $hey = $this->db->prepare($sorgu);
                $hey->execute();
                $hey->closeCursor();
            }catch (\PDOException $e){
                throw $e;
            }
        }
    }

    public function createSession(){
        if(!$this->existsTable('tokens')){
            $sorgu = "
                CREATE TABLE tokens (
                  id int AUTO_INCREMENT PRIMARY KEY,
                  user_id int NOT NULL,
                  FOREIGN KEY (user_id) REFERENCES users (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                  token varchar(32) NOT NULL,
                  expiry_date DATETIME NOT NULL
                ) DEFAULT CHARACTER SET utf8;
            ";

            try{
                $hey = $this->db->prepare($sorgu);
                $hey->execute();
                $hey->closeCursor();
            }catch (\PDOException $e){
                throw $e;
            }
        }
    }
}