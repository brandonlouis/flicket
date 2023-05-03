<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/register_classes.php";

class RegisterContr {
    public function validateRegistration($fullName, $email, $phoneNo, $password1, $password2) {
        $r = new Register();
        $register = $r->validateRegistration($fullName, $email, $phoneNo, $password1, $password2);
        
        setcookie('flash_message', $register[0], time() + 3, '/');
        setcookie('flash_message_type', $register[1], time() + 3, '/');

        if ($register[1] == "danger") {
            header("location: ../views/register.php");
            exit();
        }

        header("location: ../views/login.php?email=" . $email);
        exit();
    }
}
