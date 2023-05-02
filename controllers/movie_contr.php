<?php

class MovieContr extends Dbh {

    public function retrieveMovies() {
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

        $_SESSION['movies'] = $movies;

        $stmt = null;
    }

    public function retrieveAMovie($id) {
        $sql = "SELECT m.*, GROUP_CONCAT(g.genreName SEPARATOR ', ') as genres
                FROM movie m
                LEFT JOIN moviegenre mg ON m.id = mg.movieId
                LEFT JOIN genre g ON mg.genreName = g.genreName
                WHERE m.id = ?
                GROUP BY m.id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $_SESSION['movieDetails'] = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
    }
    

    public function retrieveLanguages() {
        $sql = "SELECT * from language;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $languages = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $languages[] = $row;
        }

        $_SESSION['languages'] = $languages;

        $stmt = null;
    }

    public function retrieveGenres() {
        $sql = "SELECT * from genre ORDER BY genreName ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $genres = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genres[] = $row;
        }

        $_SESSION['genres'] = $genres;

        $stmt = null;
    }

    public function createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster) {
        session_start();
        $m = new Movie();
        $m->setTitle($title);
        $m->setSynopsis($synopsis);
        $m->setRuntimeMin($runtimeMin);
        $m->setTrailerURL($trailerURL);
        $m->setStartDate($startDate);
        $m->setEndDate($endDate);
        $m->setLanguage($language);
        $m->setGenre($genre);
        $m->setPoster($poster);

        $sql = "INSERT INTO movie (title, synopsis, runtimeMin, trailerURL, startDate, endDate, language, poster) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($m->getTitle(), $m->getSynopsis(), $m->getRuntimeMin(), $m->getTrailerURL(), $m->getStartDate(), $m->getEndDate(), $m->getLanguage(), $m->getPoster()));

        $sql2 = "SELECT id FROM movie WHERE title = ? AND poster = ?;";
        $stmt = $this->connect()->prepare($sql2);
        $stmt->execute(array($m->getTitle(), $m->getPoster()));
        $movieId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        foreach ($m->getGenre() as $genreName) {
            $genreSql = "INSERT INTO moviegenre (genreName, movieId) VALUES (?, ?);";
            $genreStmt = $this->connect()->prepare($genreSql);
            $genreStmt->execute(array($genreName, $movieId));
        }

        $stmt = null;
        $genreStmt = null;
        
        setcookie('flash_message', 'Movie successfully created!', time() + 3, '/');
        setcookie('flash_message_type', 'success', time() + 3, '/');

        header("location: ../views/movieSessions/manageMovieSessions.php");
        exit();
    }

    public function updateMovie($id, $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster) {
        session_start();
        $m = new Movie();
        $m->setId($id);
        $m->setTitle($title);
        $m->setSynopsis($synopsis);
        $m->setRuntimeMin($runtimeMin);
        $m->setTrailerURL($trailerURL);
        $m->setStartDate($startDate);
        $m->setEndDate($endDate);
        $m->setLanguage($language);
        $m->setGenre($genre);
        $m->setPoster($poster);

        if ($m->getPoster() == null) {
            $sql = "UPDATE movie SET title = ?, synopsis = ?, runtimeMin = ?, trailerURL = ?, startDate = ?, endDate = ?, language = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array($m->getTitle(), $m->getSynopsis(), $m->getRuntimeMin(), $m->getTrailerURL(), $m->getStartDate(), $m->getEndDate(), $m->getLanguage(), $m->getId()));
        } else if ($m->getPoster() != null) {
            $sql = "UPDATE movie SET title = ?, synopsis = ?, runtimeMin = ?, trailerURL = ?, startDate = ?, endDate = ?, language = ?, poster = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array($m->getTitle(), $m->getSynopsis(), $m->getRuntimeMin(), $m->getTrailerURL(), $m->getStartDate(), $m->getEndDate(), $m->getLanguage(), $m->getPoster(), $m->getId()));
        }

        $deleteGenreSql = "DELETE FROM moviegenre WHERE movieId = ?";
        $deleteGenreStmt = $this->connect()->prepare($deleteGenreSql);
        $deleteGenreStmt->execute(array($m->getId()));

        foreach ($m->getGenre() as $genreName) {
            $genreSql = "INSERT INTO moviegenre (movieId, genreName) VALUES (?, ?)";
            $genreStmt = $this->connect()->prepare($genreSql);
            $genreStmt->execute(array($m->getId(), $genreName));
        }
                

        $stmt = null;
        $genreStmt = null;

        setcookie('flash_message', 'Movie (ID: ' . $m->getId() . ') updated successfully!', time() + 3, '/');
        setcookie('flash_message_type', 'success', time() + 3, '/');

        header("location: ../views/movieSessions/manageMovieSessions.php");
        exit();
    }

    public function deleteMovie($id) {
        session_start();
        $m = new Movie();
        $m->setId($id);

        $sql = "DELETE FROM movie WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($m->getId()));

        setcookie('flash_message', 'Movie (ID: ' . $m->getId() . ') deleted successfully!', time() + 3, '/');
        setcookie('flash_message_type', 'success', time() + 3, '/');

        $stmt = null;

        header("location: ../views/movieSessions/manageMovieSessions.php");
        exit();
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
            $stmt->execute(array('%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%'));

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
            $stmt->execute(array('%' . $searchText . '%'));    
        }


        $movies = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movies[] = $row;
        }

        $_SESSION['movies'] = $movies;

        $stmt = null;

        header("location: ../views/movieSessions/searchMovieSessions.php");
        exit();
    }
}