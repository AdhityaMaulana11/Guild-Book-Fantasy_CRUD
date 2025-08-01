<?php
require_once '../config/db.php';
require_once '../auth/session.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Unauthorized");

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM monsters WHERE id=$id");
header("Location: ../dashboard.php");
exit;
?>
