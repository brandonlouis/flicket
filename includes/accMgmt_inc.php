<?php

include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/account_contr.php";

if (isset($_GET['deleteId'])) {
    $amc = new AccountContr();
    $amc->deleteAccount($_GET['deleteId']);

} else if (isset($_POST['createAccount']) || isset($_POST['updateAccount'])) {
    $userType = $_POST["userType"];
    $fullName = $_POST["fullName"];
    $email = strtolower($_POST["email"]);
    $phoneNo = $_POST["phoneNo"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    $amc = new AccountContr();

    if (isset($_POST['createAccount'])) {
        $amc->createAccount($userType, $fullName, $email, $phoneNo, $password1, $password2);
    } else if (isset($_POST['updateAccount']) && isset($_GET['id'])) {
        $amc->updateAccount($_GET['id'], $userType, $fullName, $email, $phoneNo, $password1, $password2);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];
    
    $amc = new AccountContr();
    $amc->searchAccounts($searchText, $filter);
}