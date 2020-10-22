<?php
// If user's not logged then go to login page
session_start();
if (!isset($_SESSION['logged']))
  header('Location: login.php');

$userId = $_SESSION['logged'];

if(isset($_GET['account']) && !empty($_GET['account'])) {
  $accountId = htmlspecialchars($_GET['account']);
  $_SESSION['account']=$accountId;
}
elseif(isset($_SESSION['account']) && !empty($_SESSION['account']))
  $accountId = htmlspecialchars($_SESSION['account']);

$type=$amount="";
if(isset($_POST['amount']) && !empty($_POST['amount'])) 
  $amount = htmlspecialchars($_POST['amount']);

if(isset($_POST['type']) && !empty($_POST['type'])) 
  $type = htmlspecialchars($_POST['type']);

require_once "model/accountModel.php";
$accountModel = new AccountModel();

if ($accountModel->userVerif($accountId, $userId)) {
  $account = $accountModel->getAccount($accountId);
  $Transfer = $accountModel->execCounterTransfer($accountId, $type, $amount);
  $account = $accountModel->getAccount($accountId);

} else header('Location: login.php');

$uName =($_SESSION['uName']);
$cnxState = 'Deconnexion';
$title = "Opération sur " . $account['a_type'] . " - " . $account['a_number'];
include "view/template/header.php";
require "view/guichetView.php";
include "view/template/footer.php";
