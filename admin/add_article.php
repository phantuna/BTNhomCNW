<?php
include 'db.php'; // Kết nối CSDL

// Lấy danh sách thể loại và tác giả để hiển thị trong dropdown
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
        <div class="container-fluid">
            <div class="h3">
                <a class="navbar-brand" href="#">Administration</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="./">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php">Trang ngoài</a></li>
                    <li class="nav-item"><a class="nav-link" href="category.php">Thể loại</a></li>
                    <li class="nav-item"><a class="nav-link" href="author.php">Tác giả</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="article.php">Bài viết</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-5 mb-5">
    <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>
    <?php if (isset($errorMsg)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errorMsg); ?></div>
    <?php endif; ?>

    <form action="add_article.php" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="mb-3">
            <label for="summary" class="form-label">Tóm tắt</label>
            <textarea class="form-control" name="summary" required></textarea>
        </div>


        <div class="mb-3">
            <label for="category" class="form-label">Thể loại</label>
            <select class="form-select" name="category_id" required>
                <option value="" disabled selected>Chọn thể loại</option>
                <?php while($row = $result_categories->fetch_assoc()): ?>
                    <option value="<?php echo $row['ma_tloai']; ?>"><?php echo $row['ten_tloai']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="author" class="form-label">Tác giả</label>
            <select class="form-select" name="author_id" required>
                <option value="" disabled selected>Chọn tác giả</option>
                <?php while($row = $result_authors->fetch_assoc()): ?>
                    <option value="<?php echo $row['ma_tgia']; ?>"><?php echo $row['ten_tgia']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" value="Thêm" class="btn btn-success">
            <a href="article.php" class="btn btn-warning">Quay lại</a>
        </div>
    </form>
</main>

<footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
    <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
