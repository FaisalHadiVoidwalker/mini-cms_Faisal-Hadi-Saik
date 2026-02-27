<?php
require_once "config/connectDB.php";
require_once "app/controllers/HomeController.php";

$controller = new HomeController($pdo);

$page = $_GET['page'] ?? 'home';

if ($page === 'detail') {
    $controller->detail($_GET['id'] ?? null);
} else {
    $controller->home();
}
