<?php
require_once 'functions.php';
require_once 'header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$product = getProductById($id);
$media = getProductMedia($id);
?>

<h1 class="mb-4"><?= htmlspecialchars($product['name']) ?></h1>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Price: $<?= number_format($product['price'], 2) ?></h5>
        <p class="card-text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <p class="card-text"><small class="text-muted">Best Seller: <?= $product['is_best_seller'] ? 'Yes' : 'No' ?></small></p>
    </div>
</div>

<h2 class="mb-3">Product Media</h2>
<div class="row">
    <?php foreach ($media as $item): ?>
        <div class="col-md-4 mb-3">
            <?php if ($item['file_type'] === 'image'): ?>
                <img src="<?= $item['file_name'] ?>" alt="Product Image" class="img-fluid">
            <?php else: ?>
                <video src="<?= $item['file_name'] ?>" controls class="img-fluid">Your browser does not support the video tag.</video>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<a href="index.php" class="btn btn-secondary">Back to List</a>
<a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-warning">Edit</a>

<?php require_once 'footer.php'; ?>