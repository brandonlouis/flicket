<?php

class CinemaHall extends Dbh {
    private $id;
    private $hallNumber;
    private $name;
    private $address;
    private $capacity;
    private $status;

    public function retrieveAllCinemaHalls() {
        $sql = "SELECT *
                FROM cinemahall
                ORDER BY name, hallNumber ASC";
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

        $sql = "SELECT *
                FROM cinemahall
                WHERE id = ?
                GROUP BY id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $cinemaHallDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $cinemaHallDetails;
    }

    public function retrieveAllAvailableMovies() {
        $sql = "SELECT *
                FROM cinemahall
                WHERE status = 'Available'
                GROUP BY id 
                ORDER BY name, hallNumber ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $cinemaHalls = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cinemaHalls[] = $row;
        }

        $stmt = null;
        return $cinemaHalls;
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

    public function updateCinemaHall($id, $hallNumber, $name, $address, $capacity, $status) {
        session_start();
        $this->id = $id;
        $this->hallNumber = $hallNumber;
        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;
        $this->status = $status;

        $sql = "UPDATE cinemahall SET hallNumber = ?, name = ?, address = ?, capacity = ?, status = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->hallNumber, $this->name, $this->address, $capacity, $this->status, $this->id]);

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

    // public function searchMovies($searchText, $filter) {
    //     session_start();

    //     if ($filter == "None") {
    //         $sql = "SELECT m.*, genres 
    //                 FROM movie m 
    //                 JOIN (
    //                     SELECT movieId, GROUP_CONCAT(genreName ORDER BY genreName ASC SEPARATOR ', ') AS genres
    //                     FROM moviegenre
    //                     GROUP BY movieId
    //                 ) mg ON m.id = mg.movieId
    //                 WHERE m.id LIKE ? OR m.title LIKE ? OR m.synopsis LIKE ? OR m.runtimeMin LIKE ? OR m.trailerURL LIKE ? OR m.startDate LIKE ? OR m.endDate LIKE ? OR m.language LIKE ? OR genres LIKE ?
    //                 GROUP BY m.id 
    //                 ORDER BY m.title ASC";
    //         $stmt = $this->connect()->prepare($sql);
    //         $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

    //     } else {
    //         $sql = "SELECT m.*, genres 
    //                 FROM movie m 
    //                 JOIN (
    //                     SELECT movieId, GROUP_CONCAT(genreName ORDER BY genreName ASC SEPARATOR ', ') AS genres
    //                     FROM moviegenre
    //                     GROUP BY movieId
    //                 ) mg ON m.id = mg.movieId
    //                 WHERE " . $filter . " LIKE ?
    //                 GROUP BY m.id 
    //                 ORDER BY m.title ASC;";
    //         $stmt = $this->connect()->prepare($sql);
    //         $stmt->execute(['%' . $searchText . '%']);    
    //     }

    //     $movies = array();
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         $movies[] = $row;
    //     }

    //     $stmt = null;
    //     return $movies;
    // }
}