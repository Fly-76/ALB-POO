<?php

class Form {
    protected $html;

    public function __construct(string $action="", string $method="POST") {
        $this->html = "<div class='container'><div class='row'>"
                    . "<form action='" . $action . "' method='" . $method . "'>";
    }

    public function setText(string $reference, string $text, string $value){
        $this->html .= "<div class='d-flex justify-content-between mb-2 col8'>" 
        . "<label for='" . $reference . "'>" . $text . "</label>"
        . "<input type='text' name='". $reference . "' id='". $reference . "' value='" . $value ."'/></div>";
    }

    public function setCheckBox(string $text){
        $this->html .= "<div class='d-flex justify-content-between mb-2 col8'>" 
        . "<label for='" . lcfirst($text) . "'>" . $text . "</label>"
        . "<input type='checkbox' name='". lcfirst($text) . " 'id='". lcfirst($text) . "'/></div>";
    }
    
    public function setRadio(string $text, array $inputs){
        $this->html .= "<div>". $text . "</div><div class='d-flex justify-content-between mb-2 col8'>";
        foreach ($inputs as $value) {
            $this->html .=  "<span><label for='" . lcfirst($value) . "'>" . $value . "</label>";
            $this->html .=  "<input type='radio' name='". lcfirst($text) . " 'id='". lcfirst($value) . "'/></span>";
        }
        $this->html .= "</div>";
    }

    public function setSubmit(string $name, string $text){
        $this->html .= "<div class='d-flex justify-content-end mt-3'><input type='submit' class='btn btn-primary' name='" . $name ."' value='" . $text ."'></div>";
    }

    public function showForm(){
        echo $this->html . "</form></div></div>";
    }
}


