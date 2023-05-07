<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/deal_classes.php";

class DealContr {

    public function retrieveAllDeals() {
        $d = new Deal();
        return $d->retrieveAllDeals();
    }

    public function retrieveOneDeal($id) {
        $d = new Deal();
        return $d->retrieveOneDeal($id);
    }

    public function createDeal($dealName, $description, $price, $suspendStatus, $image, $fnbItems) {
        $d = new Deal();
        $deal = $d->createDeal($dealName, $description, $price, $suspendStatus, $image, $fnbItems);
        
        setcookie('flash_message', $deal[0], time() + 3, '/');
        setcookie('flash_message_type', $deal[1], time() + 3, '/');

        header("location: ../views/dealMgmt/manageDeals.php");
        exit();
    }

    public function updateDeal($id, $itemName, $description, $price, $suspendStatus, $image, $fnbItems) {
        $d = new Deal();
        $deal = $d->updateDeal($id, $itemName, $description, $price, $suspendStatus, $image, $fnbItems);

        setcookie('flash_message', $deal[0], time() + 3, '/');
        setcookie('flash_message_type', $deal[1], time() + 3, '/');

        header("location: ../views/dealMgmt/manageDeals.php");
        exit();
    }

    public function deleteDeal($id) {
        $d = new Deal();
        $deal = $d->deleteDeal($id);

        setcookie('flash_message', $deal[0], time() + 3, '/');
        setcookie('flash_message_type', $deal[1], time() + 3, '/');

        header("location: ../views/dealMgmt/manageDeals.php");
        exit();
    }

    public function searchDeals($searchText, $filter) {

        $d = new Deal();
        $_SESSION['deals'] = $d->searchDeals($searchText, $filter);
        header("location: ../views/dealMgmt/searchDeals.php");
        exit();
    }

    public function getFnBItemInDeals($id) {
        $d = new Deal();
        return $d->getFnBItemInDeals($id);
    }
}

if (isset($_GET['deleteId'])) {
    $dc = new DealContr();
    $dc->deleteDeal($_GET['deleteId']);

} else if (isset($_POST['createDeal']) || isset($_POST['updateDeal'])) {
    $dealName = $_POST["dealName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $suspendStatus = $_POST["suspendStatus"];
    $fnbItems = explode(", ", $_POST["fnbItem"]);
    $image = null;
    if (isset($_FILES["imgFile"]) && $_FILES["imgFile"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $imageContents = file_get_contents($_FILES["imgFile"]["tmp_name"]);
        $image = base64_encode($imageContents);
    }
    
    $dc = new DealContr();

    if (isset($_POST['createDeal'])) {
        $dc->createDeal($dealName, $description, $price, $suspendStatus, $image, $fnbItems);
    } else if (isset($_POST['updateDeal']) && isset($_GET['dealId'])) {
        $dc->updateDeal($_GET['dealId'], $dealName, $description, $price, $suspendStatus, $image, $fnbItems);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];

    if ($filter == 'suspendStatus'){
        if(preg_match('/not suspended/i',$searchText) == 1){
            $searchText = 0;
        } else if(preg_match('/suspended/i',$searchText) == 1) {
            $searchText = 1;
        }
    }

    $dc = new DealContr();
    $dc->searchDeals($searchText, $filter);
} 