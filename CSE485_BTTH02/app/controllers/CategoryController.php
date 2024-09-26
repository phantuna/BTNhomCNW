<?php
require_once '../models/Category.php';

class CategoryController {
    public function index() {
        $categories = Category::getAll();
        require '../views/category.php'; 
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryName = $_POST['txtCatName'] ?? '';
            if (empty(trim($categoryName))) {
                header("Location: ../views/add_category.php?error=Vui lòng nhập tên thể loại.");
                exit();
            }

            $category = new Category();
            $success = $category->addCategory($categoryName);

            if ($success) {
                header("Location: ../views/category.php?success=Thêm thể loại thành công");
            } else {
                header("Location: ../views/add_category.php?error=Có lỗi xảy ra khi thêm thể loại.");
            }
            exit();
        }
    }

    public function edit($catId) {
        $categoryModel = new Category();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catId = $_POST['txtCatId'] ?? '';
            $catName = $_POST['txtCatName'] ?? '';
            if ($categoryModel->updateCategory($catId, $catName)) {
                header("Location: ../views/category.php");
            } else {
                header("Location: ../views/edit_category.php?id=$catId&error=Lỗi khi sửa thể loại.");
            }
            exit();
        }
        
        $category = $categoryModel->getById($catId);
        if (!$category) {
            header("Location: ../views/category.php?error=Thể loại không tồn tại.");
            exit();
        }
        require '../views/edit_category.php'; // Hiển thị form chỉnh sửa
    }

    public function delete($catId) {
        $categoryModel = new Category();
        
        if ($categoryModel->hasArticles($catId)) {
            header("Location: ../views/category.php?error=Không thể xóa thể loại vì vẫn còn bài viết liên quan.");
            exit();
        } 
        
        if ($categoryModel->deleteCategory($catId)) {
            header("Location: ../views/category.php?success=Xóa thể loại thành công");
        } else {
            header("Location: ../views/category.php?error=Lỗi khi xóa thể loại.");
        }
        exit();
    }
}

// Xử lý action từ query string
$controller = new CategoryController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $controller->addCategory();
        break;
    case 'edit':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $controller->edit($_GET['id']);
        } else {
            header("Location: ../views/category.php?error=ID thể loại không hợp lệ.");
        }
        break;
    case 'delete':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            header("Location: ../views/category.php?error=ID thể loại không hợp lệ.");
        }
        break;
    default:
        $controller->index();
        break;
}
?>
