<?php
include "../component/connection.php";
include "../function.php";
$id ="";
$name =  "";
$alamat = "";
$np =  "";
$jk = "";
$jk = "";
$tanggal_lahir =  "";

if(isset($_GET['edit_karyawan'])){
    $id = $_GET['edit_karyawan'];
    $data = getAllDatabyid($connect,"tb_karyawan","id_karyawan",$id);
    $name =  $data['Nama'];
    $alamat =  $data['alamat'];
    $np =  $data['np'];
    $jk =  $data['jenis_kelamin'];
    $tanggal_lahir =  $data['tanggal_lahir'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="input.css" />
  </head>
  <body>
    <section class="container">
      <header>Input Data Karyawan</header>
      <form action="../logic/<?= isset($_GET['edit_karyawan']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

        <div class="input-box" hidden>
            <label>Id Karyawan</label>
            <input name="id_karyawan" type="number" placeholder="Masukan id Karyawan" value="<?= $id ?>" />
        </div>
        <div class="input-box">
          <label>Nama</label>
          <input name="nama_karyawan" type="text" placeholder="Masukan nama lengkap" value="<?= $name ?>"  required />
        </div>

        <div class="column">
          <div class="input-box">
            <label>No telepon</label>
            <input name="np" type="number" placeholder="Masukkan nomor telepon" value="<?= $np ?>" required />
          </div>

          <div class="input-box">
            <label>Tanggal lahir</label>
            <input name="tanggal_lahir" type="date" placeholder="Masukkan tanggal lahir" value="<?= $tanggal_lahir ?>" required />
          </div>
        </div>

        <div class="gender-box">
          <h3>Jenis Kelamin</h3>
          <div class="gender-option">
            <div class="gender">
              <input type="radio" id="check-male" name="gender" value="Laki-Laki" <?= $jk == "Laki-Laki" ? 'checked' : "" ?> />
              <label for="check-male">Laki Laki</label>
            </div>
            <div class="gender">
              <input type="radio" id="check-female" name="gender" value="Perempuan" <?= $jk != "Laki-Laki" ? 'checked' : "" ?>  />
              <label for="check-female">Perempuan</label>
            </div>
          
          </div>
        </div>
        <div class="input-box address">
          <label>Alamat</label>
          <input name="alamat" type="text" placeholder="Masukkan alamat karyawan" value="<?= $alamat ?>" required />
        </div>
        <button type="submit" name="submit" value="<?= isset($_GET['edit_karyawan']) ? 'edit_karyawan' : 'simpan_karyawan' ?>">Submit</button>
      </form>
    </section>
  </body>
</html>