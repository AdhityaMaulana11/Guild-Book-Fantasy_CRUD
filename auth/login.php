<?php
require_once '../config/db.php';
require_once 'session.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "⚠️ Password salah!";
        }
    } else {
        $error = "⚠️ Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Masuk Guild - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-purple-900 to-indigo-900 text-white font-serif">

<div class="bg-gradient-to-br from-yellow-800 to-yellow-900 p-8 rounded-xl shadow-2xl w-96">
    <h2 class="text-3xl mb-6 font-bold text-center text-yellow-300">⚔️ Masuk Guild</h2>

    <?php if (isset($error)) : ?>
        <div class="text-red-400 mb-4 text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" class="space-y-4">
        <input type="text" name="username" placeholder="Nama Pengguna" required class="w-full p-2 rounded text-black">
        <input type="password" name="password" placeholder="Kata Sandi" required class="w-full p-2 rounded text-black">
        
        <button name="login" class="w-full bg-green-700 hover:bg-green-800 p-2 rounded text-lg">Masuk</button>
        
        <p class="mt-4 text-center text-sm">Belum bergabung? <a href="register.php" class="text-yellow-400 font-semibold">Daftar Petualang</a></p>
    </form>
</div>

</body>
</html>
