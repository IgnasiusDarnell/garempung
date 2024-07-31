<?php
require_once 'functions.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

if (deleteProduct($id)) {
    header('Location: index.php');
    exit;
} else {
    echo "Error deleting product.";
}