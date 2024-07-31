<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garempung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="assets/icon.png" alt="Garempung" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav w-100 justify-content-around custom-nav-links">
                    <a class="nav-link active" aria-current="page" href="#home">Home</a>
                    <a class="nav-link" href="#produk">PRODUK</a>
                    <a class="nav-link" href="#about">TENTANG KAMI</a>
                    <a class="nav-link" href="#kontak">KONTAK</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Selamat Datang Di Garempung.ld<br>Stand Laptop Kayu Yang Elegan Dan<br>Fungsional</h1>
            <button class="btn btn-pesan">Pesan Sekarang</button>
        </div>
    </section>

    <!-- jumbotron -->

    <!-- Keunggulan Produk -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Keunggulan Produk Garempung.id</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">Desain Ergonomis</h4>
                            <p class="card-text">Setiap stand laptop dirancang dengan mempertimbangkan kenyamanan dan
                                kesehatan pengguna. Desain ergonomis membantu menjaga postur tubuh yang baik, mengurangi
                                risiko cedera leher dan punggung.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">Stabil dan Kokoh</h4>
                            <p class="card-text">Struktur stand laptop kami dibuat untuk memastikan stabilitas dan
                                kekokohan, mampu menahan berat laptop dengan aman dan memberikan kenyamanan saat
                                digunakan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">Harga Terjangkau</h4>
                            <p class="card-text">Kami menawarkan produk berkualitas tinggi dengan harga yang kompetitif.
                                Dengan dua pilihan ukuran, pelanggan dapat memilih sesuai kebutuhan dan anggaran mereka.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end -->

    <!-- Item Section -->
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

    <section class="py-5 bg-light" id="produk">
        <h2 class="text-center mb-4">PRODUK UNGGULAN</h2>
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
                                <a href="detail.php?id=<?= $product['id'] ?>" class="btn btn-primary">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Buatan Lokal -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 product-images">
                <div class="row">
                    <div class="col-8">
                        <img src="https://via.placeholder.com/380x492" alt="Image 1" class="img-fluid">
                    </div>
                    <div class="col-4 d-flex flex-column">
                        <img src="https://via.placeholder.com/239x239" alt="Image 2" class="img-fluid mb-2">
                        <img src="https://via.placeholder.com/239x240" alt="Image 3" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6 product-text">
                <h2>Buatan Lokal</h2>
                <p>Produk kami adalah hasil karya pengrajin lokal yang berpengalaman, mendukung ekonomi lokal dan
                    memastikan kontrol kualitas yang ketat.</p>
                <h2>Estetika Minimalis</h2>
                <p>Dengan desain minimalis yang modern, stand laptop Garempung.id tidak hanya fungsional tetapi juga
                    menambah keindahan meja kerja Anda. Tampilan kayu alami memberikan kesan hangat dan profesional.</p>
            </div>
        </div>
    </div>
    <!-- end Buatan Lokal -->

    <!-- Visi Misi -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 product-text">
                <h2>Visi </h2>
                <p>Produk kami adalah hasil karya pengrajin lokal yang berpengalaman, mendukung ekonomi lokal dan
                    memastikan kontrol kualitas yang ketat.</p>
                <h2>Misi</h2>
                <p>Dengan desain minimalis yang modern, stand laptop Garempung.id tidak hanya fungsional tetapi juga
                    menambah keindahan meja kerja Anda. Tampilan kayu alami memberikan kesan hangat dan profesional.</p>
            </div>
            <div class="col-md-6 product-images">
                <div class="row">
                    <div class="col-4 d-flex flex-column">
                        <img src="https://via.placeholder.com/239x239" alt="Image 2" class="img-fluid mb-2">
                        <img src="https://via.placeholder.com/239x240" alt="Image 3" class="img-fluid">
                    </div>
                    <div class="col-8">
                        <img src="https://via.placeholder.com/380x492" alt="Image 1" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Visi Misi -->

    <!-- Testimoni -->
    <div class="container my-5">
        <h1 class="text-center mb-5">Testimoni</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <img src="assets/background.png" alt="Testimoni 1" class="testimonial-img">
                    <div class="testimonial-content">
                        <img src="assets/owner.png" alt="Avatar" class="avatar">
                        <h5 class="mt-4 mb-1">Bang Yatma</h5>
                        <p class="text-muted small">Pedagang Asongan</p>
                        <p>"Mantap, desainnya keren.!"</p>
                        <div class="stars">
                            ★★★★☆
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <img src="assets/background.png" alt="Testimoni 2" class="testimonial-img">
                    <div class="testimonial-content">
                        <img src="assets/owner.png" alt="Avatar" class="avatar">
                        <h5 class="mt-4 mb-1">William</h5>
                        <p class="text-muted small">Ibu Rumah Tangga</p>
                        <p>"Makasih Panta, aku sekarang berasa tinggal di apartment karena barang-barang yang terlihat
                            mewah"</p>
                        <div class="stars">
                            ★★★★☆
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <img src="assets/background.png" alt="Testimoni 3" class="testimonial-img">
                    <div class="testimonial-content">
                        <img src="assets/owner.png" alt="Avatar" class="avatar">
                        <h5 class="mt-4 mb-1">Adiba</h5>
                        <p class="text-muted small">Karyawan Swasta</p>
                        <p>"Sangat bermanfaat untuk kantong saya yang tidak terlalu banyak"</p>
                        <div class="stars">
                            ★★★★☆
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Testimoni -->


    <?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include the configuration file
    require "config.php";

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM member WHERE id_member='1'";
    $stmt = $config->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <section class="contact-section text-center py-5">
        <div class="container" id="about">
            <h2 class="mb-2">TENTANG</h2>
            <h2 class="mb-4">GAREMPUNG.ID</h2>
            <img src="assets/owner.png" alt="Garempung" class="logo-img mb-3">
            <p>Muhammad Mandaka Adyatma</p>
            <p>(Owner Garempung.id)</p>
            <p><?php echo htmlspecialchars($row['about']); ?></p>
        </div>
    </section>
    <!-- Contact Section -->
    <section class="contact-section text-center py-5">
        <div class="container" id="kontak">
            <h2 class="mb-4">KONTAK</h2>
            <img src="assets/icon.png" alt="Garempung" class="logo mb-3" style="height: 100px;">
            <p class="mb-4">Kami ingin mendengar dari Anda! Apakah Anda memiliki pertanyaan mengenai produk kami, ingin
                memberikan umpan balik, atau butuh bantuan? Hubungi kami melalui formulir kontak di bawah ini atau
                gunakan informasi kontak yang tersedia.</p>
            <div class="contact-info mb-3">
                <p><i class="fa fa-whatsapp"></i> <?php echo htmlspecialchars($row['Whatsapp']); ?></p>
                <p><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 24 24">
                        <path fill="#070707"
                            d="M22.567,4.538c-0.292-0.306-0.702-0.481-1.125-0.481H16.9c-0.46-2.286-2.481-4.014-4.9-4.014 S7.559,1.77,7.1,4.056H2.557c-0.422,0-0.832,0.176-1.125,0.481C1.139,4.844,0.982,5.264,1.001,5.691L1.71,20.945 c0.081,1.737,1.497,3.098,3.225,3.098h14.13c1.728,0,3.145-1.36,3.225-3.097L22.999,5.69C23.018,5.264,22.861,4.844,22.567,4.538z M12,2.043c1.307,0,2.41,0.845,2.82,2.014H9.18C9.59,2.888,10.693,2.043,12,2.043z M20.292,20.853 c-0.031,0.667-0.57,1.189-1.227,1.189H4.935c-0.657,0-1.196-0.522-1.227-1.19L3.021,6.056h17.959L20.292,20.853z">
                        </path>
                        <path
                            d="M16.06,16.623c0,1.9-1.8,3.38-4.09,3.38c-2.491,0-4.25-1.77-4.25-1.77l1.1-1.75c0,0,1.99,1.49,3.15,1.49 c1.12,0,2.06-0.62,2.06-1.35c0-0.92-0.6-1.29-2.41-1.95c-1.55-0.57-3.46-1.27-3.46-3.43c0-1.88,1.67-3.3,3.88-3.3 c2.485,0,3.797,1.388,3.8,1.39l-1.04,1.72c-0.001,0-1.519-1.09-2.76-1.09c-1.08,0-1.86,0.54-1.86,1.28 c0,0.64,0.56,0.96,2.13,1.53C13.89,13.342,16.06,14.132,16.06,16.623z">
                        </path>
                    </svg> <?php echo htmlspecialchars($row['shopee']); ?></p>
                <p><i class="fa fa-instagram"></i> <?php echo htmlspecialchars($row['instagram']); ?></p>
                <p><i class="fa fa-facebook"></i> <?php echo htmlspecialchars($row['facebook']); ?></p>
            </div>
        </div>
    </section>
    <!-- Alamat -->

    <section class="contact-section text-center py-5">
        <div class="container">
            <h2 class="mb-4">Lokasi Kami</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item w-100"
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d990.785614466309!2d110.7072344!3d-6.6292222!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e711ff1ca199bfd%3A0xcdb32b0bad656575!2sJl.%20Wonosari%2C%20Kabupaten%20Jepara%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1721631578215!5m2!1sid!2sid"
                            style="border:0; height: 450px;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <h4 class="mt-4">Wonosari, Tahunan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59451</h4>
        </div>
    </section>
    <!-- End Alamat -->
    <!-- F0otoer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <img src="assets/icon.png" alt="Garempung Logo" class="logo img-fluid mb-3"
                        style="max-height: 100px;">
                    <p class="small">Hubungi Kami. Kami Selalu Siap Mendengar Dari Anda. Jika Anda Memiliki Pertanyaan
                        Atau Memerlukan Informasi Lebih Lanjut Tentang Produk Kami, Jangan Ragu Untuk Menghubungi Kami
                        Melalui Form Di Bawah Ini Atau Menggunakan Informasi Kontak Di Bagian Bawah Halaman Ini</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="contact-info">
                        <h5>Alamat</h5>
                        <p>Wonosari, Tahunan, Kec. Tahunan,<br>Kabupaten Jepara, Jawa Tengah<br>59451</p>
                        <h5>Email</h5>
                        <p> <?php echo htmlspecialchars($row['email']); ?></p>
                        <h5>Telepon</h5>
                        <p> <?php echo htmlspecialchars($row['Whatsapp']); ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <p><a href="#"><i class="fa fa-facebook"></i>
                                <?php echo htmlspecialchars($row['facebook']); ?></a></p>
                        <p><a href="#"><i class="fa fa-whatsapp"></i>
                                <?php echo htmlspecialchars($row['Whatsapp']); ?></a></p>
                        <p><a href="#"><i class="fa fa-instagram"></i>
                                <?php echo htmlspecialchars($row['instagram']); ?></a>
                        </p>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row footer-bottom">
                <div class="col-md-6 mb-2 mb-md-0">
                    <p class="small mb-0">Copyright © 2024</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="small me-3">Terms & Conditions</a>
                    <a href="#" class="small">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer -->

    <!-- Rest of the content... -->

    <script src="js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- Include Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>