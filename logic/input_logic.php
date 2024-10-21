<?php
include '../component/connection.php';

if(isset($_POST['submit']))
{
    //karyawan logic
    if($_POST['submit'] == 'simpan_karyawan')
    {
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
            
            if($result){
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
        

    }else if($_POST['submit'] == 'simpan_supplier')
    {
    // mysqli_real_escape_string 
    $name_supplier = mysqli_real_escape_string($connect, $_POST['name_supplier']);
    $np = mysqli_real_escape_string($connect, $_POST['np']);
    $alamat = mysqli_real_escape_string($connect, $_POST['alamat']);
    
    // parameterized query 
    $query = "INSERT INTO `tb_supplier`(`nama`, `alamat`, `np`) VALUES (?, ?, ?)";
    
    // Menggunakan prepared statement
    $stmt = mysqli_prepare($connect, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sss', $name_supplier,$alamat, $np);
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
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
    
    }else if($_POST['submit'] == 'simpan_produk')
    {
      
    $nama_produk = mysqli_real_escape_string($connect, $_POST['nama_produk']);
    $jumlah_produk = mysqli_real_escape_string($connect, $_POST['jumlah_produk']);
    $harga_produk = mysqli_real_escape_string($connect, $_POST['harga_produk']);
    $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
    
    $query = "INSERT INTO `tb_produk`(`nama_produk`, `jumlah`, `id_kategori`, `harga`) VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($connect, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sisi', $nama_produk, $jumlah_produk, $kategori, $harga_produk);
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
            header("location:../produk.php?success");
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
    }

    mysqli_close($connect);
    

    }else if($_POST['submit'] == 'simpan_stock_in') // simpan data stock
    {
    $produk = mysqli_real_escape_string($connect, $_POST['produk']);
    $supplier = mysqli_real_escape_string($connect, $_POST['supplier']);
    $jumlah = mysqli_real_escape_string($connect, $_POST['jumlah_produk']);
    $tanggal = mysqli_real_escape_string($connect, $_POST['tanggal']);
    
    $query = "INSERT INTO `tb_restok`(`id_produk`, `id_supplier`, `jumlah_restok`, `tanggal`) VALUES (?, ?, ? ,?)";
    
    $stmt = mysqli_prepare($connect, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssss', $produk, $supplier, $jumlah, $tanggal);
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
            //melakukan simpan jumlah ke table produk
            $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` + $jumlah  WHERE id_produk = $produk";
            $sql = mysqli_query($connect,$query);
            if($sql){
                header("location:../stock_in.php?success");
                exit();
            }
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
    }

    mysqli_close($connect);
    }else if($_POST['submit'] == 'simpan_kategori')
    {

    $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
    
    $query = "INSERT INTO `tb_kategori`(`kategori`) VALUES (?)";
    
    $stmt = mysqli_prepare($connect, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $kategori);
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
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
    }else if($_POST['submit'] == 'simpan_penjualan') //simpan data penjualan
    {
    $produk = mysqli_real_escape_string($connect, $_POST['produk']);
    $penjualan = mysqli_real_escape_string($connect, $_POST['terjual']);
    $tanggal = mysqli_real_escape_string($connect, $_POST['tanggal']);

    //mengambil data produk
    $query_produk = "SELECT  `jumlah` FROM `tb_produk` WHERE id_produk = $produk";
    $sql = mysqli_query($connect,$query_produk);
    $data =mysqli_fetch_assoc($sql);

    //cek apakah stock produk cukup
    if($penjualan>$data['jumlah']){
        session_start(); 
        $_SESSION['error_message'] = 'stock tidak cukup';
        header("location: ../input_component/input_penjualan.php");
        die();
    }

    $query = "INSERT INTO `tb_penjualan_harian`(`id_produk`,`penjualan`,`tanggal`) VALUES (?,?,?)";
    
    $stmt = mysqli_prepare($connect, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iis', $produk,$penjualan,$tanggal);
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
              //melakukan simpan jumlah ke table produk
              $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` - $penjualan  WHERE id_produk = $produk";
              $sql = mysqli_query($connect,$query);
              if($sql){
                  header("location:../penjualan.php?success");
                  exit();
                }
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal membuat pernyataan SQL: " . mysqli_error($connect);
    }

    mysqli_close($connect);
    }else if($_POST['submit'] == 'simpan_record') //simpan data penjualan
    {
    $produk = mysqli_real_escape_string($connect, $_POST['produk']);
    $harga = mysqli_real_escape_string($connect, $_POST['harga']);
    $terjual = mysqli_real_escape_string($connect, $_POST['terjual']);
    $perekap = mysqli_real_escape_string($connect, $_POST['perekap']);
    $tanggal = mysqli_real_escape_string($connect, $_POST['tanggal']);
    $tanggal_rekap = mysqli_real_escape_string($connect, $_POST['tanggal_rekap']);
    
    $query = "INSERT INTO `tb_rekap_penjualan`(`produk`,`harga`,`nama_perekap`,`terjual`,`tanggal`,`tanggal_rekap`) VALUES (?,?,?,?,?,?)";
    
    $stmt = mysqli_prepare($connect, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sisiss', $produk,$harga,$perekap,$terjual,$tanggal,$tanggal_rekap);
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
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
    }else{
        header("location:../index.php?error");
    }
} else {
    header("location:../index.php?error");
}
?>

