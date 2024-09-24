<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

$errorMsg = isset($_GET['error']) ? $_GET['error'] : '';
$articleId = isset($_GET['id']) ? $_GET['id'] : null;

if ($articleId) {
    // Truy vấn để lấy thông tin bài viết hiện tại
    $sql = "SELECT tieude, tomtat FROM baiviet WHERE ma_bviet = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $stmt->bind_result($title, $summary);
    $stmt->fetch();
    $stmt->close();
} else {
    header("Location: article.php?error=Mã bài viết không hợp lệ.");
    exit;
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
    <!-- Phần header -->
</header>
<main class="container mt-5 mb-5">
    <h3 class="text-center text-uppercase fw-bold">Sửa thông tin bài viết</h3>
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($errorMsg); ?>
        </div>
    <?php endif; ?>

    <form action="process_edit_article.php" method="post">
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
            <a href="article.php" class="btn btn-warning">Quay lại</a>
        </div>
    </form>
</main>
<footer>
    <!-- Phần footer -->
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
