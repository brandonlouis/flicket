<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/profile_classes.php";

class DeleteProfileContr {
    public function deleteProfile($userType) {
        $p = new Profile();
        $profile = $p->deleteProfile($userType);

        setcookie('flash_message', $profile[0], time() + 3, '/');
        setcookie('flash_message_type', $profile[1], time() + 3, '/');

        header("location: ../../views/profile/manageProfiles.php");
        exit();
    }
}

$dpc = new DeleteProfileContr();
$dpc->deleteProfile($_GET['deleteId']);