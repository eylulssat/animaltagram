<?php
require_once('../core/init.php'); // Veritabanı bağlantısını başlat

header('Content-Type: application/json');

try {
    // Gönderileri çek
    $gonderiler = $db->getRows("SELECT * FROM gonderi_ekle ORDER BY id DESC");

    // JSON formatında döndür
    echo json_encode($gonderiler, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?>