<?php

class ProfileContr extends Dbh {

    public function retrieveProfiles() {
        $sql = "SELECT * FROM profile ORDER BY userType ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $profiles = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profiles[] = $row;
        }

        $_SESSION['profiles'] = $profiles;

        $stmt = null;
    }

    public function retrieveAProfile($userType) {

        $sql = "SELECT * FROM profile WHERE userType = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($userType));

        $_SESSION['profileDetails'] = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public function createProfile($userType, $description, $accessType) {
        session_start();
        $p = new Profile();
        $p->setUserType($userType);
        $p->setDescription($description);
        $p->setAccessType($accessType);

        $sql = "SELECT * FROM profile WHERE userType = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($p->getUserType()));

        if ($stmt->rowCount() > 0) {
            setcookie('flash_message', 'User Type already exists', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/profile/createProfile.php");
            exit();
        } else {
            $sql = "INSERT INTO profile (userType, description, accessType) VALUES (?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array($p->getUserType(), $p->getDescription(), $p->getAccessType()));
    
            $stmt = null;
            
            setcookie('flash_message', 'Profile successfully created!', time() + 3, '/');
            setcookie('flash_message_type', 'success', time() + 3, '/');
        }

        header("location: ../views/profile/manageProfiles.php");
        exit();
    }

    public function updateProfile($oldUserType, $userType, $description, $accessType) {
        session_start();
        $p = new Profile();
        $p->setUserType($userType);
        $p->setDescription($description);
        $p->setAccessType($accessType);

        $sql = "UPDATE profile SET userType = ?, description = ?, accessType = ? WHERE userType = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($p->getUserType(), $p->getDescription(), $p->getAccessType(), $oldUserType));

        $stmt = null;

        setcookie('flash_message', 'Profile (User Type: ' . $p->getUserType() . ') updated successfully!', time() + 3, '/');
        setcookie('flash_message_type', 'success', time() + 3, '/');

        header("location: ../views/profile/manageProfiles.php");
        exit();
    }

    public function deleteProfile($userType) {
        session_start();
        $p = new Profile();
        $p->setUserType($userType);

        $sql = "DELETE FROM profile WHERE userType = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($p->getUserType()));

        setcookie('flash_message', 'Profile (User Type: ' . $p->getUserType() . ') deleted successfully!', time() + 3, '/');
        setcookie('flash_message_type', 'success', time() + 3, '/');

        $stmt = null;

        header("location: ../views/profile/manageProfiles.php");
        exit();
    }

    public function searchProfiles($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * FROM profile WHERE userType LIKE ? OR description LIKE ? OR accessType LIKE ? ORDER BY userType ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array('%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%'));
        } else {
            $sql = "SELECT * FROM profile WHERE " . $filter . " LIKE ? ORDER BY userType ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array('%' . $searchText . '%'));
        }

        $profiles = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profiles[] = $row;
        }

        $_SESSION['profiles'] = $profiles;

        $stmt = null;

        header("location: ../views/profile/searchProfiles.php");
        exit();
    }
}