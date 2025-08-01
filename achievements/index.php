<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();

$query = "SELECT achievements.*, users.name AS adventurer_name, quests.title AS quest_title 
          FROM achievements 
          JOIN users ON achievements.adventurer_id = users.id
          JOIN quests ON achievements.quest_id = quests.id";
$result = mysqli_query($conn, $query);

$isAdmin = isAdmin();
?>

<!DOCTYPE html>
<html>
<head>
    <title>🏆 Papan Prestasi - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-800 to-yellow-950 text-white p-10 font-serif">

<h1 class="text-4xl font-bold text-center text-yellow-300 mb-10 drop-shadow-lg">🏅 Papan Prestasi GuildBook Fantasi</h1>

<?php if ($isAdmin) : ?>
<div class="text-center mb-8">
    <a href="create.php" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded shadow text-lg">➕ Tambah Pencapaian</a>
</div>
<?php endif; ?>

<div class="max-w-6xl mx-auto space-y-6">

    <?php 
    $counter = 1;
    if (mysqli_num_rows($result) > 0):
        while ($a = mysqli_fetch_assoc($result)) : 
    ?>
        <div class="bg-yellow-900/80 border border-yellow-700 p-6 rounded-2xl shadow-2xl hover:scale-105 transition transform space-y-4">

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="text-3xl font-bold text-yellow-400">🏅 <?= $counter++ ?></div>
                    <div>
                        <div class="text-xl font-extrabold"><?= htmlspecialchars($a['title']) ?></div>
                        <div class="text-sm text-white/80 italic">"<?= htmlspecialchars($a['description']) ?>"</div>
                    </div>
                </div>
                
                <div class="text-right space-y-1">
                    <div class="text-green-300 font-semibold">✔️ <?= $a['verified'] ? 'Terverifikasi' : 'Belum Diverifikasi' ?></div>
                    <div class="text-yellow-200 text-sm">📅 <?= $a['date_awarded'] ?></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-white/90 bg-yellow-800/50 p-4 rounded-lg">
                <div>🧝‍♂️ <span class="text-yellow-300">Petualang:</span> <?= $a['adventurer_name'] ?></div>
                <div>🗺️ <span class="text-yellow-300">Asal Misi:</span> <?= $a['quest_title'] ?></div>
            </div>

            <?php if ($isAdmin) : ?>
            <div class="text-right">
                <a href="delete.php?id=<?= $a['id'] ?>" onclick="return confirm('Hapus pencapaian ini?')" class="bg-red-700 hover:bg-red-800 px-4 py-1 rounded text-sm">🗑️ Hapus</a>
            </div>
            <?php endif; ?>

        </div>
    <?php endwhile; ?>
    
    <?php else: ?>
        <p class="text-center text-white/60">Belum ada pencapaian tercatat di papan prestasi...</p>
    <?php endif; ?>

</div>

<div class="mt-10 text-center">
    <a href="../dashboard.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-6 py-2 rounded shadow">⬅ Kembali ke Guild</a>
</div>

</body>
</html>
