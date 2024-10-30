<?php
include "../component/connection.php";
include "../function.php";
$id = "";
$bahan_baku = "";
$satuan = "";
$kategori = "";
$deskripsi = "";

if (isset($_GET['edit_kategori'])) {
    $id = $_GET['edit_kategori'];
    $data = getAllDatabyid($connect, "tb_bahan_baku", "id", $id);
    // $kategori =  $data['kategori'];
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
        <header>Input Data kategori</header>
        <form action="../logic/<?= isset($_GET['edit_bahan_baku']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

            <div class="input-box" hidden>
                <label>Id bahan baku</label>
                <input name="id_bahan_baku" type="number" placeholder="Masukan id supplier" value="<?= $id ?>" />
            </div>

            <div class="input-box">
                <label>bahan_baku</label>
                <input name="bahan_baku" type="text" placeholder="Masukan kategori" value="<?= $bahan_baku ?>" required />
            </div>
            <div class="input-box">
                <label>satuan</label>
                <input name="satuan" type="text" placeholder="Masukan kategori" value="<?= $satuan ?>" required />
            </div>
            <div class="input-box">
                <label>kategori</label>
                <input name="kategori" type="text" placeholder="Masukan kategori" value="<?= $kategori ?>" required />
            </div>
            <div class="input-box">
                <label>deskripsi</label>
                <input name="deskripsi" type="text" placeholder="Masukan kategori" value="<?= $deskripsi ?>" required />
            </div>

            <button type="submit" name="submit" value="<?= isset($_GET['edit_bahan_baku']) ? 'edit_bahan_baku' : 'simpan_bahan_baku' ?>">Submit</button>
        </form>
    </section>
</body>

</html>