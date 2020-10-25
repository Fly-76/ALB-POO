<?php
class Entity {

    public function __construct(array $data) {
        //echo "<br> Initialisation de l'objet ";
        $this->hydrate($data);
    }
    private function hydrate(array $data) {

        foreach ($data as $key => $value) {

            $method = "set" . ucfirst($key);
            if(method_exists($this, $method)) {
                //echo "<br>key : " . $key . " / value : " . $value;
                $this->$method($value);
            }
        }
    }
}