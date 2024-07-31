<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "../../config.php";

    try {
        $sql = "SELECT * FROM member WHERE id_member='1'";
        $stmt = $config->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "<p>Data tidak ditemukan</p>";
        }
    } catch (PDOException $e) {
        echo 'Query gagal: ' . $e->getMessage();
    }

    ?>

    <div class="container">
        <h2 class="mb-3 text-center">Edit Toko</h2>
        <div class="row">
            <div class="col-sm-9 mx-auto">
                <form enctype="multipart/form-data" method="post" action="edit.php">
                    <div class="form-group mb-3">
                        <label for="whatsapp">WhatsApp:</label>
                        <input class="form-control" type="text" name="whatsapp" id="whatsapp" value="<?php echo htmlspecialchars($row['Whatsapp']); ?>" >
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="shopee">Shopee:</label>
                        <input class="form-control" type="text" name="shopee" id="shopee" value="<?php echo htmlspecialchars($row['shopee']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="facebook">Facebook:</label>
                        <input class="form-control" type="text" name="facebook" id="facebook" value="<?php echo htmlspecialchars($row['facebook']); ?>" >
                    </div>
                    <div class="form-group mb-3">
                        <label for="instagram">Instagram:</label>
                        <input class="form-control" type="text" name="instagram" id="instagram" value="<?php echo htmlspecialchars($row['instagram']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="about">About:</label>
                        <textarea class="form-control" name="about" id="about" rows="4"><?php echo htmlspecialchars($row['about']); ?></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                    </div>
                    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($row['id_member']); ?>">
                </form>
            </div>
        </div>
    </div>
</body>

</html>