<?php
session_start();
include "../config/db.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* FORM SUBMIT */
if (isset($_POST['submit'])) {

    $user_id     = $_SESSION['user_id'];
    $item_name   = mysqli_real_escape_string($conn, $_POST['item_name']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $contact     = mysqli_real_escape_string($conn, $_POST['contact']);

    mysqli_query($conn, "
        INSERT INTO items 
        (user_id, item_type, item_name, location, description, contact)
        VALUES 
        ('$user_id', 'Lost', '$item_name', '$location', '$description', '$contact')
    ");

    header("Location: my_reports.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Lost Item</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:Poppins;
    background:#f4f6fb;
}
.container{
    max-width:420px;
    margin:50px auto;
    background:#fff;
    padding:30px;
    border-radius:14px;
    box-shadow:0 15px 30px rgba(0,0,0,0.12);
}
h2{
    text-align:center;
    margin-bottom:20px;
}
label{
    font-weight:500;
    margin-top:10px;
    display:block;
}
input, textarea{
    width:100%;
    padding:10px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
textarea{
    resize:none;
    height:90px;
}
button{
    width:100%;
    margin-top:18px;
    padding:12px;
    background:#e74c3c;
    border:none;
    color:#fff;
    font-size:15px;
    border-radius:10px;
    cursor:pointer;
}
button:hover{
    background:#c0392b;

}
.back-box{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
}
</style>
</head>

<body>

<div class="container">
    <h2>Report Lost Item</h2>

    <form method="POST">
        <label>Your Name</label>
        <input type="text" name="name" required>

        <label>Item Name</label>
        <input type="text" name="item_name" required>

        <label>Lost Location</label>
        <input type="text" name="location" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Contact</label>
        <input type="text" name="contact" required>

        <button type="submit" name="submit">Submit Lost Item</button>
    </form>
    <button type="button" onclick="history.back()">← Back</button> <a href="../dashboard.php"> </a> 
</div>

</body>
</html>
