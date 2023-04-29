<?php

class Dbh {

    protected function connect() {
        try {
            $username = "root";
            $password = "";
            $dbh  = new PDO('mysql:host=localhost;dbname=flicketdb', $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Connection failed: " . $e->getMessage();
            die(); // Close connection
        }
    }
}