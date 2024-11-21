<?php
include '../component/connection.php';
session_start();

var_dump($_POST);
if (isset($_POST['print_tagihan'])) {
    header("Location: print_tagihan.php");
    exit;
} elseif (isset($_POST['print_penjualan'])) {
    $cost = $_POST['costumer'];
    $toko = $_POST['toko'];
    $alamat = $_POST['alamat'];

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
