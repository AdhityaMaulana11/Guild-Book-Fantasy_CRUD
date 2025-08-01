<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM quests WHERE id=$id"));
$monsters = mysqli_query($conn, "SELECT * FROM monsters");

if ($_POST) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = $_POST['location'];
    $difficulty = $_POST['difficulty'];
    $reward = intval($_POST['reward']);
    $monster_id = $_POST['monster_id'] ?: 'NULL';

    $sql = "UPDATE quests SET title='$title', description='$description', location='$location', difficulty='$difficulty', reward=$reward, monster_id=$monster_id WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Misi - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-900 to-purple-950 text-white p-10 font-serif flex flex-col items-center justify-center">

<div class="bg-yellow-800/90 border-4 border-yellow-700 p-8 rounded-2xl shadow-2xl max-w-lg w-full">
    <h1 class="text-3xl font-bold mb-6 text-yellow-300 text-center">✏️ Edit Misi Guild</h1>

    <form method="post" class="space-y-4">
        <input name="title" value="<?= $data['title'] ?>" placeholder="Judul Misi" required class="w-full p-3 rounded bg-yellow-100 text-black placeholder-gray-600">
        
        <textarea name="description" placeholder="Deskripsi Misi" class="w-full p-3 rounded bg-yellow-100 text-black placeholder-gray-600"><?= $data['description'] ?></textarea>
        
        <input name="location" value="<?= $data['location'] ?>" placeholder="Lokasi" class="w-full p-3 rounded bg-yellow-100 text-black placeholder-gray-600">
        
        <select name="difficulty" class="w-full p-3 rounded bg-yellow-100 text-black">
            <option value="Easy" <?= $data['difficulty']=='Easy'?'selected':'' ?>>Mudah</option>
            <option value="Medium" <?= $data['difficulty']=='Medium'?'selected':'' ?>>Sedang</option>
            <option value="Hard" <?= $data['difficulty']=='Hard'?'selected':'' ?>>Sulit</option>
            <option value="Epic" <?= $data['difficulty']=='Epic'?'selected':'' ?>>Epik</option>
        </select>
        
        <input type="number" name="reward" value="<?= $data['reward'] ?>" placeholder="Reward (Gold)" class="w-full p-3 rounded bg-yellow-100 text-black">

        <select name="monster_id" class="w-full p-3 rounded bg-yellow-100 text-black">
            <option value="">Tanpa Monster</option>
            <?php while ($m = mysqli_fetch_assoc($monsters)) : ?>
                <option value="<?= $m['id'] ?>" <?= $data['monster_id']==$m['id']?'selected':'' ?>><?= $m['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <div class="flex justify-between mt-8">
            <a href="index.php" class="flex items-center bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transition transform hover:scale-105">
                ⬅️ <span class="ml-2">Kembali</span>
            </a>
            
            <button class="flex items-center bg-gradient-to-r from-blue-700 to-blue-900 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-2 rounded-lg shadow-lg transition transform hover:scale-105">
                🎯 <span class="ml-2">Update Misi</span>
            </button>
        </div>

    </form>
</div>

</body>
</html>
