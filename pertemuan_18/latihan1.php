<?php
$a = 5;

// PERBAIKAN: Menambahkan titik koma (;) di akhir statement dan menggunakan 'else if' jika ada kondisi [cite: 203, 204]
if ($a > 0) {
    $status = "A lebih besar dari 0";
} else if ($a < 0) { 
    $status = "A lebih kecil dari 0";
} else {
    $status = "A sama dengan 0";
}

echo "Status: " . $status;
?>