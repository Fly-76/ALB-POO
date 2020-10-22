<?php
// If user's not logged then go to login page
session_start();
if (!isset($_SESSION['logged']))
  header('Location: login.php');

$userId = $_SESSION['logged'];

if(isset($_GET['account']) && !empty($_GET['account'])) {
  $accountId = htmlspecialchars($_GET['account']);

  require_once "model/accountModel.php";
  $accountModel = new AccountModel();

  require_once "model/transactionModel.php";
  $transactionModel = new TransactionModel();

  if (!$accountModel->userVerif($accountId, $userId)) header('Location: login.php');

  $account = $accountModel->getAccount($accountId);
  $transact = $transactionModel->getTransactions($accountId);
}

$uName =($_SESSION['uName']);
$cnxState = 'Deconnexion';
$title = $account['a_type'] . " - " . $account['a_number'];
include "view/template/header.php";
require "view/accountView.php";
include "view/template/footer.php";

