<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kiểm tra xem bài viết có tồn tại không
    $sql_check = "SELECT COUNT(*) as total FROM baiviet WHERE ma_bviet = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['total'] > 0) {
        // Nếu bài viết tồn tại, thực hiện xóa
        $sql = "DELETE FROM baiviet WHERE ma_bviet = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Chuyển hướng về trang danh sách bài viết sau khi xóa thành công
            header("Location: article.php?success=Xóa bài viết thành công.");
            exit();
        } else {
            header("Location: article.php?error=Lỗi khi xóa bài viết.");
            exit();
        }
    } else {
        header("Location: article.php?error=Bài viết không tồn tại.");
        exit();
    }
} else {
    header("Location: article.php?error=Không tìm thấy mã bài viết.");
    exit();
}
?>
