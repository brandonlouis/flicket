<?php

class Movie extends Dbh {

    private $id;
    private $title;
    private $synopsis;
    private $runtimeMin;
    private $trailerURL;
    private $startDate;
    private $endDate;
    private $poster;
    private $language;
    private $genre;
    private $status;
    private $fullName;
    private $email;
    private $movieId;
    private $sessionId;
    private $movieQty;

    
    public function retrieveAllMovies() {
        $sql = "SELECT m.*, GROUP_CONCAT(mg.genreName ORDER BY mg.genreName ASC SEPARATOR ', ') AS genres
                FROM movie m
                JOIN moviegenre mg ON m.id = mg.movieId
                GROUP BY m.id 
                ORDER BY m.title ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $movies = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movies[] = $row;
        }

        $stmt = null;
        return $movies;
    }

    public function retrieveOneMovie($id) {
        $this->id = $id;

        $sql = "SELECT m.*, GROUP_CONCAT(g.genreName SEPARATOR ', ') as genres
                FROM movie m
                LEFT JOIN moviegenre mg ON m.id = mg.movieId
                LEFT JOIN genre g ON mg.genreName = g.genreName
                WHERE m.id = ?
                GROUP BY m.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $movieDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $movieDetails;
    }

    public function retrieveAllAvailableMovies() {
        $sql = "SELECT m.*, GROUP_CONCAT(mg.genreName ORDER BY mg.genreName ASC SEPARATOR ', ') AS genres
                FROM movie m
                JOIN moviegenre mg ON m.id = mg.movieId
                WHERE m.status = 'Available'
                GROUP BY m.id 
                ORDER BY m.title ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $movies = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movies[] = $row;
        }

        $stmt = null;
        return $movies;
    }
    

    public function retrieveAllLanguages() {
        $sql = "SELECT * from language;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $languages = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $languages[] = $row;
        }

        $stmt = null;
        return $languages;
    }

    public function retrieveAllGenres() {
        $sql = "SELECT * from genre ORDER BY genreName ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $genres = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genres[] = $row;
        }

        $stmt = null;
        return $genres;
    }

    public function createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster, $status) {
        session_start();
        $this->title = $title;
        $this->synopsis = $synopsis;
        $this->runtimeMin = $runtimeMin;
        $this->trailerURL = $trailerURL;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->language = $language;
        $this->genre = $genre;
        $this->poster = $poster;
        $this->status = $status;

        if (strpos($this->status, 'Select') !== false) {
            return array("Please select a Status", "danger");
        }

        $sql = "INSERT INTO movie (title, synopsis, runtimeMin, trailerURL, startDate, endDate, language, poster, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->title, $this->synopsis, $this->runtimeMin, $this->trailerURL, $this->startDate, $this->endDate, $this->language, $this->poster, $this->status]);

        $sqlId = "SELECT id FROM movie WHERE title = ? AND poster = ?;";
        $stmt = $this->connect()->prepare($sqlId);
        $stmt->execute([$this->title, $this->poster]);
        $movieId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        foreach ($this->genre as $genreName) {
            $genreSql = "INSERT INTO moviegenre (genreName, movieId) VALUES (?, ?);";
            $genreStmt = $this->connect()->prepare($genreSql);
            $genreStmt->execute([$genreName, $movieId]);
        }

        $stmt = null;
        $genreStmt = null;
        return array("Movie successfully created!", "success");
    }

    public function updateMovie($id, $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster) {
        session_start();
        $this->id = $id;
        $this->title = $title;
        $this->synopsis = $synopsis;
        $this->runtimeMin = $runtimeMin;
        $this->trailerURL = $trailerURL;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->language = $language;
        $this->genre = $genre;
        $this->poster = $poster;

        if ($this->poster == null) {
            $sql = "UPDATE movie SET title = ?, synopsis = ?, runtimeMin = ?, trailerURL = ?, startDate = ?, endDate = ?, language = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->title, $this->synopsis, $this->runtimeMin, $this->trailerURL, $this->startDate, $this->endDate, $this->language, $this->id]);
        } else {
            $sql = "UPDATE movie SET title = ?, synopsis = ?, runtimeMin = ?, trailerURL = ?, startDate = ?, endDate = ?, language = ?, poster = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->title, $this->synopsis, $this->runtimeMin, $this->trailerURL, $this->startDate, $this->endDate, $this->language, $this->poster, $this->id]);
        }

        $deleteGenreSql = "DELETE FROM moviegenre WHERE movieId = ?";
        $deleteGenreStmt = $this->connect()->prepare($deleteGenreSql);
        $deleteGenreStmt->execute([$this->id]);

        foreach ($this->genre as $genreName) {
            $genreSql = "INSERT INTO moviegenre (movieId, genreName) VALUES (?, ?)";
            $genreStmt = $this->connect()->prepare($genreSql);
            $genreStmt->execute([$this->id, $genreName]);
        }

        $stmt = null;
        $genreStmt = null;
        return array('Movie (ID: ' . $this->id . ') updated successfully!', "success");
    }

    public function suspendMovie($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE movie SET status = 'Suspended' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Movie (ID: ' . $this->id . ') suspended successfully!', "success");        
    }
    public function activateMovie($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE movie SET status = 'Available' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Movie (ID: ' . $this->id . ') activated successfully!', "success");        
    }

    public function searchMovies($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT m.*, genres 
                    FROM movie m 
                    JOIN (
                        SELECT movieId, GROUP_CONCAT(genreName ORDER BY genreName ASC SEPARATOR ', ') AS genres
                        FROM moviegenre
                        GROUP BY movieId
                    ) mg ON m.id = mg.movieId
                    WHERE m.id LIKE ? OR m.title LIKE ? OR m.synopsis LIKE ? OR m.runtimeMin LIKE ? OR m.trailerURL LIKE ? OR m.startDate LIKE ? OR m.endDate LIKE ? OR m.language LIKE ? OR genres LIKE ?
                    GROUP BY m.id 
                    ORDER BY m.title ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

        } else {
            $sql = "SELECT m.*, genres 
                    FROM movie m 
                    JOIN (
                        SELECT movieId, GROUP_CONCAT(genreName ORDER BY genreName ASC SEPARATOR ', ') AS genres
                        FROM moviegenre
                        GROUP BY movieId
                    ) mg ON m.id = mg.movieId
                    WHERE " . $filter . " LIKE ?
                    GROUP BY m.id 
                    ORDER BY m.title ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);    
        }

        $movies = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movies[] = $row;
        }

        $stmt = null;
        return $movies;
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