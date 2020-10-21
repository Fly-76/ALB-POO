<?php
require_once "model/entity/database.php";

function getTransact($db, $accountId) {
    $query = $db->prepare("SELECT * FROM alb_transactions WHERE t_account_id = :accountId ORDER BY t_id DESC");
    $query->execute(["accountId" => $accountId]);
    return $query->fetchall(PDO::FETCH_ASSOC);
}
