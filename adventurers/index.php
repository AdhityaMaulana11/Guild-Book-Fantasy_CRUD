<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'adventurer'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Petualang - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-purple-900 to-black text-white p-10 font-serif">

<h1 class="text-5xl font-bold text-center text-yellow-300 mb-12 drop-shadow-lg tracking-wider">🧝‍♂️ Daftar Petualang Guild</h1>

<?php if (isAdmin()): ?>
<div class="text-center mb-10">
    <a href="create.php" class="bg-green-700 hover:bg-green-800 px-8 py-3 rounded-xl shadow-lg text-lg font-bold tracking-wide">
        ➕ Rekrut Petualang Baru
    </a>
</div>
<?php endif; ?>

<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">

<?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div class="bg-indigo-800/90 border-4 border-indigo-600 p-6 rounded-2xl shadow-2xl flex flex-col items-center hover:scale-105 transition transform space-y-3">

        <img src="../assets/uploads/<?= $row['avatar'] ?: 'default.png' ?>" class="w-28 h-28 rounded-full object-cover border-4 border-yellow-500 shadow-lg mb-3">

        <h2 class="text-2xl font-extrabold text-yellow-300 text-center"><?= htmlspecialchars($row['name']) ?></h2>

        <div class="text-center text-white/90 space-y-1 text-sm">
            <p>🧬 <span class="text-yellow-200">Ras:</span> <?= $row['race'] ?></p>
            <p>⚔️ <span class="text-yellow-200">Kelas:</span> <?= $row['class'] ?></p>
            <p>🎖️ <span class="text-yellow-200">Rank:</span> <?= $row['rank'] ?> | <span class="text-yellow-200">Level:</span> <?= $row['level'] ?></p>
        </div>

        <?php if ($row['bio']) : ?>
        <p class="italic text-white/70 text-center mt-2">"<?= htmlspecialchars($row['bio']) ?>"</p>
        <?php endif; ?>

        <div class="flex flex-wrap justify-center gap-3 mt-4">
            <a href="profile.php?id=<?= $row['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-1 rounded text-sm font-bold">🔍 Profil</a>
            
            <?php if (isAdmin()): ?>
            <a href="edit.php?id=<?= $row['id'] ?>" class="bg-blue-700 hover:bg-blue-800 px-4 py-1 rounded text-sm">✏️ Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus petualang ini?')" class="bg-red-700 hover:bg-red-800 px-4 py-1 rounded text-sm">🗑️ Hapus</a>
            <?php endif; ?>
        </div>

    </div>
<?php endwhile; ?>

</div>

<div class="mt-16 flex justify-center">
    <a href="../dashboard.php" class="inline-flex items-center bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 text-yellow-300 px-8 py-3 rounded-2xl shadow-2xl text-lg font-extrabold tracking-wider transition transform hover:scale-105">
        🏰 <span class="ml-2">Kembali ke Guild</span>
    </a>
</div>

</body>
</html>
