<?php
include 'component/connection.php';
include 'function.php';
session_start();
$dataPenjualan = getPenjualan($connect);
$title = "penjualan";

$query = "SELECT SUM(ph.penjualan*harga) as total
FROM `tb_penjualan_harian` ph 
JOIN tb_produk pr ON pr.id_produk = ph.id_produk ";
$sql = mysqli_query($connect, $query);
$result = mysqli_fetch_assoc($sql);

$total = $result['total'];


if(isset($_GET['record'])){
    $nama = $_SESSION['karyawan'];
    $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
    $time = $dt->format('Y/m/d');


// Query SQL untuk memindahkan data dari tb_penjualan_harian ke tb_rekap_penjualan dengan tambahan informasi
$sqlMoveData = "INSERT INTO tb_rekap_penjualan (produk, harga, nama_perekap, terjual, tanggal, tanggal_rekap)
                SELECT p.nama_produk,p.harga,?, pe.penjualan, pe.tanggal, ?
                FROM tb_penjualan_harian pe
                JOIN tb_produk p ON p.id_produk = pe.id_produk";

// Persiapkan statement
$stmt = mysqli_prepare($connect, $sqlMoveData);
if ($stmt) {
    // Bind parameter
    mysqli_stmt_bind_param($stmt, 'ss', $nama, $time);
    
    // Eksekusi query
    mysqli_stmt_execute($stmt);
    
    // Periksa jika query berhasil dijalankan
    if(mysqli_stmt_affected_rows($stmt) > 0) {
        $sqlDeleteData = "DELETE FROM `tb_penjualan_harian`";
        $sql = mysqli_query($connect,$sqlDeleteData);
        echo"<script>alert()</script>";
        header('location:penjualan.php');
    } else {
    }
    // Tutup statement
    mysqli_stmt_close($stmt);
} else {
    echo "Gagal menyiapkan statement: " . mysqli_error($koneksi);
}

    $connect->close();

}else{

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <!-- table start -->
            <div class="btn_penjualan">
                <a href="input_component/input_penjualan.php" class=" button btn m-3"><i class="fas fa-plus-square me-2"></i>Tambah Data</a>
                <button class=" button-rekap m-3 me-0 btn" onclick="pop_up()"><i class="fas fa-plus-square me-2"></i>Rekap Penjualan</button>
            </div>
            <table id="tableformat" class="table table-striped table-bordered table-hover ">
            <thead>
                <tr>
                    <th scope="col">produk</th>
                    <th scope="col">harga</th>
                    <th scope="col">terjual</th>
                    <th scope="col">tanggal</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop start -->
                <?php  
        foreach ($dataPenjualan as $tampil):
            ?>
        <tr>
            <td><?= $tampil['produk']; ?></td>
            <td><?= $tampil['harga']; ?></td>
            <td><?= $tampil['terjual']; ?></td>
            <td><?= $tampil['tanggal']; ?></td>
            <td>
                <a href="input_component/input_penjualan.php?edit_penjualan=<?= $tampil['id']?>" type="button"><i class="fa fa-pen"></i></a>
                <!-- delete -->
                <a href="logic/delete.php?delete_penjualan=<?= $tampil['id'] ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <!-- loop end -->
    </tbody>
</table>


<!-- table end -->

    <div class="pendapatan">
        <p class="me-1">TOTAL PENDAPATAN :</p> 
        <p><?php echo $total; ?></p>
    </div>
</div>
<!-- pop up box -->
<div class="pop-up-container" id="popbox">
    <button class="x_btn" onclick="close_pop()" type="button">
        <span class="x"></span>
        <span class="x"></span>
    </button>
    <div class="pop-content">
        <h4>peringatan!!</h4>
        <p>data disini akan dipindahkan apa anda yakin?</p>
        <a href="penjualan.php?record" class=" button mb-3 btn ">lanjutkan</a>
      
    </div>
</div>

</div>

<script src="script.js"></script>
<script>
    $(document).ready(function()
    {
        $('#tableformat').DataTable({
            "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ]
        });
    })
</script>
</body>


<!-- table format -->
</html>