<?php include("config.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Siswa Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h3>Siswa yang sudah mendaftar</h3>
        </header>
        <nav>
            <a href="form-daftar.php" class="btn btn-add">[+] Tambah Baru</a>
            <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
            <a href="cetak.php" target="_blank" class="btn btn-primary">Cetak Laporan PDF</a>
        </nav>

        <?php if(isset($_GET['status'])): ?>
            <p class="status-message <?php echo $_GET['status']; ?>">
                <?php echo $_GET['status'] == 'sukses' ? "Proses berhasil!" : "Proses gagal!"; ?>
            </p>
        <?php endif; ?>

        <div class="table-wrapper">
            <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Sekolah Asal</th>
                    <th>Tanggal Daftar</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM calon_siswa";
                $query = mysqli_query($db, $sql);
                $no = 1;
                while($siswa = mysqli_fetch_array($query)){
                    echo "<tr>";
                    // ✨ URUTAN DATA TABEL DISESUAIKAN ✨
                    echo "<td>".$no++."</td>";
                    echo "<td><img src='foto_siswa/".$siswa['foto']."' class='student-photo'></td>";
                    echo "<td>".$siswa['nama']."</td>";
                    echo "<td>".$siswa['alamat']."</td>";
                    echo "<td>".$siswa['jenis_kelamin']."</td>";
                    echo "<td>".$siswa['asal_sekolah']."</td>";
                    echo "<td class='timestamp'>".date('d-m-Y H:i', strtotime($siswa['tanggal_daftar']))."</td>";
                    echo "<td>";
                    echo "<a href='form-edit.php?id=".$siswa['id']."' class='btn btn-edit'>Edit</a>";
                    echo "<a href='hapus.php?id=".$siswa['id']."' class='btn btn-delete' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
            </table>
        </div>
        <p style="text-align:center; margin-top:20px; font-weight:bold;">Total Pendaftar: <?php echo mysqli_num_rows($query) ?></p>
    </div>
</body>
</html>