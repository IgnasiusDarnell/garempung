<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garempung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .carousel-item img {
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            color: #555;
        }

        .checked {
            color: #ffbb33;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #000;
            border-radius: 50%;
        }
    </style>
</head>

<body>

    <?php
    require 'config.php';

    // Define the base path for the images
    $basePath = 'admin/product/';

    // Correcting the SQL query by placing the WHERE clause before the ORDER BY clause
    $sql = "SELECT p.id, p.name, p.price, p.description, p.is_best_seller, pm.file_name, pm.file_type 
    FROM products p 
    LEFT JOIN product_media pm ON p.id = pm.product_id 
    ORDER BY p.created_at DESC";
    $stmt = $config->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $groupedProducts = [];
    foreach ($products as $product) {
        $productId = $product['id'];
        if (!isset($groupedProducts[$productId])) {
            $groupedProducts[$productId] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'description' => $product['description'],
                'is_best_seller' => $product['is_best_seller'],
                'images' => []
            ];
        }
        if ($product['file_type'] === 'image') {
            $groupedProducts[$productId]['images'][] = $basePath . $product['file_name'];
        }
    }

    $groupedProducts = array_values($groupedProducts); // Re-indexing the array
    ?>

    <div class="container my-5">
        <a href="index.php" class="btn btn-primary">
            <i class="fa fa-home me-2"></i>Return to Home
        </a>
        <h1 class="mb-4 text-center">Our Products</h1>
        <div class="row">
            <?php foreach ($groupedProducts as $product) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($product['images'])) : ?>
                            <!-- Carousel for images -->
                            <div id="carousel<?= $product['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($product['images'] as $index => $image) : ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="<?= htmlspecialchars($product['name']) ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $product['id'] ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $product['id'] ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        <?php elseif (isset($product['file_type']) && $product['file_type'] === 'video') : ?>
                            <video src="<?= htmlspecialchars($product['file_name']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" controls>
                                Your browser does not support the video tag.
                            </video>
                        <?php else : ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-muted">No image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text">Rp.<?= number_format($product['price']) ?></p>
                            <p class="card-text"><small class="text-muted">Best Seller: <?= $product['is_best_seller'] ? 'Yes' : 'No' ?></small></p>
                            <a href="detail.php?id=<?= $product['id'] ?>" class="btn btn-primary mt-auto">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Include Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>