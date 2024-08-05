<?php
require_once 'functions.php';
require_once 'header.php';

$products = getAllProducts();
?>

<h1 class="mb-4">Product List</h1>
<a href="create.php" class="btn btn-primary mb-3">Add New Product</a>
<div class="row">
    <?php foreach ($products as $product) : ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <?php if (!empty($product['images'])) : ?>
                    <!-- Carousel for images -->
                    <div id="carousel<?= $product['id'] ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($product['images'] as $index => $image) : ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: cover;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel<?= $product['id'] ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel<?= $product['id'] ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                <?php elseif ($product['file_type'] === 'video') : ?>
                    <video src="<?= htmlspecialchars($product['file_name']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" controls>
                        Your browser does not support the video tag.
                    </video>
                <?php else : ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-muted">No image</span>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text">Rp.<?= number_format($product['price']) ?></p>
                    <p class="card-text"><small class="text-muted">Best Seller: <?= $product['is_best_seller'] ? 'Yes' : 'No' ?></small></p>
                    <a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>