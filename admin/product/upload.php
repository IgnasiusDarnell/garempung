<?php
require_once 'functions.php';

$product_id = $_POST['product_id'] ?? null;
if (!$product_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Product ID is required']);
    exit;
}

if (!empty($_FILES['file'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
    $upload_dir = 'images/';

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_type = $file['type'];

    if (in_array($file_type, $allowed_types)) {
        $upload_path = $upload_dir . uniqid() . '_' . $file_name;
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $media_type = strpos($file_type, 'image') !== false ? 'image' : 'video';
            $media_id = addProductMedia($product_id, $upload_path, $media_type);
            if ($media_id) {
                echo json_encode(['success' => true, 'file_path' => $upload_path, 'media_id' => $media_id]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add media to database']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to move uploaded file']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid file type']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded']);
}
