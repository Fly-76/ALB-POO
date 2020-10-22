<?php
require_once "model/entity/database.php";

class AccountModel extends Database {

    public function getAccount($accountId) {
        $db = parent::getDB();
        $query = $db->prepare("SELECT * FROM alb_accounts WHERE a_id = :accountId");
        $query->execute(["accountId" => $accountId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAccounts($userId) {
        $db = parent::getDB();
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

    public function userVerif($accountId, $userId) {
        $result =false;
        $db = parent::getDB();
        $query = $db->prepare("SELECT * FROM alb_accounts WHERE a_id = :accountId AND a_user_id = :userId");
        $query->execute([
            "accountId" => $accountId,
            "userId" => $userId
        ]);
        if ($query->fetch(PDO::FETCH_ASSOC)) $result =true;
        return $result;
    }

    // --- NEW ACCOUNT CREATION ----------------------------------------------------------------
    function newAccount($userId, $type, $amount) {

        $db = parent::getDB();
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
    function deleteAccount($accountId) {

        $db = parent::getDB();

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

    // --- VIREMENT ----------------------------------------------------------------------------
    private function accountNb($accountNb) {
        $pos = strrpos($accountNb, ":");
        return substr($accountNb, $pos+2);
    }

    public function execTransfer($accountDebit, $accountCredit, $amount) {

        $db = parent::getDB();
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
                "accountDebit" => $this->accountNb($accountDebit),
                "accountCredit" => $accountCredit
            ]);

            // Log credit transaction
            $query->execute([
                "amount" => $amount,
                "opName" => 'Credit',
                "opDescription" => 'Transfert depuis ',
                "accountDebit" => $this->accountNb($accountCredit),
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
                "account" => $this->accountNb($accountDebit)
            ]);

            // Update of credited account balance
            $query = $db->prepare("
                UPDATE alb_accounts
                SET a_balance = ((SELECT a_balance FROM alb_accounts WHERE a_number = :account) + :amount)
                WHERE a_number = :account;
            ");
            $query->execute([
                "amount" => $amount,
                "account" => $this->accountNb($accountCredit)
            ]);

            $db->commit();
        }
    }

    // --- COUNTER OPERARATION  ----------------------------------------------------------------
    function execCounterTransfer($account, $type, $amount) {

        $db = parent::getDB();
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
}
