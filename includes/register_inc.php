<?php

if(!isset($_POST["submit"])) {
    $fullName = $_POST["fullName"];
    $email = strtolower($_POST["email"]);
    $phoneNo = $_POST["phoneNo"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    include "../classes/dbh_classes.php";
    include "../classes/register_contr.php";
    include "../classes/register_classes.php";
    
    $rc = new RegisterContr();
    $rc->validateRegistration($fullName, $email, $phoneNo, $password1, $password2);

    header("location: ../views/login.php?email=" . $email);
}