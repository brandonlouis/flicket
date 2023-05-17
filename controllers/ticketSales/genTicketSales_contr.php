<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketSales_classes.php";

class GenTicketSalesContr {
    public function genTicketSales($timeLevel, $input) {
        $ts = new TicketSales();

        if($timeLevel == "session"){
            $_SESSION['ticketSales'] = $ts->retrieveSessionTicketSales($input);
            $_SESSION['timeLevel'] = "Session";
            $_SESSION['sessionID'] = $input;
        } else if($timeLevel == "day") {
            $_SESSION['ticketSales'] = $ts->retrieveDailyTicketSales($input);
            $_SESSION['timeLevel'] = "Day";
            $_SESSION['dayDate'] = $input;
        } else if($timeLevel == "week") {
            $_SESSION['ticketSales'] = $ts->retrieveWeeklyTicketSales($input);
            $_SESSION['timeLevel'] = "Week";
            $_SESSION['startDate'] = $input;
            $_SESSION['endDate'] = $this->endDate = date('Y-m-d', strtotime("+1 week",strtotime($input)));;
        }
        

        header("location: ../../views/ticketSalesReport/viewTicketSalesReport.php");
        exit();
    }
}

$timeLevel = $_POST['timeLevel'];
if($timeLevel == "session") {
    $gtsc = new GenTicketSalesContr();
    $gtsc->genTicketSales($timeLevel, $_POST['sessionID']);
} else if($timeLevel == "day") {
    $gtsc = new GenTicketSalesContr();
    $gtsc->genTicketSales($timeLevel, $_POST['dayDate']);
} else if($timeLevel == "week") {
    $gtsc = new GenTicketSalesContr();
    $gtsc->genTicketSales($timeLevel, $_POST['weekDate']);
} 

