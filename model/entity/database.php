<?php
abstract class Database {
    protected $db;
  
    public function __construct() {
        try
        {
            $this->db = new PDO('mysql:host=localhost; dbname=banque_php; charset=utf8', 'root', '');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }    
    }
  
    public function getDB() {
        return $this->db;
    }
  }
  