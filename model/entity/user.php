<?php
class User {
    protected ?integer $u_id;
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

    public function __construct(array $data) {
      $this->hydrate($data);
    }
  
    private function hydrate(array $data) {
      foreach ($data as $key => $value) {
        $method = "set" . ucfirst($key);
        if(method_exists($this, $method)) {
          $this->$method($value);
        }
      }
    }  
}