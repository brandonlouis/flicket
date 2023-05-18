<?php

class CinemaUtil extends Dbh {

    //session related attr
    private $id;
    private $movieId;
    private $hallId;

    //cinemahall related attr
    private $capacity;

    //format: 'YYYY-MM-DD'
    private $dayDate;
    private $startDate;
    private $endDate;

    public function retrieveSessionCinemaUtil($id) {
        session_start();
        $this->id = $id;

        $sql = "SELECT session.id, cinemahall.capacity, COUNT(*) 
                FROM session 
                JOIN ticket
                ON session.id = ticket.sessionID
                JOIN cinemahall
                ON session.hallId = cinemahall.id
                WHERE session.id = ?
                GROUP BY session.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $cinemaUtil = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cinemaUtil[] = $row;
        }

        $stmt = null;
        return $cinemaUtil;
    }

    public function retrieveDailyCinemaUtil($dayDate) {
        session_start();
        $this->dayDate = $dayDate;

        $sql = "SELECT session.id, cinemahall.capacity, COUNT(*) 
                FROM session 
                JOIN ticket
                ON session.id = ticket.sessionID
                JOIN cinemahall
                ON session.hallId = cinemahall.id
                WHERE session.startTime LIKE ?
                AND session.endTime LIKE ?
                AND ticket.status = 'Available'
                GROUP BY session.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['%' . $this->dayDate . '%','%' . $this->dayDate . '%']);

        $cinemaUtil = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cinemaUtil[] = $row;
        }

        $stmt = null;
        return $cinemaUtil;
    }

    public function retrieveWeeklyCinemaUtil($startDate) {
        session_start();
        $this->startDate = $startDate;
        $this->endDate = date('Y-m-d', strtotime("+1 week",strtotime($startDate)));;

        $sql = "SELECT session.id, cinemahall.capacity, COUNT(*) 
                FROM session 
                JOIN ticket
                ON session.id = ticket.sessionID
                JOIN cinemahall
                ON session.hallId = cinemahall.id
                WHERE CAST(session.startTime AS DATE) >= ?
                AND CAST(session.startTime AS DATE) < ?
                AND ticket.status = 'Available'
                GROUP BY session.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->startDate, $this->endDate]);

        $cinemaUtil = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cinemaUtil[] = $row;
        }

        $stmt = null;
        return $cinemaUtil;
    }

    
}