<?php

class Login extends LoginContr {

    private $email;
    private $password;

    public function __construct($email=NULL, $password=NULL) {
        $this->email = $email;
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
}