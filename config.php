<?php
session_start();

// 1. KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_inventaris";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. PENGATURAN DUAL BAHASA
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = in_array($_GET['lang'], ['id', 'en']) ? $_GET['lang'] : 'id';
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'id';
}

// Kamus Terjemahan
$teks = [
    'id' => [
        'title' => 'Sistem Inventaris',
        'login_title' => 'Silakan Masuk',
        'login' => 'Masuk',
        'username' => 'Nama Pengguna',
        'password' => 'Kata Sandi',
        'add' => 'Tambah Barang',
        'name' => 'Nama Barang',
        'category' => 'Kategori',
        'qty' => 'Jumlah',
        'price' => 'Harga',
        'action' => 'Aksi',
        'edit' => 'Ubah',
        'delete' => 'Hapus',
        'save' => 'Simpan',
        'cancel' => 'Batal',
        'logout' => 'Keluar',
        'switch_lang' => 'English',
        'lang_code' => 'en',
        'empty' => 'Belum ada data barang.'
    ],
    'en' => [
        'title' => 'Inventory System',
        'login_title' => 'Login',
        'login' => 'Login',
        'username' => 'Username',
        'password' => 'Password',
        'add' => 'Add Item',
        'name' => 'Item Name',
        'category' => 'Category',
        'qty' => 'Quantity',
        'price' => 'Price',
        'action' => 'Action',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'logout' => 'Logout',
        'switch_lang' => 'Indonesia',
        'lang_code' => 'id',
        'empty' => 'No items found.'
    ]
];

$lang = $teks[$_SESSION['lang']];
?>