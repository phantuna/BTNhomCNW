<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu

if (isset($_GET['id'])) {
    $catId = $_GET['id'];

    // Xóa thể loại
    $sql = "DELETE FROM tacgia WHERE ma_tgia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $catId);

    if ($stmt->execute()) {
        // Chuyển hướng về trang danh sách thể loại với thông báo thành công
        header("Location: author.php?msg=Xóa thể loại thành công!");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa thể loại: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID thể loại không hợp lệ.";
}
?>