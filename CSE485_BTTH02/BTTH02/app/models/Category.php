<?php
require_once '../services/DatabaseService.php';

class Category {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();
    }

    public function addCategory($categoryName) {
        $stmt = $this->conn->prepare("INSERT INTO theloai (ten_tloai) VALUES (?)");
        $stmt->bind_param("s", $categoryName);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public static function getAll() {
        $conn = getDatabaseConnection();
        $sql = "SELECT ma_tloai, ten_tloai FROM theloai";
        $result = $conn->query($sql);
        $categories = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        $conn->close();
        return $categories;
    }

    public static function getById($catId) {
        $conn = getDatabaseConnection();
        $sql = "SELECT ten_tloai, ma_tloai FROM theloai WHERE ma_tloai = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $catId); // Đảm bảo rằng catId là số nguyên
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về thể loại
        }
        
        return null; // Trường hợp không tìm thấy
    }
    
    

    public function updateCategory($catId, $catName) {
        $sql = "UPDATE theloai SET ten_tloai = ? WHERE ma_tloai = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $catName, $catId);
        return $stmt->execute();
    }

    public function hasArticles($catId) {
        $sql = "SELECT COUNT(*) as total FROM baiviet WHERE ma_tloai = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $catId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total'] > 0; // Có bài viết liên quan
    }

    public function deleteCategory($catId) {
        $sql = "DELETE FROM theloai WHERE ma_tloai = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $catId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
?>
