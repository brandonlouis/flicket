<?php

class LoginContr extends Dbh {

    public function validateLogin($email, $password) {
        session_start();
        $l = new Login();
        $l->setEmail($email);
        $l->setPassword($password);


        $sql = "SELECT password FROM account WHERE email = ?;"; // Get hashed password from db and check email existence in db
        $stmt = $this->connect()->prepare($sql);
                
        if (!$stmt->execute(array($l->getEmail()))){ // In the event that query can't execute
            setcookie('flash_message', 'Something went wrong, please try again later', time() + 3, '/');
            setcookie('flash_message_type', 'warning', time() + 3, '/');
            
            $stmt = null;
            header("location: ../views/login.php");
            exit();
        } else if ($stmt->rowCount() == 0) { // Email does not exist in db
            setcookie('flash_message', 'Email does not exist', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            $stmt = null;
            header("location: ../views/login.php");
            exit();
        }

        $hashedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($l->getPassword(), $hashedPassword[0]['password']); // Check if input password matches hashed password

        if ($checkPassword == false) {
            setcookie('flash_message', 'Incorrect password, please try again', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            $stmt = null;
            header("location: ../views/login.php");
            exit();

        } else if ($checkPassword == true) { // Hashed password matches
            $sql = "SELECT * FROM account WHERE email = ? AND password = ?;";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute(array($l->getEmail(), $hashedPassword[0]['password']))){ // In the event that query can't execute
                setcookie('flash_message', 'Something went wrong, please try again later', time() + 3, '/');
                setcookie('flash_message_type', 'warning', time() + 3, '/');
                
                $stmt = null;
                header("location: ../views/login.php");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC); // Get user details from db

            $_SESSION['email'] = $user[0]['email']; // Set session variables for usage later
            $_SESSION['userType'] = $user[0]['userType'];

            setcookie('flash_message', 'Logged in successfully. Welcome, ' . $user[0]['fullName'] . '!', time() + 3, '/');
            setcookie('flash_message_type', 'success', time() + 3, '/');
        }

        $stmt = null;
    }
}