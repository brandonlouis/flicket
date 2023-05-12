<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketType_classes.php";

class UpdateTicketTypeContr {
    public function updateTicketType($id, $name, $description, $price) {
        $tt = new TicketType();
        $ticketType = $tt->updateTicketType($id, $name, $description, $price);

        setcookie('flash_message', $ticketType[0], time() + 3, '/');
        setcookie('flash_message_type', $ticketType[1], time() + 3, '/');

        if ($ticketType[1] == "danger") {
            header("location: ../../views/ticketType/updateTicketType.php?ticketTypeId=" . $id);
            exit();
        } else {
            header("location: ../../views/ticketType/manageTicketTypes.php");
            exit();
        }
    }
}

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

$ttc = new UpdateTicketTypeContr();
$ttc->updateTicketType($_GET['ticketTypeId'], $name, $description, $price);