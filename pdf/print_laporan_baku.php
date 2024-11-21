<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../component/connection.php';
include '../function.php';
session_start();
$start = $_SESSION['tanggal-mulai'];
$end = $_SESSION['tanggal-berakhir'];
$status = $_SESSION['status'];



$data_laporan = getBakufilter($connect, $start, $end, $status);



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
        .table th, .table td { padding: 10px; border-bottom: 1px solid #ddd;  text-align: left;  }
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
                   
                    <th scope="col">Bahan Baku</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal</th>
                </tr>
            </thead>
            <tbody>
        </html>';

// Tambahkan data dari $data_laporan ke dalam tabel

foreach ($data_laporan as $item) {
    $html .= '
       <tr>
       <td>' . htmlspecialchars($item['nama']) . '</td>
       <td>' . htmlspecialchars($item['jumlah']) . '</td>
       <td>' . htmlspecialchars($item['status']) . '</td>
       <td>' . htmlspecialchars($item['created_at']) . '</td>
       
       </tr>';
}

$html .= '
            </tbody>
        </table>

    </div>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output();
