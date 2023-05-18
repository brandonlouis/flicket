<?php

class MovieBooking extends Dbh {
    private $fullName;
    private $email;
    private $movieId;
    private $sessionId;
    private $movieQty;
    private $seatLocation;
    private $hallId;

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

    public function createMovieBooking($hallId, $sessionId, $ticketType, $seatLocation) {
        session_start();
        $this->hallId = $hallId;
        $this->sessionId = $sessionId;
        $this->ticketType = $ticketType;
        $this->seatLocation = $seatLocation;

        foreach ($seatLocation as $seat) {
            preg_match('/([A-Z]+)(\d+)/', $seat, $matches);
            $rowLetter = $matches[1];
            $seatNumber = $matches[2];

            $sql = "SELECT id FROM seat WHERE hallId = ? AND rowLetter = ? AND seatNumber = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->hallId, $rowLetter, $seatNumber]);
            $id = $stmt->fetchColumn();

            $sql = "INSERT INTO ticket (sessionID, seatId, ticketType, accountId, status) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->sessionId, $id, $this->ticketType, $_SESSION['id'], 'Available']);

            $sql = "UPDATE seat SET status = 'Occupied' WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
        }
        
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