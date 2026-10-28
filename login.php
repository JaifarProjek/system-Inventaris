<?php
require 'config.php';

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Data tidak boleh kosong!";
    } else {
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            // FIX: Cek MD5 atau Plain Text agar tidak error lagi!
            if ($row['password'] === md5($password) || $row['password'] === $password) {
                $_SESSION['login'] = true;
                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <title><?= $lang['login'] ?> - <?= $lang['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96 relative border-t-4 border-blue-600">
        <a href="?lang=<?= $lang['lang_code'] ?>" class="absolute top-4 right-4 text-sm text-blue-500 hover:text-blue-700 font-semibold">
            <?= $lang['switch_lang'] ?>
        </a>

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800"><?= $lang['login_title'] ?></h2>
        
        <?php if($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-5 rounded text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2"><?= $lang['username'] ?></label>
                <input type="text" name="username" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2"><?= $lang['password'] ?></label>
                <input type="password" name="password" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full transition duration-200 shadow-md">
                <?= $lang['login'] ?>
            </button>
        </form>
    </div>
</body>
</html>