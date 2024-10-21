<?php
if (empty( $_SESSION['username'])  AND empty($_SESSION['pass'] )){
    header("location:login.php");  
} 

?>
<div class="header--wrapper">
    <h2>LEKUMU.</h2>
    <div class="header--title">
        <h2><?php echo"$title"; ?></h2>
    </div>
    <div class="user--info">
        <div class="logout--box">
            <a href="#" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-logout">Logout</span>
            </a>
        </div>
        <div class="header--name">
            <p><?php echo $_SESSION['karyawan'] ?></p>
        </div>
    </div>
</div>