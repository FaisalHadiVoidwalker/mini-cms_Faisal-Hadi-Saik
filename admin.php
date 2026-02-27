<?php
session_start();

require_once "config/connectDB.php";
require_once "app/controllers/AdminController.php";

$controller = new AdminController($pdo);

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {

  case 'tambah':
    $controller->tambah();
    break;

  case 'edit':
    $controller->edit($_GET['id'] ?? null);
    break;

  case 'hapus':
    $controller->hapus($_GET['id'] ?? null);
    break;

  default:
    $controller->dashboard();
    break;

  case 'store':
    $controller->store();
    break;

  case 'update':
    $controller->update($_GET['id'] ?? null);
    break;
}
