<?php

class TicketSales extends Dbh {

    private $id;
    private $sessionID;
    private $ticketType;

    //format: 'YYYY-MM-DD'
    private $dayDate;
    private $startDate;
    private $endDate;

    public function retrieveSessionTicketSales($sessionID) {
        session_start();
        $this->sessionID = $sessionID;

        $sql = "SELECT ticket.ticketType, tickettype.price, COUNT(*) FROM ticket 
                JOIN tickettype
                ON ticket.ticketType = tickettype.name
                JOIN session
                ON ticket.sessionID = session.id
                WHERE session.id = ?
                GROUP BY ticket.ticketType
                ORDER BY ticket.ticketType ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->sessionID]);

        $ticketSales = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketSales[] = $row;
        }

        $stmt = null;
        return $ticketSales;
    }

    public function retrieveDailyTicketSales($dayDate) {
        session_start();
        $this->dayDate = $dayDate;

        $sql = "SELECT ticket.ticketType, tickettype.price, COUNT(*) FROM ticket 
                JOIN tickettype
                ON ticket.ticketType = tickettype.name
                JOIN session
                ON ticket.sessionID = session.id
                WHERE session.startTime LIKE ?
                AND session.endTime LIKE ?
                AND ticket.status = 'Available'
                GROUP BY ticket.ticketType
                ORDER BY ticket.ticketType ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['%' . $this->dayDate . '%','%' . $this->dayDate . '%']);

        $ticketSales = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketSales[] = $row;
        }

        $stmt = null;
        return $ticketSales;
    }

    public function retrieveWeeklyTicketSales($startDate) {
        session_start();
        $this->startDate = $startDate;
        $this->endDate = date('Y-m-d', strtotime("+1 week",strtotime($startDate)));

        $sql = "SELECT ticket.ticketType, tickettype.price, COUNT(*) FROM ticket 
                JOIN tickettype
                ON ticket.ticketType = tickettype.name
                JOIN session
                ON ticket.sessionID = session.id
                WHERE CAST(session.startTime AS DATE) >= ?
                AND CAST(session.startTime AS DATE) < ?
                AND ticket.status = 'Available'
                GROUP BY ticket.ticketType
                ORDER BY ticket.ticketType ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->startDate, $this->endDate]);

        $ticketSales = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketSales[] = $row;
        }

        $stmt = null;
        return $ticketSales;
    }

    
}