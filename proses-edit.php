<?php
include("config.php");

if(isset($_POST['simpan'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['asal_sekolah'];
    $foto_lama = $_POST['foto_lama'];
    
    // Cek apakah user memilih file foto baru atau tidak
    if($_FILES['foto']['name'] != ""){
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $fotobaru = date('dmYHis').$foto;
        $path = "foto_siswa/".$fotobaru;

        // Proses upload foto baru
        if(move_uploaded_file($tmp, $path)){
            // Hapus foto lama
            if(file_exists("foto_siswa/".$foto_lama)) unlink("foto_siswa/".$foto_lama);

            // Proses update ke database
            $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', asal_sekolah='$sekolah', foto='$fotobaru' WHERE id=$id";
            $query = mysqli_query($db, $sql);
            if($query) { header('Location: list-siswa.php?status=sukses'); } else { die("Gagal menyimpan perubahan..."); }
        }
    } else {
        // Jika user tidak memilih file foto baru
        $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', asal_sekolah='$sekolah' WHERE id=$id";
        $query = mysqli_query($db, $sql);
        if($query) { header('Location: list-siswa.php?status=sukses'); } else { die("Gagal menyimpan perubahan..."); }
    }
} else {
    die("Akses dilarang...");
}
?>