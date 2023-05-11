<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/account_classes.php";

class AccountContr {

    public function retrieveAllAccounts() {
        $a = new Account();
        return $a->retrieveAllAccounts();
    }

    public function retrieveOneAccount($id) {
        $a = new Account();
        return $a->retrieveOneAccount($id);
    }

    public function createAccount($userType, $fullName, $email, $phoneNo, $password1, $password2) {
        $a = new Account();
        $account = $a->createAccount($userType, $fullName, $email, $phoneNo, $password1, $password2);
        
        setcookie('flash_message', $account[0], time() + 3, '/');
        setcookie('flash_message_type', $account[1], time() + 3, '/');

        if ($account[1] == "danger") {
            header("location: ../views/account/createAccount.php");
            exit();
        } else {
            header("location: ../views/account/manageAccounts.php");
            exit();
        }
    }

    public function updateAccount($id, $userType, $fullName, $email, $phoneNo, $password1, $password2) {
        $a = new Account();
        $account = $a->updateAccount($id, $userType, $fullName, $email, $phoneNo, $password1, $password2);
        
        setcookie('flash_message', $account[0], time() + 3, '/');
        setcookie('flash_message_type', $account[1], time() + 3, '/');

        if ($account[1] == "danger") {
            header("location: ../views/account/updateAccount.php?id=" . $id);
            exit();
        } else {
            header("location: ../views/account/manageAccounts.php");
            exit();
        }
    }

    public function deleteAccount($id) {
        $a = new Account();
        $account = $a->deleteAccount($id);
        
        setcookie('flash_message', $account[0], time() + 3, '/');
        setcookie('flash_message_type', $account[1], time() + 3, '/');

        if($_SESSION['userType'] !== 'userAdmin') {
            header("location: /flicket/controllers/logout_contr.php");
        } else {
            header("location: ../views/account/manageAccounts.php");
        }
        exit();
    }

    public function searchAccounts($searchText, $filter) {
        $a = new Account();
        $_SESSION['accounts'] = $a->searchAccounts($searchText, $filter);

        header("location: ../views/account/searchAccounts.php");
        exit();
    }
}


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