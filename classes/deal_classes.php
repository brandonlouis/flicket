<?php

class Deal extends Dbh {

    private $id;
    private $dealName;
    private $description;
    private $price;
    private $status;
    private $image;
    private $fnbItems;
    
    public function retrieveAllDeals() {
        $sql = "SELECT *
                FROM deal 
                ORDER BY id,dealName ASC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $deals = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $deals[] = $row;
        }

        $stmt = null;
        return $deals;
    }

    public function retrieveOneDeal($id) {
        $this->id = $id;

        $sql = "SELECT *
                FROM deal
                WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $singleItem = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;
        return $singleItem;
    }

    public function createDeal($dealName, $description, $price, $status, $image, $fnbItems) {
        session_start();
        $this->dealName = $dealName;
        $this->description = $description;
        $this->price = $price;
        $this->status = $status;
        $this->image = $image;
        $this->fnbItems = $fnbItems;

        $sql1 = "INSERT INTO deal (dealName, description, price, status, image) VALUES (?, ?, ?, ?, ?);";
        $stmt1 = $this->connect()->prepare($sql1);
        $stmt1->execute([$this->dealName, $this->description, $this->price, $this->status, $this->image]);

        $sql2 = "SELECT id FROM deal WHERE dealName = ? AND image = ? AND description = ?;";
        $stmt2 = $this->connect()->prepare($sql2);
        $stmt2->execute([$this->dealName, $this->image, $this->description]);
        $dealId = $stmt2->fetch(PDO::FETCH_ASSOC)['id'];

        foreach ($this->fnbItems as $itemName) {
            $itemIdSql = "SELECT id FROM fnbitem WHERE itemname = ?";
            $itemIdStmt = $this->connect()->prepare($itemIdSql);
            $itemIdStmt->execute([$itemName]);
            $itemId = $itemIdStmt->fetch(PDO::FETCH_ASSOC)['id'];

            $insertSql = "INSERT INTO fnbitemdeal (fnbitem_id, deal_id) VALUES (?, ?);";
            $insertStmt = $this->connect()->prepare($insertSql);
            $insertStmt->execute([$itemId, $dealId]);
        }

        $stmt1 = null;
        $stmt2 = null;
        $itemIdStmt = null;
        $insertStmt = null;
        return array("Deal successfully created!", "success");
    }

    public function updateDeal($id, $dealName, $description, $price, $image, $fnbItems) {
        session_start();
        $this->id = $id;
        $this->dealName = $dealName;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->fnbItems = $fnbItems;

        if($this->image == null) {
            $sql1 = "UPDATE deal SET dealName = ?, description = ?, price = ? WHERE id = ?;";
            $stmt1 = $this->connect()->prepare($sql1);
            $stmt1->execute([$this->dealName, $this->description, $this->price, $this->id]);
        } else {
            $sql1 = "UPDATE deal SET dealName = ?, description = ?, price = ?, image = ? WHERE id = ?;";
            $stmt1 = $this->connect()->prepare($sql1);
            $stmt1->execute([$this->dealName, $this->description, $this->price, $this->image, $this->id]);
        }

        $deleteSql = "DELETE FROM fnbitemdeal WHERE deal_id = ?;";
        $deleteStmt = $this->connect()->prepare($deleteSql);
        $deleteStmt->execute([$this->id]);

        foreach ($this->fnbItems as $itemName) {
            $itemIdSql = "SELECT id FROM fnbitem WHERE itemname = ?";
            $itemIdStmt = $this->connect()->prepare($itemIdSql);
            $itemIdStmt->execute([$itemName]);
            $itemId = $itemIdStmt->fetch(PDO::FETCH_ASSOC)['id'];

            $insertSql = "INSERT INTO fnbitemdeal (fnbitem_id, deal_id) VALUES (?, ?);";
            $insertStmt = $this->connect()->prepare($insertSql);
            $insertStmt->execute([$itemId, $this->id]);
        }

        $stmt1 = null;
        $stmt2 = null;
        $itemIdStmt = null;
        $deleteStmt = null;
        $insertStmt = null;

        return array('Deal (ID: ' . $this->id . ') updated successfully!', "success");
    }

    public function suspendDeal($id) {
        session_start();
        $this->id = $id;

        $sql = "UPDATE deal SET status = 'Suspended' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $stmt = null;
        return array('Deal (ID: ' . $this->id . ') suspended successfully!', "success");
    }
    public function activateDeal($id) {
        session_start();
        $this->id = $id;
        
        $sql = "UPDATE deal SET status = 'Available' WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);
        
        $stmt = null;
        return array('Deal (ID: ' . $this->id . ') activated successfully!', "success");
    }

    public function searchDeals($searchText, $filter) {
        session_start();

        if ($filter == "None") {
            $sql = "SELECT * 
                    FROM deal 
                    WHERE id LIKE ? OR dealName LIKE ? OR price LIKE ? OR status LIKE ?
                    ORDER BY id, dealName ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%', '%' . $searchText . '%']);

        } else if($filter == "price") {
            //ensures that only exact value will be returned for price
            $searchText = (array) $searchText;
            $sql = "SELECT *
                    FROM deal
                    WHERE " . $filter . " = ?
                    ORDER BY id, dealName ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($searchText); 
        } else {
            $sql = "SELECT *
                    FROM deal
                    WHERE " . $filter . " LIKE ?
                    ORDER BY id, dealName ASC;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['%' . $searchText . '%']);    
        }

        $deals = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $deals[] = $row;
        }

        $stmt = null;
        return $deals;
    }

    public function getFnBItemInDeals($id){
        $this->id = $id;

        $sql = "SELECT fnbitem.itemName, COUNT(*)
                FROM fnbitem JOIN fnbitemdeal
                ON fnbitem.id = fnbitemdeal.fnbItem_id
                JOIN deal
                ON fnbitemdeal.deal_id = deal.id
                WHERE deal.id = ?
                GROUP BY fnbitem.id
                ORDER BY fnbitem.itemName";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->id]);

        $fnbItems = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fnbItems[] = $row;
        }

        $stmt = null;
        return $fnbItems;
    }
}