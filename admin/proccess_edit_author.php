<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catId = isset($_POST['txtCatId']) ? $_POST['txtCatId'] : null;
    $catName = isset($_POST['txtCatName']) ? $_POST['txtCatName'] : null;

    // Kiểm tra xem ID và tên tác giả có hợp lệ không
    if ($catId && $catName) {
        // Truy vấn cập nhật tên tác giả
        $sql = "UPDATE tacgia SET ten_tgia = ? WHERE ma_tgia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $catName, $catId);

        if ($stmt->execute()) {
            // Nếu cập nhật thành công, chuyển hướng về danh sách tác giả
            header("Location: author.php?success=Thành công! Đã cập nhật tên tác giả.");
            exit();
        } else {
            // Nếu có lỗi xảy ra
            header("Location: edit_author.php?id=$catId&error=Lỗi khi cập nhật.");
            exit();
        }

       
    } else {
        // Nếu ID hoặc tên không hợp lệ
        header("Location: edit_author.php?id=$catId&error=ID hoặc tên tác giả không hợp lệ.");
        exit();
    }
} else {
    // Nếu không phải POST request
    header("Location: author.php?error=Không được phép truy cập trực tiếp.");
    exit();
}
?>
