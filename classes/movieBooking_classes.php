<?php

class MovieBooking extends Dbh {
    private $fullName;
    private $email;
    private $movieId;
    private $sessionId;
    private $movieQty;

    public function retrieveAllMovieBookings($id) {
        $this->id = $id;
        
        $sql = "SELECT t.id as id, t.accountid as accountid, t.ticketType as ticketType, s.startTime as startTime, s.endTime as endTime,
                m.title as title, m.poster as poster, ch.name as cinemaName, ch.hallNumber as hallNumber
                FROM ticket t
                JOIN session s ON s.id = t.sessionID
                JOIN movie m ON m.id = s.movieId
                JOIN cinemahall ch ON ch.id = s.hallId
                WHERE accountid = ?
                GROUP BY t.id
                ORDER BY t.id ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $movieBookings = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movieBookings[] = $row;
        }

        $stmt = null;
        return $movieBookings;
    }

    public function createMovieBooking($sessionId, $ticketType) {
        session_start();
        $this->sessionId = $sessionId;
        $this->ticketType = $ticketType;

        $sql = "INSERT INTO ticket (sessionID, seatId, ticketType, accountId, status) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->sessionId, '1', $this->ticketType, $_SESSION['id'], 'Available']);
        
        $stmt = null;
        return array("Booking made successfully! Your purchase receipt will be sent to your email address", "success");
    }

    public function deleteMovieBooking($id) {
        session_start();
        $this->id = $id;

        $sql = "DELETE FROM ticket WHERE id = ?;"; 
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $stmt = null;
        return array('Movie Booking (ID: ' . $this->id . ') deleted successfully!', "success");
    }
}