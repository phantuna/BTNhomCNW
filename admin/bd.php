<?php
$servername = "localhost"; // Tên server của bạn
$username = "root";         // Username MySQL
$password = "";             // Mật khẩu MySQL (nếu có)
$dbname = "BTTH01_CSE485";  // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy số lượng người dùng
$result_users = $conn->query("SELECT COUNT(*) as total FROM users");
$row_users = $result_users->fetch_assoc();
$total_users = $row_users['total'];

// Lấy số lượng thể loại
$result_categories = $conn->query("SELECT COUNT(*) as total FROM theloai");
$row_categories = $result_categories->fetch_assoc();
$total_categories = $row_categories['total'];

// Lấy số lượng tác giả
$result_authors = $conn->query("SELECT COUNT(*) as total FROM authors");
$row_authors = $result_authors->fetch_assoc();
$total_authors = $row_authors['total'];

// Lấy số lượng bài viết
$result_articles = $conn->query("SELECT COUNT(*) as total FROM baiviet");
$row_articles = $result_articles->fetch_assoc();
$total_articles = $row_articles['total'];

// Đóng kết nối
$conn->close();
?>
