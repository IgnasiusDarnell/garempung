<?php
require_once 'functions.php';

// Mengambil parameter id dari URL
$id = $_GET['id'] ?? null;

// Jika id tidak ada, redirect ke halaman utama
if (!$id) {
    header('Location: ./index.php');
    exit;
}

try {
    // Menghapus produk dan memeriksa hasilnya
    if (deleteProduct($id)) {
        header('Location: ./index.php');
        exit;
    } else {
        throw new Exception("Error deleting product.");
    }
} catch (Exception $e) {
    // Menampilkan pesan kesalahan
    echo "Error: " . htmlspecialchars($e->getMessage());
}
