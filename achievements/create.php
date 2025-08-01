<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

$adventurers = mysqli_query($conn, "SELECT * FROM users WHERE role='adventurer'");
$quests = mysqli_query($conn, "SELECT * FROM quests");

if ($_POST) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $adventurer_id = intval($_POST['adventurer_id']);
    $quest_id = intval($_POST['quest_id']);
    $verified = isset($_POST['verified']) ? 1 : 0;

    $sql = "INSERT INTO achievements (title, description, adventurer_id, quest_id, date_awarded, verified) 
            VALUES ('$title', '$description', $adventurer_id, $quest_id, NOW(), $verified)";
    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pencapaian - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-900 to-purple-950 text-white p-8 font-serif">

<div class="max-w-xl mx-auto bg-yellow-800/90 border-4 border-yellow-600 p-8 rounded-2xl shadow-2xl">

    <h1 class="text-4xl text-center text-yellow-300 font-extrabold mb-8 drop-shadow-lg">➕ Tambah Pencapaian Petualang</h1>

    <form method="post" class="space-y-6">

        <div>
            <label class="block mb-1">🏅 Judul Pencapaian</label>
            <input name="title" placeholder="Contoh: Penakluk Naga Hitam" required class="w-full p-3 rounded text-black">
        </div>

        <div>
            <label class="block mb-1">📝 Deskripsi</label>
            <textarea name="description" placeholder="Deskripsi singkat..." required class="w-full p-3 rounded text-black"></textarea>
        </div>

        <div>
            <label class="block mb-1">🧝‍♂️ Pilih Petualang</label>
            <select name="adventurer_id" required class="w-full p-3 rounded text-black">
                <option value="">-- Pilih Petualang --</option>
                <?php while ($a = mysqli_fetch_assoc($adventurers)) : ?>
                    <option value="<?= $a['id'] ?>"><?= $a['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label class="block mb-1">🗺️ Dari Misi</label>
            <select name="quest_id" required class="w-full p-3 rounded text-black">
                <option value="">-- Pilih Misi --</option>
                <?php while ($q = mysqli_fetch_assoc($quests)) : ?>
                    <option value="<?= $q['id'] ?>"><?= $q['title'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="verified" class="text-black">
            <span>Terverifikasi</span>
        </div>

        <div class="flex justify-between mt-8">
            <a href="index.php" class="bg-gray-700 hover:bg-gray-800 px-6 py-2 rounded shadow-lg">⬅ Kembali</a>
            <button class="bg-green-700 hover:bg-green-800 px-6 py-2 rounded font-bold">💾 Simpan</button>
        </div>

    </form>
</div>

</body>
</html>
