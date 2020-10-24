<?php
require_once "model/entity/entity.php";
class Account extends Entity {
    protected ?int $a_id;
    protected ?int $a_user_id;
    protected ?string $a_number;
    protected ?string $a_type;
    protected ?float $a_balance;
    protected ?string $a_creation_date;
    protected ?string $a_close_date;

	public function setA_id(int $a_id):Account {
		$this->a_id = $a_id;
		return $this;
	}
	public function getA_id():int {
		return $this->a_id;
	}

	public function setA_account_id(int $a_account_id):Account {
		$this->a_account_id = $a_account_id;
		return $this;
	}
	public function getA_account_id():int {
		return $this->a_account_id;
	}

	public function setA_description(string $a_description):Account {
		$this->a_description = $a_description;
		return $this;
	}
	public function getA_description():string {
		return $this->a_description;
	}

	public function setA_type(string $a_type):Account {
		$this->a_type = $a_type;
		return $this;
	}
	public function getA_type():string {
		return $this->a_type;
	}

	public function setA_amount(float $a_amount):Account {
		$this->a_amount = $a_amount;
		return $this;
	}
	public function getA_amount():float {
		return $this->a_amount;
	}

	public function setA_date(string $a_date):Account {
		$this->a_date = $a_date;
		return $this;
	}
	public function getA_date():string {
		return $this->a_date;
	}
}