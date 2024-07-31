<?php
require_once 'functions.php';
require_once 'header.php';

$product_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $is_best_seller = isset($_POST['is_best_seller']) ? 1 : 0;

    if (createProduct($name, $price, $description, $is_best_seller)) {
        $product_id = $config->lastInsertId();
    }
}
?>

<h1 class="mb-4">Create Product</h1>
<form action="" method="POST" id="create-form">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_best_seller" name="is_best_seller">
        <label class="form-check-label" for="is_best_seller">Best Seller</label>
    </div>
    <button type="submit" class="btn btn-primary">Create Product</button>
</form>

<?php if ($product_id): ?>
    <h2 class="mt-4 mb-3">Upload Product Media</h2>
    <form action="upload.php" class="dropzone" id="my-dropzone">
        <input type="hidden" name="product_id" value="<?= $product_id ?>">
    </form>
    <div id="preview" class="mt-4 row"></div>
    <a href="index.php" class="btn btn-secondary mt-3">Finish and Go to Product List</a>
<?php endif; ?>

<script>
Dropzone.options.myDropzone = {
    paramName: "file",
    maxFilesize: 5, // MB
    acceptedFiles: "image/*,video/*",
    init: function() {
        this.on("success", function(file, response) {
            response = JSON.parse(response);
            if (response.success) {
                var preview = document.getElementById('preview');
                var col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                if (file.type.startsWith('image/')) {
                    col.innerHTML = `
                        <img src="${response.file_path}" class="img-fluid" alt="Product Image">
                        <button class="btn btn-sm btn-danger mt-2" onclick="deleteMedia(${response.media_id}, this)">Delete</button>
                    `;
                } else {
                    col.innerHTML = `
                        <video src="${response.file_path}" controls class="img-fluid">Your browser does not support the video tag.</video>
                        <button class="btn btn-sm btn-danger mt-2" onclick="deleteMedia(${response.media_id}, this)">Delete</button>
                    `;
                }
                preview.appendChild(col);
            }
        });
    }
};

function deleteMedia(mediaId, button) {
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
                button.closest('.col-md-4').remove();
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

document.getElementById('create-form').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('my-dropzone').querySelector('input[name="product_id"]').value = data.product_id;
            document.getElementById('my-dropzone').style.display = 'block';
            document.querySelector('h2').style.display = 'block';
            document.querySelector('a.btn-secondary').style.display = 'inline-block';
        } else {
            alert('Failed to create product');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred while creating the product');
    });
});
</script>

<?php require_once 'footer.php'; ?>