<?php
require_once '../models/Statistics.php'; // Mặt khác trong folder models của bạn

class DashboardController {
    private $statsModel;

    public function __construct() {
        $this->statsModel = new Statistics();
    }

    public function index() {
        $total_categories = $this->statsModel->getTotalCategories();
        $total_authors = $this->statsModel->getTotalAuthors();
        $total_articles = $this->statsModel->getTotalArticles();

        require '../views/dashboard.php'; // Load view
    }
}

// Xử lý yêu cầu
$controller = new DashboardController();
$controller->index();
?>
