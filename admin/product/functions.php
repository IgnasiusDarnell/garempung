<?php
require_once '../../config.php';

function getAllProducts()
{
    global $config;
    $stmt = $config->query("SELECT p.*, pm.file_name, pm.file_type 
                            FROM products p 
                            LEFT JOIN product_media pm ON p.id = pm.product_id 
                            GROUP BY p.id 
                            ORDER BY p.created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getProductThumbnail($product_id)
{
    global $config;
    $stmt = $config->prepare("SELECT file_name, file_type FROM product_media WHERE product_id = ? LIMIT 1");
    $stmt->execute([$product_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getProductById($id)
{
    global $config;
    $stmt = $config->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Tambahkan fungsi createProduct yang mengembalikan ID produk
function createProduct($name, $price, $description, $is_best_seller)
{
    global $config;
    $stmt = $config->prepare("INSERT INTO products (name, price, description, is_best_seller) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $price, $description, $is_best_seller])) {
        return $config->lastInsertId();
    }
    return false;
}

function updateProduct($id, $name, $price, $description, $is_best_seller)
{
    global $config;
    $stmt = $config->prepare("UPDATE products SET name = ?, price = ?, description = ?, is_best_seller = ? WHERE id = ?");
    return $stmt->execute([$name, $price, $description, $is_best_seller, $id]);
}

function deleteProduct($id)
{
    global $config;
    $stmt = $config->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}

function addProductMedia($product_id, $file_name, $file_type)
{
    global $config;
    $stmt = $config->prepare("INSERT INTO product_media (product_id, file_name, file_type) VALUES (?, ?, ?)");
    if ($stmt->execute([$product_id, $file_name, $file_type])) {
        return $config->lastInsertId();
    }
    return false;
}

function getProductMedia($product_id)
{
    global $config;
    $stmt = $config->prepare("SELECT * FROM product_media WHERE product_id = ?");
    $stmt->execute([$product_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteProductMedia($media_id)
{
    global $config;
    $stmt = $config->prepare("SELECT file_name FROM product_media WHERE id = ?");
    $stmt->execute([$media_id]);
    $media = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($media && unlink($media['file_name'])) {
        $stmt = $config->prepare("DELETE FROM product_media WHERE id = ?");
        return $stmt->execute([$media_id]);
    }
    return false;
}
