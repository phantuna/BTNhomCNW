<?php
require_once '../services/DatabaseService.php';

class Statistics {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();
    }

    public function getTotalCategories() {
        $sql = "SELECT COUNT(*) as total FROM theloai";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getTotalAuthors() {
        $sql = "SELECT COUNT(*) as total FROM tacgia";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getTotalArticles() {
        $sql = "SELECT COUNT(*) as total FROM baiviet";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
