<?php
include 'component/connection.php';
include 'function.php';
session_start();
$dataRekap = getAllData($connect, "tb_rekap_penjualan");
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
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
            <table id="tableformat" class="table table-striped table-bordered table-hover w-full ">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Terjual</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">Toko</th>
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
                            <td><?= $tampil['harga'] * $tampil['terjual']; ?></td>
                            <td><?= $tampil['tanggal']; ?></td>
                            <td><?= $tampil['costumer']; ?></td>
                            <td><?= $tampil['toko']; ?></td>


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
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#tableformat').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdf',
                        orientation: 'portrait', // Menggunakan 'portrait' bukan 'potrait'
                        pageSize: 'legal',
                        download: 'open',
                        title: 'data penjualan',
                        customize: function(doc) {
                            doc.content[1].margin = [100, 0, 100, 0] //left, top, right, bottom
                        }

                    },
                    'copy', 'csv', 'excel'
                ],
                columnDefs: [{
                    className: "dt-center",
                    targets: "_all"
                }]
            });
        });
    </script>

</body>


<!-- table format -->

</html>