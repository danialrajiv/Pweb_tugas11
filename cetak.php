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
$pdf->Cell(190, 7, 'SMANSA', 0, 1, 'C');

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