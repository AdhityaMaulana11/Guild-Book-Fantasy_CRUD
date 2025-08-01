<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='adventurer'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Petualang - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-900 to-purple-950 text-white p-10 font-serif">

<h1 class="text-5xl font-bold text-yellow-300 mb-12 text-center drop-shadow-lg">🧝‍♂️ Profil Petualang</h1>

<div class="max-w-2xl mx-auto bg-yellow-900/80 border-4 border-yellow-700 p-10 rounded-3xl shadow-2xl flex flex-col items-center backdrop-blur">

    <div class="relative">
        <img src="../assets/uploads/<?= $data['avatar'] ?: 'default.png' ?>" class="w-40 h-40 rounded-full object-cover border-4 border-yellow-500 shadow-lg">
        <div class="absolute -bottom-3 right-0 bg-yellow-700 text-black px-3 py-1 rounded-full text-sm font-bold">Lv. <?= $data['level'] ?></div>
    </div>

    <h2 class="text-3xl font-extrabold text-yellow-300 mt-6 mb-2"><?= htmlspecialchars($data['name']) ?></h2>
    <p class="text-lg mb-1">🌍 <span class="text-yellow-200">Ras:</span> <?= $data['race'] ?: '-' ?></p>
    <p class="text-lg mb-1">⚔️ <span class="text-yellow-200">Kelas:</span> <?= $data['class'] ?: '-' ?></p>
    <p class="text-lg mb-1">🎖️ <span class="text-yellow-200">Rank:</span> <?= $data['rank'] ?: '-' ?></p>

    <div class="mt-6 bg-yellow-800/70 border-2 border-yellow-600 p-6 rounded-xl text-center max-w-xl">
        <h3 class="text-xl font-bold text-yellow-300 mb-2">📜 Bio Singkat</h3>
        <p class="italic text-white/80">"<?= $data['bio'] ?: 'Tidak ada catatan khusus tentang petualang ini.' ?>"</p>
    </div>

    <div class="mt-8">
        <a href="index.php" class="bg-gray-700 hover:bg-gray-800 px-8 py-3 rounded-xl shadow-lg text-lg font-bold">↩️ Kembali ke Daftar</a>
    </div>

</div>

</body>
</html>
