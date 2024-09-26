<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_login.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light shadow">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/category.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link active" href="../views/author.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/article.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Thêm mới tác giả</h3>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php elseif (isset($_GET['msg'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                <?php endif; ?>

                <form action="../controllers/AuthorController.php?action=add" method="post"> <!-- Chỉ định controller và action -->
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tên tác giả</span>
                        <input type="text" class="form-control" name="txtAuthorName" required>
                    </div>
                    
                    <div class="form-group float-end">
                        <input type="submit" value="Thêm" class="btn btn-success">
                        <a href="../views/author.php" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-light d-flex justify-content-center align-items-center border-top" style="height:80px">
        <h4 class="text-center text-uppercase">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
