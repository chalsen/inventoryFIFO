<?php
include "../component/connection.php";
include "../function.php";
$id ="";
$kategori = "";

if(isset($_GET['edit_kategori'])){
    $id = $_GET['edit_kategori'];
    $data = getAllDatabyid($connect,"tb_kategori","id_kategori",$id);
    $kategori =  $data['kategori'];    
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="input.css" />
  </head>
  <body>
    <section class="container">
      <header>Input Data kategori</header>
      <form action="../logic/<?= isset($_GET['edit_kategori']) ? 'edit' : 'input_logic' ?>.php" method="POST" class="form">

        <div class="input-box" hidden>
            <label>Id Kategori</label>
            <input name="id_kategori" type="number" placeholder="Masukan id supplier" value="<?= $id?>"/>
        </div>

        <div class="input-box">
          <label>kategori</label>
          <input name="kategori" type="text" placeholder="Masukan kategori" value="<?= $kategori ?>" required />
        </div>

       <button type="submit" name="submit" value="<?= isset($_GET['edit_kategori']) ? 'edit_kategori' : 'simpan_kategori' ?>" >Submit</button>
      </form>
    </section>
  </body>
</html>