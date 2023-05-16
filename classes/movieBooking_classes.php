<?php

class MovieBooking extends Dbh {
    private $fullName;
    private $email;
    private $movieId;
    private $sessionId;
    private $movieQty;

    public function retrieveAllMovieBookings($email) {
        $this->email = $email;
        
        $sql = "SELECT mb.id as id, mb.email as email, mb.quantity as quantity, s.startTime as startTime,
                s.endTime as endTime, ch.name as cinemaName, ch.hallNumber as hallNumber, m.title as title, m.poster as poster
                FROM bookmovie mb
                JOIN session s ON s.id = mb.sessionID
                JOIN cinemahall ch ON ch.id = s.hallId
                JOIN movie m on m.id = mb.movieID
                WHERE email = ?
                GROUP BY mb.id
                ORDER BY mb.id ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->email]);

        $movieBookings = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movieBookings[] = $row;
        }

        $stmt = null;
        return $movieBookings;
    }

    public function retrieveOneMovieBooking($id) {
        $this->id = $id;

        $sql = "SELECT mb.fullName, mb.email, mb.quantity, s.startTime, s.endTime, ch.name, ch.hallNumber, m.title 
                FROM bookmovie mb
                JOIN session s ON s.id = mb.sessionID
                JOIN cinemahall ch ON ch.id = s.hallId
                JOIN movie m on m.id = mb.movieID
                GROUP BY mb.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $cinemaHallDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $cinemaHallDetails;
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