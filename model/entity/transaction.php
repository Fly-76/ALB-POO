<?php
require_once "model/entity/entity.php";
class Transaction extends Entity {
    protected ?int $t_id;
    protected ?int $t_account_id;
    protected ?string $t_description;
    protected ?string $t_type;
    protected ?float $t_amount;
    protected ?string $t_date;

	public function setT_id(int $t_id):Transaction {
		$this->t_id = $t_id;
		return $this;
	}
	public function getT_id():int {
		return $this->t_id;
	}

	public function setT_Account_id(int $t_Account_id):Transaction {
		$this->t_Account_id = $t_Account_id;
		return $this;
	}
	public function getT_Account_id():int {
		return $this->t_Account_id;
	}

	public function setT_number(string $t_number):Transaction {
		$this->t_number = $t_number;
		return $this;
	}
	public function getT_number():string {
		return $this->t_number;
	}

	public function setT_type(string $t_type):Transaction {
		$this->t_type = $t_type;
		return $this;
	}
	public function getT_type():string {
		return $this->t_type;
	}

	public function setT_balance(float $t_balance):Transaction {
		$this->t_balance = $t_balance;
		return $this;
	}
	public function getT_balance():float {
		return $this->t_balance;
	}

	public function setT_creation_date(string $t_creation_date):Transaction {
		$this->t_creation_date = $t_creation_date;
		return $this;
	}
	public function getT_creation_date():string {
		return $this->t_creation_date;
	}

	public function setT_close_date(string $t_close_date):Transaction {
		$this->t_close_date = $t_close_date;
		return $this;
	}
	public function getT_close_date():string {
		return $this->t_close_date;
	}

}