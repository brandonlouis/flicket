<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/profile_classes.php";

class UpdateProfileContr {
    public function updateProfile($oldUserType, $userType, $description, $accessType) {
        $p = new Profile();
        $profile = $p->updateProfile($oldUserType, $userType, $description, $accessType);
        
        setcookie('flash_message', $profile[0], time() + 3, '/');
        setcookie('flash_message_type', $profile[1], time() + 3, '/');

        if ($profile[1] == "danger") {
            header("location: ../../views/profile/updateProfile.php?userType=" . $oldUserType);
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

$upc = new UpdateProfileContr();
$upc->updateProfile($_GET['userType'], $userType, $description, $accessType);