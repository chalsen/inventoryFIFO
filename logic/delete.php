<?php
include '../component/connection.php';

function delete($connect, $table, $field, $id, $location)
{
    $id_tmp = mysqli_real_escape_string($connect, $id);
    $query = "DELETE FROM $table WHERE $field = ?";
    $stmt = mysqli_prepare($connect, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id_tmp);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            header("location: $location");
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
    }
    mysqli_close($connect);
}

if (isset($_GET['delete_karyawan'])) {
    session_start();
    $id = $_GET['delete_karyawan'];

    if ($id == $_SESSION['id_karyawan']) {
        header("location: ../karyawan.php?error");
        die();
    }
    $query = " DELETE FROM `tb_login` WHERE id_karyawan = $id";
    $sql = mysqli_query($connect, $query);

    $location = "../karyawan.php?deleteSuccess";
    $table = "`tb_karyawan`";
    $column = "id_karyawan";
    delete($connect, $table, $column, $id, $location);
} else if (isset($_GET['delete_supplier'])) {
    $id = $_GET['delete_supplier'];

    $query = " UPDATE `tb_restok` SET `id_supplier` = null  WHERE id_supplier = $id";
    $sql = mysqli_query($connect, $query);

    $location = "../supplier.php?deleteSuccess";
    $table = "`tb_supplier`";
    $column = "id_supplier";
    delete($connect, $table, $column, $id, $location);
} else if (isset($_GET['delete_produk'])) {
    $id = $_GET['delete_produk'];
    $query_restock = " DELETE FROM `tb_restok`  WHERE id_produk = $id";
    $sql_restock = mysqli_query($connect, $query_restock);
    $query_penjualan = "DELETE FROM `tb_penjualan_harian` WHERE id_produk = $id";
    $sql_penjualan = mysqli_query($connect, $query_penjualan);

    $location = "../produk.php?deleteSuccess";
    $table = "`tb_produk`";
    $column = "id_produk";
    delete($connect, $table, $column, $id, $location);
} else if (isset($_GET['delete_stock_in'])) {
    $id = $_GET['delete_stock_in'];
    $location = "../stock_in.php?deleteSuccess";
    $table = "`tb_baku`";
    $column = "id";

    // $query_select = "SELECT id_produk,jumlah_restok from tb_restok WHERE id_restok = $id";
    // $sql_select = mysqli_query($connect, $query_select);
    // $result = mysqli_fetch_assoc($sql_select);

    // $id_produk = $result['id_produk'];
    // $jumlah = $result['jumlah_restok'];

    // $query_update = "UPDATE tb_produk SET jumlah = `jumlah`- $jumlah WHERE id_produk = $id_produk";
    // $sql_update = mysqli_query($connect, $query_update);


    delete($connect, $table, $column, $id, $location);
} else if (isset($_GET['delete_kategori'])) {
    $id = $_GET['delete_kategori'];
    $query = "UPDATE `tb_produk` SET `id_kategori` = null 
    WHERE `tb_produk`.`id_kategori` = $id";
    $sql = mysqli_query($connect, $query);

    $location = "../kategori.php?deleteSuccess";
    $table = "`tb_kategori`";
    $column = "id_kategori";
    delete($connect, $table, $column, $id, $location);
} else if (isset($_GET['delete_penjualan'])) {

    $id = $_GET['delete_penjualan'];
    $location = "../penjualan.php?deleteSuccess";
    $table = "`tb_penjualan_harian`";
    $column = "id_penjualan";

    $query_select = "SELECT id_produk,penjualan from tb_penjualan_harian WHERE id_penjualan = $id";
    $sql_select = mysqli_query($connect, $query_select);
    $result = mysqli_fetch_assoc($sql_select);

    $id_produk = $result['id_produk'];
    $jumlah = $result['penjualan'];

    $query_update = "UPDATE tb_produk SET jumlah = `jumlah`+ $jumlah WHERE id_produk = $id_produk";
    $sql_update = mysqli_query($connect, $query_update);


    delete($connect, $table, $column, $id, $location);
} else if (isset($_GET['delete_record'])) {
    $id = $_GET['delete_record'];
    $location = "../recordAdmin.php?deleteSuccess";
    $table = "`tb_rekap_penjualan`";
    $column = "id_rekap";
    delete($connect, $table, $column, $id, $location);
} else if (isset($_POST['delete_all'])) {
    deleteALL("tb_restok", $connect);
    header("location: ../stock_in.php");
    exit();
} else if (isset($_POST['Reset_keranjang'])) {

    // Ambil data dari tb_penjualan_harian
    $query_select = "SELECT id_produk, penjualan FROM tb_penjualan_harian";
    $sql_select = mysqli_query($connect, $query_select);

    // Update stok di tb_produk
    while ($row = mysqli_fetch_assoc($sql_select)) {
        $id_produk = $row['id_produk'];
        $penjualan = $row['penjualan'];

        // Update stok
        $query_update = "UPDATE tb_produk SET jumlah = jumlah + $penjualan WHERE id_produk = $id_produk";
        mysqli_query($connect, $query_update);
    }

    // Hapus semua record dari tb_penjualan_harian
    deleteALL("tb_penjualan_harian", $connect);

    header("location: ../penjualan.php");
    exit();
} else {
    header("location: ../index.php?deleteError");
}

function deleteALL($table, $connect)
{
    $query_delete = "DELETE FROM $table WHERE 1";
    mysqli_query($connect, $query_delete);
}
