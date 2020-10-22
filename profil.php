<?php
// If user's not logged then go to login page
session_start();
if (!isset($_SESSION['logged']))
  header('Location: login.php');

$userId = $_SESSION['logged'];

require_once "model/userModel.php";
$userModel = new UserModel();
$user = $userModel->getUser($id);

$uName =($_SESSION['uName']);
$cnxState = 'Deconnexion';
$title = 'Modifier vos informations de connexion';
include "view/template/header.php";
require "view/profilView.php";
include "view/template/footer.php";

