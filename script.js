const currentPath = window.location.pathname;
var currentHref = window.location.href;
const liKaryawan = document.getElementById('li_karyawan');
const lidashboard = document.getElementById('li_dashboard');
const lisupplier = document.getElementById('li_supplier');
const liproduk = document.getElementById('li_produk');
const SubMenu_produk = document.getElementById('SubMenu_produk');
const SubMenu_StockIn = document.getElementById('SubMenu_stock_in');
const SubMenu_kategori = document.getElementById('SubMenu_kategori');
const penjualan = document.querySelector('#li_penjualan');
const record = document.getElementById('li_record');
const popbox = document.getElementById('popbox');
const btn_edit = document.querySelectorAll('.edit_penjualan');
const grup_edit = document.querySelectorAll('.grupEdit');
const grup_action = document.querySelectorAll('.grupAction');
const cencelEdit = document.querySelectorAll('.cencelEdit');


function updateNavClass(activeTabId) {
    
    lidashboard.classList.toggle('active', activeTabId === 'dashboard');
    liKaryawan.classList.toggle('active', activeTabId === 'karyawan');
    lisupplier.classList.toggle('active', activeTabId === 'supplier');
    liproduk.classList.toggle('active', activeTabId === 'produk' || activeTabId === 'stock_in' || activeTabId === 'kategori');
    SubMenu_produk.classList.toggle('active', activeTabId === 'produk');
    SubMenu_StockIn.classList.toggle('active', activeTabId === 'stock_in');
    SubMenu_kategori.classList.toggle('active', activeTabId === 'kategori');
    penjualan.classList.toggle('active', activeTabId ===  'penjualan');
    record.classList.toggle('active', activeTabId ===  'record');
    
}
function updateKaryawanClass() {
    
    if (currentPath.includes('karyawan.php')) {
        updateNavClass('karyawan');
    } else if (currentPath.includes('index.php')) {
        updateNavClass('dashboard');
    } else if (currentPath.includes('supplier.php')) {
        updateNavClass('supplier');
    } else if (currentPath.includes('produk.php')) {
        updateNavClass('produk');
    } else if (currentPath.includes('stock_in.php')) {
        updateNavClass('stock_in');
    } else if (currentPath.includes('kategori.php')) {
        updateNavClass('kategori');
    } else if (currentPath.includes('penjualan.php')) {
        updateNavClass('penjualan');
    } else if (currentPath.includes('record.php')||currentPath.includes('recordAdmin.php')) {
        updateNavClass('record');
    }
}

document.addEventListener('DOMContentLoaded', updateKaryawanClass);

window.addEventListener('popstate', function (event) {
    if (event.state) {
        updateKaryawanClass();
    }
});


function pop_up(){
    popbox.style.visibility = "visible";
}

function close_pop(){
    popbox.style.visibility = "hidden";
}

function showWarning(Message) {
    var popbox = document.getElementById("popbox");
    popbox.style.visibility = "visible";
    var continueButton = document.querySelector(".pop-content a.button");
    continueButton.classList.add("invisible");
    let text = document.getElementById('text_warning');
        text.innerHTML = Message;
}

function showConfirmationDelete(id) {
    var popbox = document.getElementById("popbox");
    popbox.style.visibility = "visible";
    var continueButton = document.querySelector(".pop-content a.button");
    continueButton.classList.remove("invisible");
    if (currentPath.includes('produk.php')) {
        continueButton.href = "logic/delete.php?delete_produk=" + id;
    }else if(currentPath.includes('kategori.php')){
        continueButton.href = "logic/delete.php?delete_kategori=" + id;
    }else if(currentPath.includes('supplier.php')){
        continueButton.href = "logic/delete.php?delete_supplier=" + id;
    }else if(currentPath.includes('karyawan.php')){
        continueButton.href = "logic/delete.php?delete_karyawan=" + id;
    }else if(currentPath.includes('stock_in.php')){
        let text = document.getElementById('text_warning');
        text.innerHTML = "penghapusan akan berdampak pada table produk,apa anda yakin?";
        continueButton.href = "logic/delete.php?delete_stock_in=" + id;
    }else if(currentPath.includes('penjualan.php')){
        let text = document.getElementById('text_warning');
        text.innerHTML = "anda yakin ingin menghapus data?";
        continueButton.href = "logic/delete.php?delete_penjualan=" + id;
    }
}

function showConfirmationEdit(id) {
    var popbox = document.getElementById("popbox");
    popbox.style.visibility = "visible";
    var continueButton = document.querySelector(".pop-content a.button");
    continueButton.classList.remove("invisible");

    if(currentPath.includes('karyawan.php')){
        continueButton.href = "input_component/input_karyawan.php?edit_karyawan=" + id;
    }
    else{
    continueButton.href = "input_component/input_produk.php?edit_produk=" + id;
    }
}

function confirmDeleteAll() {
    var popbox = document.getElementById("popbox");
    popbox.style.visibility = "visible";
    var continueButton = document.querySelector(".pop-content a.button");
    continueButton.classList.remove("invisible");
    let text = document.getElementById('text_warning');
        text.innerHTML = "anda yakin ingin mengapus semuah data?";
    continueButton.addEventListener('click',function(){
        document.getElementById("deleteForm").submit();
    })
    
}

function logout(){
    if(confirm('anda ingin logout?') == true){
        location.href = "logic/logout.php";
    }
}

// belom kelar men
function validateInput() {
    var password = document.getElementById('password');
    if (password.value.length < 8) {
        password.focus();
    }else{

    }
}

if (currentHref.includes('karyawan.php?error')) {
    alert("akun sedang dipakai");
} 

function onChangeProduk() {
    let selection = document.querySelector("#selection_product");
    let selectionOption = selection.options[selection.selectedIndex];
    let harga = selectionOption.getAttribute("harga");
    let stok = selectionOption.getAttribute("stok");
    
    let hargaProduk = document.querySelector("#hargaProduk");
    let stokProduk = document.querySelector("#stokProduk");
    hargaProduk.value = "RP. " + harga;
    stokProduk.value = stok;
}


function cheking_penjualan() {

    const button = document.querySelector("#submitBtn");
    let jumlahProduk = document.querySelector("#jumlahProduk") ;
    let stokProduk = document.querySelector("#stokProduk").value ;
    let nilaiJumlahProduk = parseInt(jumlahProduk.value);
    let nilaiSelect = document.querySelector("#selection_product").value;
    let border_select = document.querySelector("#tambahPenjualan > div > div:nth-child(1) > div > div.card-body > div.search_select_box > div")
    button.disabled = true; 
    button.innerText = "Processing...";
    
     stokProduk = parseInt(stokProduk);
    if (nilaiSelect == "" ) {
        showWarning("silahkan input barang")
        button.disabled = false; 
        button.innerText = "Masukan ke Transaksi";
        border_select.style.border = "1px solid red";
    }else if(  jumlahProduk.value == "" || nilaiJumlahProduk <= 0 ) {
        showWarning("input jumlah pembelian produk kosong atau tidak benar")
        button.disabled = false; 
        button.innerText = "Masukan ke Transaksi";
        jumlahProduk.style.border = "1px solid red";
        jumlahProduk.focus();
    }else if( nilaiJumlahProduk > stokProduk ) {
        showWarning("stok produk kurang");
        button.disabled = false; 
        button.innerText = "Masukan ke Transaksi";
    }else{
        document.querySelector("#tambahPenjualan").submit()
    }
}

function cekDataPenjualan(){
    let btnBayar = document.querySelector("#btnBayar") ;
    let btnTagihan = document.querySelector("#btnTagihan"); 
    let btnPembeli = document.querySelector("#btnPembeli"); 
    let dataPenjualan = document.querySelector("#checkDataPenjualan") ;
    let dataCostumer = document.querySelector("#checkDataCostumer") ;
    let btnModalPembeli = document.querySelector(".btnModalPembeli") ;
    let btnInputPembeli = document.querySelector(".btnInputPembeli") ;
    let grupInfoPembeli = document.querySelectorAll(".grupInfoPembeli") ;
     // Periksa apakah nilai dari input tidak ada atau kosong
    
     if (!dataPenjualan.value) {
       btnBayar.classList.add("invisible");
       btnTagihan.classList.add("invisible");
       btnPembeli.classList.add("invisible");
    } else {
        btnBayar.classList.remove("invisible");
        btnTagihan.classList.remove("invisible");
        btnPembeli.classList.remove("invisible");
    }
    if(!dataCostumer.value){
        btnTagihan.classList.add("invisible");
        btnBayar.classList.add("invisible");
        btnInputPembeli.innerHTML = "Simpan";
        btnModalPembeli.innerHTML = "Input pembeli";
        grupInfoPembeli.forEach(element => {
            element.classList.add("invisible"); // Ganti "namaClassBaru" dengan class yang ingin ditambahkan
        });
    }else{
        btnPembeli.innerHTML = "Edit Pembeli"
        btnTagihan.classList.remove("invisible");
        btnBayar.classList.remove("invisible");
        btnInputPembeli.innerHTML = "edit";
        btnModalPembeli.innerHTML = "edit pembeli";
        grupInfoPembeli.forEach(element => {
            element.classList.remove("invisible"); // Ganti "namaClassBaru" dengan class yang ingin ditambahkan
        });
    }

}

function showFormPembayaran(){
    let form_pembayaran = document.querySelector('#form-pembayaran');
    form_pembayaran.classList.toggle('invisible');
}

function oneclick(){
    this.disabled = true;
    this.style.pointerEvents='none'; 
    this.innerHTML = 'Processing...';
}