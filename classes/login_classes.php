<?php

class Login extends Dbh {

    private $email;
    private $password;

    
    public function validateLogin($email, $password) {
        session_start();
        $this->email = $email;
        $this->password = $password;

        $sql = "SELECT password FROM account WHERE email = ?;"; // Get hashed password from db and check email existence in db
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->email]);

        if ($stmt->rowCount() == 0) { // Email does not exist in db
            $stmt = null;
            return array("Email does not exist", "danger");
        }

        $hashedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($this->password, $hashedPassword[0]['password']); // Check if input password matches hashed password

        if ($checkPassword == false) {
            $stmt = null;
            return array("Incorrect password, please try again", "danger");

        } else if ($checkPassword == true) { // Hashed password matches
            $sql = "SELECT * FROM account WHERE email = ? AND password = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->email, $hashedPassword[0]['password']]);
            
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC); // Get user details from db

            $_SESSION['email'] = $user[0]['email']; // Set session variables for usage later
            $_SESSION['userType'] = $user[0]['userType'];

            $stmt = null;
            return array('Logged in successfully. Welcome, ' . $user[0]['fullName'] . '!', "success");
        }
    }
}