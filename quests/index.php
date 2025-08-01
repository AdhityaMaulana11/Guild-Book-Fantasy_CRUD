<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();

$query = "SELECT quests.*, monsters.name AS monster_name 
          FROM quests 
          LEFT JOIN monsters ON quests.monster_id = monsters.id";
$result = mysqli_query($conn, $query);

$isAdmin = isAdmin();
$myId = $_SESSION['user_id'];
$myRole = $_SESSION['role'];

$myQuests = [];
if ($myRole === 'adventurer') {
    $logCheck = mysqli_query($conn, "SELECT quest_id, status FROM quest_log WHERE adventurer_id = $myId");
    while ($log = mysqli_fetch_assoc($logCheck)) {
        $myQuests[$log['quest_id']] = $log['status'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🛡️ Papan Misi - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-900 to-yellow-950 text-white p-10 font-serif">

<h1 class="text-5xl font-bold text-center text-yellow-300 mb-12 drop-shadow-lg tracking-widest">📜 Papan Misi GuildBook Fantasi</h1>

<?php if ($isAdmin) : ?>
<div class="text-center mb-10">
    <a href="create.php" class="bg-green-600 hover:bg-green-700 px-8 py-3 rounded-2xl shadow-lg text-lg font-bold tracking-wide">
        ➕ Tambah Misi Baru
    </a>
</div>
<?php endif; ?>

<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">

    <?php while ($q = mysqli_fetch_assoc($result)) : ?>
    <div class="bg-yellow-800/90 border-4 border-yellow-600 p-6 rounded-2xl shadow-2xl flex flex-col justify-between hover:scale-105 transition transform">

        <div class="mb-4">
            <h2 class="text-2xl font-extrabold text-yellow-300 mb-2">🗺️ <?= htmlspecialchars($q['title']) ?></h2>
            <p class="italic text-white/80 mb-4">"<?= htmlspecialchars($q['description']) ?>"</p>

            <div class="space-y-1 text-sm">
                <p>📍 <span class="text-yellow-200">Lokasi:</span> <?= $q['location'] ?></p>
                <p>👹 <span class="text-yellow-200">Monster Target:</span> <?= $q['monster_name'] ?: 'Tidak Ada' ?></p>
                <p>⚔️ <span class="text-yellow-200">Kesulitan:</span> <?= $q['difficulty'] ?></p>
                <p>🎁 <span class="text-yellow-200">Reward:</span> <?= $q['reward'] ?> Gold</p>
                <p>🔒 <span class="text-yellow-200">Status:</span> <?= $q['status'] ?></p>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 mt-auto">

            <?php if ($isAdmin) : ?>
                <a href="edit.php?id=<?= $q['id'] ?>" class="bg-blue-700 hover:bg-blue-800 px-4 py-1 rounded text-sm">✏️ Edit</a>
                <a href="delete.php?id=<?= $q['id'] ?>" onclick="return confirm('Hapus misi ini?')" class="bg-red-700 hover:bg-red-800 px-4 py-1 rounded text-sm">🗑️ Hapus</a>
            <?php endif; ?>

            <?php if ($myRole === 'adventurer') : ?>
                <?php if (isset($myQuests[$q['id']]) && $myQuests[$q['id']] === 'In Progress') : ?>
                    <a href="complete.php?id=<?= $q['id'] ?>" class="bg-green-600 hover:bg-green-700 px-4 py-1 rounded text-sm">✅ Selesaikan</a>
                <?php elseif (!isset($myQuests[$q['id']]) && $q['status'] === 'Available') : ?>
                    <a href="take.php?id=<?= $q['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 px-4 py-1 rounded text-sm text-black font-bold">🎒 Ambil Misi</a>
                <?php elseif (isset($myQuests[$q['id']]) && $myQuests[$q['id']] === 'Completed') : ?>
                    <span class="text-green-400 font-semibold">✔️ Selesai</span>
                <?php endif; ?>
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
