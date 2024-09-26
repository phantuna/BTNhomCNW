<?php
require_once '../services/DatabaseService.php';

class Author {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();
    }

    public function addAuthor($authorName) {
        $stmt = $this->conn->prepare("INSERT INTO tacgia (ten_tgia) VALUES (?)");
        $stmt->bind_param("s", $authorName);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public static function getAll() {
        $conn = getDatabaseConnection();
        $sql = "SELECT ma_tgia, ten_tgia FROM tacgia";
        $result = $conn->query($sql);
        $authors = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $authors[] = $row;
            }
        }
        $conn->close();
        return $authors;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tacgia WHERE ma_tgia = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về tác giả
        }
        
        return null; // Trường hợp không tìm thấy
    }

    public function updateAuthor($id, $name) {
        $stmt = $this->conn->prepare("UPDATE tacgia SET ten_tgia = ? WHERE ma_tgia = ?");
        $stmt->bind_param("si", $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function exists($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM tacgia WHERE ma_tgia = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $exists = $row['total'] > 0; // Trả về true nếu tác giả tồn tại
        $stmt->close();
        return $exists;
    }

    public function deleteAuthor($catId) {
        $stmt = $this->conn->prepare("DELETE FROM tacgia WHERE ma_tgia = ?");
        $stmt->bind_param("i", $catId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
?>
