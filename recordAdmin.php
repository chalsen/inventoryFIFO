<?php
include 'component/connection.php';
include 'function.php';
session_start();
$dataRekap = getAllData($connect,"tb_rekap_penjualan");
$title = "Rekap data penjualan";
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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">

    <title><?= $title ?></title>
</head>

<body>
<?php include 'component/sidebar.php'; ?>

<div class="main--content">
    <?php include 'component/header.php'; ?>
    
    <div class="card--container">
        <!-- table start -->
        <a href="input_component/input_record.php" class=" button mb-3 btn "  ><i class="fas fa-plus-square me-2"></i>Tambah Data</a>
        <table id="tableformat" class="table table-striped table-bordered table-hover ">
            <thead>
                <tr>
                    <th scope="col">produk</th>
                    <th scope="col">harga</th>
                    <th scope="col">terjual</th>
                    <th scope="col">Perekap</th>
                    <th scope="col">tanggal terjual</th>
                    <th scope="col" >tanggal direkap</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop start -->
                <?php  
        foreach ($dataRekap as $tampil):
            ?>
        <tr>
            <td><?= $tampil['produk']; ?></td>
            <td><?= $tampil['harga']; ?></td>
            <td><?= $tampil['terjual']; ?></td>
            <td><?= $tampil['nama_perekap']; ?></td>
            <td><?= $tampil['tanggal']; ?></td>
            <td><?= $tampil['tanggal_rekap']; ?></td>
            <td>
                <a href="input_component/input_record.php?edit_record=<?= $tampil['id_rekap']?>" type="button"><i class="fa fa-pen"></i></a>
                <!-- delete -->
                <a href="logic/delete.php?delete_record=<?= $tampil['id_rekap'] ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <!-- loop end -->
    </tbody>
</table>
<!-- table end -->
</div>

</div>

<script src="script.js"></script>



<script src="datatables/datatables.js"></script>



<script>
    $(document).ready(function() {
        $('#tableformat').DataTable({
  
            columnDefs: [
                { className: "dt-center", targets: "_all" }
            ]
        });
    });
</script>

</body>


<!-- table format -->
</html>