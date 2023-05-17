<?php

class CinemaHall extends Dbh {
    private $id;
    private $hallNumber;
    private $name;
    private $address;
    private $capacity;
    private $status;

    public function retrieveAllCinemaHalls() {
        $sql = "SELECT ch.*, COUNT(s.id) AS totalSeats
                FROM cinemahall ch 
                LEFT JOIN seat s ON ch.id = s.hallId 
                GROUP BY ch.id
                ORDER BY ch.name, ch.hallNumber ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $cinemaHalls = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cinemaHalls[] = $row;
        }

        $stmt = null;
        return $cinemaHalls;
    }

    public function retrieveOneCinemaHall($id) {
        $this->id = $id;

        $sql = "SELECT ch.*, COUNT(s.id) AS totalSeats
                FROM cinemahall ch
                LEFT JOIN seat s ON ch.id = s.hallId 
                WHERE ch.id = ?
                GROUP BY ch.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $cinemaHallDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $cinemaHallDetails;
    }

    public function createCinemaHall($hallNumber, $name, $address, $capacity, $status) {
        session_start();
        $this->hallNumber = $hallNumber;
        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;
        $this->status = $status;

        $sql = "SELECT * FROM cinemahall WHERE name = ? && hallNumber = ?;"; // Check if cinema hall exists
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->name, $this->hallNumber]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Cinema hall already exists", "danger");

        } else {
            $sql = "INSERT INTO cinemahall (hallNumber, name, address, capacity, status) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->hallNumber, $this->name, $this->address, $capacity, $this->status]);
        }

        $stmt = null;
        return array("Cinema hall successfully created!", "success");
    }

    public function updateCinemaHall($id, $hallNumber, $name, $address, $capacity) {
        session_start();
        $this->id = $id;
        $this->hallNumber = $hallNumber;
        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;

        $sql = "SELECT * FROM cinemahall WHERE name = ? && hallNumber = ?;"; // Check if cinema hall exists
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->name, $this->hallNumber]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Cinema hall already exists", "danger");

        } else {
            $sql = "UPDATE cinemahall SET hallNumber = ?, name = ?, address = ?, capacity = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->hallNumber, $this->name, $this->address, $capacity, $this->id]);
        }

        $stmt = null;
        return array('Cinema Hall (ID: ' . $this->id . ') updated successfully!', "success");
    }

    public function suspendCinemaHall($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE cinemahall SET status = 'Suspended' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Cinema Hall (ID: ' . $this->id . ') suspended successfully!', "success");
    }

    public function activateCinemaHall($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE cinemahall SET status = 'Available' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Cinema Hall (ID: ' . $this->id . ') activated successfully!', "success");        
    }

    public function searchCinemaHalls($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * 
                    FROM cinemahall 
                    WHERE id LIKE ? OR name LIKE ? OR hallNumber LIKE ? OR address LIKE ? OR capacity LIKE ?
                    GROUP BY id 
                    ORDER BY name ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

        } else {
            $sql = "SELECT * FROM cinemahall WHERE " . $filter . " LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);
        }

        $cinemahalls = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cinemahalls[] = $row;
        }

        $stmt = null;
        return $cinemahalls;
    }
}