<?php
require_once('../core/init.php'); // Veritabanı bağlantısını başlat

// Veritabanından gönderileri çek
$gonderiler = $db->getRows("SELECT * FROM gonderi_ekle ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>AnimalTagram</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white p shadow-sm fixed-top">
        <div class="container px-5">
            <a class="navbar-brand fw-bold" href="#">AnimalTagram</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link me-lg-3" href="Anasayfa.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-lg-3" href="GönderiEkle.html">Gönderi Oluştur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Profil.html">Profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="ilan-wrapper">
            <?php foreach ($gonderiler as $gonderi): ?>
                <div class="ilanlar">
                    <div class="kullanici d-flex align-items-center mb-3">
                        <img src="../assets/img/profile.png" alt="Profil Fotoğrafı" class="rounded-circle" width="50"
                            height="50">
                        <span class="ms-2 fw-bold">Hatice Yıldız</span>
                    </div>
                    <img src="../<?= $gonderi->resim_url ?>" alt="Gönderi Resmi" class="img-fluid rounded mb-3">
                    <p class="aciklama"><?= htmlspecialchars($gonderi->aciklama) ?></p>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-primary">Beğen</button>
                        <button class="btn btn-outline-secondary">Yorum Yap</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-black text-center py-3 mt-5 text-white-50">
        <div class="container px-5">
            <div class="text-white-50 small">
                <div class="mb-2">© 2025 Tüm hakları saklıdır | MEÇKA</div>
                <span class="mx-1">mecka_yazilim@gmail.com</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</body>

</html>