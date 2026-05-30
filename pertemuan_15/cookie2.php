<?php
// Wajib dijalankan di baris pertama jika halaman menggunakan $_SESSION
session_start();

// 1. PEMERIKSAAN SESSION (Apakah pengguna sudah login?)
if (isset($_SESSION['login'])) {
    
    echo "<h1>Selamat Datang ". $_SESSION['login'] ."</h1>";
    echo "<h2>Halaman ini hanya bisa diakses jika Anda sudah login</h2>";
    
    echo "<hr>"; // Batas penanda antara materi Session dan Cookie

    // 2. PEMERIKSAAN COOKIE
    if (isset($_COOKIE['username'])) {
        echo "<h1>Cookie 'username' ada. Isinya : " . $_COOKIE['username'] . "</h1>";
    } else {
        echo "<h1>Cookie 'username' TIDAK ada.</h1>";
    }

    if (isset($_COOKIE['namalengkap'])) {
        echo "<h1>Cookie 'namalengkap' ada. Isinya : " . $_COOKIE['namalengkap'] . "</h1>";
    } else {
        echo "<h1>Cookie 'namalengkap' TIDAK ada.</h1>";
    }

    // 3. NAVIGASI / LINK MENU
    echo "<br><br>";
    echo "<h2>Klik <a href='cookie1.php'>di sini</a> untuk penciptaan cookies</h2>";
    echo "<h2>Klik <a href='cookie3.php'>di sini</a> untuk penghapusan cookies</h2>";
    echo "<h2>Klik <a href='session3.php'>di sini (session3.php)</a> untuk LOGOUT</h2>";

} else {
    // Jika session 'login' belum ada, kunci halaman dan hentikan skrip
    die("<h1>Anda belum login!</h1><h2>Anda tidak berhak masuk ke halaman ini. Silahkan login <a href='session1.php'>di sini</a></h2>");  
}
?>