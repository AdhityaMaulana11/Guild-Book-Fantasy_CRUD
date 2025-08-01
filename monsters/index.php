<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

$result = mysqli_query($conn, "SELECT * FROM monsters ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Monster - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-black via-red-900 to-black text-white p-8 font-serif">

<h1 class="text-5xl text-center mb-10 font-extrabold text-red-500 drop-shadow-lg">👹 Catatan Monster Guild</h1>

<div class="text-center mb-8">
    <a href="create.php" class="bg-green-700 hover:bg-green-800 px-6 py-3 rounded shadow-lg text-lg">➕ Tambah Monster Baru</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 max-w-7xl mx-auto">
    <?php while ($m = mysqli_fetch_assoc($result)) : ?>
    <div class="bg-gradient-to-br from-red-800 via-black to-red-900 border-4 border-red-700 p-6 rounded-2xl shadow-2xl flex flex-col justify-between hover:scale-105 transition transform">
        
        <h2 class="text-2xl font-extrabold text-red-400 mb-2"><?= htmlspecialchars($m['name']) ?></h2>
        
        <div class="space-y-1 mb-4 text-sm">
            <p>👾 <span class="text-red-300">Jenis:</span> <?= $m['type'] ?></p>
            <p>⚠️ <span class="text-red-300">Level Ancaman:</span> <?= $m['threat_level'] ?></p>
            <p>📍 <span class="text-red-300">Lokasi:</span> <?= $m['location'] ?></p>
            <p>📅 <span class="text-red-300">Ditambahkan:</span> <?= $m['created_at'] ?></p>
        </div>

        <?php if ($m['image']) : ?>
        <img src="../assets/uploads/<?= $m['image'] ?>" alt="Monster Image" class="rounded-lg h-48 w-full object-cover mb-4 shadow-lg">
        <?php endif; ?>

        <div class="flex gap-3">
            <a href="edit.php?id=<?= $m['id'] ?>" class="bg-blue-700 hover:bg-blue-800 px-4 py-1 rounded text-sm">✏️ Edit</a>
            <a href="delete.php?id=<?= $m['id'] ?>" onclick="return confirm('Hapus monster ini?')" class="bg-red-700 hover:bg-red-800 px-4 py-1 rounded text-sm">🗑️ Hapus</a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div class="mt-12 text-center">
    <a href="../dashboard.php" class="bg-yellow-600 hover:bg-yellow-700 px-6 py-2 rounded-lg shadow-lg text-black font-bold">⬅ Kembali ke Dashboard</a>
</div>

</body>
</html>
