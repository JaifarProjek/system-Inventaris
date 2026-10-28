<?php
require 'config.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }

$pesan = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars(trim($_POST['nama_barang']));
    $kategori = htmlspecialchars(trim($_POST['kategori']));
    $jumlah = filter_var($_POST['jumlah'], FILTER_SANITIZE_NUMBER_INT);
    $harga = filter_var($_POST['harga'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (empty($nama) || empty($kategori) || empty($jumlah) || empty($harga)) {
        $pesan = "Semua field harus diisi!";
    } elseif ($jumlah < 1 || $harga < 1) {
        $pesan = "Jumlah dan Harga harus lebih dari 0!";
    } else {
        $query = "INSERT INTO barang (nama_barang, kategori, jumlah, harga) VALUES ('$nama', '$kategori', '$jumlah', '$harga')";
        if (mysqli_query($conn, $query)) {
            header("Location: index.php");
            exit;
        } else {
            $pesan = "Gagal menyimpan data!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <title><?= $lang['add'] ?> - <?= $lang['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border-t-4 border-green-600">
        <h2 class="text-2xl font-bold mb-6 text-gray-800"><?= $lang['add'] ?></h2>
        
        <?php if($pesan): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm">
                <?= $pesan ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-1"><?= $lang['name'] ?></label>
                <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-1"><?= $lang['category'] ?></label>
                <input type="text" name="kategori" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div class="flex space-x-4">
                <div class="w-1/3">
                    <label class="block text-gray-700 text-sm font-bold mb-1"><?= $lang['qty'] ?></label>
                    <input type="number" name="jumlah" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div class="w-2/3">
                    <label class="block text-gray-700 text-sm font-bold mb-1"><?= $lang['price'] ?> (Rp)</label>
                    <input type="number" name="harga" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none">
                </div>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="submit" class="w-1/2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition"><?= $lang['save'] ?></button>
                <a href="index.php" class="w-1/2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center transition"><?= $lang['cancel'] ?></a>
            </div>
        </form>
    </div>
</body>
</html>