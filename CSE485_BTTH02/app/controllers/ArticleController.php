<?php
require_once '../models/Article.php';

class ArticleController {
    private $articleModel;
    
    public function __construct() {
        $this->articleModel = new Article();
    }

    public function index() {
        $articles = $this->articleModel->getAll();
        require '../views/article.php'; // Hiển thị danh sách bài viết
    }

    // Thêm bài viết
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $summary = $_POST['summary'] ?? '';
            $category_id = $_POST['ma_tloai'] ?? '';
            $author_id = $_POST['ma_tgia'] ?? '';

            $success = $this->articleModel->addArticle($title, $summary, $category_id, $author_id);

            if ($success) {
                header("Location: ../views/article.php?success=Thêm bài viết thành công");
                exit();
            } else {
                header("Location: ../views/add_article.php?error=Có lỗi xảy ra khi thêm bài viết.");
                exit();
            }
        }
    }

    // Lấy bài viết theo ID
    public function getArticleById($id) {
        return $this->articleModel->getById($id);
    }

    // Cập nhật bài viết
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleId = $_POST['articleId'] ?? '';
            $title = $_POST['title'] ?? '';
            $summary = $_POST['summary'] ?? '';

            if ($this->articleModel->updateArticle($articleId, $title, $summary)) {
                header("Location: ../views/article.php?success=Cập nhật bài viết thành công");
                exit();
            } else {
                header("Location: ../views/edit_article.php?id=$articleId&error=Có lỗi xảy ra khi cập nhật bài viết.");
                exit();
            }
        }
    }

    // Xóa bài viết
    public function delete($id) {
        // Kiểm tra xem bài viết có tồn tại không
        if ($this->articleModel->exists($id)) {
            // Thực hiện xóa bài viết
            if ($this->articleModel->deleteArticle($id)) {
                header("Location: ../views/article.php?success=Xóa bài viết thành công.");
            } else {
                header("Location: ../views/article.php?error=Lỗi khi xóa bài viết.");
            }
        } else {
            header("Location: ../views/article.php?error=Bài viết không tồn tại.");
        }
        exit();
    }
}

// Xử lý action từ query string
$controller = new ArticleController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $controller->add();
        break;
    case 'delete':
        if (isset($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            header("Location: ../views/article.php?error=ID bài viết không hợp lệ.");
        }
        break;
    case 'update':
        $controller->update();
        break;
    default:
        $controller->index();
        break;
}
?>
