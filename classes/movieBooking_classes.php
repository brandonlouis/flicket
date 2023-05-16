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

    public function bookMovie($fullName, $email, $movieId, $sessionId, $movieQty) {
        session_start();
        $this->fullName = $fullName;
        $this->email = $email;
        $this->movieId = $movieId;
        $this->sessionId = $sessionId;
        $this->movieQty = $movieQty;

        $sql = "INSERT INTO bookmovie (fullName, email, movieId, sessionId, quantity) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->fullName, $this->email, $this->movieId, $this->sessionId, $this->movieQty]);
        
        $stmt = null;
        return array("Booking made successfully! Your purchase receipt will be sent to your email address", "success");
    }
}