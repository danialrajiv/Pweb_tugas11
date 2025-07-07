# **Lanjutan Tugas 10: CRUD dengan Laporan PDF**

### 📌 Deskripsi Tugas
Ini adalah **pembaruan (update)** dari Tugas 10 sebelumnya. Aplikasi pendaftaran siswa yang sudah memiliki fitur CRUD dan upload foto kini disempurnakan dengan menambahkan fungsionalitas untuk **membuat laporan dalam format PDF**.

Fitur ini memungkinkan pengguna untuk mencetak seluruh data siswa yang tersimpan di database ke dalam sebuah dokumen PDF yang terstruktur rapi, langsung dari halaman web.

---

### ✅ Fitur Aplikasi
- **Create, Read, Update, Delete (CRUD)**: Fungsionalitas penuh untuk mengelola data siswa.
- **Upload Foto**: Menyimpan dan menampilkan foto untuk setiap siswa.
- **Penyimpanan Permanen**: Menggunakan database MySQL.
- **Desain Menarik**: Antarmuka modern yang konsisten di semua halaman.
- **✨ Fitur Baru: Laporan PDF**: Tombol untuk membuat dan menampilkan laporan data seluruh siswa dalam format PDF.

---

### ⚙️ Cara Kerja Fitur Laporan PDF
Fitur baru ini bekerja dengan alur sebagai berikut:

1.  **🖱️ Aksi Pengguna**: Pengguna menekan tombol **"Cetak Laporan PDF"** yang ada di halaman `list-siswa.php`.

2.  **➡️ Pengalihan**: Browser akan membuka tab baru dan mengakses file `cetak.php`.

3.  **📚 Inisialisasi**: Skrip `cetak.php` pertama-tama memuat library **FPDF** dan melakukan koneksi ke database MySQL untuk persiapan mengambil data.

4.  **📄 Pembuatan Dokumen**: Skrip membuat sebuah objek dokumen PDF virtual (ukuran A4, orientasi Potrait). Judul laporan seperti "LAPORAN DATA SISWA" dan header tabel (No, Nama, Alamat, dll.) ditulis ke dalam dokumen ini.

5.  **⚙️ Pengambilan Data**: Skrip menjalankan query `SELECT * FROM calon_siswa` untuk mengambil semua data siswa dari database.

6.  **✍️ Pencetakan Data**: Data yang didapat dari database kemudian di-looping. Untuk setiap baris data siswa, skrip akan membuat satu baris baru di dalam tabel pada dokumen PDF dan mengisinya dengan informasi yang sesuai (nama, alamat, dll).

7.  **📤 Output**: Setelah semua data selesai ditulis ke dalam dokumen virtual, fungsi `Output()` dari FPDF akan mengirimkan dokumen PDF yang sudah jadi ke browser untuk ditampilkan kepada pengguna.

---

### 📂 Struktur Proyek
```
/pendaftaran-db/
├── fpdf/                  <-- Folder library FPDF
├── foto_siswa/
├── cetak.php              <-- File baru untuk generate PDF
├── config.php
├── index.php
├── form-daftar.php
├── proses-pendaftaran.php
├── list-siswa.php         (Ada tombol cetak baru)
├── form-edit.php
├── proses-edit.php
├── hapus.php
└── style.css
```

### 🖼️ Tampilan Web (Screenshot)

*(Di bagian ini, unggah screenshot aplikasi Anda, lalu ganti placeholder di bawah)*

**Halaman Daftar Siswa dengan Tombol Cetak**
![Daftar Siswa](https://github.com/danialrajiv/Pweb_tugas11/blob/main/list_siswa.png)

**Contoh Hasil Laporan PDF**
![Laporan PDF](https://github.com/danialrajiv/Pweb_tugas11/blob/main/laporan_pdf.png)

---

### 👨‍💻 Kode Sumber (Source Code)

<details>
<summary><b>list-siswa.php (Update)</b></summary>

```php
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
                    echo "<td>".$no++."</td>";
                    echo "<td><img src='uploads/".$siswa['foto']."' class='student-photo'></td>";
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
```

</details>


<details>
<summary><b>cetak.php (File Baru)</b></summary>

```php
<?php
// Memanggil library FPDF
require('fpdf/fpdf.php');
// Memanggil koneksi ke database
include('config.php');

// Membuat instance object dari class FPDF untuk membuat halaman baru
$pdf = new FPDF('P', 'mm', 'A4'); // P = Potrait, L = Landscape
$pdf->AddPage();

// Mengatur jenis font, style, dan ukuran
$pdf->SetFont('Arial', 'B', 16);
// Mencetak string judul
$pdf->Cell(190, 7, 'LAPORAN DATA SISWA BARU', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 7, 'SMK CODING', 0, 1, 'C');

// Memberikan spasi ke bawah agar tidak terlalu rapat
$pdf->Cell(10, 7, '', 0, 1);

// Mengatur font untuk header tabel
$pdf->SetFont('Arial', 'B', 10);
// Mencetak header tabel
$pdf->Cell(10, 6, 'NO', 1, 0, 'C');
$pdf->Cell(40, 6, 'NAMA', 1, 0, 'C');
$pdf->Cell(60, 6, 'ALAMAT', 1, 0, 'C');
$pdf->Cell(35, 6, 'JENIS KELAMIN', 1, 0, 'C');
$pdf->Cell(40, 6, 'ASAL SEKOLAH', 1, 1, 'C'); // Angka 1 terakhir berarti pindah baris

// Mengatur font untuk isi tabel
$pdf->SetFont('Arial', '', 10);

// Query untuk mengambil data dari database
$query = mysqli_query($db, "SELECT * FROM calon_siswa");
$no = 1;
while ($row = mysqli_fetch_array($query)) {
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(40, 6, $row['nama'], 1, 0);
    $pdf->Cell(60, 6, $row['alamat'], 1, 0);
    $pdf->Cell(35, 6, $row['jenis_kelamin'], 1, 0);
    $pdf->Cell(40, 6, $row['asal_sekolah'], 1, 1);
}

// Mengirimkan output file PDF ke browser
$pdf->Output();
?>
```
</details>
