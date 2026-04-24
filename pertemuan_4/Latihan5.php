<?php
echo "Tabel Perkalian<br>";
echo "====================<br>";

$angka_dasar = 12;

// Kita mulai dari 15 sampai 45, meloncat 2 (agar tetap ganjil)
for ($pengali = 15; $pengali <= 45; $pengali += 2) {
    $hasil = $angka_dasar * $pengali;
    echo "$angka_dasar * $pengali = $hasil <br>";
}
?>