<?php

class Seat extends Dbh {

    private $id;
    private $hallId;
    private $rowLetter;
    private $seatNumber;
    private $status;

    // TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TO MOVE TO CINEMAHALL
    public function retrieveAllHalls() {
        $sql = "SELECT ch.*, COUNT(s.id) AS totalSeats
                FROM cinemahall ch 
                LEFT JOIN seat s ON ch.id = s.hallId 
                GROUP BY ch.id;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    
        $halls = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $halls[] = $row;
        }
    
        $stmt = null;
        return $halls;
    }

    public function retrieveOneHall($id) {
        $this->id = $id;

        $sql = "SELECT ch.*, COUNT(s.id) AS totalSeats
                FROM cinemahall ch
                LEFT JOIN seat s ON ch.id = s.hallId 
                WHERE ch.id = ?
                GROUP BY ch.id;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $hallDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $hallDetails;
    }
    // TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TO MOVE TO CINEMAHALL



    public function retrieveAllSeats($hallId) {
        $sql = "SELECT ch.*, (SELECT COUNT(*) FROM seat s WHERE s.hallId = ch.id AND s.status = 'Available') AS seatsAvailable,
                        COUNT(s.id) AS totalSeats,
                        GROUP_CONCAT(CONCAT(s.rowLetter, ':', s.seatNumber, ':', s.status) SEPARATOR ',') AS seatData
                FROM cinemahall ch
                INNER JOIN seat s
                ON ch.id = s.hallId 
                WHERE ch.id = ?
                GROUP BY ch.name, ch.hallNumber, ch.capacity;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$hallId]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $seats = explode(',', $row['seatData']);
    
        $row['seats'] = $seats;
    
        $stmt = null;
        return $row;
    }

    public function retrieveOneSeat($id) {
        $this->id = $id;

        $sql = "SELECT cinemahall.name, cinemahall.hallNumber, seat.* 
                FROM cinemahall 
                INNER JOIN seat 
                ON cinemahall.id = seat.hallId
                WHERE seat.id = ?
                ORDER BY cinemahall.name;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $seatDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $seatDetails;
    }

    public function createSeat($hallId, $seatData, $status) {
        session_start();
        $this->hallId = $hallId;
        $this->status = $status;

        $sql = "SELECT COUNT(*) AS occupied_count FROM seat WHERE hallId = ? AND status = 'Occupied';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->hallId]);
        $occupiedCount = $stmt->fetch(PDO::FETCH_ASSOC)['occupied_count'];

        if (strpos($this->status, "Assign") !== false) {
            return array("Please select a Status", "danger");
        } else if ($occupiedCount > 0) {
            $stmt = null;
            return array("Cannot create seats for a hall with occupied seats!", "danger");
        } 

        $sql = "DELETE FROM seat WHERE hallId = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->hallId]);

        foreach ($seatData as $seat) {
            $components = explode(':', $seat);
            $this->rowLetter = $components[0];
            $this->seatNumber = $components[1];

            $sql = "INSERT INTO seat (hallId, rowLetter, seatNumber, status) VALUES (?, ?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->hallId, $this->rowLetter, $this->seatNumber, $this->status]);
        }
        
        $stmt = null;
        return array("Seats successfully created!", "success");
    }

    public function updateSeat($hallId, $selectedSeats, $seatStatus) {
        session_start();
        $this->hallId = $hallId;
        $this->status = $seatStatus;

        if (strpos($this->status, "Assign") !== false) {
            return array("Please select a Status", "danger");
        }

        sort($selectedSeats); // Sort seats in ascending order
        $seatString = implode(", ", $selectedSeats);
        if (strlen($seatString) > 0 && substr($seatString, -2) === ", ") { // Remove trailing comma and space
            $seatString = substr($seatString, 0, -2);
        }
        
        foreach ($selectedSeats as $seat) {
            preg_match('/([A-Z]+)(\d+)/', $seat, $matches);
            $this->rowLetter = $matches[1];
            $this->seatNumber = $matches[2];

            $sql = "UPDATE seat SET status = ? WHERE hallId = ? AND rowLetter = ? AND seatNumber = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->status, $this->hallId, $this->rowLetter, $this->seatNumber]);
        }
        
        $stmt = null;
        return array('Seat (' . $seatString . ') updated successfully!', "success");
    }

    public function suspendSeat($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE seat SET status = 'Suspended' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Seat (ID: ' . $this->id . ') suspended successfully!', "success");        
    }
    public function activateSeat($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE seat SET status = 'Available' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Seat (ID: ' . $this->id . ') activated successfully!', "success");        
    }

    public function searchSeats($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT ch.name, ch.hallNumber, s.*
                    FROM cinemahall as ch
                    INNER JOIN seat as s
                    ON ch.id = s.hallId 
                    WHERE ch.name LIKE ? OR ch.hallNumber LIKE ? OR CONCAT(s.rowLetter, s.seatNumber) LIKE ? OR s.status LIKE ?
                    ORDER BY ch.name, ch.hallNumber, CONCAT(s.rowLetter, s.seatNumber);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

        } else {
            $sql = "SELECT ch.name, ch.hallNumber, s.*, CONCAT(s.rowLetter, s.seatNumber) AS seatRowSeatNumber 
                    FROM cinemahall as ch
                    INNER JOIN seat as s
                    ON ch.id = s.hallId 
                    WHERE " . $filter . " LIKE ?
                    ORDER BY ch.name, ch.hallNumber, seatRowSeatNumber;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);
        }

        $seats = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $seats[] = $row;
        }

        $stmt = null;
        return $seats;
    }
}