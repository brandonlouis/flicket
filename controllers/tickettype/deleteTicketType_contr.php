<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketType_classes.php";

class DeleteTicketTypeContr {
    public function deleteTicketType($id) {
        $tt = new TicketType();
        $ticketType = $tt->deleteTicketType($id);

        setcookie('flash_message', $ticketType[0], time() + 3, '/');
        setcookie('flash_message_type', $ticketType[1], time() + 3, '/');

        header("location: ../../views/ticketType/manageTicketTypes.php");
        exit();
    }
}

$ttc = new DeleteTicketTypeContr();
$ttc->deleteTicketType($_GET['deleteId']);