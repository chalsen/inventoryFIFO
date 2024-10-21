const currentPath = window.location.pathname;
var currentHref = window.location.href;
const liKaryawan = document.getElementById('li_karyawan');
const lidashboard = document.getElementById('li_dashboard');
const lisupplier = document.getElementById('li_supplier');
const liproduk = document.getElementById('li_produk');
const SubMenu_produk = document.getElementById('SubMenu_produk');
const SubMenu_StockIn = document.getElementById('SubMenu_stock_in');
const SubMenu_kategori = document.getElementById('SubMenu_kategori');
const penjualan = document.getElementById('li_penjualan');
const record = document.getElementById('li_record');
const popbox = document.getElementById('popbox');


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

function showConfirmationDelete(id) {
    var popbox = document.getElementById("popbox");
    popbox.style.visibility = "visible";
    var continueButton = document.querySelector(".pop-content a.button");
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
    }
}

function showConfirmationEdit(id) {
    var popbox = document.getElementById("popbox");
    popbox.style.visibility = "visible";
    var continueButton = document.querySelector(".pop-content a.button");

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