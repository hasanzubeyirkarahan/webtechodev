<?php

$ogrenci_no   = "b251210029";

$tanimli_kullanici = $ogrenci_no . "@sakarya.edu.tr";
$tanimli_sifre     = $ogrenci_no;

// Sadece POST isteği kabul et
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.html");
    exit;
}

// Veri al ve temizle
$kullanici = isset($_POST["kullanici"]) ? trim($_POST["kullanici"]) : "";
$sifre     = isset($_POST["sifre"])     ? trim($_POST["sifre"])     : "";

// Boş alan kontrolü
if (empty($kullanici) || empty($sifre)) {
    header("Location: ../login.html?hata=1&mesaj=bos");
    exit;
}

// Email formatı kontrolü
if (!filter_var($kullanici, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../login.html?hata=1&mesaj=format");
    exit;
}

// Kimlik doğrulama
if ($kullanici === $tanimli_kullanici && $sifre === $tanimli_sifre) {
    // Başarılı giriş - Session başlat
    session_start();
    $_SESSION["ogrenci_no"]   = $ogrenci_no;
    $_SESSION["kullanici"]    = $kullanici;
    $_SESSION["giris_tarihi"] = date("Y-m-d H:i:s");

    // Başarı sayfasına yönlendir
    header("Location: hosgeldiniz.php?no=" . urlencode($ogrenci_no));
    exit;
} else {
    // Hatalı giriş - geri yönlendir
    header("Location: ../login.html?hata=1&mesaj=hatali");
    exit;
}
?>
