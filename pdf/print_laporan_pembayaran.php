<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../component/connection.php';
include '../function.php';
session_start();
$start = $_SESSION['tanggal-mulai'];
$end = $_SESSION['tanggal-berakhir'];
$total = 0;


$data_laporan = getLaporanByTanggal($connect, $start, $end);



$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 900px; margin: auto; padding: 30px;  }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left;   }
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
                        <h2  style="margin: 0;">Laporan Penjualan</h2>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="table" style="margin-bottom: 40px ;">
            <thead>
                <tr>
                   
                    <th scope="col">Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Terjual</th>
                    <th scope="col">Total per item</th>
                    <th scope="col">Toko</th>
                    <th scope="col">Costumer</th>
                    <th scope="col">tanggal</th>
  
                </tr>
            </thead>
            <tbody>
        </html>';

// Tambahkan data dari $data_laporan ke dalam tabel

foreach ($data_laporan as $item) {
    $total = $total + $item['harga'] * $item['terjual'];
    $html .= '
       <tr>
           <td>' . htmlspecialchars($item['produk']) . '</td>
           <td>Rp ' . number_format($item['harga'], 0, ',', '.') . '</td>
           <td>' . htmlspecialchars($item['terjual']) . '</td>
           <td>Rp ' . number_format($item['harga'] * $item['terjual'], 0, ',', '.') . '</td>
           <td>' . htmlspecialchars($item['toko']) . '</td>
           <td>' . htmlspecialchars($item['costumer']) . '</td>
           <td>' . htmlspecialchars($item['tanggal']) . '</td>
    
       </tr>';
}

$html .= '
            </tbody>
        </table>
        <hr >
            <h3 style="text-align: right; margin-right:30px ;">Total: Rp ' . number_format($total, 0, ',', '.')  . '</h3>

    </div>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output();
