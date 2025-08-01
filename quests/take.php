<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();

if ($_SESSION['role'] !== 'adventurer') die("Unauthorized");

$quest_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Cek apakah sudah pernah ambil
$cek = mysqli_query($conn, "SELECT * FROM quest_log WHERE adventurer_id=$user_id AND quest_id=$quest_id");
if (mysqli_num_rows($cek) === 0) {
    mysqli_query($conn, "INSERT INTO quest_log (adventurer_id, quest_id, status, date_taken) VALUES ($user_id, $quest_id, 'In Progress', NOW())");
    mysqli_query($conn, "UPDATE quests SET status='In Progress' WHERE id=$quest_id");
}

header("Location: index.php");
exit;
?>
