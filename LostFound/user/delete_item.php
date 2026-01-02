<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = (int)$_GET['id'];

/* DELETE ONLY OWN ITEM */
mysqli_query($conn,"
    DELETE FROM items 
    WHERE id='$id' AND user_id='$user_id'
");

header("Location: my_reports.php");
exit;
