<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/login_classes.php";

class LoginContr {

    public function validateLogin($email, $password) {
        $l = new Login();
        $login = $l->validateLogin($email, $password);

        setcookie('flash_message', $login[0], time() + 3, '/');
        setcookie('flash_message_type', $login[1], time() + 3, '/');

        if ($login[1] == "danger") {
            header("location: ../views/login.php");
            exit();
        }

        header("location: ../index.php");
        exit();
    }
}