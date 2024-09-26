<?php
require_once '../services/DatabaseService.php';

class Article {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();
    }

    public function addArticle($title, $summary, $category_id, $author_id) {
        $stmt = $this->conn->prepare("INSERT INTO baiviet (tieude, tomtat, ma_tloai, ma_tgia) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $summary, $category_id, $author_id);
        
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function exists($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM baiviet WHERE ma_bviet = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $exists = $row['total'] > 0;
        $stmt->close();
        return $exists;
    }

    public function deleteArticle($id) {
        $stmt = $this->conn->prepare("DELETE FROM baiviet WHERE ma_bviet = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public static function getAll() {
        $conn = getDatabaseConnection();
        $sql = "SELECT 
                    bv.ma_bviet,
                    bv.tieude,
                    bv.tomtat,
                    bv.ngayviet,
                    tg.ten_tgia,
                    tl.ten_tloai 
                FROM 
                    baiviet bv
                JOIN 
                    tacgia tg ON bv.ma_tgia = tg.ma_tgia
                JOIN 
                    theloai tl ON bv.ma_tloai = tl.ma_tloai
                ORDER BY bv.ma_bviet ASC;";
                
        $result = $conn->query($sql);
        $articles = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT tieude, tomtat FROM baiviet WHERE ma_bviet = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $article = $result->fetch_assoc();
        $stmt->close();
        return $article;
    }

    public function updateArticle($id, $title, $summary) {
        $stmt = $this->conn->prepare("UPDATE baiviet SET tieude = ?, tomtat = ? WHERE ma_bviet = ?");
        $stmt->bind_param("ssi", $title, $summary, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
?>
