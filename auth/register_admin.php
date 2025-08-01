<?php
require_once '../config/db.php';
require_once 'session.php';
redirectIfNotLoggedIn();

if (!isAdmin()) {
    die("Unauthorized access!");
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = 'admin';

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "⚠️ Username sudah digunakan!";
    } else {
        $sql = "INSERT INTO users (username, password, role, name) VALUES ('$username', '$password', '$role', '$name')";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../dashboard.php?success=1");
            exit;
        } else {
            $error = "⚠️ Pendaftaran admin gagal!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Admin - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-yellow-900 to-orange-900 text-white font-serif">

<div class="bg-gradient-to-br from-purple-800 to-purple-900 p-8 rounded-xl shadow-2xl w-96">
    <h2 class="text-3xl mb-6 font-bold text-center text-yellow-300">🏅 Tambah Admin</h2>

    <?php if (isset($error)) : ?>
        <div class="text-red-400 mb-4 text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" class="space-y-4">
        <input type="text" name="username" placeholder="Nama Pengguna" required class="w-full p-2 rounded text-black">
        <input type="password" name="password" placeholder="Kata Sandi" required class="w-full p-2 rounded text-black">
        <input type="text" name="name" placeholder="Nama Admin" required class="w-full p-2 rounded text-black">
        
        <button name="register" class="w-full bg-yellow-700 hover:bg-yellow-800 p-2 rounded text-lg">Daftar Admin</button>
        
        <a href="../dashboard.php" class="block mt-4 text-center text-yellow-300 font-semibold">← Kembali ke Dashboard</a>
    </form>
</div>

</body>
</html>
