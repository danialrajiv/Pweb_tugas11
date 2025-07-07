<?php
include("config.php");
if(!isset($_GET['id'])){ header('Location: list-siswa.php'); }

$id = $_GET['id'];
$sql = "SELECT * FROM calon_siswa WHERE id=$id";
$query = mysqli_query($db, $sql);
$siswa = mysqli_fetch_assoc($query);

if(mysqli_num_rows($query) < 1 ){ die("Data tidak ditemukan..."); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulir Edit Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header><h3>Formulir Edit Siswa</h3></header>
        <form action="proses-edit.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <input type="hidden" name="id" value="<?php echo $siswa['id'] ?>" />
                <input type="hidden" name="foto_lama" value="<?php echo $siswa['foto'] ?>" />
                <div class="form-group"><label for="nama">Nama: </label><input type="text" name="nama" placeholder="Nama lengkap" value="<?php echo $siswa['nama'] ?>" /></div>
                <div class="form-group"><label for="alamat">Alamat: </label><textarea name="alamat"><?php echo $siswa['alamat'] ?></textarea></div>
                <div class="form-group radio-group">
                    <label>Jenis Kelamin: </label>
                    <label><input type="radio" name="jenis_kelamin" value="laki-laki" <?php echo ($siswa['jenis_kelamin'] == 'laki-laki') ? "checked": "" ?>> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="perempuan" <?php echo ($siswa['jenis_kelamin'] == 'perempuan') ? "checked": "" ?>> Perempuan</label>
                </div>
                <div class="form-group">
                    <label for="agama">Agama: </label>
                    <select name="agama"><?php $agama = $siswa['agama']; ?>
                        <option <?php echo ($agama == 'Islam') ? "selected": "" ?>>Islam</option>
                        <option <?php echo ($agama == 'Kristen') ? "selected": "" ?>>Kristen</option>
                        <option <?php echo ($agama == 'Katolik') ? "selected": "" ?>>Katolik</option>
                        <option <?php echo ($agama == 'Hindu') ? "selected": "" ?>>Hindu</option>
                        <option <?php echo ($agama == 'Budha') ? "selected": "" ?>>Budha</option>
                    </select>
                </div>
                <div class="form-group"><label for="asal_sekolah">Sekolah Asal: </label><input type="text" name="asal_sekolah" placeholder="Nama sekolah" value="<?php echo $siswa['asal_sekolah'] ?>" /></div>
                <div class="form-group">
                    <label for="foto">Foto: </label>
                    <img src="uploads/<?php echo $siswa['foto'] ?>" width="150" style="display:block; margin-bottom:10px;">
                    <input type="file" name="foto" />
                    <small style="color:red">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>
                <div class="form-actions"><input type="submit" value="Simpan" name="simpan" class="btn btn-primary"/></div>
            </fieldset>
        </form>
    </div>
</body>
</html>