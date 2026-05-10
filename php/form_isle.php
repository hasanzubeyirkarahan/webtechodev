<?php
/**
 * form_isle.php
 * İletişim formu POST verilerini karşılar ve düzenli biçimde ekrana yazdırır.
 */

// Sadece POST isteği kabul et
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../iletisim.html");
    exit;
}

// Verileri al ve güvenli hale getir
function temizle($veri) {
    return htmlspecialchars(strip_tags(trim($veri)));
}

$adSoyad          = temizle($_POST["adSoyad"]          ?? "");
$email            = temizle($_POST["email"]             ?? "");
$telefon          = temizle($_POST["telefon"]           ?? "");
$konu             = temizle($_POST["konu"]              ?? "");
$mesaj            = temizle($_POST["mesaj"]             ?? "");
$iletisimYontemi  = temizle($_POST["iletisimYontemi"]   ?? "Belirtilmedi");
$nereden          = temizle($_POST["nereden"]           ?? "Belirtilmedi");
$butce            = temizle($_POST["butce"]             ?? "0");
$kvkk             = isset($_POST["kvkk"]) ? "Onaylandı" : "Onaylanmadı";
$alanlar          = isset($_POST["alanlar"]) && is_array($_POST["alanlar"])
                    ? array_map("temizle", $_POST["alanlar"])
                    : [];
$tarih            = date("Y-m-d H:i:s");

// Temel doğrulama
$hatalar = [];
if (strlen($adSoyad) < 3) $hatalar[] = "Ad Soyad geçersiz.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $hatalar[] = "E-posta adresi geçersiz.";
if (!preg_match('/^[0-9]{10,11}$/', preg_replace('/\s+/', '', $telefon))) $hatalar[] = "Telefon numarası geçersiz.";
if (empty($konu)) $hatalar[] = "Konu seçilmedi.";
if (strlen($mesaj) < 10) $hatalar[] = "Mesaj çok kısa.";
if ($kvkk !== "Onaylandı") $hatalar[] = "KVKK onayı verilmedi.";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Sonucu | Web Projesi</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav class="navbar">
  <a href="../index.html" class="navbar-brand">Port<span>folio</span></a>
  <ul class="nav-links" id="navLinks">
    <li><a href="../index.html">🏠 Hakkımda</a></li>
    <li><a href="../iletisim.html">✉️ İletişim</a></li>
  </ul>
</nav>

<div class="page-wrapper">
  <div class="section" style="max-width:800px;">

<?php if (!empty($hatalar)): ?>
    <!-- HATA -->
    <div class="card" style="border-left:4px solid #dc2626;">
      <h2 style="color:#dc2626;font-family:var(--font-display);margin-bottom:1rem;">❌ Form Hataları</h2>
      <ul style="color:#dc2626;padding-left:1.5rem;">
        <?php foreach ($hatalar as $hata): ?>
          <li><?= $hata ?></li>
        <?php endforeach; ?>
      </ul>
      <div style="margin-top:1.5rem;">
        <a href="../iletisim.html" class="btn btn-primary">← Geri Dön</a>
      </div>
    </div>

<?php else: ?>
    <!-- BAŞARILI -->
    <div style="text-align:center;margin-bottom:2rem;">
      <div style="font-size:4rem;">✅</div>
      <h2 style="font-family:var(--font-display);font-size:2rem;color:var(--primary);">Form Başarıyla Gönderildi!</h2>
      <p style="color:var(--text-light);">Aşağıda gönderilen veriler sunucu tarafından alınmıştır.</p>
    </div>

    <!-- VERİ TABLOSU -->
    <div style="overflow-x:auto;margin-bottom:2rem;">
      <table class="info-table">
        <thead>
          <tr>
            <th>Alan</th>
            <th>Gönderilen Değer</th>
          </tr>
        </thead>
        <tbody>
          <tr><td><strong>👤 Ad Soyad</strong></td><td><?= $adSoyad ?></td></tr>
          <tr><td><strong>📧 E-posta</strong></td><td><?= $email ?></td></tr>
          <tr><td><strong>📞 Telefon</strong></td><td><?= $telefon ?></td></tr>
          <tr><td><strong>📋 Konu</strong></td><td><?= $konu ?></td></tr>
          <tr><td><strong>💬 İletişim Yöntemi</strong></td><td><?= $iletisimYontemi ?></td></tr>
          <tr>
            <td><strong>✅ İlgi Alanları</strong></td>
            <td>
              <?php if (!empty($alanlar)): ?>
                <?php foreach ($alanlar as $alan): ?>
                  <span class="badge"><?= $alan ?></span>
                <?php endforeach; ?>
              <?php else: ?>
                Seçilmedi
              <?php endif; ?>
            </td>
          </tr>
          <tr><td><strong>💰 Bütçe</strong></td><td><?= $butce ?> ₺</td></tr>
          <tr><td><strong>🔍 Nereden Duydunuz</strong></td><td><?= $nereden ?></td></tr>
          <tr><td><strong>📜 KVKK</strong></td><td><?= $kvkk ?></td></tr>
          <tr><td><strong>📅 Gönderim Tarihi</strong></td><td><?= $tarih ?></td></tr>
          <tr>
            <td><strong>💬 Mesaj</strong></td>
            <td style="white-space:pre-wrap;"><?= $mesaj ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- PHP Kaynak Kodu Gösterimi (ödev gerekliliği) -->
    <div class="card" style="background:var(--primary);border:none;">
      <h4 style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:0.75rem;font-family:monospace;">
        📄 PHP $_POST Verisi (Sunucu Tarafı)
      </h4>
      <pre style="color:#a3e635;font-size:0.82rem;overflow-x:auto;line-height:1.6;white-space:pre-wrap;"><?php
        $veriGoster = [
          'adSoyad'         => $adSoyad,
          'email'           => $email,
          'telefon'         => $telefon,
          'konu'            => $konu,
          'iletisimYontemi' => $iletisimYontemi,
          'alanlar'         => $alanlar,
          'butce'           => $butce . ' TL',
          'nereden'         => $nereden,
          'kvkk'            => $kvkk,
          'mesaj'           => $mesaj,
          'tarih'           => $tarih
        ];
        print_r($veriGoster);
      ?></pre>
    </div>

    <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;">
      <a href="../iletisim.html" class="btn btn-primary">✉️ Yeni Form Gönder</a>
      <a href="../index.html" class="btn btn-secondary">🏠 Ana Sayfa</a>
    </div>

<?php endif; ?>

  </div>

  <footer>
    <p>© 2025 Web Teknolojileri Projesi – Sakarya Üniversitesi | <a href="../index.html">Ana Sayfa</a></p>
  </footer>
</div>
</body>
</html>
