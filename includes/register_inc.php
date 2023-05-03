<?php

include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/register_contr.php";

if(!isset($_POST["submit"])) {
    $fullName = $_POST["fullName"];
    $email = strtolower($_POST["email"]);
    $phoneNo = $_POST["phoneNo"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    
    $rc = new RegisterContr();
    $rc->validateRegistration($fullName, $email, $phoneNo, $password1, $password2);
}