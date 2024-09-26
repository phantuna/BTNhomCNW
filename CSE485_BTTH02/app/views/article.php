<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link" href="category.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link" href="author.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="article.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <a href="./add_article.php" class="btn btn-success">Thêm mới</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Tên thể loại</th>
                            <th scope="col">Tác giả</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        require_once '../services/DatabaseService.php';
                        require_once '../models/Article.php'; // Đảm bảo đường dẫn đúng tới Article.php

                        // Gọi phương thức getAll để lấy danh sách bài viết
                        $articles = Article::getAll(); 
                        ?>
                        <?php if (!empty($articles)) : ?>
                            <?php foreach ($articles as $article) : ?>
                                <tr>
                                    <th scope='row'><?= htmlspecialchars($article['ma_bviet']) ?></th>
                                    <td><?= htmlspecialchars($article['tieude']) ?></td>
                                    <td><?= htmlspecialchars($article['ten_tloai']) ?></td>
                                    <td><?= htmlspecialchars($article['ten_tgia']) ?></td>
                                    <td><a href='edit_article.php?id=<?= $article['ma_bviet'] ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
                                    <td><a href='../controllers/ArticleController.php?action=delete&id=<?= $article['ma_bviet'] ?>' 
                                        onclick='return confirm("Bạn có chắc chắn muốn xóa bài viết này?");'><i class='fa-solid fa-trash'></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan='6'>Không có bài viết nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
