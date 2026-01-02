<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: my_reports.php");
    exit;
}

$id = intval($_GET['id']);

/* Fetch report */
$q = mysqli_query($conn, "
    SELECT * FROM items 
    WHERE id='$id' AND user_id='$user_id'
");

if (mysqli_num_rows($q) == 0) {
    header("Location: my_reports.php");
    exit;
}

$data = mysqli_fetch_assoc($q);

/* Update */
if (isset($_POST['update'])) {
    $item_name   = mysqli_real_escape_string($conn, $_POST['item_name']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $contact     = mysqli_real_escape_string($conn, $_POST['contact']);

    mysqli_query($conn, "
        UPDATE items SET
            item_name='$item_name',
            location='$location',
            description='$description',
            contact='$contact'
        WHERE id='$id' AND user_id='$user_id'
    ");

    header("Location: my_reports.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit <?= $data['item_type']; ?> Item</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<style>
body{font-family:Poppins;background:#f4f6fb;padding:30px;}
.box{max-width:420px;margin:auto;background:#fff;padding:25px;border-radius:14px;}
input,textarea{width:100%;padding:10px;margin:8px 0;}
button{width:100%;padding:12px;background:#3498db;color:#fff;border:none;}
</style>
</head>

<body>
<div class="box">
<h3>Edit <?= $data['item_type']; ?> Item</h3>

<form method="POST">
    <input type="text" name="item_name" value="<?= $data['item_name']; ?>" required>
    <input type="text" name="location" value="<?= $data['location']; ?>" required>
    <textarea name="description" required><?= $data['description']; ?></textarea>
    <input type="text" name="contact" value="<?= $data['contact']; ?>" required>

    <button type="submit" name="update">Update</button>
</form>
</div>
</body>
</html>
