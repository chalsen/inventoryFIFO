<div class="sidebar">
        <div class="logo">
            <ul class="menu">
                <li  id="li_dashboard">
                    <a href="index.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li id="li_karyawan">
                    <a href="karyawan.php" >
                        <i class="fas fa-user"></i>
                        <span>Karyawan</span>
                    </a>
                </li>
                <li id="li_supplier">
                    <a href="supplier.php">
                        <i class="fas fa-cart-plus"></i>
                        <span>Supplier</span>
                    </a>
                </li>
                <!-- sub menu -->
                <li id="li_produk">
                    <a href="#">
                        <i class="fas fa-box"></i>
                        <span>produk</span>
                        <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="p-0">
                        <li id="SubMenu_stock_in"><a href="stock_in.php"><span>stock Masuk</span></a></li>
                        <li id="SubMenu_produk"><a href="produk.php"><span>list-produk</span></a></li>
                        <li id="SubMenu_kategori"><a href="kategori.php"><span>kategori</span></a></li>
                    </ul>
                </li>
                <li id="li_penjualan">
                    <a href="penjualan.php">
                        <i class="fas fa-tag"></i>
                        <span>penjualan</span>
                    </a>
                </li>
                <li id="li_record">
                    <a href="<?= $_SESSION['level'] ==='admin' ? 'recordAdmin.php' : 'record.php'; ?>">
                        <i class="fas fa-briefcase"></i>
                        <span>record</span>
                    </a>
                </li>
            </ul>
    </div>
</div>

