<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketType_classes.php";

class ManageTicketTypeContr {

    public function retrieveAllTicketTypes() {
        $tt = new TicketType();
        return $tt->retrieveAllTicketTypes();
    }

    public function retrieveOneTicketType($id) {
        $tt = new TicketType();
        return $tt->retrieveOneTicketType($id);
    }
}