<?php

function getTotalCount($connect, $table, $column)
{
    $query = "SELECT COUNT($column) as total FROM $table";
    $sql = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($sql);

    return $result['total'];
}
function produkTerlaris($connect)
{
    $query = "SELECT produk, SUM(terjual) AS total_terjual , harga
    FROM tb_rekap_penjualan
    GROUP BY produk
    ORDER BY total_terjual DESC
    LIMIT 5;    
    ";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}

function getAllData($connect, $table)
{
    $query = "SELECT * FROM $table";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}
function cleanInput($data) {
    if (is_array($data)) {
        // Rekursif jika elemen dalam array juga merupakan array
        return array_map('cleanInput', $data);
    } elseif (is_string($data)) {
        return stripslashes($data);
    }
    return $data;
}

function getDataBakuByIdProduct($connect, $id) {
    $query = "
    SELECT 
        tb_baku.*, 
         tb_pivot_baku_produk.stok as stok_pivot,
        tb_produk.* 
    FROM 
        tb_baku
    JOIN 
        tb_pivot_baku_produk ON tb_pivot_baku_produk.id_baku = tb_baku.id
    JOIN 
        tb_produk ON tb_pivot_baku_produk.id_produk = tb_produk.id_produk
    WHERE 
        tb_produk.id_produk = $id

";
$sql = mysqli_query($connect, $query);
$result = array();

while ($row = mysqli_fetch_assoc($sql)) {
    $result[] = $row;
}

return $result;
}
function getNameBaku($connect,$id){
    $query = "SELECT * FROM tb_baku WHERE id=$id";
    $sql = mysqli_query($connect, $query);
    $result = array();

    // Mengambil baris pertama (row)
    $result = mysqli_fetch_assoc($sql);

    return $result;
}

function getproductData($connect)
{
    $query = "SELECT  p.*,
    p.jumlah AS total_stock,
    k.kategori as kategori
    FROM tb_produk p
    LEFT JOIN tb_restok r ON r.id_produk = p.id_produk
    LEFT JOIN tb_kategori k ON k.id_kategori = p.id_kategori
    GROUP by p.id_produk";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}
function getAllSupplier($connect)
{
    $query = "SELECT `id_supplier`, `Nama` FROM `tb_supplier`";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}


function getAllProduct($connect)
{
    $query = "SELECT * FROM `tb_produk`";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}

function getAllBaku($connect)
{
    $query = "SELECT * FROM `tb_baku`";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}

function getAllKategori($connect)
{
    $query = "SELECT * FROM `tb_kategori`";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}

function getAllDatabyid($connect, $table, $column, $id)
{
    $query = "SELECT * FROM $table WHERE $column = $id";
    $sql = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($sql);
    return $result;
}

function total_laba_kotor($connect)
{
    $query = "SELECT SUM(jumlah*harga) AS total
    FROM tb_produk ";
    $sql = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($sql);
    return $result['total'];
}


function getDataStockIn($connect)
{
    $query = "SELECT r.id_restok AS id, 
    r.jumlah_restok AS jumlah, 
    r.tanggal AS tanggal, 
    p.nama_produk AS produk, 
    s.nama AS nama, 
    s.id_supplier AS id_supplier 
FROM tb_restok r 
JOIN tb_produk p ON r.id_produk = p.id_produk 
LEFT JOIN tb_supplier s ON r.id_supplier = s.id_supplier 
    ";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}


function getPenjualan($connect)
{
    $query = "SELECT 
    j.id_penjualan AS id,
    j.id_produk AS id_produk,
    p.nama_produk AS produk,
    p.harga AS harga,
    j.penjualan AS jumlah,
    j.costumer AS costumer,
    j.toko AS toko,
    j.alamat AS alamat,
    j.tanggal AS tanggal,
    (SELECT SUM(j2.penjualan * p2.harga) 
     FROM tb_penjualan_harian j2 
     JOIN tb_produk p2 ON j2.id_produk = p2.id_produk) AS total,
    (SELECT COUNT(DISTINCT j3.id_produk) 
     FROM tb_penjualan_harian j3) AS jumlah_produk
FROM 
    tb_penjualan_harian j
JOIN 
    tb_produk p ON j.id_produk = p.id_produk
    ";
    $sql = mysqli_query($connect, $query);
    $result = array();

    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }

    return $result;
}
