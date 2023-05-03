<?php

include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/login_contr.php";

if(!isset($_POST["submit"])) {
    $email = strtolower($_POST["loginEmail"]);
    $password = $_POST["loginPassword"];
    
    $lc = new LoginContr();
    $lc->validateLogin($email, $password);
}