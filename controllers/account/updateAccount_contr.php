<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/account_classes.php";

class UpdateAccountContr {
    public function updateAccount($id, $userType, $fullName, $email, $phoneNo, $password1, $password2) {
        $a = new Account();
        $account = $a->updateAccount($id, $userType, $fullName, $email, $phoneNo, $password1, $password2);
        
        setcookie('flash_message', $account[0], time() + 3, '/');
        setcookie('flash_message_type', $account[1], time() + 3, '/');

        if ($account[1] == "danger") {
            header("location: ../../views/account/updateAccount.php?id=" . $id);
            exit();
        } else {
            header("location: ../../views/account/manageAccounts.php");
            exit();
        }
    }
}

$userType = $_POST["userType"];
$fullName = $_POST["fullName"];
$email = strtolower($_POST["email"]);
$phoneNo = $_POST["phoneNo"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];

$uac = new UpdateAccountContr();
$uac->updateAccount($_GET['id'], $userType, $fullName, $email, $phoneNo, $password1, $password2);