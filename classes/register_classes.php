<?php

class Register extends RegisterContr {

    private $fullName;
    private $email;
    private $phoneNo;
    private $password1;
    private $password2;

    public function __construct($fullName=NULL, $email=NULL, $phoneNo=NULL, $password1=NULL, $password2=NULL) {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNo = $phoneNo;
        $this->password1 = $password1;
        $this->password2 = $password2;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPhoneNo($phoneNo) {
        $this->phoneNo = $phoneNo;
    }
    public function setPassword1($password1) {
        $this->password1 = $password1;
    }
    public function setPassword2($password2) {
        $this->password2 = $password2;
    }

    public function getFullName() {
        return $this->fullName;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPhoneNo() {
        return $this->phoneNo;
    }
    public function getPassword1() {
        return $this->password1;
    }
    public function getPassword2() {
        return $this->password2;
    }
}