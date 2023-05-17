<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/account_classes.php";

class DeleteAccountContr {
    public function deleteAccount($id) {
        $a = new Account();
        $account = $a->deleteAccount($id);
        
        setcookie('flash_message', $account[0], time() + 3, '/');
        setcookie('flash_message_type', $account[1], time() + 3, '/');

        if($_SESSION['userType'] !== 'userAdmin') {
            session_start();
            session_unset();
            session_destroy();

            setcookie('flash_message', 'Account suspended successfully!', time() + 3, '/');
            header("location: ../../index.php");
        } else {
            header("location: ../../views/account/manageAccounts.php");
        }
        exit();
    }
}

$dac = new DeleteAccountContr();
$dac->deleteAccount($_GET['deleteId']);