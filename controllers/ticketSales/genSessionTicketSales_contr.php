<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketSales_classes.php";

class GenSessionTicketSalesContr {
    public function genSessionTicketSales($sessionID) {
        $ts = new TicketSales();

        $_SESSION['ticketSales'] = $ts->retrieveSessionTicketSales($sessionID);
        $_SESSION['timeLevel'] = "Session";
        $_SESSION['sessionID'] = $sessionID;

        header("location: ../../views/ticketSalesReport/viewTicketSalesReport.php");
        exit();
    }
}

$sessionID = $_POST['sessionID'];
$gstsc = new GenSessionTicketSalesContr();
$gstsc->genSessionTicketSales($sessionID);
