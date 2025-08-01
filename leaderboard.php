<?php
require_once 'config/db.php';
require_once 'auth/session.php';

$sql = "
    SELECT u.name, u.rank, u.level, COUNT(q.id) AS quests_completed, SUM(q.reward) AS total_reward
    FROM users u
    JOIN quest_log l ON u.id = l.adventurer_id
    JOIN quests q ON l.quest_id = q.id
    WHERE l.status = 'Completed' AND u.role = 'adventurer'
    GROUP BY u.id
    ORDER BY quests_completed DESC, total_reward DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-800 to-yellow-950 text-white p-10 font-serif">

    <h1 class="text-4xl font-bold text-center text-yellow-300 mb-10">🏆 Papan Kehormatan GuildBook Fantasi</h1>

    <div class="max-w-4xl mx-auto space-y-6">
        <?php 
        $rank = 1;
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()): 
        ?>
            <div class="bg-yellow-900/80 border border-yellow-700 p-6 rounded-xl shadow-xl flex items-center justify-between hover:scale-105 transition transform">
                
                <div class="flex items-center space-x-4">
                    <div class="text-4xl font-bold text-yellow-400">#<?= $rank++ ?></div>
                    <div>
                        <div class="text-xl font-bold"><?= htmlspecialchars($row['name']) ?></div>
                        <div class="text-sm text-white/80">🎖️ <?= $row['rank'] ?> | 🔥 Level <?= $row['level'] ?></div>
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-green-300 font-semibold">✔️ <?= $row['quests_completed'] ?> Quest</div>
                    <div class="text-yellow-200">💰 <?= $row['total_reward'] ?> Gold</div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-white/60">Belum ada petualang yang layak dicatat dalam papan kehormatan...</p>
        <?php endif; ?>
    </div>

    <div class="mt-10 text-center">
        <a href="dashboard.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-6 py-2 rounded shadow">⬅ Kembali ke Guild</a>
    </div>

</body>
</html>
