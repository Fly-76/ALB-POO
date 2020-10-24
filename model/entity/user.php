<?php
require_once "model/entity/entity.php";
class User extends Entity {
  protected ?int $u_id;
  protected ?string $u_civility;
  protected ?string $u_firstname;
  protected ?string $u_lastname;
  protected ?string $u_birthdate;
  protected ?string $u_email;
  protected ?string $u_password;
  protected ?string $u_address_line1;
  protected ?string $u_address_line2;
  protected ?string $u_zipcode;
  protected ?string $u_city;
  protected ?string $u_country;
  protected ?string $u_creation_date;
 
  public function setU_id(int $u_id):User {
      $this->u_id = $u_id;
		return $this;
	}
	public function getU_id():int {
		return $this->u_id;
	}

	public function setU_civility(string $u_civility):User {
		$this->u_civility = $u_civility;
		return $this;
	}
	public function getU_civility():string {
		return $this->u_civility;
	}

	public function setU_firstname(string $u_firstname):User {
		$this->u_firstname = $u_firstname;
		return $this;
	}
	public function getU_firstname():string {
		return $this->u_firstname;
	}

	public function setU_lastname(string $u_lastname):User {
		$this->u_lastname = $u_lastname;
		return $this;
	}
	public function getU_lastname():string {
		return $this->u_lastname;
	}

	public function setU_birthdate(string $u_birthdate):User {
		$this->u_birthdate = $u_birthdate;
		return $this;
	}
	public function getU_birthdate():string {
		return $this->u_birthdate;
	}

	public function setU_email(string $u_email):User {
		$this->u_email = $u_email;
		return $this;
	}
	public function getU_email():string {
		return $this->u_email;
	}

	public function setU_password(string $u_password):User {
		$this->u_password = $u_password;
		return $this;
	}
	public function getU_password():string {
		return $this->u_password;
	}

	public function setU_address_line1(string $u_address_line1):User {
		$this->u_address_line1 = $u_address_line1;
		return $this;
	}
	public function getU_address_line1():string {
		return $this->u_address_line1;
	}

	public function setU_address_line2(string $u_address_line2):User {
		$this->u_address_line2 = $u_address_line2;
		return $this;
	}
	public function getU_address_line2():string {
		return $this->u_address_line2;
	}

	public function setU_zipcode(string $u_zipcode):User {
		$this->u_zipcode = $u_zipcode;
		return $this;
	}
	public function getU_zipcode():string {
		return $this->u_zipcode;
	}

	public function setU_city(string $u_city):User {
		$this->u_city = $u_city;
		return $this;
	}
	public function getU_city():string {
		return $this->u_city;
	}

	public function setU_country(string $u_country):User {
		$this->u_country = $u_country;
		return $this;
	}
	public function getU_country():string {
		return $this->u_country;
	}

	public function setU_creation_date(string $u_creation_date):User {
		$this->u_creation_date = $u_creation_date;
		return $this;
	}
	public function getU_creation_date():string {
		return $this->u_creation_date;
	}

}