<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

if ($_POST) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $race = $_POST['race'];
    $class = $_POST['class'];
    $rank = $_POST['rank'];
    $level = intval($_POST['level']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    $avatar = null;
    if ($_FILES['avatar']['name']) {
        $target = '../assets/uploads/' . time() . '_' . $_FILES['avatar']['name'];
        move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
        $avatar = basename($target);
    }

    $sql = "INSERT INTO users (username, password, role, name, race, class, `rank`, level, bio, avatar) 
            VALUES ('$username', '$password', 'adventurer', '$name', '$race', '$class', '$rank', $level, '$bio', '$avatar')";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekrut Petualang Baru - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-900 to-purple-950 text-white p-10 font-serif">

<h1 class="text-5xl font-bold text-yellow-300 mb-10 text-center drop-shadow-lg">⚔️ Rekrut Petualang Baru ⚔️</h1>

<form method="post" enctype="multipart/form-data" class="bg-yellow-900/80 border-4 border-yellow-600 p-8 rounded-3xl shadow-2xl max-w-3xl mx-auto space-y-6 backdrop-blur">

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-1 font-bold">🪪 Username</label>
            <input name="username" required class="w-full p-3 rounded-xl text-black">
        </div>
        
        <div>
            <label class="block mb-1 font-bold">🔒 Password</label>
            <input type="password" name="password" required class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🏷️ Nama Petualang</label>
            <input name="name" required class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🌍 Ras (Elf, Human, Orc, dll)</label>
            <input name="race" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">⚔️ Kelas (Mage, Warrior, dll)</label>
            <input name="class" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🎖️ Rank (Novice, Veteran, Epic)</label>
            <input name="rank" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">📊 Level Awal</label>
            <input type="number" name="level" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🖼️ Avatar (opsional)</label>
            <input type="file" name="avatar" accept="image/*" class="text-white">
        </div>
    </div>

    <div>
        <label class="block mb-1 font-bold">📜 Bio Singkat</label>
        <textarea name="bio" class="w-full p-3 rounded-xl text-black" placeholder="Ceritakan latar belakang singkat..."></textarea>
    </div>

    <div class="flex justify-center gap-4 pt-6">
        <button class="bg-green-700 hover:bg-green-800 px-8 py-3 rounded-xl shadow-lg text-lg font-bold">💾 Simpan</button>
        <a href="index.php" class="bg-gray-700 hover:bg-gray-800 px-8 py-3 rounded-xl shadow-lg text-lg font-bold">↩️ Kembali</a>
    </div>

</form>

</body>
</html>
