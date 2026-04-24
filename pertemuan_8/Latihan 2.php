<html>
<head>
<title>Contoh Penggunaan UDF</title>
</head>

<body>

<!-- Form Input -->
<form method="post">
Masukkan Bilangan Pertama : <br>
<input type="text" name="A" size="10"><br>

Masukkan Bilangan Kedua : <br>
<input type="text" name="B" size="10"><br>

<input type="submit" value="hitung">
</form>

<?php
$a = $_POST["A"];
$b = $_POST["B"];

function jumlah($A, $B)
{
    return $A + $B;
}

function kurang($A, $B)
{
    return $A - $B;
}

function kali($A, $B)
{
    return $A * $B;
}

function bagi($A, $B)
{
    return $A / $B;
}

echo "<br>";
echo "Bilangan Pertama : $a<br>";
echo "Bilangan Kedua : $b<br><br>";

echo "Hasil Penjumlahan:<br>";
printf(" %d + %d = %d", $a, $b, jumlah($a, $b));

echo "<br><br>Hasil Pengurangan:<br>";
printf(" %d - %d = %d", $a, $b, kurang($a, $b));

echo "<br><br>Hasil Perkalian:<br>";
printf(" %d * %d = %d", $a, $b, kali($a, $b));

echo "<br><br>Hasil Pembagian:<br>";
printf(" %d / %d = %d", $a, $b, bagi($a, $b));
?>

</body>
</html>