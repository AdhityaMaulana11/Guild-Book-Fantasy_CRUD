<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM monsters WHERE id=$id"));

if ($_POST) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $threat_level = intval($_POST['threat_level']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $image = $data['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/" . $image);
    }

    $sql = "UPDATE monsters SET name='$name', type='$type', threat_level=$threat_level, location='$location', image='$image' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Monster - GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-black via-red-900 to-black text-white p-8 font-serif">

<div class="max-w-2xl mx-auto bg-gradient-to-br from-red-900 via-black to-red-800 p-8 rounded-2xl shadow-2xl border-4 border-red-700">

    <h1 class="text-4xl text-center text-red-400 font-extrabold mb-8 drop-shadow-lg">✏️ Edit Monster</h1>

    <form method="post" enctype="multipart/form-data" class="space-y-6">

        <div>
            <label class="block mb-1">📝 Nama Monster</label>
            <input name="name" value="<?= $data['name'] ?>" required class="w-full p-3 rounded text-black">
        </div>

        <div>
            <label class="block mb-1">👾 Jenis Monster</label>
            <input name="type" value="<?= $data['type'] ?>" required class="w-full p-3 rounded text-black">
        </div>

        <div>
            <label class="block mb-1">⚠️ Level Ancaman</label>
            <select name="threat_level" class="w-full p-3 rounded text-black">
                <option value="1" <?= $data['threat_level']==1?'selected':'' ?>>🟢 Rendah</option>
                <option value="2" <?= $data['threat_level']==2?'selected':'' ?>>🟡 Sedang</option>
                <option value="3" <?= $data['threat_level']==3?'selected':'' ?>>🟠 Tinggi</option>
                <option value="4" <?= $data['threat_level']==4?'selected':'' ?>>🔴 Ekstrem</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">📍 Lokasi Kemunculan</label>
            <input name="location" value="<?= $data['location'] ?>" required class="w-full p-3 rounded text-black">
        </div>

        <div>
            <label class="block mb-1">🖼️ Ganti Gambar (Opsional)</label>
            <input type="file" name="image" accept="image/*" class="w-full p-3 rounded text-black">

            <?php if ($data['image']) : ?>
            <img src="../assets/uploads/<?= $data['image'] ?>" class="mt-4 rounded-lg h-48 w-full object-cover shadow-lg">
            <?php endif; ?>
        </div>

        <div class="flex justify-between mt-8">
            <a href="index.php" class="bg-gray-700 hover:bg-gray-800 px-6 py-2 rounded shadow-lg">⬅ Kembali</a>
            <button class="bg-blue-700 hover:bg-blue-800 px-6 py-2 rounded font-bold">💾 Update</button>
        </div>

    </form>
</div>

</body>
</html>
