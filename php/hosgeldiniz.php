<?php
/**
 * hosgeldiniz.php
 * Başarılı girişten sonra gösterilen hoşgeldiniz sayfası.
 */

session_start();

// Session kontrolü - direkt erişimi engelle
if (!isset($_SESSION["ogrenci_no"])) {
    // Direkt erişimde URL parametresine bak (demo için)
    if (!isset($_GET["no"])) {
        header("Location: ../login.html?hata=1");
        exit;
    }
    $ogrenci_no = htmlspecialchars($_GET["no"]);
} else {
    $ogrenci_no = htmlspecialchars($_SESSION["ogrenci_no"]);
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hoşgeldiniz | Web Projesi</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="login-wrapper">
  <div class="login-card" style="text-align:center;">
    <div style="font-size:5rem;margin-bottom:1rem;">🎉</div>
    <h2 style="font-family:var(--font-display);font-size:1.8rem;color:var(--primary);margin-bottom:0.5rem;">
      Hoşgeldiniz!
    </h2>
    <div style="background:linear-gradient(135deg,var(--primary),var(--accent2));color:#fff;padding:1rem 1.5rem;border-radius:10px;margin:1.5rem 0;font-size:1.1rem;">
      <strong><?= $ogrenci_no ?></strong>
    </div>
    <p style="color:var(--text-light);margin-bottom:1.5rem;">
      Başarıyla giriş yaptınız. Sisteme hoş geldiniz!
    </p>
    <div style="display:flex;flex-direction:column;gap:0.75rem;">
      <a href="../index.html" class="btn btn-primary">🏠 Ana Sayfaya Git</a>
      <a href="cikis.php" class="btn" style="background:var(--border);color:var(--text);">🚪 Çıkış Yap</a>
    </div>
    <p style="margin-top:1.5rem;font-size:0.8rem;color:var(--text-light);">
      Giriş zamanı: <?= isset($_SESSION["giris_tarihi"]) ? $_SESSION["giris_tarihi"] : date("Y-m-d H:i:s") ?>
    </p>
  </div>
</div>
</body>
</html>
