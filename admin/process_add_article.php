<?php
include "db.php";
 //Lấy danh sách thể loại và tác giả để hiển thị trong dropdown
 $sql_categories = "SELECT ma_tloai, ten_tloai FROM theloai";
 $result_categories = $conn->query($sql_categories);
 
 $sql_authors = "SELECT ma_tgia, ten_tgia FROM tacgia";
 $result_authors = $conn->query($sql_authors);
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Lấy giá trị từ form
     $title = trim($_POST['title']);
     $summary = trim($_POST['summary']);
     $categoryId = $_POST['category_id'];
     $authorId = $_POST['author_id'];
 
     // Kiểm tra tính hợp lệ của khóa ngoại
     $checkCategory = $conn->prepare("SELECT COUNT(*) FROM theloai WHERE ma_tloai = ?");
     $checkCategory->bind_param("i", $categoryId);
     $checkCategory->execute();
     $checkCategory->bind_result($categoryExists);
     $checkCategory->fetch();
     $checkCategory->close();
 
     $checkAuthor = $conn->prepare("SELECT COUNT(*) FROM tacgia WHERE ma_tgia = ?");
     $checkAuthor->bind_param("i", $authorId);
     $checkAuthor->execute();
     $checkAuthor->bind_result($authorExists);
     $checkAuthor->fetch();
     $checkAuthor->close();
 
     // Kiểm tra tất cả điều kiện
     if ($categoryExists > 0 && $authorExists > 0 && !empty($title) && !empty($summary)) {
         // Chuẩn bị & ràng buộc
         $stmt = $conn->prepare("INSERT INTO baiviet (tieude, tomtat, ma_tloai, ma_tgia) VALUES (?, ?, ?, ?)");
         $stmt->bind_param("ssii", $title, $summary, $categoryId, $authorId);
 
         // Thực hiện câu lệnh
         if ($stmt->execute()) {
             // Chuyển hướng về trang danh sách bài viết
             header("Location: article.php?success=Thêm bài viết thành công.");
             exit();
         } else {
             $errorMsg = "Có lỗi xảy ra, vui lòng thử lại.";
         }
     } else {
         $errorMsg = "Tất cả các thông tin phải được nhập và phải tồn tại.";
     }
    }
?>