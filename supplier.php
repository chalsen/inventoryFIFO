<?php
include 'component/connection.php';
include 'function.php';
session_start();
$dataSupplier = getAllData($connect, "tb_supplier");
$title = "Supplier";
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
            <a href="input_component/input_supplier.php" class="button mb-3 btn"><i class="fas fa-plus-square me-2"></i>Tambah Data</a>
            <table id="tableformat" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No Telp</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataSupplier as $tampil) : ?>
                        <tr>
                            <td><?= $tampil['Nama']; ?></td>
                            <td><?= $tampil['alamat']; ?></td>
                            <td><?= $tampil['np']; ?></td>
                            <td>
                                <a href="input_component/input_supplier.php?edit_supplier=<?= $tampil['id_supplier']?>" class="me-2 edit link-light">
                                    <i class="fa fa-pen" aria-hidden="true"></i>
                                </a>
                                <a onclick="showConfirmationDelete(<?= $tampil['id_supplier']?>)">
                                    <i class="fa fa-trash"></i>
                                </a>
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
            <p>jika anda ingin menghapus maka perubahan akan terjadi pada table stock masuk!!</p>
            <a class=" button mb-3 btn ">lanjutkan</a>
        </div>
    </div>

    </div>

    <script src="script.js"></script>
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
