<?php
require_once '../services/DatabaseService.php';
require_once '../models/Article.php';

// Bắt đầu bộ đệm đầu ra
ob_start();

$controller = new Article();
$articleId = $_GET['id'] ?? null;
$errorMsg = ""; // Khởi tạo biến thông báo lỗi
$title = ""; // Khởi tạo biến tiêu đề
$summary = ""; // Khởi tạo biến tóm tắt

if ($articleId) {
    // Lấy thông tin bài viết
    $article = $controller->getById($articleId);
    if (!$article) {
        header("Location: article.php?error=Mã bài viết không hợp lệ.");
        exit;
    }
    $title = $article['tieude']; // Thiết lập tiêu đề
    $summary = $article['tomtat']; // Thiết lập tóm tắt
} else {
    header("Location: article.php?error=Mã bài viết không hợp lệ.");
    exit;
}

// Cập nhật thông tin bài viết nếu là POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $summary = $_POST['summary'] ?? '';

    // Gọi phương thức để cập nhật bài viết
    if ($controller->updateArticle($articleId, $title, $summary)) {
        header("Location: article.php?message=Cập nhật thành công!");
        exit;
    } else {
        $errorMsg = "Có lỗi xảy ra khi cập nhật bài viết.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link" href="author.php">Tác giả</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="article.php">Bài viết</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-5 mb-5">
    <h3 class="text-center text-uppercase fw-bold">Sửa thông tin bài viết</h3>
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($errorMsg); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="input-group mt-3 mb-3">
            <span class="input-group-text">Mã bài viết</span>
            <input type="text" class="form-control" name="articleId" value="<?php echo htmlspecialchars($articleId); ?>" readonly>
        </div>

        <div class="input-group mt-3 mb-3">
            <span class="input-group-text">Tiêu đề</span>
            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>

        <div class="input-group mt-3 mb-3">
            <span class="input-group-text">Tóm tắt</span>
            <textarea class="form-control" name="summary" required><?php echo htmlspecialchars($summary); ?></textarea>
        </div>

        <div class="form-group float-end">
            <input type="submit" value="Lưu lại" class="btn btn-success">
            <a href="../views/article.php" class="btn btn-warning">Quay lại</a>
        </div>
    </form>
</main>

<footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
    <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
