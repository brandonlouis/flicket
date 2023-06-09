<?php

class FnBItem extends Dbh {

    private $id;
    private $itemName;
    private $description;
    private $price;
    private $category;
    private $status;
    private $image;
    private $accountId;
    private $fnbItemID;
    private $fnbQty;
    
    public function retrieveAllFnBitems() {
        $sql = "SELECT *
                FROM fnbitem 
                ORDER BY id,itemName ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $fnbitems = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fnbitems[] = $row;
        }

        $stmt = null;
        return $fnbitems;
    }

    public function retrieveOneFnBItem($id) {
        $this->id = $id;

        $sql = "SELECT *
                FROM fnbitem
                WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $singleItem = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $singleItem;
    }

    public function retrieveAllAvailableFnBItem() {
        $sql = "SELECT *
                FROM fnbitem
                WHERE status = 'Available'
                GROUP BY id 
                ORDER BY itemName";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $fnbitems = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fnbitems[] = $row;
        }

        $stmt = null;
        return $fnbitems;
    }

    public function createFnBItem($itemName, $description, $price, $category, $status, $image) {
        session_start();
        $this->itemName = $itemName;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->status = $status;
        $this->image = $image;

        if (strpos($this->category, 'Select') !== false) {
            return array("Please select a Category", "danger");
        } else if (strpos($this->status, 'Select') !== false) {
            return array("Please select a Status", "danger");
        }

        $sql = "INSERT INTO fnbitem (itemName, description, price, category, status, image) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->itemName, $this->description, $this->price, $this->category, $this->status, $this->image]);

        $stmt = null;
        return array("F&B item successfully created!", "success");
    }

    public function updateFnBItem($id, $itemName, $description, $price, $category, $image) {
        session_start();
        $this->id = $id;
        $this->itemName = $itemName;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->image = $image;
        
        if($this->image == null){
            $sql = "UPDATE fnbitem SET itemName = ?, description = ?, price = ?, category = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->itemName, $this->description, $this->price, $this->category, $this->id]);
        } else {
            $sql = "UPDATE fnbitem SET itemName = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$this->itemName, $this->description, $this->price, $this->category, $this->image, $this->id]);
        }

        $stmt = null;
        return array('F&B item (ID: ' . $this->id . ') updated successfully!', "success");
    }

    public function suspendFnBitem($id) {
        session_start();
        $this->id = $id;

        $sql = "UPDATE fnbitem SET status = 'Suspended' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $stmt = null;
        return array('F&B item (ID: ' . $this->id . ') suspended successfully!', "success");
    }
    public function activateFnBitem($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE fnbitem SET status = 'Available' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('F&B item (ID: ' . $this->id . ') activated successfully!', "success");        
    }

    public function searchFnBItems($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * 
                    FROM fnbitem 
                    WHERE id LIKE ? OR itemName LIKE ? OR price LIKE ? OR category LIKE ? OR status LIKE ?
                    ORDER BY id, itemName ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

        } else if($filter == "price") {
            //ensures that only exact value will be returned for price
            $searchText = (array) $searchText;
            $sql = "SELECT *
                    FROM fnbitem
                    WHERE " . $filter . " = ?
                    ORDER BY id, itemName ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($searchText); 
        } else {
            $sql = "SELECT *
                    FROM fnbitem
                    WHERE " . $filter . " LIKE ?
                    ORDER BY id, itemName ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);    
        }

        $fnbItems = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fnbItems[] = $row;
        }

        $stmt = null;
        return $fnbItems;
    }

    public function purchaseFnBItem($fnbItemID, $fnbQty, $accountId) {
        session_start();
        $this->fnbItemID = $fnbItemID;
        $this->fnbQty = $fnbQty;
        $this->accountId = $accountId;


        $sql = "INSERT INTO fnbpurchases (fnbItemID, quantity, accountId) VALUES (?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->fnbItemID, $this->fnbQty, $this->accountId]);

        $stmt = null;
        return array("Purchase made successfully! Your purchase receipt will be sent to your email address", "success");
    }
}