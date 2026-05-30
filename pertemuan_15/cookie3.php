<?php
// Setel waktu kedaluwarsa ke satu jam yang lalu untuk menghapus cookie
setcookie("username", "", time() - 3600, "/");
setcookie("namalengkap", "", time() - 3600, "/");

echo "<h1>Cookie Berhasil dihapus.</h1>";

// Perbaikan: Menyesuaikan nama file tautan agar sesuai dengan halaman sebelumnya
echo "<h2>Klik <a href='cookie1.php'>di sini</a> untuk penciptaan cookies</h2>";
echo "<h2>Klik <a href='cookie2.php'>di sini</a> untuk pemeriksaan cookies</h2>";
?>