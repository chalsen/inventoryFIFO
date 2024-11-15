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
} else {
}
