<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $media_id = $_POST['media_id'] ?? null;
    if ($media_id) {
        if (deleteProductMedia($media_id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete media']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Media ID is required']);
    }
} else {
    header('Location: index.php');
    exit;
}
    