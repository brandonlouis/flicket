<?php

include "../classes/dbh_classes.php";
include "../controllers/profile_contr.php";
include "../classes/profile_classes.php";

if (isset($_GET['deleteId'])) {
    $pc = new ProfileContr();
    $pc->deleteProfile($_GET['deleteId']);

} else if (isset($_POST['createProfile']) || isset($_POST['updateProfile'])) {
    $userType = $_POST["userType"];
    $description = $_POST["description"];
    $accessType = $_POST["accessType"];

    $pc = new ProfileContr();

    if (isset($_POST['createProfile'])) {
        $pc->createProfile($userType, $description, $accessType);
    } else if (isset($_POST['updateProfile']) && isset($_GET['userType'])) {
        $pc->updateProfile($_GET['userType'], $userType, $description, $accessType);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];
    
    $pc = new ProfileContr();
    $pc->searchProfiles($searchText, $filter);
}