<?php
// ==========================================
// 1. KONFIGURASI KONEKSI DATABASE LANGSUNG
// ==========================================
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_paspor";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Validasi jika koneksi gagal
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// ==========================================
// 2. LOGIKA PROSES SISTEM (POST METHOD)
// ==========================================

// Logika 1: Input Pendaftaran (Menu Daftar)
if (isset($_POST['btn_daftar'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pemohon']);
    $tgl_daftar = mysqli_real_escape_string($koneksi, $_POST['tanggal_daftar']);
    
    // Auto-generate No. Daftar
    $query_count = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pendaftaran");
    $data_count = mysqli_fetch_assoc($query_count);
    $no_daftar = "REG-" . str_pad(($data_count['total'] + 1), 4, "0", STR_PAD_LEFT);
    
    // Logika kapasitas: 1 hari maksimal 5 orang, jika penuh geser ke hari berikutnya
    $cek_kapasitas = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM pendaftaran WHERE tanggal_daftar = '$tgl_daftar'");
    $data_kapasitas = mysqli_fetch_assoc($cek_kapasitas);
    
    $tgl_datang = $tgl_daftar;
    if ($data_kapasitas['jml'] >= 5) {
        $tgl_datang = date('Y-m-d', strtotime($tgl_daftar . ' +1 day'));
    }
    
    $jadwal_datang = $tgl_datang . " 09:00:00"; 
    
    // Simpan ke tabel pendaftaran
    mysqli_query($koneksi, "INSERT INTO pendaftaran (no_daftar, nama_pemohon, tanggal_daftar, jadwal_datang) VALUES ('$no_daftar', '$nama', '$tgl_daftar', '$jadwal_datang')");
    
    // Pemicu otomatis isi tabel pengurusan
    $id_baru = mysqli_insert_id($koneksi);
    mysqli_query($koneksi, "INSERT INTO pengurusan (id_daftar) VALUES ('$id_baru')");
    
    // REFRESH AMAN MENGGUNAKAN JAVASCRIPT
    echo "<script>window.location.href='index.php?page=daftar';</script>";
    exit();
}

// Logika 2 & 3: Proses Daftar Ulang / Pengurusan Berkas
if (isset($_POST['btn_proses_berkas'])) {
    $id_daftar = (int)$_POST['id_daftar'];
    $ktp = isset($_POST['ktp']) ? 'Ada' : 'Tidak';
    $kk = isset($_POST['kk']) ? 'Ada' : 'Tidak';
    $ijazah_akta = isset($_POST['ijazah_akta']) ? 'Ada' : 'Tidak';
    
    if ($ktp == 'Ada' && $kk == 'Ada' && $ijazah_akta == 'Ada') {
        $berkas = "Lengkap";
        $status = "Diterima";
        $keterangan = "OK";
        $pembayaran = 355000;
        
        $q_antrian = mysqli_query($koneksi, "SELECT MAX(no_antrian) as max_antri FROM pengurusan");
        $d_antrian = mysqli_fetch_assoc($q_antrian);
        $no_antrian = ($d_antrian['max_antri'] == null) ? 1 : ($d_antrian['max_antri'] + 1);
    } else {
        $berkas = "Belum Lengkap";
        $status = "Ditolak";
        $keterangan = "Tidak";
        $pembayaran = 0;
        $no_antrian = "NULL";
    }
    
    $val_antrian = ($no_antrian === "NULL") ? "NULL" : "'$no_antrian'";
    
    mysqli_query($koneksi, "UPDATE pengurusan SET ktp='$ktp', kk='$kk', ijazah_akta='$ijazah_akta', berkas='$berkas', status='$status', keterangan='$keterangan', no_antrian=$val_antrian, pembayaran=$pembayaran WHERE id_daftar=$id_daftar");
    
    // REFRESH AMAN MENGGUNAKAN JAVASCRIPT
    echo "<script>window.location.href='index.php?page=pengurusan';</script>";
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'daftar';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Pengajuan Paspor - Kantor Imigrasi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f6f9; }
        .header { background: #00b30f; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .navbar { margin-bottom: 20px; }
        .navbar a { text-decoration: none; padding: 10px 15px; background: #ddd; color: #333; border-radius: 3px; margin-right: 5px; font-weight: bold;}
        .navbar a.active { background: #00b33f; color: white; }
        .container { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"], .form-group input[type="date"] { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 3px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .total-box { margin-top: 20px; font-size: 1.2em; font-weight: bold; background: #e2e3e5; padding: 10px; display: inline-block; border-left: 5px solid #0056b3; }
    </style>
</head>
<body>

<div class="header">
    <h2>PENGAJUAN PASPOR</h2>
    <h3>Kantor Imigrasi Cabang</h3>
    <p><strong>Programmer:</strong> Nita Apriliyanti</p> 
</div>

<div class="navbar">
    <a href="index.php?page=daftar" class="<?= $page == 'daftar' ? 'active' : '' ?>">Daftar</a>
    <a href="index.php?page=daftar_ulang" class="<?= $page == 'daftar_ulang' ? 'active' : '' ?>">Daftar Ulang</a>
    <a href="index.php?page=pengurusan" class="<?= $page == 'pengurusan' ? 'active' : '' ?>">Pengurusan</a>
</div>

<div class="container">

    <!-- TAB 1: DAFTAR -->
    <?php if ($page == 'daftar'): ?>
        <h3>Input Pendaftaran</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Pemohon</label>
                <input type="text" name="nama_pemohon" required placeholder="Masukkan nama lengkap">
            </div>
            <div class="form-group">
                <label>Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" required value="<?= date('Y-m-d') ?>">
            </div>
            <button type="submit" name="btn_daftar" class="btn">Simpan</button>
        </form>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">

        <h3>Data Pendaftar</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Daftar</th>
                    <th>Nama Pemohon</th>
                    <th>Tgl Daftar</th>
                    <th>Hari, Tanggal & Jam Datang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM pendaftaran ORDER BY id_daftar DESC");
                while ($row = mysqli_fetch_assoc($query)):
                    $timestamp = strtotime($row['jadwal_datang']);
                    $hari_tanggal_jam = date('l, d-M-Y H:i', $timestamp) . " WIB";
                ?>
                <tr>
                    <td><?= $row['no_daftar'] ?></td>
                    <td><?= $row['nama_pemohon'] ?></td>
                    <td><?= date('d-M-Y', strtotime($row['tanggal_daftar'])) ?></td>
                    <td><strong><?= $hari_tanggal_jam ?></strong></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <!-- TAB 2: DAFTAR ULANG -->
    <?php elseif ($page == 'daftar_ulang'): ?>
        <h3>Validasi Input Data Daftar Ulang</h3>
        <p>Silakan periksa kelengkapan berkas fisik pemohon di bawah ini:</p>
        
        <table>
            <thead>
                <tr>
                    <th>No. Daftar</th>
                    <th>Nama Pemohon</th>
                    <th>Berkas Fisik (Centang Jika Ada)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT pendaftaran.*, pengurusan.* FROM pendaftaran INNER JOIN pengurusan ON pendaftaran.id_daftar = pengurusan.id_daftar WHERE pengurusan.keterangan = 'Tidak'");
                while ($row = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <form action="" method="POST">
                        <input type="hidden" name="id_daftar" value="<?= $row['id_daftar'] ?>">
                        <td><?= $row['no_daftar'] ?></td>
                        <td><?= $row['nama_pemohon'] ?></td>
                        <td>
                            <label><input type="checkbox" name="ktp" <?= $row['ktp'] == 'Ada' ? 'checked' : '' ?>> KTP</label> &nbsp;&nbsp;
                            <label><input type="checkbox" name="kk" <?= $row['kk'] == 'Ada' ? 'checked' : '' ?>> KK</label> &nbsp;&nbsp;
                            <label><input type="checkbox" name="ijazah_akta" <?= $row['ijazah_akta'] == 'Ada' ? 'checked' : '' ?>> Ijazah/Akta</label>
                        </td>
                        <td>
                            <button type="submit" name="btn_proses_berkas" class="btn" style="background: #007bff;">Simpan Validasi</button>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <!-- TAB 3: PENGURUSAN -->
    <?php elseif ($page == 'pengurusan'): ?>
        <h3>Data Pengurusan Paspor</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Antrian</th>
                    <th>No. Daftar</th>
                    <th>Nama Pemohon</th>
                    <th>Berkas</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_pendapatan = 0;
                $query = mysqli_query($koneksi, "SELECT pendaftaran.*, pengurusan.* FROM pendaftaran INNER JOIN pengurusan ON pendaftaran.id_daftar = pengurusan.id_daftar ORDER BY pengurusan.no_antrian ASC, pendaftaran.id_daftar DESC");
                while ($row = mysqli_fetch_assoc($query)):
                    $total_pendapatan += $row['pembayaran'];
                ?>
                <tr>
                    <td><?= $row['no_antrian'] ?? '-' ?></td>
                    <td><?= $row['no_daftar'] ?></td>
                    <td><?= $row['nama_pemohon'] ?></td>
                    <td><?= $row['berkas'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><span style="font-weight:bold; color: <?= $row['keterangan']=='OK'?'green':'red' ?>"><?= $row['keterangan'] ?></span></td>
                    <td>Rp <?= number_format($row['pembayaran'], 0, ',', '.') ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-box">
            Pendapatan Sekarang: Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>