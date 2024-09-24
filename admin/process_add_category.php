<?php
include "db.php";
// Xử lý form khi được gửi
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $catName = $_POST['txtCatName'];

            // Thêm thể loại vào cơ sở dữ liệu
            $sql = "INSERT INTO theloai (ten_tloai) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $catName);

            if ($stmt->execute()) {
                // Chuyển hướng về danh sách thể loại
                header("Location: category.php?msg=Thêm thể loại thành công!");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Lỗi: " . $stmt->error . "</div>";
            }

            $stmt->close();
        }
        ?>