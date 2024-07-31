<?php
// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../../config.php";

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $email = $_POST['email'];
    $shopee = $_POST['shopee'];
    $instagram = $_POST['instagram'];
    $about = $_POST['about'];
    
    try {
        // Buat query untuk mengupdate data
        $sql = "UPDATE member SET email = :email, shopee = :shopee, instagram = :instagram, about = :about WHERE id_member = :id";
        $stmt = $config->prepare($sql);
        
        // Bind parameter ke query
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':shopee', $shopee);
        $stmt->bindParam(':instagram', $instagram);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Eksekusi query
        if ($stmt->execute()) {
            echo "Data berhasil diupdate";
        } else {
            echo "Gagal mengupdate data";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

