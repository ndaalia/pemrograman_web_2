<?php
$a = 10;

if ($a > 0) {
   echo "Variabel A terdefinisi dan aman dari Notice.";
}

echo "<br>";

if (isset($_GET['test']) && $_GET['test'] == 0) {
   echo "Parameter test bernilai 0";
} else {
   echo "Gunakan URL: http://localhost/PemrogramanWeb2/Pertemuan18/latihan4.php?test=0 agar kondisi terpenuhi.";
}
?>