<?php
include "../component/connection.php";
include "../function.php";
$id ="";
$name = "";
$np = "";
$alamat = "";

if(isset($_GET['edit_supplier'])){
    $id = $_GET['edit_supplier'];
    $data = getAllDatabyid($connect,"tb_supplier","id_supplier",$id);
    $name =  $data['Nama'];
    $alamat =  $data['alamat'];
    $np =  $data['np'];
    
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
      <header>Input Data Supplier</header>
      <form action="../logic/<?= isset($_GET['edit_supplier']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

        <div class="input-box" hidden>
            <label>Id Supplier</label>
            <input name="id_supplier" type="number" placeholder="Masukan id supplier" value="<?= $id ?>"/>
        </div>

        <div class="input-box">
          <label>Nama</label>
          <input name="name_supplier" type="text" placeholder="Masukan nama lengkap" value="<?= $name ?>" required />
        </div>

        <div class="column">
          <div class="input-box">
            <label>No telepon</label>
            <input name="np" type="number" placeholder="Masukkan nomor telepon" value="<?= $np ?>" required />
          </div> 
        </div>
        <div class="input-box address">
          <label>Alamat</label>
          <input name="alamat" type="text" placeholder="Masukkan alamat anda" value="<?= $alamat ?>" required />
        </div>
       <button type="submit" name="submit" value="<?= isset($_GET['edit_supplier']) ? 'edit_supplier' : 'simpan_supplier' ?>" >Submit</button>
      </form>
    </section>
  </body>
</html>