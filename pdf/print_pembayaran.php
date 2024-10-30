<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../component/connection.php';
include '../function.php';
session_start();

$data_penjualan = getPenjualan($connect);
$tanggal = date("d-m-Y");
if (!empty($data_penjualan)) {
    $customer_name = $data_penjualan[0]['costumer'];
} else {
    // Tangani situasi ketika tidak ada data penjualan
    $customer_name = "Nama Customer Tidak Ditemukan";
}
$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 900px; margin: auto; padding: 30px;  }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #ddd;   }
        h1{ text-align: center ; margin-bottom: 30px; }
        h2{ margin : 0 ; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Roti Uncu</h1>
        
        <table style="width: 100%; border-collapse: collapse; padding: 0; margin: 0;">
            <tbody>
                <tr>
                    <td style="text-align: left; width: 50%; padding: 0;">
                        <h2  style="margin: 0;">Kwitansi</h2>
                    </td>
                    <td style="text-align: right; width: 50%; padding: 0;">
                        <p  style="margin: 0;">' . date("d-m-Y") . '</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        
         <table  style="border-spacing: 20px 1px;  margin-bottom: 20px; ">
            <tr>
            <td>Telah terima dari</td>
                <td>: ' . htmlspecialchars($customer_name) . '</td>
                
            </tr>
            <tr>
            <td>Sejumlah uang</td>
            <td>: Rp.' . htmlspecialchars(number_format($_SESSION['pembayaran'], 0, ',', '.')) . '</td>
               
            </tr>
        </table>
        <hr>
        <table class="table" style="margin-bottom: 40px ;">
            <thead>
                <tr>
                   
                    <th scope="col">Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total</th>
  
                </tr>
            </thead>
            <tbody>
        </html>';

// Tambahkan data dari $data_penjualan ke dalam tabel

foreach ($data_penjualan as $item) {
    $html .= '
       <tr>
    
           <td>' . htmlspecialchars($item['produk']) . '</td>
           <td>Rp ' . number_format($item['harga'], 0, ',', '.') . '</td>
           <td>' . htmlspecialchars($item['jumlah']) . '</td>
           <td>Rp ' . number_format($item['harga'] * $item['jumlah'], 0, ',', '.') . '</td>
    
       </tr>';
}

$html .= '
            </tbody>
        </table>
        <hr >
            <h4 style="text-align: right; margin: 10px 30px 0px 0px;">Total: Rp ' . number_format($data_penjualan[0]['total'], 0, ',', '.')  . '</h4>
            <h4 style="text-align: right; margin: 0px 30px 10px 0px; border-bottom:1px solid black;">Pembayaran: Rp ' . number_format($_SESSION['pembayaran'], 0, ',', '.')  . '</h4>
            <h4 style="text-align: right; margin: 0px 30px 0px 0px; border-bottom:1px">Kembali: Rp ' . number_format($_SESSION['pembayaran'] - $data_penjualan[0]['total'], 0, ',', '.')  . '</h4>

    </div>
</body>
</html>
';


$mpdf->WriteHTML($html);
transferData($connect);
$mpdf->Output();


//function tranfer record dari penjualan ke laporan
function transferData($connect)
{
    $tanggal = date("Y-m-d");
    $query_insert = "INSERT INTO tb_rekap_penjualan (produk, harga, costumer,toko,alamat,terjual,tanggal) 
                     SELECT p.nama_produk,p.harga,j.costumer,j.toko,j.alamat,j.penjualan,'$tanggal'
                     FROM tb_penjualan_harian j JOIN tb_produk p on j.id_produk =p.id_produk ;	 ";

    if (mysqli_query($connect, $query_insert)) {
        // Hapus data dari tb_penjualan_harian setelah berhasil di-transfer

        $query_delete = "DELETE FROM tb_penjualan_harian";
        mysqli_query($connect, $query_delete);
    } else {
        echo "Gagal melakukan transfer data: " . mysqli_error($connect);
    }
}
