<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

if (isset($_POST['txtCatId']) && isset($_POST['txtCatName'])) {
    $catId = $_POST['txtCatId']; // Lấy ID thể loại từ biểu mẫu
    $catName = trim($_POST['txtCatName']);

    // Xác thực dữ liệu
    if (empty($catName)) {
        header("Location: edit_category.php?id=$catId&error=Tên thể loại không được để trống");
        exit;
    }

    // Truy vấn cập nhật thể loại
    $sql = "UPDATE theloai SET ten_tloai = ? WHERE ma_tloai = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        header("Location: edit_category.php?id=$catId&error=Lỗi chuẩn bị câu truy vấn: " . $conn->error);
        exit;
    }

    $stmt->bind_param("si", $catName, $catId);

    if ($stmt->execute()) {
        // Chuyển hướng người dùng về trang danh sách thể loại
        header("Location: category.php?msg=Cập nhật thành công!");
        exit; // Ngăn chặn thực thi mã tiếp theo
    } else {
        header("Location: edit_category.php?id=$catId&error=Có lỗi xảy ra khi cập nhật: " . $stmt->error);
        exit;
    }
} else {
    header("Location: category.php?error=ID thể loại không hợp lệ.");
    exit;
}
?>
