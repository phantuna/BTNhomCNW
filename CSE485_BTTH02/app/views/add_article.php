<?php
require_once '../services/DatabaseService.php';
require_once '../models/Article.php'; 

// Lấy danh sách bài viết, tác giả và thể loại
$articles = Article::getAll();
$conn = getDatabaseConnection(); // Mở kết nối khác để lấy tác giả và thể loại

$result_authors = $conn->query("SELECT * FROM tacgia");
$result_categories = $conn->query("SELECT * FROM theloai");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
        <div class="container-fluid">
            <div class="h3">
                <a class="navbar-brand" href="#">Administration</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="./">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Trang ngoài</a></li>
                    <li class="nav-item"><a class="nav-link" href="../views/category.php">Thể loại</a></li>
                    <li class="nav-item"><a class="nav-link" href="../views/author.php">Tác giả</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="../views/article.php">Bài viết</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-5 mb-5">
    <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>

    <?php if (!empty($errorMsg)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errorMsg); ?></div>
    <?php endif; ?>

    <form action="../controllers/ArticleController.php?action=add" method="post"> <!-- Thay đổi action đây -->
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
            <select class="form-select" name="ma_tloai" required>
                <option value="" disabled selected>Chọn thể loại</option>
                <?php while ($category = $result_categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['ma_tloai']; ?>"><?php echo $category['ten_tloai']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="author" class="form-label">Tác giả</label>
            <select class="form-select" name="ma_tgia" required>
                <option value="" disabled selected>Chọn tác giả</option>
                <?php while ($author = $result_authors->fetch_assoc()): ?>
                    <option value="<?php echo $author['ma_tgia']; ?>"><?php echo $author['ten_tgia']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" value="Thêm" class="btn btn-success">
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
