<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/profile_classes.php";

class CreateProfileContr {
    public function createProfile($userType, $description, $accessType) {
        $p = new Profile();
        $profile = $p->createProfile($userType, $description, $accessType);
        
        setcookie('flash_message', $profile[0], time() + 3, '/');
        setcookie('flash_message_type', $profile[1], time() + 3, '/');

        if ($profile[1] == "danger") {
            header("location: ../../views/profile/createProfile.php");
            exit();
        } else {
            header("location: ../../views/profile/manageProfiles.php");
            exit();
        }
    }
}

$userType = $_POST["userType"];
$description = $_POST["description"];
$accessType = $_POST["accessType"];

$cpc = new CreateProfileContr();
$cpc->createProfile($userType, $description, $accessType);