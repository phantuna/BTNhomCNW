<?php
require_once '../models/Author.php';

class AuthorController {
    private $authorModel;

    public function __construct() {
        $this->authorModel = new Author();
    }

    public function index() {
        $authors = $this->authorModel->getAll();
        require '../views/author.php'; // Hiển thị danh sách tác giả
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authorName = $_POST['txtAuthorName'] ?? '';
            $success = $this->authorModel->addAuthor($authorName);
            if ($success) {
                header("Location: ../views/author.php?msg=Thêm tác giả thành công");
            } else {
                header("Location: ../views/add_author.php?error=Có lỗi xảy ra khi thêm tác giả.");
            }
            exit;
        }
    }

    public function getAuthorById($id) {
        return $this->authorModel->getById($id);
    }

    public function updateAuthor($catId, $catName) {
        if (empty(trim($catName))) {
            return false; // Không cập nhật nếu tên rỗng
        }
        return $this->authorModel->updateAuthor($catId, $catName);
    }

    public function delete($catId) {
        if ($this->authorModel->exists($catId)) {
            if ($this->authorModel->deleteAuthor($catId)) {
                header("Location: ../views/author.php?msg=Xóa tác giả thành công!");
            } else {
                header("Location: ../views/author.php?msg=Lỗi khi xóa tác giả.");
            }
        } else {
            header("Location: ../views/author.php?msg=Tác giả không tồn tại.");
        }
        exit;
    }
}

// Xử lý action từ query string
$controller = new AuthorController();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            $controller->add();
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $controller->delete($_GET['id']);
            } else {
                header("Location: ../views/author.php?msg=ID tác giả không hợp lệ.");
            }
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller->index();
}
?>
