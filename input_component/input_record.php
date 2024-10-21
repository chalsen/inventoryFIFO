<?php
include "../component/connection.php";
include "../function.php";

$data_supplier = getAllSupplier($connect);
$data_produk = getAllProduct($connect);

$id ="";
$produk =  "";
$harga = "";
$terjual = "";
$tanggal =  "";
$tanggal_rekap = 0;

if(isset($_GET['edit_record'])){
    $id = $_GET['edit_record'];
    $data = getAllDatabyid($connect,"tb_rekap_penjualan","id_rekap",$id);
    $produk =  $data['produk'];
    $harga =  $data['harga'];
    $terjual =  $data['terjual'];
    $tanggal =  $data['tanggal'];
    $tanggal_rekap = $data['tanggal_rekap'];
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

      <header>input Rekap</header>
      <form action="../logic/<?= isset($_GET['edit_record']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

        <div class="input-box" hidden>
            <label>Id Karyawan</label>
            <input name="id" type="number" placeholder="Masukan id Karyawan" value="<?= $id ?>" />
        </div>



          <div class="input-box">
                <label>produk</label>
                <input name="produk" type="text" placeholder="Masukkan nama" value="<?= $produk ?>" required />
            </div>

          <div class="input-box">
                <label>harga</label>
                <input name="harga" type="number" placeholder="Masukkan harga produk" value="<?= $harga ?>" required />
            </div>
          <div class="input-box">
                <label>terjual</label>
                <input name="terjual" type="number" placeholder="Masukkan jumlah terjual" value="<?= $terjual ?>" required />
            </div>
          <div class="input-box">
                <label>perekap</label>
                <input name="perekap" type="text" placeholder="Masukkan jumlah terjual"  required />
            </div>
          <div class="input-box">
                <label>tanggal</label>
                <input name="tanggal" type="date" placeholder="Masukkan jumlah produk" value="<?= $tanggal ?>" required />
            </div>

          <div class="input-box">
            <label>Tanggal rekap</label>
            <input name="tanggal_rekap" type="date" placeholder="Masukkan tanggal lahir" value="<?= $tanggal_rekap ?>" required />
          </div>
       
        <button type="submit" name="submit" value="<?= isset($_GET['edit_record']) ? 'edit_record' : 'simpan_record' ?>">Submit</button>
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
</html>