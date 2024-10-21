<?php
include '../component/connection.php';

if(isset($_POST['submit'])){
    if($_POST['submit'] == 'edit_produk'){
        $id = $_POST['id_produk'];
        $nama_produk = $_POST['nama_produk'];
        $jumlah = $_POST['jumlah_produk'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga_produk'];

        $query = "UPDATE `tb_produk` SET `nama_produk`='$nama_produk', `jumlah`='$jumlah', `id_kategori`='$kategori', `harga`='$harga' WHERE `id_produk`='$id'";
        $sql = mysqli_query($connect, $query);
        
        if($sql){
            header("location:../produk.php?success");
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }
    } else if($_POST['submit'] == 'edit_supplier') {
        
        $id = $_POST['id_supplier'];
        $nama_supplier = $_POST['name_supplier'];
        $np = $_POST['np'];
        $alamat = $_POST['alamat'];
      
        $query = "UPDATE `tb_supplier` SET `nama`='$nama_supplier', `alamat`='$alamat', `np`='$np' WHERE `id_supplier`='$id'";
        $sql = mysqli_query($connect, $query);

        if($sql){
            header("location:../supplier.php?success");
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }

    } else if($_POST['submit'] == 'edit_karyawan') {
        $id = $_POST['id_karyawan'];
        $nama_karyawan = $_POST['nama_karyawan'];
        $np = $_POST['np'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jk = $_POST['gender'];
        $alamat = $_POST['alamat'];
      

        $query = "UPDATE `tb_karyawan` SET `Nama`='$nama_karyawan', `alamat`='$alamat', `np`='$np', `jenis_kelamin`='$jk', `tanggal_lahir`='$tanggal_lahir' WHERE `id_karyawan`='$id'";
        $sql = mysqli_query($connect, $query);

        if($sql){
            header("location:../karyawan.php?success");
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }
    } else if($_POST['submit'] == 'edit_stock_in') {
        $id = $_POST['id_restok'];
        $produk = $_POST['produk'];
        $supplier = $_POST['supplier'];
        $jumlah_produk = $_POST['jumlah_produk'];
        $tanggal = $_POST['tanggal'];
        $jumlah_lama = $_POST['jumlah_lama'];


        $query = "UPDATE `tb_restok` SET `id_produk`=$produk  ,`id_supplier`= $supplier,`jumlah_restok`=$jumlah_produk, `tanggal`= '$tanggal'  WHERE `id_restok`='$id'";
        $sql = mysqli_query($connect, $query);
        
        if($sql){
            //melakukan perubahan jumlah pada table produk 
            $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` - $jumlah_lama + $jumlah_produk  WHERE `id_produk`='$produk'";
            $sql = mysqli_query($connect, $query);  
            
            if($sql){
                header("location:../stock_in.php?success");
            }
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }
    } else if($_POST['submit'] == 'edit_kategori') {
        $id = $_POST['id_kategori'];
        $kategori = $_POST['kategori'];
        $query = "UPDATE `tb_kategori` SET  `kategori`= '$kategori'  WHERE `id_kategori`='$id'";
        $sql = mysqli_query($connect, $query);

        if($sql){
            header("location:../kategori.php?success");
            exit();
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }
    } else if($_POST['submit'] == 'edit_penjualan') {
        $id = $_POST['id_penjualan'];
        $produk = $_POST['produk'];
        $terjual = $_POST['terjual'];
        $jumlah_lama = $_POST['jumlah_lama'];
        $tanggal = $_POST['tanggal'];


         //mengambil data produk
        $query_produk = "SELECT  `jumlah` FROM `tb_produk` WHERE id_produk = $produk";
        $sql = mysqli_query($connect,$query_produk);
        $data =mysqli_fetch_assoc($sql);

        //cek apakah stock produk cukup
        if($terjual>$data['jumlah']){
            session_start(); 
            $_SESSION['error_message'] = 'stock tidak cukup';
            header("location: ../input_component/input_penjualan.php?edit_penjualan=$id");
            die();
        }

        $query = "UPDATE `tb_penjualan_harian` SET  `id_produk`= '$produk',`penjualan`= '$terjual',`tanggal`= '$tanggal'  WHERE `id_penjualan`='$id'";
        $sql = mysqli_query($connect, $query);

        if($sql){
            $query = "UPDATE `tb_produk` SET `jumlah` = `jumlah` + $jumlah_lama -$terjual  WHERE `id_produk`='$produk'";
            $sql_produk = mysqli_query($connect, $query);  
            if($sql_produk){
                header("location:../penjualan.php?success");
                exit();
            }
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }
    } else if($_POST['submit'] == 'edit_record') {
        $id = $_POST['id'];
        $produk = $_POST['produk'];
        $harga = $_POST['harga'];
        $terjual = $_POST['terjual'];
        $tanggal = $_POST['tanggal'];
        $tanggal_rekap = $_POST['tanggal_rekap'];
        
        $query = "UPDATE `tb_rekap_penjualan` SET  `produk`= '$produk',`harga`= '$harga',`terjual`= '$terjual',`tanggal`= '$tanggal',`tanggal_rekap`= '$tanggal_rekap' WHERE `id_rekap`='$id'";
        $sql = mysqli_query($connect, $query);

        if($sql){
            header("location:../recordAdmin.php?success");
            exit();
            
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_error($connect);
        }

    }
}
?>
