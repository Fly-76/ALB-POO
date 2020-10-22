<?php
// *** First check db connexion, !!! Database class not yet abstract
// require_once "model/entity/database.php";
// $DBConnection = new Database();

// *** Now set Database to abstract and check child creation
    require_once "model/userModel.php";
    $userModel = new UserModel();

    require_once "model/accountModel.php";
    $accountModel = new AccountModel();

    require_once "model/transactionModel.php";
    $transactionModel = new TransactionModel();

// *** Check userModel
    echo "<br>";
    $user = $userModel->getUser('root@gmail.com');
    var_dump($user);
    echo "<br>";

// *** Check transactionModel
    echo "<br>";
    $transaction = $transactionModel->getTransactions(3);
    var_dump($transaction);
    echo "<br>";

// *** Check accountModel
    echo "<br>";
    if ($accountModel->userVerif(1, 1))
        echo "Verif Successed";
    else        
        echo "Verif Failed";
    echo "<br>";

    echo "<br>";
    $accounts = $accountModel->getAccounts(3);
    var_dump($accounts);
    echo "<br>";

    echo "<br> ACCOUNT";
    $account = $accountModel->getAccount(3);
    var_dump($account);
    echo "<br>";




 
