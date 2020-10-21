<?php
function dbConnect() {
    try
    {
        $db = new PDO('mysql:host=localhost; dbname=banque_php; charset=utf8', 'root', '');
        return $db;
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
}

class Database {
    private $db;
    public function __construct() {
        try
        {
            $this->$db = new PDO('mysql:host=localhost; dbname=banque_php; charset=utf8', 'root', '');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }    
    }
}
  