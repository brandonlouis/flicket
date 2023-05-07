<?php

class Account extends Dbh {

    private $id;
    private $fullName;
    private $email;
    private $phoneNo;
    private $password1;
    private $password2;
    private $userType;

    
    public function retrieveAllAccounts() {
        $sql = "SELECT * FROM account ORDER BY id ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $accounts = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accounts[] = $row;
        }

        $stmt = null;
        return $accounts;
    }

    public function retrieveOneAccount($id) {
        $this->id = $id;

        $sql = "SELECT * FROM account WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $accountDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = null;
        return $accountDetails;
    }

    public function createAccount($userType, $fullName, $email, $phoneNo, $password1, $password2) {
        session_start();
        $this->userType = $userType;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNo = $phoneNo;
        $this->password1 = $password1;
        $this->password2 = $password2;

        $sql = "SELECT * FROM account WHERE email = ?;"; // Check if email exists
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->email]);

        $sqlProfile = "SELECT * FROM profile WHERE userType = ?;"; // Check accessType for selected userType in dropdown
        $stmtProfile = $this->connect()->prepare($sqlProfile);
        $stmtProfile->execute([$this->userType]);
        $row = $stmtProfile->fetch(PDO::FETCH_ASSOC);
        $accessType = $row['accessType'];

        if (strpos($this->userType, "Please") !== false) {
            $stmt = null;
            return array("Please select a User Type", "danger");

        } else if ($stmt->rowCount() > 0) {
            $stmt = null;
            return array("Email already exists", "danger");

        } else if ($accessType != 'external' && strpos($this->email, '@flicket.com') === false) {
            $stmt = null;
            return array('Email for internal roles <b>must</b> contain "@flicket.com"', "danger");

        } else if ($accessType == 'external' && strpos($this->email, '@flicket.com') !== false) {
            $stmt = null;
            return array('Email for external roles must <b>not</b> contain "@flicket.com"', "danger");
            
        } else if ($this->password1 != $this->password2) {
            $stmt = null;
            return array("Passwords do not match", "danger");
            
        } else {
            $sql = "INSERT INTO account (fullName, email, phoneNo, password, userType) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            
            $hashedPwd = password_hash($this->password2, PASSWORD_DEFAULT);
            $stmt->execute([$this->fullName, $this->email, $this->phoneNo, $hashedPwd, $this->userType]);
        }

        $stmt = null;
        return array("Account successfully created!", "success");
    }

    public function updateAccount($id, $userType, $fullName, $email, $phoneNo, $password1, $password2) {
        session_start();
        $this->id = $id;
        $this->userType = $userType;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNo = $phoneNo;
        $this->password1 = $password1;
        $this->password2 = $password2;

        $sqlEmail = "SELECT COUNT(*) as count FROM account WHERE email = ? AND id != ?";
        $stmtEmail = $this->connect()->prepare($sqlEmail);
        $stmtEmail->execute([$this->email, $this->id]);
        $rowEmail = $stmtEmail->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM profile WHERE userType = ?;"; // Check accessType for selected userType in dropdown
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->userType]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $accessType = $row['accessType'];

        if ($rowEmail['count'] > 0) {
            $stmt = null;
            return array("Email already exists", "danger");

        } else if ($accessType != 'external' && strpos($this->email, '@flicket.com') === false) {
            $stmt = null;
            return array('Email for internal roles <b>must</b> contain "@flicket.com"', "danger");

        } else if ($accessType == 'external' && strpos($this->email, '@flicket.com') !== false) {
            $stmt = null;
            return array('Email for external roles must <b>not</b> contain "@flicket.com"', "danger");

        } else if ($this->password1 != $this->password2) {
            $stmt = null;
            return array("Passwords do not match", "danger");

        } else {
            if (!$this->password1 && !$this->password2) {
                $sql = "UPDATE account SET fullName = ?, email = ?, phoneNo = ?, userType = ? WHERE id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$this->fullName, $this->email, $this->phoneNo, $this->userType, $this->id]);
            } else {
                $sql = "UPDATE account SET fullName = ?, email = ?, phoneNo = ?, password = ?, userType = ? WHERE id = ?;";
                $stmt = $this->connect()->prepare($sql);

                $hashedPwd = password_hash($this->password2, PASSWORD_DEFAULT);
                $stmt->execute([$this->fullName, $this->email, $this->phoneNo, $hashedPwd, $this->userType, $this->id]);
            }
        }
        
        $stmt = null;
        return array('Account (ID: ' . $this->id . ') updated successfully!', "success");
    }

    public function deleteAccount($id) {
        session_start();
        $this->id = $id;

        $sql = "DELETE FROM account WHERE id = ?;"; // Get hashed password from db and check email existence in db
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $stmt = null;
        return array('Account (ID: ' . $this->id . ') deleted successfully!', "success");
    }

    public function searchAccounts($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * FROM account WHERE fullName LIKE ? OR email LIKE ? OR phoneNo LIKE ? OR userType LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);
        } else {
            $sql = "SELECT * FROM account WHERE " . $filter . " LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);
        }

        $accounts = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accounts[] = $row;
        }

        $stmt = null;
        return $accounts;
    }
}