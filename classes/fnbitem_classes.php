<?php

class FnBItem extends Dbh {

    private $id;
    private $itemName;
    private $description;
    private $price;
    private $category;
    private $suspendStatus;
    private $image;
    
    public function checkFnBitemsInDeal($id){

        $sql1 = "SELECT COUNT(*) FROM fnbitemdeal WHERE fnbItem_id = ?";
        $stmt1 = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result["COUNT"] == 0) {
            return false;
        } else{
            return true;
        }
    }
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

    public function createFnBItem($itemName, $description, $price, $category, $suspendStatus, $image) {
        session_start();
        $this->itemName = $itemName;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->suspendStatus = $suspendStatus;
        $this->image = $image;

        $sql = "INSERT INTO fnbitem (itemName, description, price, category, suspendStatus, image) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->itemName, $this->description, $this->price, $this->category, $this->suspendStatus, $this->image]);

        $stmt = null;
        return array("F&B item successfully created!", "success");
    }

    public function updateFnBItem($id, $itemName, $description, $price, $category, $suspendStatus, $image) {
        session_start();
        $this->id = $id;
        $this->itemName = $itemName;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->suspendStatus = $suspendStatus;
        $this->image = $image;
        

        $sql = "UPDATE fnbtitem SET itemName = ?, description = ?, price = ?, category = ?, suspendStatus = ?, image = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->itemName, $this->description, $this->price, $this->category, $this->suspendStatus, $this->image, $this->id]);
           

        $stmt = null;
        return array('F&B item (ID: ' . $this->id . ') updated successfully!', "success");
    }

    public function deleteFnBitem($id) {
        session_start();
        $this->id = $id;

        $sql = "DELETE FROM fnbitem WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $stmt = null;
        return array('F&B item (ID: ' . $this->id . ') deleted successfully!', "success");
    }

    public function searchFnBItems($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * 
                    FROM fnbitem 
                    WHERE id LIKE ? OR itemName LIKE ? OR price LIKE ? OR category LIKE ? OR suspendStatus LIKE ?
                    ORDER BY id, itemName ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

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
}