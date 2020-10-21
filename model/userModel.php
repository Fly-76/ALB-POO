<?php
require_once "model/entity/database.php";

function getUser($db, $email) {
    $query = $db->prepare("SELECT * FROM alb_users WHERE u_email = :email");
    $query->execute(["email" => $email]);
    return $query->fetch(PDO::FETCH_ASSOC);
}


class UserModel extends Database {

    public function getUser($email):array {
        $query = $this->db->query("SELECT * FROM student");
        $students = $query->fetchAll(PDO::FETCH_ASSOC);
        // Parcours le tableau et transforme chaque tableau associatif en objet
        foreach ($students as $key => $value) {
          $students[$key] = new Student($value);
        }
        return $students;
      }
}