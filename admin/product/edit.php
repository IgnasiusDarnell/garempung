<?php
require_once 'functions.php';
require_once 'header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ./index.php');
    exit;
}

$product = getProductById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $is_best_seller = isset($_POST['is_best_seller']) ? 1 : 0;

    if (updateProduct($id, $name, $price, $description, $is_best_seller)) {
        header('Location: index.php');  // Changed this line
        exit;
    }
}

$media = getProductMedia($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        h2 {
            color: #343a40;
        }

        .dropzone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            background: #e9ecef;
            padding: 50px;
        }

        .dropzone .dz-message {
            color: #007bff;
        }

        .img-fluid {
            border-radius: 5px;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .form-check-label {
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">Edit Product</h1>


        <h2 class="mt-4 mb-3">Product Media</h2>
        <form action="upload.php" class="dropzone" id="my-dropzone">
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <div class="dz-message">Drop files here or click to upload.</div>
        </form>

        <div id="media-container" class="row mt-4">
            <?php foreach ($media as $item) : ?>
                <div class="col-md-4 mb-3" id="media-item-<?= $item['id'] ?>">
                    <?php if ($item['file_type'] === 'image') : ?>
                        <img src="<?= htmlspecialchars($item['file_name']) ?>" alt="Product Image" class="img-fluid">
                    <?php else : ?>
                        <video src="<?= htmlspecialchars($item['file_name']) ?>" controls class="img-fluid">Your browser does not support the video tag.</video>
                    <?php endif; ?>
                    <button class="btn btn-sm btn-danger mt-2" onclick="deleteMedia(<?= $item['id'] ?>)">Delete</button>
                </div>
            <?php endforeach; ?>
        </div>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_best_seller" name="is_best_seller" <?= $product['is_best_seller'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_best_seller">Best Seller</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a class="btn btn-danger" href="./index.php">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.myDropzone = {
            paramName: "file",
            maxFilesize: 5, // MB
            acceptedFiles: "image/*,video/*",
            init: function() {
                this.on("success", function(file, response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        var preview = document.getElementById('media-container');
                        var col = document.createElement('div');
                        col.className = 'col-md-4 mb-3';
                        var mediaElement = '';
                        if (file.type.startsWith('image/')) {
                            mediaElement = `<img src="${response.file_path}" class="img-fluid" alt="Product Image">`;
                        } else {
                            mediaElement = `<video src="${response.file_path}" controls class="img-fluid">Your browser does not support the video tag.</video>`;
                        }
                        col.innerHTML = `
                            ${mediaElement}
                            <button class="btn btn-sm btn-danger mt-2" onclick="deleteMedia(${response.media_id})">Delete</button>
                        `;
                        preview.appendChild(col);
                    }
                });
            }
        };

        function deleteMedia(mediaId) {
            if (confirm('Are you sure you want to delete this media?')) {
                fetch('delete_media.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'media_id=' + mediaId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var mediaItem = document.getElementById('media-item-' + mediaId);
                            if (mediaItem) {
                                mediaItem.remove();
                            }
                        } else {
                            alert('Failed to delete media');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting media');
                    });
            }
        }
    </script>
</body>

</html>

<?php require_once 'footer.php'; ?>