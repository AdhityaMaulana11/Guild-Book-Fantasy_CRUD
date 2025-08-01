<?php
require_once 'auth/session.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GuildBook Fantasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-900 to-black text-white flex flex-col items-center justify-center font-serif">

    <h1 class="text-5xl font-extrabold mb-4 text-yellow-400 drop-shadow-lg">🏰 GuildBook Fantasi</h1>
    <p class="mb-8 text-center max-w-xl text-lg italic">Tempat berkumpulnya para petualang sejati! Gabung, ambil misi, taklukkan monster, dan ukir namamu di sejarah.</p>

    <div class="flex space-x-4">
        <a href="auth/login.php" class="bg-indigo-700 hover:bg-indigo-800 px-6 py-2 rounded shadow text-lg">⚔️ Masuk Guild</a>
        <a href="auth/register.php" class="bg-green-700 hover:bg-green-800 px-6 py-2 rounded shadow text-lg">🧙‍♂️ Daftar Petualang</a>
    </div>

</body>
</html>
