<?php
include "../component/connection.php";
include "../function.php";
session_start();
$data_supplier = getAllSupplier($connect);
$data_produk = getAllProduct($connect);

$id ="";
$id_produk =  "";
$id_supplier = "";
$jumlah = "";
$jumlah_lama = 0;
$tanggal =  "";

if(isset($_GET['edit_penjualan'])){
    $id = $_GET['edit_penjualan'];
    $data = getAllDatabyid($connect,"tb_penjualan_harian","id_penjualan",$id);
    $id_produk =  $data['id_produk'];
    $jumlah =  $data['penjualan'];
    $jumlah_lama =  $data['penjualan'];
    $tanggal =  $data['tanggal'];
}

if (isset($_SESSION['error_message'])) {
  echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
  unset($_SESSION['error_message']); // Hapus pesan dari sesi setelah ditampilkan
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="input.css" />
  </head>
  <body>
    <section class="container">
      <header>Input data penjualan</header>
      <form action="../logic/<?= isset($_GET['edit_penjualan']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

        <div class="input-box" hidden>
            <label>Id Karyawan</label>
            <input name="id_penjualan" type="number" placeholder="Masukan id Karyawan" value="<?= $id ?>" />
            <input name="jumlah_lama" type="number" placeholder="Masukan id Karyawan" value="<?= $jumlah_lama ?>" />
        </div>


        <div class="input-box">
          <label>produk</label>
          <div class="search_select_box">
            <select  name="produk" class="w-100" data-live-search="true">
                 <?php foreach ($data_produk as $tampil) : ?>
                    <option value="<?php echo $tampil['id_produk']; ?>" <?php echo ($tampil['id_produk'] == $id_produk) ? 'selected' : ''; ?>><?php echo $tampil['nama_produk']; ?></option>
                  <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="column">
          <div class="input-box">
                <label>Terjual</label>
                <input name="terjual" type="number" placeholder="Masukkan jumlah produk" value="<?= $jumlah ?>" required  min="0"/>
            </div>

          <div class="input-box">
            <label>Tanggal</label>
            <input name="tanggal" type="date" placeholder="Masukkan tanggal lahir" value="<?= $tanggal ?>" required />
          </div>
       
        <button type="submit" name="submit" value="<?= isset($_GET['edit_penjualan']) ? 'edit_penjualan' : 'simpan_penjualan' ?>">Submit</button>
      </form>
    </section>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" ></script>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('.search_select_box select').selectpicker();
        })
    </script>
</body>
<script>
const currentHref = window.location.href;

</script>
</html>