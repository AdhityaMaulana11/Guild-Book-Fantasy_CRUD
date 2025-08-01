<?php
require_once 'config/db.php';
require_once 'auth/session.php';
redirectIfNotLoggedIn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-purple-900 to-indigo-950 text-white p-10 font-serif flex flex-col">

    <h1 class="text-5xl font-bold mb-4 text-yellow-300 text-center">🏰 Adventurers Guild</h1>
    <p class="text-center text-lg mb-12">Selamat datang, <span class="text-green-400 font-semibold"><?= $_SESSION['username'] ?></span>! Jelajahi dunia, kelola petualang, dan ukir legenda!</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">

        <?php if (isAdmin()): ?>
        <a href="adventurers/index.php" class="bg-gradient-to-br from-yellow-700 to-yellow-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2">
            <div class="text-4xl">🧝‍♂️</div>
            <div class="font-bold text-xl">Kelola Petualang</div>
        </a>

        <a href="monsters/index.php" class="bg-gradient-to-br from-red-700 to-red-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2">
            <div class="text-4xl">👹</div>
            <div class="font-bold text-xl">Kelola Monster</div>
        </a>

        <a href="auth/register_admin.php" class="bg-gradient-to-br from-purple-700 to-purple-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2">
            <div class="text-4xl">⚔️</div>
            <div class="font-bold text-xl">Tambah Admin</div>
        </a>
        <?php endif; ?>

        <a href="quests/index.php" class="bg-gradient-to-br from-blue-700 to-blue-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2">
            <div class="text-4xl">🗺️</div>
            <div class="font-bold text-xl">Daftar Misi</div>
        </a>

        <a href="achievements/index.php" class="bg-gradient-to-br from-green-700 to-green-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2">
            <div class="text-4xl">🏆</div>
            <div class="font-bold text-xl">Pencapaian</div>
        </a>

        <a href="leaderboard.php" class="bg-gradient-to-br from-pink-700 to-pink-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2">
            <div class="text-4xl">🏅</div>
            <div class="font-bold text-xl">Papan Peringkat</div>
        </a>

        <a href="auth/logout.php" class="bg-gradient-to-br from-gray-700 to-gray-900 p-6 rounded-xl shadow-xl hover:scale-105 transform transition text-center space-y-2 md:col-span-3">
            <div class="text-4xl">🚪</div>
            <div class="font-bold text-xl">Keluar Guild</div>
        </a>
    </div>

    <footer class="mt-16 text-center text-sm text-white/50">
        ⚔️ Semoga perjalananmu penuh kejayaan di GuildBook Fantasi ⚔️
    </footer>

</body>
</html>
