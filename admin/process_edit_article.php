<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $articleId = $_POST['articleId'];
    $title = trim($_POST['title']);
    $summary = trim($_POST['summary']);
    
    // Kiểm tra các trường không rỗng
    if (!empty($title) && !empty($summary)) {
        // Chuẩn bị và ràng buộc
        $stmt = $conn->prepare("UPDATE baiviet SET tieude = ?, tomtat = ? WHERE ma_bviet = ?");
        $stmt->bind_param("ssi", $title, $summary, $articleId);

        // Thực hiện câu lệnh
        if ($stmt->execute()) {
            // Chuyển hướng về trang danh sách bài viết với thông báo thành công
            header("Location: article.php?success=Cập nhật bài viết thành công.");
            exit();
        } else {
            header("Location: edit_article.php?id=$articleId&error=Lỗi khi cập nhật bài viết.");
            exit();
        }
    } else {
        header("Location: edit_article.php?id=$articleId&error=Tất cả các trường không được để trống.");
        exit();
    }
} else {
    // Nếu không phải POST request
    header("Location: article.php?error=Không được phép truy cập trực tiếp.");
    exit();
}
?>
