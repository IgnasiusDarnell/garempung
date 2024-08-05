<?php
// Aktifkan error reporting untuk debugging (jangan diaktifkan di produksi)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../../config.php";

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan bersihkan input
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_SPECIAL_CHARS); // Changed to FILTER_SANITIZE_SPECIAL_CHARS
    $shopee = filter_input(INPUT_POST, 'shopee', FILTER_SANITIZE_SPECIAL_CHARS);
    $instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_SPECIAL_CHARS);
    $about = filter_input(INPUT_POST, 'about', FILTER_SANITIZE_SPECIAL_CHARS);
    $facebook = filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validasi input
    if ($id === false || !$email) {
        echo "Input tidak valid";
        exit;
    }

    try {
        // Buat query untuk mengupdate data
        $sql = "UPDATE member SET email = :email, Whatsapp = :whatsapp, shopee = :shopee, instagram = :instagram, facebook = :facebook, about = :about WHERE id_member = :id";
        $stmt = $config->prepare($sql);

        // Bind parameter ke query
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':whatsapp', $whatsapp);
        $stmt->bindParam(':shopee', $shopee);
        $stmt->bindParam(':instagram', $instagram);
        $stmt->bindParam(':facebook', $facebook);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Eksekusi query
        if ($stmt->execute()) {
            header('Location: ../product/index.php');
            exit;
        } else {
            echo "Gagal mengupdate data";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
