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

// --- UTILITY -----------------------------------------------------------------------------
// *** MOVED ***
function getUser($db, $email) {
    $query = $db->prepare("SELECT * FROM alb_users WHERE u_email = :email");
    $query->execute(["email" => $email]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// *** MOVED ***
function getAccounts($db, $userId) {
//    $query = $db->prepare("SELECT * FROM alb_accounts WHERE a_user_id = :userId AND `a_close_date` IS NULL");
//    http://www.lafabriquedecode.com/blog/2013/06/mysql-max/
$query = $db->prepare("
            SELECT *
            FROM alb_accounts
            INNER JOIN alb_transactions
            ON a_id =t_account_id
            WHERE a_user_id = :userId AND `a_close_date` IS NULL
            AND t_id = (SELECT MAX(t_id)
                        FROM alb_transactions
                        WHERE t_account_id = a_id);
            ");
    $query->execute(["userId" => $userId]);
    return $query->fetchall(PDO::FETCH_ASSOC);
}

// *** MOVED ***
function getAccount($db, $accountId) {
    $query = $db->prepare("SELECT * FROM alb_accounts WHERE a_id = :accountId");
    $query->execute(["accountId" => $accountId]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// *** MOVED ***
function getTransact($db, $accountId) {
    $query = $db->prepare("SELECT * FROM alb_transactions WHERE t_account_id = :accountId");
    $query->execute(["accountId" => $accountId]);
    return $query->fetchall(PDO::FETCH_ASSOC);
}

// *** MOVED ***
function userVerif($db, $accountId, $userId) {
    $result =false;
    $query = $db->prepare("SELECT * FROM alb_accounts WHERE a_id = :accountId AND a_user_id = :userId");
    $query->execute([
        "accountId" => $accountId,
        "userId" => $userId
    ]);
    if ($query->fetch(PDO::FETCH_ASSOC)) $result =true;
    return $result;
}

// --- VIREMENT ----------------------------------------------------------------------------
function accountNb($accountNb) {
    $pos = strrpos($accountNb, ":");
    return substr($accountNb, $pos+2);
}

function execTransfer($db, $accountDebit, $accountCredit, $amount) {
    // TODO : add data control, 
    //  -> verify existing account $accountDebit, $accountCredit
    //  -> $accountDebit must be different $accountCredit
    //  -> Some accounts can no accept negative balance (PEL, Livret A)
    //     while other must be limited to specified overdraft
    //  -> $amount > 0 , $amount <= max transfer amount value
    //  ...

    if ($accountDebit!='' && $accountCredit!='' && $amount!='') {
        $db->beginTransaction();

        $query = $db->prepare("
            INSERT INTO alb_transactions 
            VALUES (
                null,
                (SELECT a_id FROM alb_accounts WHERE a_number = :accountDebit),
                CONCAT(:opDescription, :accountCredit),
                :opName,
                :amount,
                NOW()
            )
        ");

        // Log debit transaction
        $query->execute([
            "amount" => $amount,
            "opName" => 'Debit',
            "opDescription" => 'Transfert vers ',
            "accountDebit" => accountNb($accountDebit),
            "accountCredit" => $accountCredit
        ]);

        // Log credit transaction
        $query->execute([
            "amount" => $amount,
            "opName" => 'Credit',
            "opDescription" => 'Transfert depuis ',
            "accountDebit" => accountNb($accountCredit),
            "accountCredit" => $accountDebit
        ]);

        // Update of debited account balance
        $query = $db->prepare("
            UPDATE alb_accounts
            SET a_balance = ((SELECT a_balance FROM alb_accounts WHERE a_number = :account) - :amount)
            WHERE a_number = :account;
        ");
        $query->execute([
            "amount" => $amount,
            "account" => accountNb($accountDebit)
        ]);

        // Update of credited account balance
        $query = $db->prepare("
            UPDATE alb_accounts
            SET a_balance = ((SELECT a_balance FROM alb_accounts WHERE a_number = :account) + :amount)
            WHERE a_number = :account;
        ");
        $query->execute([
            "amount" => $amount,
            "account" => accountNb($accountCredit)
        ]);

        $db->commit();
    }
}

// --- NEW ACCOUNT CREATION ----------------------------------------------------------------
function newAccount($db, $userId, $type, $amount) {

    if ($type!='' && $amount!='') {

        $query = $db->query("SELECT CONCAT( 'FR 000' ,RIGHT(MAX(a_number),11) + FLOOR(RAND()*1000)) AS accountNb FROM alb_accounts");
        $account = $query->fetch(PDO::FETCH_ASSOC);

        $accountNb = $account['accountNb'];

        $query = $db->prepare("
            INSERT INTO alb_accounts
            VALUE (
                null,
                :userId,
                :accountNb,
                :type,
                :amount,
                NOW(),
                null
            )
        ");
        $query->execute([
            "accountNb" => $accountNb,
            "amount" => $amount,
            "userId" => $userId,
            "type" => $type
        ]);

        // Log first transaction
        $query = $db->prepare("
            INSERT INTO alb_transactions 
            VALUES (
                null,
                (SELECT a_id FROM alb_accounts WHERE a_number = :accountNb),
                'Ouverture de compte',
                'Credit',
                :amount,
                NOW()
            )
        ");

        $query->execute([
            "amount" => $amount,
            "accountNb" => $accountNb
        ]);
    }
}

// --- ACCOUNT SUPPRESSION -----------------------------------------------------------------
function deleteAccount($db, $accountId) {

    if ($accountId!='') {

        $query = $db->prepare("
            DELETE FROM `alb_transactions`
            WHERE t_account_id = :accountId            
        ");
        $query->execute([
            "accountId" => $accountId
        ]);

        $query = $db->prepare("
            DELETE FROM `alb_accounts`
            WHERE a_id = :accountId            
        ");
        $query->execute([
            "accountId" => $accountId
        ]);
    }
}


// --- COUNTER OPERARATION  ----------------------------------------------------------------
function execCounterTransfer($db, $account, $type, $amount) {

    if ($account!='' && $type!='' && $amount!='') {
        $db->beginTransaction();

        // Log credit/debit transaction
        $query = $db->prepare("
            INSERT INTO alb_transactions 
            VALUES (
                null,
                :account,
                :opDescription,
                :opName,
                :amount,
                NOW()
            )
        ");

        $query->execute([
            "amount" => $amount,
            "opName" => ucfirst($type),
            "opDescription" => ucfirst($type) . ' guichet',
            "account" => $account
        ]);
        
         $query = $db->prepare("
            UPDATE alb_accounts
            SET a_balance = ((SELECT a_balance FROM alb_accounts WHERE a_id = :account) + :amount)
            WHERE a_id = :account;
        ");
        $query->execute([
            "amount" => $type=="depot"?$amount:(-1)*$amount,
            "account" => $account
        ]);

        $db->commit();
    }
}