<?php
class Database
{
    public $conn;
    private $user;
    private $pass;
    private $host;
    private $db;

    public function __construct(){
        $this->host = $_SERVER['DB_HOST'];
        $this->user = $_SERVER['DB_USER'];
        $this->pass = $_SERVER['DB_PASS'];
        $this->db = $_SERVER['DB_NAME'];
    } 
    
    public function getConnection()
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