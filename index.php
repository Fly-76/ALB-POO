<?php
// If user's not logged then go to login page
session_start();
if (!isset($_SESSION['logged']))
  header('Location: login.php');

$userId = $_SESSION['logged'];

require "model/accountModel.php";
$accountModel = new AccountModel();
$accounts = $accountModel->getAccounts($userId);

$uName =($_SESSION['uName']);
$cnxState = 'Deconnexion';
$title = "Consulter vos comptes";
include "view/template/header.php";
require "view/indexView.php";
include "view/template/footer.php";

