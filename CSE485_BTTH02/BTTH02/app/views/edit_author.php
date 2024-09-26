<?php
require_once '../services/DatabaseService.php';
require_once '../models/Author.php';

// Lấy catId từ tham số GET
$catId = $_GET['id'] ?? null;
$catName = ""; // Khởi tạo biến catName
$errorMsg = ""; // Khởi tạo biến thông báo lỗi

$authorModel = new Author(); // Tạo thể hiện của Author

if (isset($catId) && is_numeric($catId)) {
    $catId = intval($catId); // Chuyển đổi sang số nguyên
    $author = $authorModel->getById($catId); // Gọi phương thức để lấy thông tin tác giả

    if ($author) {
        $catName = $author['ten_tgia']; // Lấy tên tác giả
    } else {
        // Xử lý không tìm thấy tác giả
        $errorMsg = "Tác giả không tồn tại.";
    }
} else {
    $errorMsg = "ID tác giả không hợp lệ.";
}

// Cập nhật thông tin tác giả nếu là POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = $_POST['txtCatName'] ?? ''; // Lấy tên tác giả mới
    if (!empty(trim($catName))) {
        // Gọi phương thức để cập nhật tác giả
        if ($authorModel->updateAuthor($catId, $catName)) {
            // Nếu cập nhật thành công, chuyển hướng
            header("Location: ../views/author.php?message=success");
            exit();
        } else {
            $errorMsg = "Có lỗi xảy ra khi cập nhật tác giả.";
        }
    } else {
        $errorMsg = "Tên tác giả không được để trống.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Tác Giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="../../css/style_login.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link" href="category.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="author.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link" href="article.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <h3 class="text-center text-uppercase fw-bold">Sửa thông tin tác giả</h3>
        <?php if ($errorMsg): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errorMsg); ?></div>
        <?php endif; ?>

        <form action="" method="post"> <!-- Giữ lại action để có thể xử lý lại trên trang hiện tại -->
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Mã tác giả</span>
                <input type="text" class="form-control" name="txtCatId" value="<?php echo htmlspecialchars($catId); ?>" readonly>
            </div>
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tên tác giả</span>
                <input type="text" class="form-control" name="txtCatName" value="<?php echo htmlspecialchars($catName); ?>" required>
            </div>
            <div class="form-group float-end">
                <input type="submit" value="Lưu lại" class="btn btn-success">
                <a href="../views/author.php" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
