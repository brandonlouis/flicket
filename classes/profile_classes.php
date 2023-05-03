<?php

class Profile extends Dbh {

    private $userType;
    private $description;
    private $accessType;

    
    public function retrieveAllProfiles() {
        $sql = "SELECT * FROM profile ORDER BY userType ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $profiles = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profiles[] = $row;
        }

        $stmt = null;
        return $profiles;
    }

    public function retrieveOneProfile($userType) {
        $this->userType = $userType;

        $sql = "SELECT * FROM profile WHERE userType = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->userType]);

        $profileDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $profileDetails;
    }

    public function createProfile($userType, $description, $accessType) {
        session_start();
        $this->userType = $userType;
        $this->description = $description;
        $this->accessType = $accessType;

        $sql = "SELECT * FROM profile WHERE userType = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->userType]);

        if (strpos($this->accessType, "Please") !== false) {
            $stmt = null;
            return array("Please select an Access Type", "danger");

        } else if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("User Type already exists", "danger");

        } else {
            $sql = "INSERT INTO profile (userType, description, accessType) VALUES (?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->userType, $this->description, $this->accessType]);
        }

        $stmt = null;
        return array("Profile successfully created!", "success");
    }

    public function updateProfile($oldUserType, $userType, $description, $accessType) {
        session_start();
        $this->userType = $userType;
        $this->description = $description;
        $this->accessType = $accessType;

        $sql = "UPDATE profile SET userType = ?, description = ?, accessType = ? WHERE userType = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->userType, $this->description, $this->accessType, $oldUserType]);

        $stmt = null;
        return array('Profile (User Type: ' . $this->userType . ') updated successfully!', "success");
    }

    public function deleteProfile($userType) {
        session_start();
        $this->userType = $userType;

        $sql = "DELETE FROM profile WHERE userType = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->userType]);

        $stmt = null;
        return array('Profile (User Type: ' . $this->userType . ') deleted successfully!', "success");
    }

    public function searchProfiles($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * FROM profile WHERE userType LIKE ? OR description LIKE ? OR accessType LIKE ? ORDER BY userType ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);
        } else {
            $sql = "SELECT * FROM profile WHERE " . $filter . " LIKE ? ORDER BY userType ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);
        }

        $profiles = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profiles[] = $row;
        }

        $stmt = null;
        return $profiles;
    }
}