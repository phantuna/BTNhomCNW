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
if ($result_users) {
    $row_users = $result_users->fetch_assoc();
    $total_users = $row_users['total'];
} else {
    die("Lỗi truy vấn người dùng: " . $conn->error);
}

// Lấy số lượng thể loại
$result_categories = $conn->query("SELECT COUNT(*) as total FROM theloai");
if ($result_categories) {
    $row_categories = $result_categories->fetch_assoc();
    $total_categories = $row_categories['total'];
} else {
    die("Lỗi truy vấn thể loại: " . $conn->error);
}

// Lấy số lượng tác giả
$result_authors = $conn->query("SELECT COUNT(*) as total FROM tacgia");
if ($result_authors) {
    $row_authors = $result_authors->fetch_assoc();
    $total_authors = $row_authors['total'];
} else {
    die("Lỗi truy vấn tác giả: " . $conn->error);
}

// Lấy số lượng bài viết
$result_articles = $conn->query("SELECT COUNT(*) as total FROM baiviet");
if ($result_articles) {
    $row_articles = $result_articles->fetch_assoc();
    $total_articles = $row_articles['total'];
} else {
    die("Lỗi truy vấn bài viết: " . $conn->error);
}

// Mẫu in ra số lượng
/*echo "Số lượng người dùng: " . $total_users . "<br>";
echo "Số lượng thể loại: " . $total_categories . "<br>";
echo "Số lượng tác giả: " . $total_authors . "<br>";
echo "Số lượng bài viết: " . $total_articles . "<br>";*/

// Đóng kết nối*/
/*try {
    // Tạo kết nối
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Thiết lập chế độ báo lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}*/ 
?>

