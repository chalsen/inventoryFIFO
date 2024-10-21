<?php
include 'component/connection.php';
include 'function.php';
session_start();
$data= getDataStockIn($connect);

$title = "Stock Masuk";
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
    <?php 
    include 'component/sidebar.php';
    ?>

    
    <div class="main--content">
    
    <?php 
    include 'component/header.php';
    ?>

        <div class="card--container">
            <!-- table start -->
            <div class="d-flex justify-content-between">
            <a href="input_component/input_stock_in.php" class="button mb-3 btn"><i class="fas fa-plus-square me-2"></i>Tambah Data</a>    
            <?php if( $_SESSION['level'] ==='admin') : ?>
                <form id="deleteForm" action="logic/delete.php" method="post">
                     <input type="hidden" name="delete_all" value="1">
                     <button type="button" class="button-danger mb-3 btn" onclick="confirmDeleteAll()"><i class="fas fa-trash me-2"></i> Hapus Semua Data</button>
                </form>
            <?php endif; ?>
            </div>
                


            <table id="tableformat" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col">supplier</th>
                        <th scope="col">jumlah restok</th>
                        <th scope="col">tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $tampil) : ?>
                        <tr>
                            <td><?= $tampil['produk']; ?></td>
                            <td><?= $tampil['nama']; ?></td>
                            <td><?= $tampil['jumlah']; ?></td>
                            <td><?= $tampil['tanggal']; ?></td>
                            <td>
                                <a href="input_component/input_stock_in.php?edit_stock_in=<?= $tampil['id']?>" class="edit"><i class="fa fa-pen" aria-hidden="true"></i></a>
                                <a onclick="showConfirmationDelete(<?= $tampil['id'] ?>)" class="delete"><i class="fa fa-trash"></i></a>
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
        <p id="text_warning">apakah anda mau membersihkan semua data?</p>
        <a  class=" button mb-3 btn ">lanjutkan</a>
    </div>
</div>

    </div>
    
    <script src="script.js"></script>

<!-- table format -->
<script>
    $(document).ready(function()
    {
        $('#tableformat').DataTable({
            "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ]
        });
    })
</script>
</body>
</html>