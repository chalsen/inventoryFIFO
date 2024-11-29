<?php
include 'component/connection.php';
include 'function.php';
session_start();
$dataProduk = getproductData($connect);
$title = "produk";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="datatables/datatables.css">
    <script src="datatables/datatables.js"></script>
    <title><?= $title ?></title>
</head>

<body>
    <?php include 'component/sidebar.php'; ?>

    <div class="main--content">
        <?php include 'component/header.php'; ?>

        <div class="card--container">
            <!-- table start -->
            <a href="input_component/input_produk.php" class="button mb-3 btn"><i class="fas fa-plus-square me-2"></i>Tambah Data</a>
            <a href="input_component/input_restock_produk.php" class="button mb-3 btn"><i class="fas fa-plus-square me-2"></i>Restock Produk</a>
            <table id="tableformat" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col">Stock Barang</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Baku</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($dataProduk as $tampil) :
                        $data_bakus = json_decode($tampil['baku'], true);
                    ?>
                        <tr>
                            <td><?= $tampil['nama_produk']; ?></td>
                            <td><?= $tampil['total_stock']; ?></td>
                            <td><?= $tampil['kategori']; ?></td>
                            <td>Rp.<?= $tampil['harga']; ?></td>
                            <td>
                                <ul>

                                    <?php
                                    if (isset($data_bakus)) {

                                        foreach ($data_bakus as $key => $value) {
                                            $name_baku = getNameBaku($connect, $value['id']);
                                            echo "<li>" . $name_baku['name'] . "=" . $value['value'] . "</li>";
                                        }
                                    }
                                    ?>
                                </ul>
                            </td>
                            <td>
                                <!-- <a href="#" onclick="showConfirmationEdit('<?= $tampil['id_produk'] ?>')" class="edit"><i class="fa fa-pen" aria-hidden="true"></i></a> -->
                                <a href="#" onclick="showConfirmationDelete('<?= $tampil['id_produk'] ?>')" class="delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- table end -->
        </div>

        <!-- pop up box -->
        <div class="pop-up-container" id="popbox">
            <button class="x_btn" onclick="close_pop()" type="button">
                <span class="x"></span>
                <span class="x"></span>
            </button>
            <div class="pop-content">
                <h4>peringatan!!</h4>
                <p>jika anda ingin menghapus atau mengedit data yang ada disini,maka data pada stock-in akan berubah anda yakin melanjutkan?</p>
                <a href="input_component/input_penjualan.php" class=" button mb-3 btn ">lanjutkan</a>

            </div>
        </div>

    </div>
    <?php if (isset($_GET['fail'])): ?>
        <script>
            alert("data stok kurang dari kebutuhan stok komposisi produk");
        </script>
    <?php endif; ?>
    <script src="script.js"></script>

    <!-- table format -->
    <script>
        $(document).ready(function() {
            $('#tableformat').DataTable({
                "columnDefs": [{
                    "className": "dt-center",
                    "targets": "_all"
                }]
            });
        })
    </script>
</body>

</html>