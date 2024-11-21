<?php
include 'component/connection.php';
include 'function.php';
session_start();
$dataRekap = getAllData($connect, "tb_laporan_baku");
$title = "Laporan Bahan Baku";


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

                    <button class="btn btn-primary mb-0 mr-3" type="submit" name="cetak_laporan_baku">
                        Cetak Laporan <i class="fa fa-print"></i>
                    </button>

                    <div class="d-flex">
                        <!-- Start Date -->
                        <div class="p-2">
                            <label for="tanggal-mulai" class="form-label m-0">Status</label>
                            <select name="status" id="filter-status" class="form-control">
                                <option value="" id="default-status">Semua</option>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>

                        </div>
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
                        <th scope="col">Bahan Baku</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- loop start -->
                    <?php foreach ($dataRekap as $tampil): ?>
                        <tr class="table-row" data-status="<?= $tampil['status']; ?>" data-tanggal="<?= $tampil['created_at']; ?>">
                            <td><?= $tampil['nama']; ?></td>
                            <td><?= $tampil['jumlah']; ?></td>
                            <td><?= $tampil['status']; ?></td>
                            <td><?= $tampil['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
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
            resetFilters();

            function resetFilters() {
                $('#filter-status').val(''); // Mengatur dropdown ke nilai kosong untuk "Semua"

                // Reset tanggal mulai dan tanggal berakhir
                $('#tanggal-mulai').val(''); // Mengatur tanggal mulai ke kosong
                $('#tanggal-berakhir').val('');

                filterTable();
            }

            function filterTable() {
                var selectedStatus = $('#filter-status').val(); // Ambil status yang dipilih
                var startDate = $('#tanggal-mulai').val(); // Ambil tanggal mulai
                var endDate = $('#tanggal-berakhir').val(); // Ambil tanggal berakhir

                // Jika endDate tidak diisi, set ke tanggal yang sangat jauh di masa depan
                if (!endDate) {
                    endDate = '9999-12-31'; // Tanggal jauh di masa depan
                }

                // Loop semua baris tabel
                $('#tableformat tbody tr').each(function() {
                    var rowStatus = $(this).data('status'); // Ambil status dari data attribute
                    var rowDate = $(this).data('tanggal'); // Ambil tanggal dari data atribut

                    // Cek jika status dan tanggal dalam rentang yang dipilih
                    var statusMatch = (selectedStatus === "" || rowStatus === selectedStatus);
                    var dateMatch = (rowDate >= startDate && rowDate <= endDate) || !startDate;

                    // Jika kedua kondisi terpenuhi, tampilkan baris, jika tidak sembunyikan
                    if (statusMatch && dateMatch) {
                        $(this).show(); // Tampilkan baris jika status dan tanggal cocok
                    } else {
                        $(this).hide(); // Sembunyikan baris jika status atau tanggal tidak cocok
                    }
                });
            }

            // Ketika filter status berubah
            $('#filter-status').change(function() {
                filterTable(); // Jalankan fungsi filterTable saat status berubah
            });

            // Ketika filter tanggal mulai atau tanggal berakhir berubah
            $('#tanggal-mulai, #tanggal-berakhir').on('change', function() {
                filterTable(); // Jalankan fungsi filterTable saat tanggal berubah
            });

        });
    </script>


</body>


<!-- table format -->

</html>