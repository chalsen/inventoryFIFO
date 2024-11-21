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



    <title><?= $title ?></title>
</head>

<body>
    <?php include 'component/sidebar.php'; ?>

    <div class="main--content">
        <?php include 'component/header.php'; ?>

        <div class="card--container">
            <!-- table start -->
            <form action="pdf/print.php" method="post">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <!-- Tombol Cetak Laporan -->

                    <button class="btn btn-primary mb-0 mr-3" type="submit" name="cetak_laporan_penjualan">
                        Cetak Laporan <i class="fa fa-print"></i>
                    </button>

                    <div class="d-flex">
                        <!-- Start Date -->
                        <div class="p-2">
                            <label for="tanggal-mulai" class="form-label m-0">Start</label>
                            <input type="date" id="tanggal-mulai" name="tanggal-mulai" class="form-control">
                        </div>

                        <!-- End Date -->
                        <div class="p-2">
                            <label for="tanggal-berakhir" class="form-label m-0">End</label>
                            <input type="date" id="tanggal-berakhir" name="tanggal-berakhir" class="form-control">
                        </div>
                    </div>
                </div>
            </form>

            <table id="tableformat" class="table table-striped table-bordered table-hover w-full">
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
                    <?php foreach ($dataRekap as $tampil): ?>
                        <tr class="table-row" data-tanggal="<?= $tampil['tanggal']; ?>">
                            <td><?= $tampil['produk']; ?></td>
                            <td><?= $tampil['harga']; ?></td>
                            <td><?= $tampil['terjual']; ?></td>
                            <td><?= $tampil['harga'] * $tampil['terjual']; ?></td>
                            <td><?= $tampil['tanggal']; ?></td>
                            <td><?= $tampil['costumer']; ?></td>
                            <td><?= $tampil['toko']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: center;"><strong>Total Penjualan:</strong></td>
                        <td id="total-penjualan"></td> <!-- Tempat untuk menampilkan total -->
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
            <!-- table end -->
        </div>

    </div>

    <script src="script.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            calculateTotal();
            $('#tanggal-mulai, #tanggal-berakhir').on('change', function() {
                // Ambil nilai tanggal mulai dan berakhir
                var startDate = $('#tanggal-mulai').val();
                var endDate = $('#tanggal-berakhir').val();

                // Jika endDate tidak diisi, set ke tanggal yang sangat jauh di masa depan
                if (!endDate) {
                    endDate = '9999-12-31'; // Tanggal jauh di masa depan
                }



                // Loop semua baris tabel
                $('#tableformat tbody tr').each(function() {
                    var rowDate = $(this).data('tanggal'); // Ambil tanggal dari data atribut

                    // Cek jika tanggal dalam rentang yang dipilih
                    if (rowDate >= startDate && rowDate <= endDate) {
                        $(this).show(); // Tampilkan baris
                    } else {
                        $(this).hide(); // Sembunyikan baris
                    }
                });

                calculateTotal();
            });



            function calculateTotal() {
                let total = 0;

                // Loop hanya baris yang terlihat
                $('#tableformat tbody tr:visible').each(function() {
                    // Ambil nilai kolom 'Total' (kolom ke-4)
                    var rowTotal = parseFloat($(this).find('td:nth-child(4)').text() || 0);

                    total += rowTotal;
                });

                // Update total di elemen
                $('#total-penjualan').text('Rp ' + total.toLocaleString('id-ID'));
            }
        });
    </script>


</body>


<!-- table format -->

</html>