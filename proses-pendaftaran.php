<?php
include("config.php");

if(isset($_POST['daftar'])){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['asal_sekolah'];
    
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    
    // Rename nama fotonya dengan menambahkan tanggal dan jam
    $fotobaru = date('dmYHis').$foto;
    
    // Set path folder tempat menyimpan fotonya
    $path = "foto_siswa/".$fotobaru;

    // Proses upload
    if(move_uploaded_file($tmp, $path)){
        $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, asal_sekolah, foto) VALUES ('$nama', '$alamat', '$jk', '$agama', '$sekolah', '$fotobaru')";
        $query = mysqli_query($db, $sql);

        if( $query ) {
            header('Location: list-siswa.php?status=sukses');
        } else {
            header('Location: list-siswa.php?status=gagal');
        }
    } else {
        echo "Maaf, Gambar gagal untuk diupload.";
        echo "<br><a href='form-daftar.php'>Kembali Ke Form</a>";
    }
} else {
    die("Akses dilarang...");
}
?>