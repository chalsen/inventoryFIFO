<div class="pop-up-container" id="popbox">
    <button class="x_btn" onclick="close_pop()" type="button">
        <span class="x"></span>
        <span class="x"></span>
    </button>
    <div class="pop-content">
        <h4>peringatan!!</h4>
        <p id="text_warning">apakah anda mau mengahpus semua data?</p>
        <a class=" button mb-3 btn " onclick="oneclick.call(this)">lanjutkan</a>
    </div>
</div>
<!-- transaksi  -->
<div class="form_pembayaran mb-4 rounded-3 shadow-sm border-success invisible " id="form-pembeli">
    <div class="card-header py-3">
        <h5 class="my-0 fw-normal">Input Data Pembeli</h5>
        <input type="button" id="checkDataPenjualan" value="<?= isset($data_penjualan[0]) ? 'Data Penjualan Ada' : null; ?>" hidden>
        <input type="button" id="checkDataCostumer" value="<?= isset($data_penjualan[0]['costumer']) ? 'Data Penjualan Ada' : null; ?>" hidden>
    </div>
    <div class="card-body d-flex flex-column justify-content-between">
        <div class="row mb-3 d-flex justify-content-center input-group input-group-lg ">
            <form action="logic/input_logic.php" method="post">
                <div class="mb-3">
                    <div class="mb-3">
                        <p class="mb-0">Customer</p>
                        <input class="form-control w-100 " name="costumer" type="text" placeholder="masukan nama costumer" value="<?= $customer; ?>" required />

                    </div>
                    <div class="mb-3">
                        <p class="mb-0">Toko</p>
                        <input class="form-control w-100 " name="toko" type="text" placeholder="masukan nama Toko" value="<?= $toko; ?>" required />
                    </div>
                    <div class="mb-3">
                        <p class="mb-0">Alamat</p>
                        <input class=" form-control w-100 " name="alamat" style="width: fit-content;" type="text" placeholder="masukan alamat toko" value="<?= $alamat; ?>" required />
                    </div>
                </div>
                <div>
                    <button type="submit" name="simpan_pembeli" value="pembeli" class="btnInputPembeli btn btn-lg btn-success">Simpan</button>
                </div>
            </form>
        </div>
        <div class="text-end">
            <button type="button" onclick=" showFormPembeli()" class="btn btn-lg btn-danger">Batal</button>
        </div>
    </div>
</div>




<div class="form_pembayaran invisible" id="form_bayar">
    <div class="card-header py-3">
        <h5 class="my-0 fw-normal">Pembayaraan</h5>
        <input type="button" id="checkDataPenjualan" value="<?= isset($data_penjualan[0]) ? 'Data Penjualan Ada' : null; ?>" hidden>
        <input type="button" id="checkDataCostumer" value="<?= isset($data_penjualan[0]['costumer']) ? 'Data Penjualan Ada' : null; ?>" hidden>
    </div>
    <div class="card-body">
        <form action="pdf/print.php" method="post" id="bayar">
            <div class="row mb-3">
                <p class="m-0">Total Harga</p>
                <input type="Text" id="totalHarga" value="Rp. <?= $total_harga; ?>" class="form-control" readonly>
            </div>
            <div class="row mb-5">
                <p class="m-0">Pembayaran</p>
                <input type="number" name="pembayaran" id="totalBayar" class="form-control" min="0" placeholder="masukan total uang pembayaran" required>
                <label class="text-danger invisible" id="infoKurang">maaf uang pembayaraan anda kurang</label>
            </div>
            <div class="row">
                <input type="text" name="print_penjualan" value="print_penjualan" hidden>
                <input type="text" name="costumer" value="" id="inputCost" hidden>
                <input type="text" name="toko" value="" id="inputToko" hidden>
                <input type="text" name="alamat" value="" id="inputAlamat" hidden>
                <input type="text" name="id_produk" value="" id="inputAlamat" hidden>
                <input type="text" name="id_penjual" value="" id="inputAlamat" hidden>
                <button type="button" onclick="cekPembayaran()" class="btn btn-success mb-3" id="btnPembayaran">Bayar <i class="fa fa-dollar-sign" id="btnBayar"></i></button>
                <button type="button" onclick="formBayar('close')" class="btn btn-danger">Batal <i class="fa fa-undo"></i></button>
            </div>
        </form>
    </div>

</div>