<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 50px;
        }

        .form-container {
            width: 600px;
            padding: 20px;
        }

        h2 {
            color: #f39c12; 
            font-size: 20px;
            text-align: center;
            margin-bottom: 40px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group label {
            width: 180px;
            font-size: 14px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group select {
            flex: 1;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-group input.short-input {
            flex: none;
            width: 300px;
        }

        .form-group input.vshort-input {
            flex: none;
            width: 180px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .btn {
            padding: 5px 15px;
            font-size: 14px;
            cursor: pointer;
            border: 1px solid #999;
            background: linear-gradient(to bottom, #ffffff, #e6e6e6);
            border-radius: 3px;
        }

        /* Styling tambahan untuk box hasil output PHP */
        .hasil-output {
            margin-top: 30px;
            padding: 15px;
            border: 1px dashed #f39c12;
            background-color: #fff9f0;
            width: 560px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Form Input Data Mahasiswa</h2>
    
    <form action="" method="POST">
        <div class="form-group">
            <label for="nim">ID Mahasiswa / NIM</label>
            <input type="text" id="nim" name="nim" class="short-input" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required>
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <select id="jurusan" name="jurusan" class="vshort-input" required>
                <option value="">- Pilih Jurusan -</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Sistem Komputer">Sistem Komputer</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required>
        </div>

        <div class="form-group">
            <label for="telp">No. Telp</label>
            <input type="text" id="telp" name="telp" class="vshort-input" required>
        </div>

        <div class="button-group">
            <button type="submit" name="submit" class="btn">Submit</button>
            <button type="reset" class="btn">Cancel</button>
        </div>
    </form>

    <?php
    // Logika PHP untuk menangkap dan menampilkan data yang diinput
    if (isset($_POST['submit'])) {
        // Mengambil data dari method POST
        $nim = htmlspecialchars($_POST['nim']);
        $nama = htmlspecialchars($_POST['nama']);
        $jurusan = htmlspecialchars($_POST['jurusan']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $telp = htmlspecialchars($_POST['telp']);

        // Menampilkan hasil inputan di bawah form
        echo "<div class='hasil-output'>";
        echo "<h3>Data Berhasil Dikirim:</h3>";
        echo "<b>NIM:</b> $nim <br>";
        echo "<b>Nama:</b> $nama <br>";
        echo "<b>Jurusan:</b> $jurusan <br>";
        echo "<b>Alamat:</b> $alamat <br>";
        echo "<b>No. Telp:</b> $telp <br>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>