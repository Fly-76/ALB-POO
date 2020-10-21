<?php
// If user's not logged then go to login page
session_start();
if (!isset($_SESSION['logged']))
  header('Location: login.php');

$userId = $_SESSION['logged'];

if(isset($_GET['account']) && !empty($_GET['account'])) {
  $accountId = htmlspecialchars($_GET['account']);

  require "model/accountModel.php";
  require "model/transactionModel.php";
  $db = dbConnect();
  if (!userVerif($db, $accountId, $userId)) header('Location: login.php');

  $account = getAccount($db, $accountId);
  $transact = getTransact($db, $accountId);
}

$uName =($_SESSION['uName']);
$cnxState = 'Deconnexion';
$title = $account['a_type'] . " - " . $account['a_number'];
include "view/template/header.php";
require "view/accountView.php";
include "view/template/footer.php";

