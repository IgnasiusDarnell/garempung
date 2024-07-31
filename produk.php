<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garempung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/index.css">
</head>

<body>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand " href="index.html">
                <img src="assets/icon.png" alt="Garempung" style="height: 40px;">
            </a>
            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                <div class="navbar-nav  w-100 justify-content-around custom-nav-links">
                    <a class="nav-link " aria-current="page" href="index.html">Home</a>
                    <a class="nav-link active" href="produk.html">PRODUK</a>
                    <a class="nav-link " href="about.html">TENTANG KAMI</a>
                    <a class="nav-link " href="kontak.html">KONTAK</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar -->

    <?php
    require 'config.php';

    // Define the base path for the images
    $basePath = 'admin/product/';

    // Correcting the SQL query by placing the WHERE clause before the ORDER BY clause
    $sql = "SELECT p.id, p.name, p.price, p.description, p.is_best_seller, pm.file_name, pm.file_type 
    FROM products p 
    LEFT JOIN product_media pm ON p.id = pm.product_id 
    WHERE p.is_best_seller=1
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

    <h1 class="mb-4">Best Products</h1>
    <div class="container">
        <div class="row">
            <?php foreach ($groupedProducts as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if (!empty($product['images'])): ?>
                            <!-- Carousel for images -->
                            <div id="carousel<?= $product['id'] ?>" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php foreach ($product['images'] as $index => $image): ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="<?= htmlspecialchars($image) ?>" class="d-block w-100"
                                                alt="<?= htmlspecialchars($product['name']) ?>"
                                                style="height: 200px; object-fit: cover;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carousel<?= $product['id'] ?>" role="button"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel<?= $product['id'] ?>" role="button"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <span class="text-muted">No image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <p class="card-text">$<?= number_format($product['price'], 2) ?></p>
                            <p class="card-text"><small class="text-muted">Best Seller:
                                    <?= $product['is_best_seller'] ? 'Yes' : 'No' ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



    <!-- <div class="col-sm-1 d-flex align-items-center">
        <div class="divider"></div>
    </div>
    <div class="col-sm-5">
        <div class="card">
            <div class="card-body d-flex flex-column align-items-left">
                <img src="assets/standlaptopkayulipat.png" alt="standlaptopkayukecil">
                <h4 class="card-title mt-3">Stand Laptop Kayu Lipat</h4>
                <div>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>
                <div class="d-flex justify-content-between align-items-center w-100 mt-3">
                    <div>
                        <h3>Rp 35.000</h3>
                        <p>(Detail Produk)</p>
                    </div>
                    <button type="button" class="btn btn-secondary" id="buy">Default</button>
                </div>
            </div>
        </div>
    </div> -->
    </div>
    </div>
    </section>
    <!-- Include Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>