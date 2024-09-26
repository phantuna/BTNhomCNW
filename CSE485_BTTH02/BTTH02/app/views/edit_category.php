<?php
require_once '../services/DatabaseService.php';
require_once '../models/Category.php';

// Lấy catId từ tham số GET
$catId = $_GET['id'] ?? null;
$catName = ""; // Khởi tạo biến catName

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $catId = intval($_GET['id']); // Chuyển đổi sang số nguyên
    $category = Category::getById($catId);
    
    if ($category) {
        $catName = $category['ten_tloai']; // Lấy tên thể loại
    } else {
        // Xử lý không tìm thấy thể loại
        $errorMsg = "Thể loại không tồn tại.";
    }
} else {
    $errorMsg = "ID thể loại không hợp lệ.";
}

// Cập nhật thông tin thể loại nếu là POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = $_POST['txtCatName'] ?? ''; // Lấy tên thể loại mới
    if (!empty($catName)) {
        // Gọi phương thức để cập nhật thể loại
        $categoryModel = new Category();
        if ($categoryModel->updateCategory($catId, $catName)) {
            // Nếu cập nhật thành công, chuyển hướng
            header("Location: ../views/category.php?message=success");
            exit();
        } else {
            $errorMsg = "Có lỗi xảy ra khi cập nhật thể loại.";
        }
    } else {
        $errorMsg = "Tên thể loại không được để trống.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="css/style_login.css">
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
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Sửa thông tin thể loại</h3>
                
                <?php if (!empty($errorMsg)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMsg); ?></div>
                <?php endif; ?>
                
                <form action="../views/edit_category.php?id=<?php echo htmlspecialchars($catId); ?>" method="post">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblCatId">Mã thể loại</span>
                        <input type="text" class="form-control" name="txtCatId" value="<?php echo htmlspecialchars($catId); ?>" readonly>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblCatName">Tên thể loại</span>
                        <input type="text" class="form-control" name="txtCatName" value="<?php echo htmlspecialchars($catName); ?>" required>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" value="Lưu lại" class="btn btn-success">
                        <a href="../views/category.php" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
