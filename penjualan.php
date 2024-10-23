<?php
include 'component/connection.php';
include 'function.php';
session_start();
// $dataPenjualan = getPenjualan($connect);
$data_produk = getAllProduct($connect);
$data_penjualan = getPenjualan($connect);
$title = "Transaksi"; // $query = "SELECT SUM(ph.penjualan*harga) as total
// FROM `tb_penjualan_harian` ph 
// JOIN tb_produk pr ON pr.id_produk = ph.id_produk ";
// $sql = mysqli_query($connect, $query);
// $result = mysqli_fetch_assoc($sql);

// $total = $result['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


    <link rel="stylesheet" href="datatables/datatables.css">
    <script src="datatables/datatables.js"></script>
    <title><?= $title ?></title>
</head>

<body>
    <?php include 'component/sidebar.php'; ?>

    <div class="main--content">
        <?php include 'component/header.php'; ?>

        <div class="card--container">
            <form action="Logic/input_logic.php" method="post">
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm border-success">
                            <div class="card-header py-3">
                                <h5 class="my-0 fw-normal">Produk</h5>
                            </div>
                            <div class="card-body">
                                <p>Cari Produk</p>
                                <div class="search_select_box">
                                    <select name="produk" class="w-100 mb-3" data-live-search="true">
                                        <option value="null" disabled selected>Pilih Barang...</option>
                                        <?php foreach ($data_produk as $tampil) : ?>
                                            <option value="<?php echo $tampil['id_produk']; ?>"><?php echo $tampil['nama_produk']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <p class="m-0">Harga</p>
                                        <input type="text" class="input-group-text" value="Rp 0" readonly>
                                    </div>
                                    <div class="col">
                                        <p class="m-0">Jumlah</p>
                                        <input type="number" name="jumlah" min="0" class="input-group-text" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm border-success">
                            <div class="card-header py-3">
                                <h5 class="my-0 fw-normal">Toko Tujuan</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <p class="m-0">Toko</p>
                                    <input type="text" name="toko" class="input-group-text w-100" placeholder="Masukan nama toko" required>

                                    <p class="m-0">Alamat</p>
                                    <input type="text" name="alamat" class="input-group-text w-100" placeholder="Masukan alamat toko" required>
                                </div>

                                <button type="submit" name="submit" value="simpan_penjualan" class="w-100  btn btn-md btn-success">Masukan ke keranjang <i class="fa fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="card mb-4 rounded-3 ">
                    <div class="card-header py-3 text-bg-primary d-flex justify-content-between">
                        <h4 class="my-0 fw-normal">Keranjang <i class="fas fa-shopping-basket"></i></h4>
                        <button class="btn btn-danger">Reset <i class="fas fa-undo ms-1"></i> </button>
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
                                        <th scope="col">Toko</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- looping di sini -->
                                    <?php foreach ($data_penjualan as $jual): ?>
                                        <tr>
                                            <td><?= $jual['produk']; ?></td>
                                            <td><?= $jual['harga']; ?></td>
                                            <td><?= $jual['jumlah']; ?></td>
                                            <td><?= $jual['toko']; ?></td>
                                            <td><?= $jual['alamat']; ?></td>
                                            <td>
                                                <div class="grupAction">
                                                    <button class="btn btn-success" id="edit_penjualan"><i class="fa fa-edit"></i></button>
                                                    <button class="btn btn-danger "><i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="invisible grupEdit">
                                                    <button class="btn btn-success btn_edit"><i class="fa fa-check"></i></button>
                                                    <button class="btn btn-danger btn_edit" id="cencelEdit"><i class="fa fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <p class="d-inline">Total Harga:</p>
                            <input class="d-inline form-control" style="width: fit-content;" value="Rp. 2.000" />
                        </div>
                        <button type="button" class="btn btn-md btn-success">Bayar <i class="fa fa-dollar-sign"></i></button>
                        <button type="button" class="btn btn-md btn-secondary">Cetak <i class="fa fa-print"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.search_select_box select').selectpicker();
        })
    </script>
    <script src="script.js"></script>
</body>


<!-- table format -->

</html>