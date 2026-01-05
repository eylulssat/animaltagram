<?php
require_once('../core/init.php'); // Veritabanı bağlantısını başlat

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['resim']) && isset($_POST['aciklama'])) {
        $resim = $_FILES['resim'];
        $aciklama = htmlspecialchars(trim($_POST['aciklama'])); // XSS koruması

        // Desteklenen dosya türlerini kontrol edelim
        $desteklenenDosyaTipleri = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($resim['type'], $desteklenenDosyaTipleri)) {
            echo "Yalnızca JPEG, PNG ve GIF dosyalarını yükleyebilirsiniz.";
            exit;
        }

        // Maksimum dosya boyutunu kontrol edelim (örneğin 5MB)
        $maksimumBoyut = 5 * 1024 * 1024; // 5 MB
        if ($resim['size'] > $maksimumBoyut) {
            echo "Dosya boyutu 5 MB'yi geçemez.";
            exit;
        }

        if ($resim['error'] === 0) {
            $dosyaAdi = uniqid() . '-' . basename($resim['name']);
            $hedefKlasor = '../uploads/';
            $hedefYol = $hedefKlasor . $dosyaAdi;

            // Hedef klasör yoksa oluştur
            if (!is_dir($hedefKlasor)) {
                mkdir($hedefKlasor, 0777, true);
            }

            // Dosyayı hedefe taşı
            if (move_uploaded_file($resim['tmp_name'], $hedefYol)) {
                try {
                    // Veritabanı bağlantısı kontrolü
                    if (!isset($db)) {
                        throw new Exception("Veritabanı bağlantısı bulunamadı.");
                    }

                    $query = "INSERT INTO gonderi_ekle (resim_url, aciklama) VALUES (:resim_url, :aciklama)";
                    $params = [
                        ':resim_url' => 'uploads/' . $dosyaAdi,
                        ':aciklama' => $aciklama
                    ];
                    $db->Insert($query, $params);

                    // İşlem başarılıysa ana sayfaya yönlendir
                    header('Location: ../html/Anasayfa.html');
                    exit;
                } catch (Exception $e) {
                    // Hata mesajını detaylı göster
                    echo "Veritabanı hatası: " . $e->getMessage();
                }
            } else {
                echo "Resim yüklenirken bir hata oluştu.";
            }
        } else {
            echo "Resim yükleme hatası: " . $resim['error'];
        }
    } else {
        echo "Lütfen tüm alanları doldurun.";
    }
} else {
    echo "Geçersiz istek.";
}
?>