<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = (int)$_GET['id'];

/* FETCH ITEM (ONLY OWN) */
$q = mysqli_query($conn,"
    SELECT * FROM items 
    WHERE id='$id' AND user_id='$user_id'
");

if(mysqli_num_rows($q)==0){
    die("Invalid request");
}

$item = mysqli_fetch_assoc($q);

/* UPDATE */
if(isset($_POST['update'])){
    $item_name = mysqli_real_escape_string($conn,$_POST['item_name']);
    $location  = mysqli_real_escape_string($conn,$_POST['location']);
    $desc      = mysqli_real_escape_string($conn,$_POST['description']);
    $contact   = mysqli_real_escape_string($conn,$_POST['contact']);

    mysqli_query($conn,"
        UPDATE items SET
        item_name='$item_name',
        location='$location',
        description='$desc',
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
<title>Edit Item</title>
<style>
body{font-family:Poppins;background:#f4f6fb;padding:30px}
.box{max-width:420px;margin:auto;background:#fff;padding:25px;border-radius:14px}
input,textarea{width:100%;padding:10px;margin-top:8px}
button{margin-top:15px;padding:10px 20px}
</style>
</head>
<body>

<div class="box">
<h2>Edit Item (<?= $item['item_type']; ?>)</h2>

<form method="POST">
    <input name="item_name" value="<?= htmlspecialchars($item['item_name']); ?>" required>
    <input name="location" value="<?= htmlspecialchars($item['location']); ?>" required>
    <textarea name="description" required><?= htmlspecialchars($item['description']); ?></textarea>
    <input name="contact" value="<?= htmlspecialchars($item['contact']); ?>" required>

    <button name="update">Update</button>
</form>
</div>

</body>
</html>
