<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../component/connection.php';
include '../function.php';

$data_penjualan = getPenjualan($connect);
$invoice_no = 'INV-' . date("YmdHis"); // Bisa diubah sesuai format invoice
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
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 900px; margin: auto; padding: 30px;  }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #ddd;   }
        h1{ margin : 0 ; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Invoice</h1>
        <hr>
         <table  style="border-spacing: 20px 1px;  margin-bottom: 20px; ">
            <tr>
            <td><strong>Customer:</strong></td>
                <td>' . htmlspecialchars($customer_name) . '</td>
                
            </tr>
            <tr>
            <td><strong>Toko:</strong></td>
            <td>' . htmlspecialchars($data_penjualan[0]['toko']) . '</td>
               
            </tr>
            <tr>
                <td><strong>Alamat:</strong></td>
                <td colspan="3">' . htmlspecialchars($data_penjualan[0]['alamat']) . '</td>
                <td><strong>Tanggal:</strong></td>
                <td>' . date("Y-m-d") . '</td>
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
            <tbody>';

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
       
            <h3 style="text-align: right;">Total: Rp ' . number_format($data_penjualan[0]['total'], 0, ',', '.')  . '</h3>

    </div>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output(); // 'I' untuk menampilkan di browser atau 'D' untuk mendownload
