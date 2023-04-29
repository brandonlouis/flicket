<?php

class RegisterContr extends Dbh {

    public function validateRegistration($fullName, $email, $phoneNo, $password1, $password2) {
        session_start();
        $r = new Register();
        $r->setFullName($fullName);
        $r->setEmail($email);
        $r->setPhoneNo($phoneNo);
        $r->setPassword1($password1);
        $r->setPassword2($password2);
        

        if (strpos($r->getEmail(), '@flicket.com') === false) { // Check if @flicket.com is present in email (shouldn't be)
            if ($r->getPassword1() == $r->getPassword2()) { // Check if passwords match
                $sql = "SELECT * FROM account WHERE email = ?;";
                $stmt = $this->connect()->prepare($sql);
                
                if (!$stmt->execute(array($r->getEmail()))){ // In the event that query can't execute
                    setcookie('flash_message', 'Something went wrong, please try again later', time() + 3, '/');
                    setcookie('flash_message_type', 'warning', time() + 3, '/');
        
                    $stmt = null;
                    header("location: ../views/register.php");
                    exit();
                } else if ($stmt->rowCount() == 0) { // Email does not exist in db
                    $sql = "INSERT INTO account (fullName, email, phoneNo, password, userType) VALUES (?, ?, ?, ?, 'customer');";
                    $stmt = $this->connect()->prepare($sql);
                    
                    $hashedPwd = password_hash($r->getPassword2(), PASSWORD_DEFAULT);
                    
                    if (!$stmt->execute(array($r->getFullName(), $r->getEmail(), $r->getPhoneNo(), $hashedPwd))){ // In the event that query can't execute
                        setcookie('flash_message', 'Something went wrong, please try again later', time() + 3, '/');
                        setcookie('flash_message_type', 'warning', time() + 3, '/');
            
                        $stmt = null;
                        header("location: ../views/register.php");
                        exit();
                    }
            
                    $stmt = null;
                    
                    setcookie('flash_message', 'Account created. Please login to continue', time() + 3, '/');
                    setcookie('flash_message_type', 'success', time() + 3, '/');
                } else {
                    setcookie('flash_message', 'Email already exists', time() + 3, '/');
                    setcookie('flash_message_type', 'danger', time() + 3, '/');

                    header("location: ../views/register.php");
                    exit();
                }
            } else {
                setcookie('flash_message', 'Passwords do not match', time() + 3, '/');
                setcookie('flash_message_type', 'danger', time() + 3, '/');

                header("location: ../views/register.php");
                exit();
            }
        } else {
            setcookie('flash_message', 'Invalid email address', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/register.php");
            exit();
        }
    }
}
