<?php

class Account extends AccountContr {

    private $id;
    private $fullName;
    private $email;
    private $phoneNo;
    private $password1;
    private $password2;
    private $userType;

    public function __construct($id=NULL, $fullName=NULL, $email=NULL, $phoneNo=NULL, $password1=NULL, $password2=NULL, $userType=NULL) {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNo = $phoneNo;
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->userType = $userType;
    }

    public function getId() {
        return $this->id;
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
    public function getUserType() {
        return $this->userType;
    }

    public function setId($id) {
        $this->id = $id;
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
    public function setUserType($userType) {
        $this->userType = $userType;
    }
}