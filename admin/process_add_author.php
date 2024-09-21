<?php
include 'db.php'; // Kết nối database

// Xử lý form khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $catName = trim($_POST['txtCatName']);

    // Kiểm tra xem tên tác giả không rỗng
    if (!empty($catName)) {
        // Thêm tác giả vào cơ sở dữ liệu
        $sql = "INSERT INTO tacgia (ten_tgia) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $catName);

        if ($stmt->execute()) {
            // Chuyển hướng về danh sách tác giả
            header("Location: author.php?msg=Thêm tác giả thành công!");
            exit;
        } else {
            header("Location: add_author.php?error=Lỗi khi thêm tác giả: " . $stmt->error);
            exit;
        }

        
    } else {
        header("Location: add_author.php?error=Tên tác giả không được để trống.");
        exit;
    }
} else {
    // Nếu không phải là POST request
    header("Location: add_author.php?error=Không được phép truy cập trực tiếp.");
    exit;
}
?>
