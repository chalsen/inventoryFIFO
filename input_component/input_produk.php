<?php
include "../component/connection.php";
include "../function.php";

$data_kategori = getAllKategori($connect);

$id ="";
$name = "";
$jumlah = "";
$harga = "";
$id_kategori = "";

if(isset($_GET['edit_produk'])){
    $id = $_GET['edit_produk'];
    $data = getAllDatabyid($connect,"tb_produk","id_produk",$id);
    $name =  $data['nama_produk'];
    $jumlah =  $data['jumlah'];
    $harga =  $data['harga'];
    $id_kategori = $data['id_kategori'];
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
        <header>Input Data Produk</header>
        <form action="../logic/<?= isset($_GET['edit_produk']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">
            <div class="input-box" hidden>
                <label>Id produk</label>
                <input name="id_produk" type="number" placeholder="Masukan id produk" value="<?= $id ?>" />
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Nama produk</label>
                    <input name="nama_produk" type="text" placeholder="Masukkan nama produk" value="<?= $name ?>" required />
                </div>

                <?php  if(isset($_GET['edit_produk'])): ?>
                <div class="input-box">
                    <label>Jumlah produk</label>
                    <input name="jumlah_produk" type="number" placeholder="Masukkan jumlah produk" value="<?= $jumlah ?>" required />
                </div>
                <?php endif; ?>
                
                <div class="input-box">
                    <label>Kategori Produk</label>
                    <select name="kategori">
                        <?php foreach ($data_kategori as $tampil) : ?>
                         <option value="<?php echo $tampil['id_kategori']; ?>" <?php echo ($tampil['id_kategori'] == $id_kategori) ? 'selected' : ''; ?>><?php echo $tampil['kategori']; ?></option>
                        <?php endforeach ?>
                     </select>
                </div>

                <div class="input-box">
                    <label>Harga produk</label>
                    <input name="harga_produk" type="number" placeholder="Masukkan harga produk" value="<?= $harga ?>"  required />
                </div>

                <button type="submit" name="submit" value="<?= isset($_GET['edit_produk']) ? 'edit_produk' : 'simpan_produk' ?>" >Submit</button>
        </form>
    </section>
</body>

</html>