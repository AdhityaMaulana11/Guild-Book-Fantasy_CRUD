<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='adventurer'"));

if ($_POST) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $race = $_POST['race'];
    $class = $_POST['class'];
    $rank = $_POST['rank'];
    $level = intval($_POST['level']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    $avatar = $data['avatar'];
    if ($_FILES['avatar']['name']) {
        $target = '../assets/uploads/' . time() . '_' . $_FILES['avatar']['name'];
        move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
        $avatar = basename($target);
    }

    $sql = "UPDATE users SET name='$name', race='$race', class='$class', `rank`='$rank', level=$level, bio='$bio', avatar='$avatar' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Petualang - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-900 to-purple-950 text-white p-10 font-serif">

<h1 class="text-5xl font-bold text-yellow-300 mb-10 text-center drop-shadow-lg">✏️ Edit Petualang</h1>

<form method="post" enctype="multipart/form-data" class="bg-yellow-900/80 border-4 border-yellow-600 p-8 rounded-3xl shadow-2xl max-w-3xl mx-auto space-y-6 backdrop-blur">

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-1 font-bold">🏷️ Nama Petualang</label>
            <input name="name" value="<?= $data['name'] ?>" required class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🌍 Ras</label>
            <input name="race" value="<?= $data['race'] ?>" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">⚔️ Kelas</label>
            <input name="class" value="<?= $data['class'] ?>" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🎖️ Rank</label>
            <input name="rank" value="<?= $data['rank'] ?>" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">📊 Level</label>
            <input type="number" name="level" value="<?= $data['level'] ?>" class="w-full p-3 rounded-xl text-black">
        </div>

        <div>
            <label class="block mb-1 font-bold">🖼️ Avatar Baru (opsional)</label>
            <input type="file" name="avatar" accept="image/*" class="text-white">
        </div>
    </div>

    <div>
        <label class="block mb-1 font-bold">📜 Bio Singkat</label>
        <textarea name="bio" class="w-full p-3 rounded-xl text-black"><?= $data['bio'] ?></textarea>
    </div>

    <div class="flex justify-center gap-4 pt-6">
        <button class="bg-blue-700 hover:bg-blue-800 px-8 py-3 rounded-xl shadow-lg text-lg font-bold">💾 Update</button>
        <a href="index.php" class="bg-gray-700 hover:bg-gray-800 px-8 py-3 rounded-xl shadow-lg text-lg font-bold">↩️ Kembali</a>
    </div>

</form>

</body>
</html>
