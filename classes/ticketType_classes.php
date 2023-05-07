<?php

class TicketType extends Dbh {

    private $id;
    private $name;
    private $description;
    private $price;

    
    public function retrieveAllTicketTypes() {
        $sql = "SELECT * FROM tickettype ORDER BY id ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $ticketTypes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketTypes[] = $row;
        }

        $stmt = null;
        return $ticketTypes;
    }

    public function retrieveOneTicketType($id) {
        $this->id = $id;

        $sql = "SELECT * FROM tickettype WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $ticketTypeDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $ticketTypeDetails;
    }

    public function createTicketType($name, $description, $price) {
        session_start();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;

        $sql = "SELECT * FROM tickettype WHERE name = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->name]);

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Ticket name already exists", "danger");

        } else {
            $sql = "INSERT INTO tickettype (name, description, price) VALUES (?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->name, $this->description, $this->price]);
        }

        $stmt = null;
        return array("Ticket Type successfully created!", "success");
    }

    public function updateTicketType($id, $name, $description, $price) {
        session_start();
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    
        $sql = "SELECT COUNT(*) AS count FROM tickettype WHERE name = ? AND id != ?"; // Check if name is already taken by another ticket type
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->name, $this->id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
    
        if ($count > 0) {
            return array('Ticket Type name already exists', "danger");
        } else {
            $sql = "UPDATE tickettype SET name = ?, description = ?, price = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->name, $this->description, $this->price, $this->id]);
        }
    
        $stmt = null;
        return array('Ticket Type (ID: ' . $this->id . ') updated successfully!', "success");
    }
    

    public function deleteTicketType($id) {
        session_start();
        $this->id = $id;

        $sql = "DELETE FROM tickettype WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $stmt = null;
        return array('Ticket Type (ID: ' . $this->id . ') deleted successfully!', "success");
    }

    public function searchTicketTypes($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * FROM tickettype WHERE id LIKE ? OR name LIKE ? OR description LIKE ? OR price LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);
        } else {
            $sql = "SELECT * FROM tickettype WHERE " . $filter . " LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);
        }

        $ticketTypes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketTypes[] = $row;
        }

        $stmt = null;
        return $ticketTypes;
    }
}