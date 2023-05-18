<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketSales_classes.php";

class GenDailyTicketSalesContr {
    public function genDailyTicketSales($dayDate) {
        $ts = new TicketSales();

        $_SESSION['ticketSales'] = $ts->retrieveDailyTicketSales($dayDate);
        $_SESSION['timeLevel'] = "Day";
        $_SESSION['dayDate'] = $dayDate;

        header("location: ../../views/ticketSalesReport/viewTicketSalesReport.php");
        exit();
    }
}

$dayDate = $_POST['dayDate'];
$gdtsc = new GenDailyTicketSalesContr();
$gdtsc->genDailyTicketSales($dayDate);