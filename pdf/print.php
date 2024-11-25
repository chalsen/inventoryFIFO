<?php
include '../component/connection.php';
session_start();

// var_dump($_POST);
if (isset($_POST['print_tagihan'])) {
    header("Location: print_tagihan.php");
    exit;
} elseif (isset($_POST['print_penjualan'])) {

    $query_pembayaran = 'SELECT id_produk,penjualan FROM `tb_penjualan_harian`';

    $sql = mysqli_query($connect, $query_pembayaran);
    if (!$sql) {
        die('Query gagal dijalankan: ' . mysqli_error($connect));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($sql)) {
        $data[] = $row;
    }
    $cost = $_POST['costumer'];
    $toko = $_POST['toko'];
    $alamat = $_POST['alamat'];

    // penghapusan atau pengeluaran data dari tb list_produk
    foreach ($data as $d) {
        $id = $d['id_produk'];
        $jual = $d['penjualan'];

        $queryFirstOut = "DELETE FROM `list_produk` WHERE `id_produk` = '$id'  ORDER BY created_at ASC LIMIT $jual ";

        $result = mysqli_query($connect, $queryFirstOut);
        if (!$result) {
            die('Gagal menghapus produk FIFO: ' . mysqli_error($connect));
        }
    }
    $_SESSION['pembayaran'] = $_POST['pembayaran'];
    header("Location: print_pembayaran.php");

    // mealakukan update query table cost toko dan alamat jika user menambahkan data ketika sudah menentukan pembeli
    $query_update = "
    UPDATE tb_penjualan_harian 
    SET costumer = '$cost', 
        toko = '$toko',
        alamat = '$alamat';
";

    mysqli_query($connect, $query_update);
    exit;
} elseif (isset($_POST["cetak_laporan_penjualan"])) {
    $_SESSION['tanggal-mulai'] = empty($_POST['tanggal-mulai']) ? '0000' : $_POST['tanggal-mulai'];
    $_SESSION['tanggal-berakhir'] = empty($_POST['tanggal-berakhir']) ? '9999-12-31' : $_POST['tanggal-berakhir'];

    header("Location: print_laporan_pembayaran.php");
} elseif (isset($_POST["cetak_laporan_baku"])) {
    $_SESSION['tanggal-mulai'] = empty($_POST['tanggal-mulai']) ? '0000' : $_POST['tanggal-mulai'];
    $_SESSION['tanggal-berakhir'] = empty($_POST['tanggal-berakhir']) ? '9999-12-31' : $_POST['tanggal-berakhir'];
    $_SESSION['status'] = empty($_POST['status']) ? "'masuk','keluar'" : "'" . $_POST['status'] . "'";;



    header("Location: print_laporan_baku.php");
} else {
    echo "not found";
}
