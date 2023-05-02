<?php

class AccountContr extends Dbh {

    public function retrieveAccounts() {
        $sql = "SELECT * FROM account ORDER BY id ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $accounts = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accounts[] = $row;
        }

        $_SESSION['accounts'] = $accounts;

        $stmt = null;
    }

    public function retrieveAnAccount($id) {

        $sql = "SELECT * FROM account WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($id));

        $_SESSION['accountDetails'] = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public function createAccount($userType, $fullName, $email, $phoneNo, $password1, $password2) {
        session_start();
        $am = new Account();
        $am->setUserType($userType);
        $am->setFullName($fullName);
        $am->setEmail($email);
        $am->setPhoneNo($phoneNo);
        $am->setPassword1($password1);
        $am->setPassword2($password2);

        $sql = "SELECT * FROM account WHERE email = ?;"; // Check if email exists
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($am->getEmail()));

        $sql2 = "SELECT * FROM profile WHERE userType = ?;"; // Check accessType for selected userType in dropdown
        $stmt2 = $this->connect()->prepare($sql2);
        $stmt2->execute(array($am->getUserType()));
        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        $accessType = $row['accessType'];

        if ($stmt->rowCount() > 0) {
            setcookie('flash_message', 'Email already exists', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/createAccount.php");
            exit();
        } else if ($am->getPassword1() != $am->getPassword2()) {
            setcookie('flash_message', 'Passwords do not match', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/createAccount.php");
            exit();
        } else if ($accessType != 'external' && strpos($am->getEmail(), '@flicket.com') === false) {
            setcookie('flash_message', 'Email for internal roles <b>must</b> contain "@flicket.com"', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/createAccount.php");
            exit();
        } else if ($accessType == 'external' && strpos($am->getEmail(), '@flicket.com') !== false) {
            setcookie('flash_message', 'Email for external roles must <b>not</b> contain "@flicket.com"', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/createAccount.php");
            exit();
        } else {
            $sql = "INSERT INTO account (fullName, email, phoneNo, password, userType) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            
            $hashedPwd = password_hash($am->getPassword2(), PASSWORD_DEFAULT);
            $stmt->execute(array($am->getFullName(), $am->getEmail(), $am->getPhoneNo(), $hashedPwd, $am->getUserType()));
    
            $stmt = null;
            
            setcookie('flash_message', 'Account successfully created!', time() + 3, '/');
            setcookie('flash_message_type', 'success', time() + 3, '/');
        }

        header("location: ../views/account/manageAccounts.php");
        exit();
    }

    public function updateAccount($id, $userType, $fullName, $email, $phoneNo, $password1, $password2) {
        session_start();
        $am = new Account();
        $am->setId($id);
        $am->setUserType($userType);
        $am->setFullName($fullName);
        $am->setEmail($email);
        $am->setPhoneNo($phoneNo);
        $am->setPassword1($password1);
        $am->setPassword2($password2);

        $sql = "SELECT * FROM profile WHERE userType = ?;"; // Check accessType for selected userType in dropdown
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($am->getUserType()));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $accessType = $row['accessType'];

        if ($am->getPassword1() != $am->getPassword2()) {
            setcookie('flash_message', 'Passwords do not match', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/updateAccount.php?id=" . $am->getId());
            exit();
        } else if ($accessType != 'external' && strpos($am->getEmail(), '@flicket.com') === false) {
            setcookie('flash_message', 'Email for internal roles <b>must</b> contain "@flicket.com"', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/updateAccount.php?id=" . $am->getId());
            exit();
        } else if ($accessType == 'external' && strpos($am->getEmail(), '@flicket.com') !== false) {
            setcookie('flash_message', 'Email for external roles must <b>not</b> contain "@flicket.com"', time() + 3, '/');
            setcookie('flash_message_type', 'danger', time() + 3, '/');

            header("location: ../views/account/updateAccount.php?id=" . $am->getId());
            exit();
        } else {
            if (!$am->getPassword1 && !$am->getPassword2) {
                $sql = "UPDATE account SET fullName = ?, email = ?, phoneNo = ?, userType = ? WHERE id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute(array($am->getFullName(), $am->getEmail(), $am->getPhoneNo(), $am->getUserType(), $am->getId()));
    
                $stmt = null;
    
                setcookie('flash_message', 'Account (ID: ' . $am->getId() . ') updated successfully!', time() + 3, '/');
                setcookie('flash_message_type', 'success', time() + 3, '/');
            } else {
                $sql = "UPDATE account SET fullName = ?, email = ?, phoneNo = ?, password = ?, userType = ? WHERE id = ?;";
                $stmt = $this->connect()->prepare($sql);

                $hashedPwd = password_hash($am->getPassword2(), PASSWORD_DEFAULT);
                $stmt->execute(array($am->getFullName(), $am->getEmail(), $am->getPhoneNo(), $hashedPwd, $am->getUserType(), $am->getId()));
    
                $stmt = null;
    
                setcookie('flash_message', 'Account (ID: ' . $am->getId() . ') updated successfully!', time() + 3, '/');
                setcookie('flash_message_type', 'success', time() + 3, '/');
            }
        }

        header("location: ../views/account/manageAccounts.php");
        exit();
    }

    public function deleteAccount($id) {
        session_start();
        $am = new Account();
        $am->setId($id);

        $sql = "DELETE FROM account WHERE id = ?;"; // Get hashed password from db and check email existence in db
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($am->getId()));

        setcookie('flash_message', 'Account (ID: ' . $am->getId() . ') deleted successfully!', time() + 3, '/');
        setcookie('flash_message_type', 'success', time() + 3, '/');

        $stmt = null;

        header("location: ../views/account/manageAccounts.php");
        exit();
    }

    public function searchAccounts($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * FROM account WHERE fullName LIKE ? OR email LIKE ? OR phoneNo LIKE ? OR userType LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array('%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%'));
        } else {
            $sql = "SELECT * FROM account WHERE " . $filter . " LIKE ? ORDER BY id ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(array('%' . $searchText . '%'));
        }


        $accounts = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accounts[] = $row;
        }

        $_SESSION['accounts'] = $accounts;

        $stmt = null;

        header("location: ../views/account/searchAccounts.php");
        exit();
    }
}