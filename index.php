<?php
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
    header("Location: index.php");
}

$result = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <title><?= $lang['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold"><?= $lang['title'] ?></h1>
            <div class="space-x-4 text-sm font-medium">
                <a href="?lang=<?= $lang['lang_code'] ?>" class="hover:text-blue-200"><?= $lang['switch_lang'] ?></a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded-md transition text-white">
                    <?= $lang['logout'] ?>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700">Data Inventaris</h2>
            <a href="tambah.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                + <?= $lang['add'] ?>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal border-b">
                        <th class="py-3 px-6 text-center">No</th>
                        <th class="py-3 px-6"><?= $lang['name'] ?></th>
                        <th class="py-3 px-6 text-center"><?= $lang['category'] ?></th>
                        <th class="py-3 px-6 text-center"><?= $lang['qty'] ?></th>
                        <th class="py-3 px-6 text-right"><?= $lang['price'] ?></th>
                        <th class="py-3 px-6 text-center"><?= $lang['action'] ?></th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php $i = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="py-3 px-6 text-center whitespace-nowrap font-medium"><?= $i++; ?></td>
                        <td class="py-3 px-6"><?= htmlspecialchars($row['nama_barang']); ?></td>
                        <td class="py-3 px-6 text-center"><span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs"><?= htmlspecialchars($row['kategori']); ?></span></td>
                        <td class="py-3 px-6 text-center font-bold"><?= htmlspecialchars($row['jumlah']); ?></td>
                        <td class="py-3 px-6 text-right font-medium text-gray-700">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="py-3 px-6 text-center">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="text-blue-500 hover:text-blue-700 mr-2 font-medium"><?= $lang['edit'] ?></a>
                            <a href="index.php?delete=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');" class="text-red-500 hover:text-red-700 font-medium"><?= $lang['delete'] ?></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500 italic"><?= $lang['empty'] ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>