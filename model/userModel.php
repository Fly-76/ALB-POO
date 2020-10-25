<?php
require_once "model/entity/database.php";
require_once "model/entity/user.php";

class UserModel extends Database {

  public function getUserByEmail($email) {
    $db = parent::getDB();
    $query = $db->prepare("SELECT * FROM alb_users WHERE u_email = :email");
    $query->execute(["email" => $email]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getUserById($id):User {
    $db = parent::getDB();
    $query = $db->prepare("SELECT * FROM alb_users WHERE u_id = :id");
    $query->execute(["id" => $id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    //var_dump($result);

    $user = new User($result);
    //echo "<br> POST User->firstname : " . $user->getU_firstname();

    return $user;
    //return $result;
  }
}
