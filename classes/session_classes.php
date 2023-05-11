<?php

class Session extends Dbh {

    private $id;
    private $movieId;
    private $hallId;
    private $startTime;
    private $endTime;
    private $status;

    
    public function retrieveAllSessions() {
        $sql = "SELECT s.*, m.title, m.runtimeMin, CONCAT(ch.name, ', Hall ', ch.hallNumber) AS venue, m.poster, DATE(s.startTime) AS date, DATE_FORMAT(s.startTime, '%h:%i %p') AS startTime, DATE_FORMAT(s.endTime, '%h:%i %p') AS endTime
                FROM session s
                JOIN movie m ON s.movieId = m.id
                JOIN cinemahall ch ON s.hallId = ch.id
                ORDER BY venue ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $sessions = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sessions[] = $row;
        }

        $stmt = null;
        return $sessions;
    }

    public function retrieveOneSession($id) {
        $this->id = $id;

        $sql = "SELECT s.*, m.title, m.runtimeMin, CONCAT(ch.name, ', Hall ', ch.hallNumber) AS venue, m.poster, DATE(s.startTime) AS date, DATE_FORMAT(s.startTime, '%H:%i') AS startTime, DATE_FORMAT(s.endTime, '%H:%i') AS endTime
                FROM session s
                JOIN movie m ON s.movieId = m.id
                JOIN cinemahall ch ON s.hallId = ch.id
                WHERE s.id = ?
                ORDER BY venue ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $sessionDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $sessionDetails;
    }

    public function createSession($movieId, $hallId, $date, $startTime, $endTime, $status) {
        session_start();
        $this->movieId = $movieId;
        $this->hallId = $hallId;
        $this->startTime = $date . " " . $startTime;
        $this->endTime = $date . " " . $endTime;
        $this->status = $status;

        if (strpos($this->status, 'Select') !== false) {
            return array("Please select a Status", "danger");
        }

        $sql = "SELECT * FROM session 
                WHERE hallId = ? 
                AND ((startTime <= ? AND endTime >= ?)
                    OR (startTime >= ? AND startTime < ?)
                    OR (endTime > ? AND endTime <= ?))
                AND status = 'Available';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->hallId, $this->endTime, $this->startTime, $this->startTime, $this->endTime, $this->startTime, $this->endTime]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Session timing clashes with existing session at the same venue. Please choose a different time or venue", "danger");
        }

        $sql = "INSERT INTO session (movieId, hallId, startTime, endTime, status) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->movieId, $this->hallId, $this->startTime, $this->endTime, $this->status]);

        $stmt = null;
        $genreStmt = null;
        return array("Session successfully created!", "success");
    }

    public function updateSession($sessionId, $movieId, $hallId, $date, $startTime, $endTime) {
        session_start();
        $this->movieId = $movieId;
        $this->hallId = $hallId;
        $this->startTime = $date . " " . $startTime;
        $this->endTime = $date . " " . $endTime;

        $sql = "SELECT * FROM session 
                WHERE hallId = ? 
                AND id != ?
                AND ((startTime <= ? AND endTime >= ?)
                    OR (startTime >= ? AND startTime < ?)
                    OR (endTime > ? AND endTime <= ?))
                AND status = 'Available';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->hallId, $sessionId, $this->endTime, $this->startTime, $this->startTime, $this->endTime, $this->startTime, $this->endTime]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Session timing clashes with existing session at the same venue. Please choose a different time or venue", "danger");
        }

        $sql = "UPDATE session SET movieId = ?, hallId = ?, startTime = ?, endTime = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->movieId, $this->hallId, $this->startTime, $this->endTime, $sessionId]);

        $stmt = null;
        return array('Session (ID: ' . $sessionId . ') updated successfully!', "success");
    }

    public function suspendSession($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE session SET status = 'Suspended' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Session (ID: ' . $this->id . ') suspended successfully!', "success");        
    }
    public function activateSession($id) {
        session_start();
        $this->id = $id;

        $sqlHall = "SELECT hallId, startTime, endTime
                    FROM session
                    WHERE id = ?;";
        $stmtHall = $this->connect()->prepare($sqlHall);
        $stmtHall->execute([$this->id]);
        $hall = $stmtHall->fetch(PDO::FETCH_ASSOC);
        
        $sql = "SELECT * FROM session 
                WHERE hallId = ? 
                AND id != ?
                AND ((startTime <= ? AND endTime >= ?)
                    OR (startTime >= ? AND startTime < ?)
                    OR (endTime > ? AND endTime <= ?))
                AND status = 'Available';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$hall['hallId'], $this->id, $hall['endTime'], $hall['startTime'], $hall['startTime'], $hall['endTime'], $hall['startTime'], $hall['endTime']]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array('Unable to activate session (ID: '. $this->id .') as timing clashes with existing session at the same venue', "danger");
        }
                
        $sql = "UPDATE session SET status = 'Available' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Session (ID: ' . $this->id . ') activated successfully!', "success");        
    }

    public function searchSessions($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT s.*, m.title, m.runtimeMin, CONCAT(ch.name, ', Hall ', ch.hallNumber) AS venue, m.poster, DATE(s.startTime) AS date, DATE_FORMAT(s.startTime, '%h:%i %p') AS startTime, DATE_FORMAT(s.endTime, '%h:%i %p') AS endTime
                    FROM session s
                    JOIN movie m ON s.movieId = m.id
                    JOIN cinemahall ch ON s.hallId = ch.id
                    WHERE s.id LIKE ? OR m.title LIKE ? OR CONCAT(ch.name, ', Hall ', ch.hallNumber) LIKE ? OR DATE(s.startTime) LIKE ? OR DATE_FORMAT(s.startTime, '%h:%i %p') LIKE ? OR DATE_FORMAT(s.endTime, '%h:%i %p') LIKE ? OR s.status LIKE ?
                    ORDER BY venue ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

        } else {
            $sql = "SELECT s.*, m.title, m.runtimeMin, CONCAT(ch.name, ', Hall ', ch.hallNumber) AS venue, m.poster, DATE(s.startTime) AS date, DATE_FORMAT(s.startTime, '%h:%i %p') AS startTime, DATE_FORMAT(s.endTime, '%h:%i %p') AS endTime
                    FROM session s
                    JOIN movie m ON s.movieId = m.id
                    JOIN cinemahall ch ON s.hallId = ch.id
                    WHERE " . $filter . " LIKE ?
                    ORDER BY venue ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);
        }

        $sessions = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sessions[] = $row;
        }

        $stmt = null;
        return $sessions;
    }
}