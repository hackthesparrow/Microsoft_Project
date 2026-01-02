<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $item    = mysqli_real_escape_string($conn, $_POST['item_name']);
    $loc     = mysqli_real_escape_string($conn, $_POST['location']);
    $desc    = mysqli_real_escape_string($conn, $_POST['description']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    mysqli_query($conn,"
        INSERT INTO items (user_id,item_type,item_name,location,description,contact)
        VALUES ('$user_id','Found','$item','$loc','$desc','$contact')
    ");

    header("Location: my_reports.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Report Found Item</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:Poppins,sans-serif;
    background:#f4f6fb;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}
.box{
    background:#fff;
    width:100%;
    max-width:450px;
    padding:30px;
    border-radius:14px;
    box-shadow:0 15px 30px rgba(0,0,0,0.1);
}
h2{text-align:center;margin-bottom:20px;}
.group{margin-bottom:15px;}
.group label{display:block;margin-bottom:6px;}
.group input,.group textarea{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
}
button{
    padding:10px 14px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}
.submit-btn{
    width:100%;
    background:#2ecc71;
    color:#fff;
    font-size:16px;
}
.back-box{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
}
</style>
</head>

<body>
<div class="box">

<h2>Report Found Item</h2>

<form method="POST">
    <div class="group">
        <label>Your Name</label>
        <input type="text" name="name" required>
    </div>

    <div class="group">
        <label>Item Name</label>
        <input type="text" name="item_name" required>
    </div>

    <div class="group">
        <label>Found Location</label>
        <input type="text" name="location" required>
    </div>

    <div class="group">
        <label>Description</label>
        <textarea name="description" rows="4" required></textarea>
    </div>

    <div class="group">
        <label>Contact</label>
        <input type="text" name="contact" required>
    </div>

    <button type="submit" name="submit" class="submit-btn">
        Submit Found Item
    </button>
</form>

<div class="back-box">
    <button type="button" onclick="history.back()">← Back</button>
    <a href="../dashboard.php">
        
    </a>
</div>

</div>
</body>
</html>
