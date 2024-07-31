<?php
require 'config.php';

// Get the product ID from the query parameter
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details and all associated images from the database
$sql = "SELECT p.id, p.name, p.price, p.description, p.is_best_seller, pm.file_name, pm.file_type
        FROM products p
        LEFT JOIN product_media pm ON p.id = pm.product_id
        WHERE p.id = :productId";
$stmt = $config->prepare($sql);
$stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$product) {
    echo "<h1>Product not found</h1>";
    exit;
}

// Group images
$basePath = 'admin/product/';
$images = [];
if ($product['file_type'] === 'image') {
    $images[] = $basePath . $product['file_name'];
}

// Fetch additional images
$sqlImages = "SELECT file_name FROM product_media WHERE product_id = :productId AND file_type = 'image'";
$stmtImages = $config->prepare($sqlImages);
$stmtImages->bindParam(':productId', $productId, PDO::PARAM_INT);
$stmtImages->execute();
$additionalImages = $stmtImages->fetchAll(PDO::FETCH_COLUMN);

// Merge images
$images = array_merge($images, array_map(function($fileName) use ($basePath) {
    return $basePath . $fileName;
}, $additionalImages));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['name']) : 'Product Not Found' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .carousel-item img {
            height: 400px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .product-info {
            padding: 2rem;
        }
        .price {
            font-size: 1.5rem;
            color: #28a745;
        }
        .best-seller-badge {
            background-color: #ffc107;
            color: #000;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="assets/icon.png" alt="Garempung" style="height: 40px;">
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <?php if ($product): ?>
            <div class="row product-container">
                <div class="col-lg-6 p-0">
                    <?php if (!empty($images)): ?>
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($images as $index => $image): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="<?= htmlspecialchars($product['name']) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <span class="text-muted">No image available</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 product-info">
                    <h1 class="mb-4"><?= htmlspecialchars($product['name']) ?></h1>
                    <p class="price mb-3">$<?= number_format($product['price'], 2) ?></p>
                    <?php if ($product['is_best_seller']): ?>
                        <span class="best-seller-badge mb-3 d-inline-block">
                            <i class="fas fa-award me-1"></i> Best Seller
                        </span>
                    <?php endif; ?>
                    <p class="mb-4"><?= htmlspecialchars($product['description']) ?></p>
                    <a href="combine.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Product Not Found</h4>
                <p>We're sorry, but the product you're looking for doesn't seem to exist or has been removed.</p>
                <hr>
                <p class="mb-0">Please check the product ID and try again, or return to the home page to browse our available products.</p>
            </div>
            <a href="combine.php" class="btn btn-primary">
                <i class="fas fa-home me-2"></i>Return to Home
            </a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>