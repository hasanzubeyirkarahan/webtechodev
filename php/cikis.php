<?php
/**
 * cikis.php
 * Session'ı temizler ve login sayfasına yönlendirir.
 */
session_start();
session_destroy();
header("Location: ../login.html?cikis=1");
exit;
?>
