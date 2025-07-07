<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendaftaran Siswa Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h3>Formulir Pendaftaran Siswa Baru</h3>
        </header>
        <form action="proses-pendaftaran.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group"><label for="nama">Nama: </label><input type="text" name="nama" placeholder="Nama lengkap" required /></div>
                <div class="form-group"><label for="alamat">Alamat: </label><textarea name="alamat" required></textarea></div>
                <div class="form-group radio-group">
                    <label>Jenis Kelamin: </label>
                    <label><input type="radio" name="jenis_kelamin" value="laki-laki" required> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan</label>
                </div>
                <div class="form-group">
                    <label for="agama">Agama: </label>
                    <select name="agama" required><option value="">Pilih Agama</option><option>Islam</option><option>Kristen</option><option>Katolik</option><option>Hindu</option><option>Budha</option></select>
                </div>
                <div class="form-group"><label for="asal_sekolah">Sekolah Asal: </label><input type="text" name="asal_sekolah" placeholder="Nama sekolah" required /></div>
                <div class="form-group"><label for="foto">Foto: </label><input type="file" name="foto" required /></div>
                <div class="form-actions">
                    <input type="submit" value="Daftar" name="daftar" class="btn btn-primary" />
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>