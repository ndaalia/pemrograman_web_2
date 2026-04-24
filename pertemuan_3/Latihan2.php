<html>
<head>
<title>Contoh Penggunaan IF</title>
</head>
<body>
<h2>Form Diskon Belanja</h2>
<form method="GET" action="">
  <table>
    <tr>
      <td>Besar Pembelian :</td>
      <td><input type="number" name="total_beli" required></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Tentukan Diskon"></td>
    </tr>
  </table>
</form>

<?php
if (isset($_GET['total_beli']) && $_GET['total_beli'] != "") 
{
    $total_beli = intval($_GET['total_beli']);
    $diskon = 0;
    
    echo "<hr>";
    echo "<h3>Hasil Perhitungan:</h3>";
    echo "Total Pembelian: Rp " . number_format($total_beli, 0, ',', '.') . "<br>";
    
    if($total_beli >= 200000) {
        $diskon = 0.1;
        echo "Diskon: 10%<br>";
    }
    else if ($total_beli >= 100000) {
        $diskon = 0.05;
        echo "Diskon: 5%<br>";
    }
    else {
        $diskon = 0.01;
        echo "Diskon: 1%<br>";
    }
    
    $nilai_diskon = $diskon * $total_beli;
    $total_bayar = $total_beli - $nilai_diskon;
    
    echo "Nilai Diskon: Rp " . number_format($nilai_diskon, 0, ',', '.') . "<br>";
    echo "<b>Total Bayar: Rp " . number_format($total_bayar, 0, ',', '.') . "</b><br>";
}
?>
</body>
</html>