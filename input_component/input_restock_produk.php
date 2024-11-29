<?php
include "../component/connection.php";
include "../function.php";

$data_kategori = getAllKategori($connect);
$data_supplier = getAllSupplier($connect);
$data_baku = getAllBaku($connect);
$data_produk = getAllProduct($connect);
$id = "";
$name = "";
$jumlah = "";
$harga = "";
$id_kategori = "";

if (isset($_GET['edit_produk'])) {
    $id = $_GET['edit_produk'];
    $data = getAllDatabyid($connect, "tb_produk", "id_produk", $id);
    $name = $data['nama_produk'];
    $jumlah = $data['jumlah'];
    $harga = $data['harga'];
    $id_kategori = $data['id_kategori'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="input.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <section class="container">
        <header>Input Restock Produk</header>
        <form action="../logic/input_logic.php" method="POST" class="form">
            <div class="input-box" hidden>
                <label>Id produk</label>
                <input name="id_produk" type="number" placeholder="Masukan id produk" value="<?= $id ?>" />
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Nama produk</label>
                    <select name="produk" id="produk">
                        <option selected value="">pilih produk</option>
                        <?php foreach ($data_produk as $tampil) : ?>
                            <option value="<?php echo $tampil['id_produk']; ?>"><?php echo $tampil['nama_produk']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <!-- <input name="nama_produk" type="text" placeholder="Masukkan nama produk" value="<?= $name ?>" required /> -->
                </div>

                <?php if (isset($_GET['edit_produk'])): ?>
                    <div class="input-box">
                        <label>Jumlah produk</label>
                        <input name="jumlah_produk" type="number" placeholder="Masukkan jumlah produk" value="<?= $jumlah ?>" required />
                    </div>
                <?php endif; ?>

                <!-- <div class="input-box">
                    <label>Kategori Produk</label>
                    <select name="kategori">
                        <?php foreach ($data_kategori as $tampil) : ?>
                            <option value="<?php echo $tampil['id_kategori']; ?>" <?php echo ($tampil['id_kategori'] == $id_kategori) ? 'selected' : ''; ?>><?php echo $tampil['kategori']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div> -->

                <!-- <div class="input-box">
                    <label>Bahan Baku</label>
                    <select class="select-baku form-select" name="id_baku[]" multiple="multiple">
                        <?php foreach ($data_baku as $baku) : ?>
                            <option class="option-baku" value="<?= $baku['name'] ?>"><?= $baku['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="customQTY"></div>
                </div> -->
            </div>

            <div class="input-box">
                <label>Jumlah Produk</label>
                <input name="jumlah_produk" id="qty_produk" type="number" placeholder="Masukkan jumlah produk" required />
            </div>

            <div class="input-box">
                <label>Bahan Baku</label>
                <div id="restock-baku"></div>
            </div>
            <!-- <div class="input-box">
                <label>Harga produk</label>
                <input name="harga_produk" type="number" placeholder="Masukkan harga produk" value="<?= $harga ?>" required />
            </div> -->

            <button type="submit" name="submit" value="restock_produk">Submit</button>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#customQTY").empty();
            $(".select-baku").select2({
                allowClear: true
            });

            $("#produk").on('change', function(e) {

                const id = $(this).val();
                $('#restock-baku').empty();
                $("#customQTY").empty();

                $.ajax({
                    url: '../logic/input_logic.php', // Ganti dengan URL PHP Anda
                    type: 'POST',
                    data: {
                        id_product: id,
                        restock_product: 'get_data_baku_by_id_product',
                    },
                    success: function(response) {
                        console.log("Data sent successfully: " + response);
                        const data = JSON.parse(response);
                        // Menyiapkan HTML untuk select box
                        // Menambahkan option berdasarkan stok dan stok_pivot
                        $('#qty_produk').on('input', function(e) {
                            var html = "";
                            e.preventDefault();
                            const qty = parseInt($(this).val(), 10); // Ambil dan konversi qty menjadi integer
                            if (isNaN(qty)) {
                                return; // Jika qty tidak valid, stop proses
                            }
                            // Kosongkan dulu elemen sebelum menambahkan data

                            html += `
                            <select class="select-baku form-select" name="id_baku[]" multiple="multiple">
                        `;
                            data.forEach(e => {
                                const stokPivot = parseInt(e['stok_pivot'], 10);
                                const stok = parseInt(e['stok'], 10);

                                // Hitung stok yang dapat diproses
                                const result = stokPivot * qty;
                                // alert(stokPivot);
                                // Cek apakah hasil perhitungan tidak melebihi stok yang tersedia
                                if (result <= stok) {
                                    html += `
                                
                                    <option class="option-baku" data-stok=${stokPivot} data-qty=${qty} value="${e['id']}">${e['name']} - ${e['stok']}</option>
                                `;
                                } else {
                                    html += `
                                    <option class="option-baku" data-stok=${stokPivot} data-qty=${qty} disabled value="${e['id']}">${e['name']} - ${e['stok']}</option>
                                `;
                                }
                            });

                            html += `
                        </select>
                        <div id="customQTY"></div>
                    `;

                            $("#customQTY").empty();
                            $('#restock-baku').empty();
                            $('#restock-baku').append(html);
                            // Inisialisasi ulang select2 setelah elemen select baru ditambahkan
                            $(".select-baku").select2({
                                // allowClear: true
                            });

                            // Attach select2 events setelah elemen select2 baru diinisialisasi
                            $(".select-baku").on("select2:select", function(e) {
                                const id = e.params.data.id;
                                const name = e.params.data.text;
                                const option = $(this).find(`option[value='${id}']`);
                                const stok = option.data('stok'); // Mengambil data-stok
                                const qty = option.data('qty'); // Mengambil data-qty

                                // alert(stok+" | "+qty);
                                // Cek jika input untuk ID ini belum ada
                                if (!$("#input_" + id).length) {
                                    $("#customQTY").append(
                                        `<div id="input_${id}" class="input-box">
                                        <label>Jumlah ${name}</label>
                                        <input type="hidden" name="cqty[${id}]" value="${qty * stok}" placeholder="Masukkan jumlah untuk ${name}" class="form-control" />
                                    </div>`
                                    );
                                }
                            });

                            $(".select-baku").on("select2:unselect", function(e) {
                                const id = e.params.data.id;
                                // Hapus input yang terkait dengan ID ini
                                $("#input_" + id).remove();
                            });
                        });

                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                    }
                });
            });
        });
    </script>

</body>

</html>