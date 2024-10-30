<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../component/connection.php';
include '../function.php';

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
    <title>Invoice</title>
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
                        <h2  style="margin: 0;">Invoice</h2>
                    </td>
                    <td style="text-align: right; width: 50%; padding: 0;">
                        <p  style="margin: 0;">' . $tanggal . '</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        
         <table  style="border-spacing: 20px 1px;  margin-bottom: 20px; ">
            <tr>
            <td>Kepada</td>
                <td>: ' . htmlspecialchars($customer_name) . '</td>
                
            </tr>
            <tr>
            <td>Toko</td>
            <td>: ' . htmlspecialchars($data_penjualan[0]['toko']) . '</td>
               
            </tr>
            <tr>
                <td>Alamat</td>
                <td colspan="3">: ' . htmlspecialchars($data_penjualan[0]['alamat']) . '</td>
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
            <h3 style="text-align: right; margin-right:30px ;">Total: Rp ' . number_format($data_penjualan[0]['total'], 0, ',', '.')  . '</h3>

    </div>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output();
