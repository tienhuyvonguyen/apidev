<?php
class Database
{
    private $host = $_SERVER['DB_HOST'];
    private $user = $_SERVER['DB_USER'];
    private $pass = $_SERVER['DB_PASS'];
    private $db = $_SERVER['DB_NAME'];
    public $conn;
    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}