<?php
include 'component/connection.php';
include 'function.php';
session_start();
// $dataPenjualan = getPenjualan($connect);
$data_produk = getAllProduct($connect);
$data_penjualan = getPenjualan($connect);
$title = "Transaksi";

$customer = "";
$toko = "";
$alamat = "";
$total_harga = 0;
$total_produk = 0;
$total_barang = 0;
if ($data_penjualan != null) {

    $total_produk = $data_penjualan[0]['jumlah_produk'];;
    $total_harga = $data_penjualan[0]['total'];;

    foreach ($data_penjualan as $data) {
        $total_barang += $data["jumlah"];
    }

    if ($data_penjualan[0]['costumer'] != null) {
        $customer = $data_penjualan[0]['costumer'];
        $toko = $data_penjualan[0]['toko'];
        $alamat = $data_penjualan[0]['alamat'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="datatables/datatables.css">
    <link rel="stylesheet" href="style.css">
    <title><?= $title ?></title>
</head>

<body>
    <?php include 'component/sidebar.php'; ?>

    <div class="main--content">
        <?php include 'component/header.php'; ?>

        <div class="card--container">
            <div class="row">
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-success">
                        <div class="card-header py-3">
                            <h5 class="my-0 fw-normal">Produk</h5>
                        </div>
                        <div class="card-body">
                            <form action="Logic/input_logic.php" id="tambahPenjualan" method="post">
                                <p>Cari Produk</p>
                                <div class="search_select_box">
                                    <select name="produk" onchange="onChangeProduk()" id="selection_product" class="w-100 mb-3 form-select selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Barang...</option>
                                        <?php foreach ($data_produk as $tampil) : ?>
                                            <option value="<?php echo $tampil['id_produk']; ?>" harga="<?= $tampil['harga']; ?>" stok="<?= $tampil['jumlah']; ?>"><?php echo $tampil['nama_produk']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="row mb-3 d-flex justify-content-center">
                                    <div class="row mb-3">
                                        <p class="m-0 ">Jumlah</p>
                                        <input type="number" name="jumlah" min="0" id="jumlahProduk" class="form-control w-100" placeholder="masukan jumlah barang" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <p class="m-0">Harga</p>
                                            <input type="text" class="input-group-text bg-light" id="hargaProduk" value="Rp 0" readonly>
                                        </div>
                                        <div class="col ">
                                            <p class="m-0">Stok</p>
                                            <input type="text" class="input-group-text bg-light" id="stokProduk" value="0" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="text" name="simpan" value="simpan_penjualan" hidden>
                                        <button type="button" id="submitBtn" onclick="cheking_penjualan()" class="w-100  btn btn-lg btn-success">Masukan ke Transaksi <i class="fa fa-shopping-cart"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-success">
                        <div class="card-header py-3">
                            <h5 class="my-0 fw-normal">Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row row-cols-auto mb-3 p-0">
                                <div class=" col">
                                    <p class="mb-0">Total Produk:</p>
                                    <input class="d-inline input-group-text bg-light " style="width: fit-content;" value="<?= $total_produk; ?> jenis" readonly />
                                </div>
                                <div class=" col">
                                    <p class="mb-0">Total Barang:</p>
                                    <input class="d-inline input-group-text bg-light " style="width: fit-content;" value="<?= $total_barang; ?> barang" readonly />
                                </div>
                                <div class=" col">
                                    <p class="mb-0">Total Harga:</p>
                                    <input class="d-inline input-group-text bg-light " style="width: fit-content;" value="Rp. <?= $total_harga; ?>" readonly />
                                </div>
                            </div>
                            <div class="row row-cols-auto mb-3 p-0">
                                <div class=" col grupInfoPembeli">
                                    <p class="mb-0">Pembeli:</p>
                                    <input class="d-inline input-group-text bg-light " style="width: fit-content;" value="<?= $customer; ?> " id="costumer" readonly />
                                </div>
                                <div class=" col grupInfoPembeli">
                                    <p class="mb-0">Toko:</p>
                                    <input class="d-inline input-group-text bg-light " style="width: fit-content;" value="<?= $toko; ?> " id="toko" readonly />
                                </div>
                                <div class=" col grupInfoPembeli">
                                    <p class="mb-0">Alamat:</p>
                                    <input class="d-inline input-group-text bg-light " style="width: fit-content;" value="<?= $alamat; ?>" id="alamat" readonly />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <button type="button" id="btnPembeli" onclick="showFormPembeli()" class="btnModalPembeli btn btn-md btn-warning">Input Pembeli <i class="fa fa-dollar-sign"></i></button>
                                </div>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="col">
                                    <button type="button" class="btn btn-md btn-success" onclick="formBayar('show')" id="btnBayar">Bayar <i class="fa fa-dollar-sign"></i></button>
                                </div>
                                <div class="col">
                                    <form action="pdf/print.php" method="post" target="_blank">
                                        <button type="submit" value="print_tagihan" name="print_tagihan" class="btn btn-md btn-secondary" id="btnTagihan">Cetak Tagihan <i class="fa fa-print"></i></button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="card mb-4 rounded-3 ">
                <div class="card-header py-3 text-bg-primary d-flex justify-content-between">
                    <h4 class="my-0 fw-normal">Transaksi <i class="fas fa-shopping-basket"></i></h4>
                    <form id="deleteForm" action="logic/delete.php" method="post">
                        <input type="hidden" name="Reset_keranjang" value="1">
                        <button class="btn btn-danger" type="button" onclick="confirmDeleteAll()">Reset <i class="fas fa-undo ms-1"></i> </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="d-flex  align-items-center mb-3">
                        <p class="mb-0 me-2">tanggal</p>
                        <input class="form-control w-auto" type="text" value="<?php echo date("Y-m-d");  ?>" readonly>
                    </div>
                    <div>
                        <table id="tableformat" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- looping di sini -->
                                <?php foreach ($data_penjualan as $jual): ?>
                                    <tr>
                                        <td><?= $jual['produk']; ?></td>
                                        <td>Rp. <?= $jual['harga']; ?></td>
                                        <td><?= $jual['jumlah']; ?></td>
                                        <td>Rp. <?= $jual['jumlah'] * $jual['harga']; ?></td>
                                        <td>
                                            <button onclick="showConfirmationDelete(<?= $jual['id']; ?>)" class="btn btn-danger "><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="col mt-3 d-flex justify-content-end">
                            <div class="w-auto">
                                <p class="mb-0">Total Harga:</p>
                                <input class="input-group-text bg-light " style="width: fit-content;" value="Rp. <?= $data_penjualan == null ? 0 :  $jual['total']; ?>" readonly />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- pop -->
    <?php include 'component/pop_up.php'; ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="datatables/datatables.js"></script>
    <script src="script.js"></script>
    <script>


        $(document).ready(function() {
            // if (!localStorage.getItem('refresed')) {
            //     localStorage.setItem('refresed', 'yes');
            //     location.reload();
            // } else {
            //     localStorage.removeItem('refresed');
            // }
            //cek data penjualan apakah ada
            cekDataPenjualan();
            // Inisialisasi selectpicker untuk #selection_product
            $('#selection_product').selectpicker();

            // Inisialisasi DataTable untuk #tableformat
            $('#tableformat').DataTable({
                "columnDefs": [{
                    "className": "dt-center",
                    "targets": "_all"
                }]
            });
        });
    </script>

</body>


<!-- table format -->

</html>