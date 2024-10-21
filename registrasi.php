<?php
session_start();
include "component/connection.php";
include "function.php";
$dataKaryawan = getAllData($connect,'tb_karyawan');


if (isset($_POST['Sign-in'])){


$user = $_POST["username"];
$karyawan = $_POST["id_karyawan"];
$pass = $_POST["password"];
$confirm = $_POST["confirm"];
if($pass==$confirm){

    try {
    $query = "INSERT INTO `tb_login`( `id_karyawan`, `username`, `password`, `level`) VALUES ($karyawan, '$user', '$pass', 'karyawan'   )";
    $result = mysqli_query($connect, $query);

    if($result){
    header("location: login.php");
    }else{
    echo "gagal memuat";
    }}catch (mysqli_sql_exception $e) {
        echo "<script>alert('id karyawan mungkin sudah terpakai');</script>";
    }
    }else{
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input_pass = document.getElementById('password');
            const input_confirm = document.getElementById('password-confirm');
            const error_msg = document.getElementById('error_msg');
            input_pass.classList.add('worng-input');
            input_confirm.classList.add('worng-input');
            error_msg.removeAttribute('hidden');
        });        
        </script>";
    }
}
?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleLogin.css">
    <title>Login</title>
</head>
<body>


<div class="center">
         <div class="container">
            <div class="text">
               Login
            </div>
            <form action="registrasi.php" method="POST">
               <div class="data">
                  <label>Username</label>
                  <input name="username"  id="username" type="text" required>
               </div>


               <div  class="data">
                    <label for="password">Nama Karyawan</label>
                    <select  name="id_karyawan" class="selected-data"">
                            <?php foreach ($dataKaryawan as $tampil) : ?>
                                <option value="<?php echo $tampil['id_karyawan']; ?>"><?php echo $tampil['Nama']; ?></option>
                            <?php endforeach ?>
                    </select>
                </div>


               <div class="data">
                  <label>Password</label>
                  <input name="password" id="password" type="password" required onchange="validateInput()">
               </div>



               <div class="data">
                  <label for="password-confirm">confirm</label>
                  <input type="password" name="confirm" id="password-confirm" class="form-control" required onchange="validateInput()">
               </div>
               
               <?php
                   if (isset($_SESSION['login_error'])) {
                  echo "<div class='error' style='color: red; margin-bottom: 2px'>{$_SESSION['login_error']}</div>";
                  unset($_SESSION['login_error']);
                }
               ?>
               <p hidden id="error_msg" style="color: red; margin:0">*password dan konfirmasi password tidak cocok</p>
               <div class="btn">
                  <div class="inner"></div>
                  <button type="submit" name="Sign-in" value="Sign-in">login</button>
               </div>
               <div class="signup-link">
                  sudah ada akun? <a href="login.php">Daftar disini</a>
               </div>
            </form>
         </div>
    </div>   
</body>
</html>    