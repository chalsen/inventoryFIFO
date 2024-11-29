<?php
include "../component/connection.php";
include "../function.php";

$data_supplier = getAllSupplier($connect);
$data_produk = getAllProduct($connect);

$id = "";
$id_produk =  "";
$id_supplier = "";
$jumlah = "";
$tanggal =  "";
$jumlah_lama = 0;

if (isset($_GET['edit_stock_in'])) {
  $id = $_GET['edit_stock_in'];
  $data = getAllDatabyid($connect, "tb_restok", "id_restok", $id);
  $id_produk =  $data['id_produk'];
  $id_supplier =  $data['id_supplier'];
  $jumlah =  $data['jumlah_restok'];
  $tanggal =  $data['tanggal'];
  $jumlah_lama = $data['jumlah_restok'];
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
    <header>Input stok Masuk</header>
    <form action="../logic/<?= isset($_GET['edit_stock_in']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

      <div class="input-box" hidden>
        <label>Id Karyawan</label>
        <input name="id_restok" type="number" placeholder="Masukan id Karyawan" value="<?= $id ?>" />
        <label>jumlah lama</label>
        <input name="jumlah_lama" type="number" placeholder="Masukan id Karyawan" value="<?= $jumlah_lama ?>" />
      </div>


      <div class="input-box">
        <label>Bahan baku</label>

        <input name="baku" type="text" placeholder="Masukkan Nama Bahan Baku" required />

      </div>

      <div class="column">
        <div class="input-box">
          <label>Supplier</label>
          <div class="search_select_box">
            <select name="supplier" class="w-100" data-live-search="true">
              <?php foreach ($data_supplier as $tampil) : ?>
                <option value="<?php echo $tampil['Nama']; ?>" <?php echo ($tampil['id_supplier'] == $id_supplier) ? 'selected' : ''; ?>><?php echo $tampil['Nama']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="input-box">
          <label>Jumlah Restock Bahan Baku</label>
          <input name="jumlah_baku" type="number" placeholder="Masukkan Jumlah Bahan Baku" value="<?= $jumlah ?>" required min="0" />
        </div>


        <div class="input-box">
          <label>Harga</label>
          <input name="harga" type="number" placeholder="Masukkan Harga Bahan Baku" required min="0" />
        </div>

        <div class="input-box">
          <label>Tanggal</label>
          <input name="tanggal" type="date" placeholder="Masukkan tanggal lahir" value="<?= $tanggal ?>" required />
        </div>

        <button type="submit" name="submit" value="<?= isset($_GET['edit_stock_in']) ? 'edit_stock_in' : 'simpan_stock_in' ?>">Submit</button>
    </form>
  </section>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.search_select_box select').selectpicker();
    })
  </script>
</body>

</html>