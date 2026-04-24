<!DOCTYPE html>
<html>
<head>
    <title>Latihan 3</title>
</head>
<body>
    <h2>Form Perhitungan</h2>
    <form method="POST" action="">
        Input 1: <input type="number" name="input1"><br>
        Input 2: <input type="number" name="input2"><br>
        <input type="submit" name="submit" value="Hitung">
    </form>

    <?php
    if(isset($_POST['submit'])) {
        $a = $_POST['input1'];
        $b = $_POST['input2'];
        
        echo "<h3>Hasil:</h3>";
        echo "Penjumlahan: " . ($a + $b) . "<br>";
        echo "Pengurangan: " . ($a - $b) . "<br>";
        echo "Perkalian: " . ($a * $b) . "<br>";
        echo "Pembagian: " . ($a / $b) . "<br>";
    }
    ?>
</body>
</html>