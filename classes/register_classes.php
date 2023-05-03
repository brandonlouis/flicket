<?php

class Register extends Dbh {

    private $fullName;
    private $email;
    private $phoneNo;
    private $password1;
    private $password2;

    
    public function validateRegistration($fullName, $email, $phoneNo, $password1, $password2) {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNo = $phoneNo;
        $this->password1 = $password1;
        $this->password2 = $password2;

        $sql = "SELECT * FROM account WHERE email = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->email]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Email already exists", "danger");

        } else if (strpos($this->email, '@flicket.com') !== false) {
            $stmt = null;
            return array("Invalid email address", "danger");

        } else if ($this->password1 != $this->password2) {
            $stmt = null;
            return array("Passwords do not match", "danger");

        } else {
            $sql = "INSERT INTO account (fullName, email, phoneNo, password, userType) VALUES (?, ?, ?, ?, 'customer');";
            $stmt = $this->connect()->prepare($sql);
            
            $hashedPwd = password_hash($this->password2, PASSWORD_DEFAULT);
            $stmt->execute([$this->fullName, $this->email, $this->fullName, $hashedPwd]);
    
            $stmt = null;
            return array("Account created. Please login to continue", "success");
        }
    }
}