<?php
include("config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Ambil nama file foto dari database
    $sql_select = "SELECT foto FROM calon_siswa WHERE id=$id";
    $query_select = mysqli_query($db, $sql_select);
    $data = mysqli_fetch_array($query_select);
    $foto_lama = $data['foto'];

    // Hapus file foto dari folder uploads
    if(file_exists("uploads/".$foto_lama)) {
        unlink("uploads/".$foto_lama);
    }

    // Buat query hapus data dari database
    $sql_delete = "DELETE FROM calon_siswa WHERE id=$id";
    $query_delete = mysqli_query($db, $sql_delete);

    if($query_delete){
        header('Location: list-siswa.php?status=sukses');
    } else {
        die("Gagal menghapus...");
    }
} else {
    die("Akses dilarang...");
}
?>