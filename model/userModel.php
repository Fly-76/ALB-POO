<?php
require_once "model/entity/database.php";

class UserModel extends Database {

  public function getUser($email) {
    $db = parent::getDB();
    $query = $db->prepare("SELECT * FROM alb_users WHERE u_email = :email");
    $query->execute(["email" => $email]);
    return $query->fetch(PDO::FETCH_ASSOC);
  }
}
