<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/profile_classes.php";

class ProfileContr {

    public function retrieveAllProfiles() {
        $p = new Profile();
        return $p->retrieveAllProfiles();
    }

    public function retrieveOneProfile($userType) {
        $p = new Profile();
        return $p->retrieveOneProfile($userType);
    }

    public function createProfile($userType, $description, $accessType) {
        $p = new Profile();
        $profile = $p->createProfile($userType, $description, $accessType);
        
        setcookie('flash_message', $profile[0], time() + 3, '/');
        setcookie('flash_message_type', $profile[1], time() + 3, '/');

        if ($profile[1] == "danger") {
            header("location: ../views/profile/createProfile.php");
            exit();
        } else {
            header("location: ../views/profile/manageProfiles.php");
            exit();
        }
    }

    public function updateProfile($oldUserType, $userType, $description, $accessType) {
        $p = new Profile();
        $profile = $p->updateProfile($oldUserType, $userType, $description, $accessType);
        
        setcookie('flash_message', $profile[0], time() + 3, '/');
        setcookie('flash_message_type', $profile[1], time() + 3, '/');

        if ($profile[1] == "danger") {
            header("location: ../views/profile/createProfile.php");
            exit();
        } else {
            header("location: ../views/profile/manageProfiles.php");
            exit();
        }
    }

    public function deleteProfile($userType) {
        $p = new Profile();
        $profile = $p->deleteProfile($userType);

        setcookie('flash_message', $profile[0], time() + 3, '/');
        setcookie('flash_message_type', $profile[1], time() + 3, '/');

        header("location: ../views/profile/manageProfiles.php");
        exit();
    }

    public function searchProfiles($searchText, $filter) {
        $p = new Profile();
        $_SESSION['profiles'] = $p->searchProfiles($searchText, $filter);

        header("location: ../views/profile/searchProfiles.php");
        exit();
    }
}