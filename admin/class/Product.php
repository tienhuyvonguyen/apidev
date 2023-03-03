<?php

class Product {
    private $conn;
    // table
    private $db_table = "product";
    // columns
    public $productID;
    public $price;
    public $name;
    public $picture;
    public $stock;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleProduct($productID) {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE productID = ? limit 1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $productID);
        $stmt->execute();
        return $stmt;
    }

}