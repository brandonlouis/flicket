<?php

class RegisterContr extends RegisterDBA {

    public function validateRegistration($fullName, $email, $phoneNo, $password1, $password2) {
        session_start();
        $r = new Register();
        $r->setFullName($fullName);
        $r->setEmail($email);
        $r->setPhoneNo($phoneNo);
        $r->setPassword1($password1);
        $r->setPassword2($password2);
        
        $sql = "SELECT * FROM account WHERE email = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($r->getEmail()));

        if ($stmt->rowCount() > 0) {
            setcookie('flash_message', 'Email already exists', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/register.php");
            exit();
        } else if (strpos($r->getEmail(), '@flicket.com') !== false) {
            setcookie('flash_message', 'Invalid email address', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/register.php");
            exit();
        } else if ($r->getPassword1() != $r->getPassword2()) {
            setcookie('flash_message', 'Passwords do not match', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/register.php");
            exit();
        } else {
            $sql = "INSERT INTO account (fullName, email, phoneNo, password, userType) VALUES (?, ?, ?, ?, 'customer');";
            $stmt = $this->connect()->prepare($sql);
            
            $hashedPwd = password_hash($r->getPassword2(), PASSWORD_DEFAULT);
            $stmt->execute(array($r->getFullName(), $r->getEmail(), $r->getPhoneNo(), $hashedPwd));
    
            $stmt = null;
            
            setcookie('flash_message', 'Account created. Please login to continue', time() + 3, '/');
            setcookie('flash_message_type', 'success', time() + 3, '/');
        }
    }
}
