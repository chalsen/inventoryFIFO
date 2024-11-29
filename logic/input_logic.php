<?php

use function PHPSTORM_META\type;

include '../component/connection.php';
include '../function.php';
// Atur zona waktu ke Asia/Jakarta
date_default_timezone_set("Asia/Jakarta");
if (isset($_POST['submit'])) {
    //karyawan logic
    if ($_POST['submit'] == 'simpan_karyawan') {
        $nama_karyawan = mysqli_real_escape_string($connect, $_POST['nama_karyawan']);
        $np = mysqli_real_escape_string($connect, $_POST['np']);
        $tanggal_lahir = mysqli_real_escape_string($connect, $_POST['tanggal_lahir']);
        $gender = mysqli_real_escape_string($connect, $_POST['gender']);
        $alamat = mysqli_real_escape_string($connect, $_POST['alamat']);

        $query = "INSERT INTO `tb_karyawan` (`Nama`, `alamat`, `np`, `jenis_kelamin`,`tanggal_lahir`) VALUES  (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssss', $nama_karyawan, $alamat, $np, $gender, $tanggal_lahir);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                header("location:../karyawan.php?success");
                exit();
            } else {
                echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
        }

        mysqli_close($connect);
    } else if ($_POST['submit'] == 'simpan_supplier') {
        // mysqli_real_escape_string 
        $name_supplier = mysqli_real_escape_string($connect, $_POST['name_supplier']);
        $np = mysqli_real_escape_string($connect, $_POST['np']);
        $alamat = mysqli_real_escape_string($connect, $_POST['alamat']);

        // parameterized query 
        $query = "INSERT INTO `tb_supplier`(`nama`, `alamat`, `np`) VALUES (?, ?, ?)";

        // Menggunakan prepared statement
        $stmt = mysqli_prepare($connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sss', $name_supplier, $alamat, $np);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                header("location:../supplier.php?success");
                exit();
            } else {
                echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
        }

        mysqli_close($connect);
    } else if ($_POST['submit'] == 'restock_produk') {
        $json_baku = [];
        $produk = mysqli_real_escape_string($connect, $_POST['produk']);
        $jumlah_produk = mysqli_real_escape_string($connect, $_POST['jumlah_produk']);
        $cqty = $_POST['cqty'];
        // var_dump($cqty);
        // exit;
        $current_date = date("Y-m-d H:i:s");
        // 3. Menulis query insert
        for ($i = 0; $i < $jumlah_produk; $i++) {
            $code = strval(time()) . $i;
            $query = "INSERT INTO list_produk (id_produk, created_at,code) VALUES ('$produk', '$current_date', $code)";
            mysqli_query($connect, $query);
        }

        $query2 = "UPDATE tb_produk SET jumlah = jumlah +'$jumlah_produk' WHERE id_produk = '$produk'";
        mysqli_query($connect, $query2);

        foreach ($cqty as $key => $value) {
            // var_dump($value);

            $query5 = "SELECT * FROM `tb_baku` WHERE id = ?";
            $stmt5 = mysqli_prepare($connect, $query5);

            // Bind parameter (misalnya, $key adalah string)
            mysqli_stmt_bind_param($stmt5, "s", $key);

            // Eksekusi query
            mysqli_stmt_execute($stmt5);

            // Mendapatkan hasil eksekusi query
            $result = mysqli_stmt_get_result($stmt5);

            // Mengambil satu baris hasil query
            $row = mysqli_fetch_assoc($result);

            $name = $row['name'];
            $query3 = "UPDATE tb_baku SET stok = stok -'$value' WHERE id = '$key'";
            mysqli_query($connect, $query3);
            $query = "INSERT INTO tb_laporan_baku (nama, jumlah, status) VALUES ('$name', '$value', 'keluar')";
            mysqli_query($connect, $query);
        }

        header("location:../produk.php?success");
        exit();
    } else if ($_POST['submit'] == 'restock_baku') {

        $supplier = mysqli_real_escape_string($connect, $_POST['supplier']);
        $cqty = $_POST['cqty'];

        foreach ($cqty as $key => $value) {
            // Sanitize $key and $value
            $key = mysqli_real_escape_string($connect, $key);
            $value = (int)$value; // Pastikan $value adalah integer untuk keamanan

            // Perbaiki query dengan tanda kutip untuk string
            $query = "UPDATE `tb_baku` SET `stok` = `stok` + $value WHERE `name` = '$key'";
            mysqli_query($connect, $query);
            $query = "INSERT INTO tb_laporan_baku (nama, jumlah, status) VALUES ('$key', '$value', 'masuk')";
            mysqli_query($connect, $query);
        }

        // Redirect setelah update
        header("location:../stock_in.php?success");
        exit();
    } else if ($_POST['submit'] == 'simpan_produk') {
        $json_baku = [];
        $nama_produk = mysqli_real_escape_string($connect, $_POST['nama_produk']);
        $jumlah_produk = intval($_POST['jumlah_produk']);
        $harga_produk = mysqli_real_escape_string($connect, $_POST['harga_produk']);
        $cqty = $_POST['cqty'];
        $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
        $id_baku = $_POST['id_baku'];

        // Escape IDs dan buat JSON bahan baku
        $escaped_ids = array_map(function ($id) use ($connect) {
            return intval(mysqli_real_escape_string($connect, $id));
        }, $id_baku);

        foreach ($escaped_ids as $value) {
            $json_baku[] = [
                'id' => $value,
                'value' => intval($cqty[$value]),
            ];
        }
        $result_json = json_encode($json_baku);

        // Insert produk baru
        $query = "INSERT INTO `tb_produk`(`nama_produk`, `jumlah`, `id_kategori`, `harga`, `baku`) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 'sisis', $nama_produk, $jumlah_produk, $kategori, $harga_produk, $result_json);
        mysqli_stmt_execute($stmt);
        $new_id = mysqli_insert_id($connect); // Ambil ID produk baru
        mysqli_stmt_close($stmt);

        // Validasi stok bahan baku
        $placeholders = implode(',', array_fill(0, count($escaped_ids), '?'));
        $query5 = "SELECT id, stok FROM `tb_baku` WHERE id IN ($placeholders)";
        $stmt5 = mysqli_prepare($connect, $query5);

        mysqli_stmt_bind_param($stmt5, str_repeat('i', count($escaped_ids)), ...$escaped_ids);
        mysqli_stmt_execute($stmt5);
        $result = mysqli_stmt_get_result($stmt5);

        $stok_valid = true;
        $stok_map = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $stok_map[$row['id']] = $row['stok'];
            if (isset($cqty[$row['id']])) {
                $needed_stok = $cqty[$row['id']] * $jumlah_produk;
                if ($row['stok'] < $needed_stok) {
                    $stok_valid = false;
                    break;
                }
            }
        }
        mysqli_stmt_close($stmt5);

        if (!$stok_valid) {
            header("location:../produk.php?fail");
            exit();
        }

        // Insert ke `list_produk`
        $current_date = date("Y-m-d H:i:s");
        $list_produk_values = [];
        for ($i = 0; $i < $jumlah_produk; $i++) {
            $code = strval(time()) . $i;
            $list_produk_values[] = "($new_id, '$current_date', '$code')";
        }
        $query_list = "INSERT INTO list_produk (id_produk, created_at, code) VALUES " . implode(',', $list_produk_values);
        mysqli_query($connect, $query_list);

        // Update stok bahan baku dan pivot table
        foreach ($escaped_ids as $value) {
            $stok_used = intval($cqty[$value] * $jumlah_produk);

            // Update stok bahan baku
            $query3 = "UPDATE `tb_baku` SET `stok` = `stok` - $stok_used WHERE `id` = ?";
            $stmt3 = mysqli_prepare($connect, $query3);
            mysqli_stmt_bind_param($stmt3, 'i', $value);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_close($stmt3);

            // Insert pivot table
            $query2 = "INSERT INTO `tb_pivot_baku_produk`(`id_produk`, `id_baku`, `created_at`, `stok`) VALUES (?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($connect, $query2);
            mysqli_stmt_bind_param($stmt2, 'iisi', $new_id, $value, $current_date, $stok_used);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }

        // Redirect sukses
        header("location:../produk.php?success");
        exit();
    } else if ($_POST['submit'] == 'simpan_stock_in') {
        $baku = mysqli_real_escape_string($connect, $_POST['baku']);
        $supplier = mysqli_real_escape_string($connect, $_POST['supplier']);
        $harga = mysqli_real_escape_string($connect, $_POST['harga']);
        $jumlah = mysqli_real_escape_string($connect, $_POST['jumlah_baku']);
        $tanggal = mysqli_real_escape_string($connect, $_POST['tanggal']);


        $query = "INSERT INTO `tb_baku`(`name`, `price`, `supplier`, `stok`,`created_at`) VALUES (?, ?, ? ,?,?)";

        $stmt = mysqli_prepare($connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sisis', $baku, $harga, $supplier, $jumlah, $tanggal);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {


                $query = "INSERT INTO tb_laporan_baku (nama, jumlah, status) VALUES ('$baku', '$jumlah', 'masuk')";
                mysqli_query($connect, $query);
                //melakukan simpan jumlah ke table produk
                // $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` + $jumlah  WHERE id_produk = $produk";
                // $sql = mysqli_query($connect, $query);
                // if ($sql) {
                header("location:../stock_in.php?success");
                exit();
                // }
            } else {
                echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
        }

        mysqli_close($connect);
    } else if ($_POST['submit'] == 'simpan_kategori') {

        $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);

        $query = "INSERT INTO `tb_kategori`(`kategori`) VALUES (?)";

        $stmt = mysqli_prepare($connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $kategori);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                header("location:../kategori.php?success");
                exit();
            } else {
                echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
        }

        mysqli_close($connect);
    } else if ($_POST['submit'] == 'simpan_penjualan') {
        $produk = mysqli_real_escape_string($connect, $_POST['produk']);
        $jumlah = mysqli_real_escape_string($connect, $_POST['jumlah']);
        $toko = mysqli_real_escape_string($connect, $_POST['toko']);
        $alamat = mysqli_real_escape_string($connect, $_POST['alamat']);

        // //mengambil data produk
        // $query_produk = "SELECT  `jumlah` FROM `tb_produk` WHERE id_produk = $produk";
        // $sql = mysqli_query($connect, $query_produk);
        // $data = mysqli_fetch_assoc($sql);

        // //cek apakah stock produk cukup
        // if ($jumlah > $data['jumlah']) {
        //     session_start();
        //     $_SESSION['error_message'] = 'stock tidak cukup';
        //     header("location: ../input_component/input_penjualan.php");
        //     die();
        // }

        $query = "INSERT INTO `tb_penjualan_harian`(`id_produk`,`penjualan`,`toko`,`alamat`) VALUES (?,?,?,?)";

        $stmt = mysqli_prepare($connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iiss', $produk, $jumlah, $toko, $alamat);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                //melakukan simpan jumlah ke table produk
                $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` - $jumlah  WHERE id_produk = $produk";
                $sql = mysqli_query($connect, $query);
                if ($sql) {
                    header("location:../penjualan.php?success");
                    exit();
                }
            } else {
                header("location:../penjualan.php?error");
            }

            mysqli_stmt_close($stmt);
        } else {
            header("location:../penjualan.php?error");
        }

        mysqli_close($connect);
    } else if ($_POST['submit'] == 'simpan_record') {
        $produk = mysqli_real_escape_string($connect, $_POST['produk']);
        $harga = mysqli_real_escape_string($connect, $_POST['harga']);
        $terjual = mysqli_real_escape_string($connect, $_POST['terjual']);
        $perekap = mysqli_real_escape_string($connect, $_POST['perekap']);
        $tanggal = mysqli_real_escape_string($connect, $_POST['tanggal']);
        $tanggal_rekap = mysqli_real_escape_string($connect, $_POST['tanggal_rekap']);

        $query = "INSERT INTO `tb_rekap_penjualan`(`produk`,`harga`,`nama_perekap`,`terjual`,`tanggal`,`tanggal_rekap`) VALUES (?,?,?,?,?,?)";

        $stmt = mysqli_prepare($connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sisiss', $produk, $harga, $perekap, $terjual, $tanggal, $tanggal_rekap);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                header("location:../recordAdmin.php?success");
                exit();
            } else {
                echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
        }

        mysqli_close($connect);
    } else {
        header("location:../index.php?error");
    }
} else if (isset($_POST['simpan']) == "penjualan") {


    $produk = mysqli_real_escape_string($connect, $_POST['produk']);
    $jumlah = mysqli_real_escape_string($connect, $_POST['jumlah']);

    $query = "INSERT INTO `tb_penjualan_harian`(`id_produk`,`penjualan`) VALUES (?,?)";

    $stmt = mysqli_prepare($connect, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ii', $produk, $jumlah);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            //melakukan simpan jumlah ke table produk
            $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` - $jumlah  WHERE id_produk = $produk";
            $sql = mysqli_query($connect, $query);
            if ($sql) {
                header("location:../penjualan.php?success");
                exit();
            }
        } else {
            header("location:../penjualan.php?error");
        }

        mysqli_stmt_close($stmt);
    } else {
        header("location:../penjualan.php?error");
    }

    mysqli_close($connect);
} else if (isset($_POST['simpan_pembeli']) == "pembeli") {

    $costumer = $_POST['costumer'];
    $toko = $_POST['toko'];
    $alamat =  $_POST['alamat'];

    $query = "UPDATE `tb_penjualan_harian` 
    SET `costumer` = '$costumer', `toko` = '$toko', `alamat` = '$alamat'";

    $sql = mysqli_query($connect, $query);

    if ($sql) {
        header("location:../penjualan.php?success");
        exit();
    } else {
        echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
    }
    mysqli_close($connect);
} else if ($_POST['restock_product']) {


    $data = getDataBakuByIdProduct($connect, $_POST['id_product']);

    // $data = json_decode($,true);
    // $data = cleanInput($data);
    // print_r($data);
    echo json_encode($data);
} else {
    header("location:../index.php?error");
}
