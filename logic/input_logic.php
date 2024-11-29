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
        $jumlah_produk = mysqli_real_escape_string($connect, $_POST['jumlah_produk']);
        $harga_produk = mysqli_real_escape_string($connect, $_POST['harga_produk']);
        $cqty = $_POST['cqty'];
        // var_dump($cqty);
        // exit;
        $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
        $id_baku = $_POST['id_baku']; // Misalnya ini adalah array
        $escaped_ids = array_map(function ($id) use ($connect) {
            return mysqli_real_escape_string($connect, $id);
        }, $id_baku);

        // var_dump($escaped_ids);
        // exit;
        foreach ($escaped_ids as $key => $value) {
            # code...
            // var_dump($value);
            // exit;
            $json_baku[] = [
                'id' => intval($value),

                'value' => $cqty[intval($value)],
            ];
            // $cqty = array_map(function ($id) use ($connect) {
            //     // var_dump($id);
            //     return mysqli_real_escape_string($connect, $id);
            // }, $cqty);
        }
        // var_dump($cqty);
        $result_json = json_encode($json_baku);
        // print_r($result_json);
        // exit;


        foreach ($escaped_ids as $key => $value) {
            // Convert $value to integer and store in a variable
            $int_value = intval($value);

            // Check if the value exists in the $cqty array
            if (isset($cqty[$int_value])) {
                $cqtys = $cqty[$int_value]; // Get the quantity for this $value
                $cqtys_total = $cqty[$int_value] * $jumlah_produk; // Get the quantity for this $value
                $query5 = "SELECT * FROM `tb_baku` WHERE id = ?";
                $stmt5 = mysqli_prepare($connect, $query5);

                // Bind parameter (misalnya, $key adalah string)
                mysqli_stmt_bind_param($stmt5, "s", $value);

                // Eksekusi query
                mysqli_stmt_execute($stmt5);

                // Mendapatkan hasil eksekusi query
                $result = mysqli_stmt_get_result($stmt5);

                // Mengambil satu baris hasil query
                $row = mysqli_fetch_assoc($result);

                var_dump($cqtys_total);
                if ($cqtys_total <= $row['stok']) {
                    $query = "INSERT INTO `tb_produk`(`nama_produk`, `jumlah`, `id_kategori`, `harga`,`baku`) VALUES (?, ?, ?, ?, ?)";

                    $stmt = mysqli_prepare($connect, $query);

                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'sisis', $nama_produk, $jumlah_produk, $kategori, $harga_produk, $result_json);
                        $result = mysqli_stmt_execute($stmt);
                        if ($result) {
                            $new_id = mysqli_insert_id($connect);
                    
                        // var_dump($key);
                        // var_dump($key);
                        // var_dump("berhasil");
                        // exit;
                        // Insert into tb_pivot_baku_produk table
                        $query2 = "INSERT INTO `tb_pivot_baku_produk`(`id_produk`, `id_baku`, `created_at`,`stok`) VALUES (?, ?, ?, ?)";
                        $stmt2 = mysqli_prepare($connect, $query2);

                        // Update tb_baku stock
                        $query3 = "UPDATE `tb_baku` SET `stok` = `stok` - $cqtys WHERE `name` = $key";
                        mysqli_query($connect, $query3);
                        $current_date = date("Y-m-d");
                        $ctyin = intval($cqty[intval($value)]);
                        if ($stmt2) {
                            mysqli_stmt_bind_param($stmt2, 'iisi', $new_id, $int_value, $current_date, $ctyin);
                            $result2 = mysqli_stmt_execute($stmt2);

                            // exit;
                            header("location:../produk.php?success");
                            exit();
                        }
                    } else {
                        echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
                    }
                    } else {
                        echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
                    }
                } else {
                    // var_dump($key);
                    // var_dump("gagal");
                    // exit;

                    header("location:../produk.php?fail");
                }
                // Tutup statement
                mysqli_stmt_close($stmt5);
            } else {
                // If the value is not in the $cqty array, handle as needed
                echo "No quantity found for id: $value";
            }
        }





        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);


        mysqli_close($connect);
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
