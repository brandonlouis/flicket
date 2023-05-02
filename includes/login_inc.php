<?php

if(!isset($_POST["submit"])) {
    $email = strtolower($_POST["loginEmail"]);
    $password = $_POST["loginPassword"];

    include "../classes/dbh_classes.php";
    include "../controllers/login_contr.php";
    include "../classes/login_classes.php";
    
    $lc = new LoginContr();
    $lc->validateLogin($email, $password);

    header("location: ../index.php");
}