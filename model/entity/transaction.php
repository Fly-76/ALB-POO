<?php
class Transaction {
    protected ?integer $t_id;
    protected ?integer $t_account_id;
    protected ?string $t_description;
    protected ?string $t_type;
    protected ?float $t_amount;
    protected ?string $t_date;
}