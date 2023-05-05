<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketType_classes.php";

class TicketTypeContr {

    public function retrieveAllTicketTypes() {
        $tt = new TicketType();
        return $tt->retrieveAllTicketTypes();
    }

    public function retrieveOneTicketType($id) {
        $tt = new TicketType();
        return $tt->retrieveOneTicketType($id);
    }

    public function createTicketType($name, $description, $price) {
        $tt = new TicketType();
        $ticketType = $tt->createTicketType($name, $description, $price);
        
        setcookie('flash_message', $ticketType[0], time() + 3, '/');
        setcookie('flash_message_type', $ticketType[1], time() + 3, '/');

        if ($ticketType[1] == "danger") {
            header("location: ../views/ticketType/createTicketType.php");
            exit();
        } else {
            header("location: ../views/ticketType/manageTicketTypes.php");
            exit();
        }
    }

    public function updateTicketType($id, $name, $description, $price) {
        $tt = new TicketType();
        $ticketType = $tt->updateTicketType($id, $name, $description, $price);

        setcookie('flash_message', $ticketType[0], time() + 3, '/');
        setcookie('flash_message_type', $ticketType[1], time() + 3, '/');

        if ($ticketType[1] == "danger") {
            header("location: ../views/ticketType/updateTicketType.php?ticketTypeId=" . $id);
            exit();
        } else {
            header("location: ../views/ticketType/manageTicketTypes.php");
            exit();
        }
    }

    public function deleteTicketType($id) {
        $tt = new TicketType();
        $ticketType = $tt->deleteTicketType($id);

        setcookie('flash_message', $ticketType[0], time() + 3, '/');
        setcookie('flash_message_type', $ticketType[1], time() + 3, '/');

        header("location: ../views/ticketType/manageTicketTypes.php");
        exit();
    }

    public function searchTicketTypes($searchText, $filter) {
        $tt = new TicketType();
        $_SESSION['ticketTypes'] = $tt->searchTicketTypes($searchText, $filter);

        header("location: ../views/ticketType/searchTicketTypes.php");
        exit();
    }
}


if (isset($_GET['deleteId'])) {
    $ttc = new TicketTypeContr();
    $ttc->deleteTicketType($_GET['deleteId']);

} else if (isset($_POST['createTicketType']) || isset($_POST['updateTicketType'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $ttc = new TicketTypeContr();

    if (isset($_POST['createTicketType'])) {
        $ttc->createTicketType($name, $description, $price);
    } else if (isset($_POST['updateTicketType']) && isset($_GET['ticketTypeId'])) {
        $ttc->updateTicketType($_GET['ticketTypeId'], $name, $description, $price);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];
    
    $ttc = new TicketTypeContr();
    $ttc->searchTicketTypes($searchText, $filter);
}