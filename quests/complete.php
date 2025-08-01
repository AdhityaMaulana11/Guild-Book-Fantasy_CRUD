<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();

if ($_SESSION['role'] !== 'adventurer') die("Unauthorized");

$quest_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Update quest log & status
mysqli_query($conn, "UPDATE quest_log SET status='Completed', date_completed=NOW() WHERE adventurer_id=$user_id AND quest_id=$quest_id AND status='In Progress'");
mysqli_query($conn, "UPDATE quests SET status='Completed' WHERE id=$quest_id");

header("Location: index.php");
exit;
?>
