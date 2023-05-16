<?php

class MovieBooking extends Dbh {
    private $fullName;
    private $email;
    private $movieId;
    private $sessionId;
    private $movieQty;

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