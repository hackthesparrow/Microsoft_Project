<?php
session_start();
include "../config/db.php";

/* AUTH CHECK */
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

/* ===== FETCH ADMIN DISPLAY NAME SAFELY ===== */
if (!isset($_SESSION['display_name'])) {
    $email = $_SESSION['user_email'];
    $q = mysqli_query($conn,"SELECT display_name FROM users WHERE email='$email' LIMIT 1");
    $row = mysqli_fetch_assoc($q);
    $_SESSION['display_name'] = $row['display_name'] ?? 'Admin';
}

/* ===== POST ANNOUNCEMENT ===== */
if (isset($_POST['announcement'])) {
    $msg = mysqli_real_escape_string($conn, $_POST['announcement']);
    mysqli_query($conn,"INSERT INTO announcements (message) VALUES ('$msg')");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | Campus Lost & Found</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:#fff;
    min-height:100vh;
}
.container{max-width:1200px;margin:auto;padding:30px}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:45px;
}
.header h1{font-size:28px}
.header small{opacity:.8}
.logout{
    background:#ff4d4d;
    color:#fff;
    padding:10px 24px;
    border-radius:25px;
    text-decoration:none;
}
.logout:hover{background:#ff2e2e}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}
.card{
    background:rgba(255,255,255,0.15);
    padding:28px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.3);
    transition:.3s;
}
.card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 40px rgba(0,0,0,.4);
}
.card i{font-size:32px;color:#00e5ff;margin-bottom:12px}
.card h3{margin-bottom:6px}
.card p{font-size:14px;opacity:.85}
.card a{
    display:inline-block;
    margin-top:15px;
    padding:10px 22px;
    background:#fff;
    color:#000;
    border-radius:20px;
    text-decoration:none;
}
.card a:hover{background:#000;color:#fff}

/* ANNOUNCEMENT */
.section{margin-top:60px}
.box{
    background:rgba(255,255,255,0.15);
    padding:25px;
    border-radius:18px;
}
textarea{
    width:100%;
    min-height:120px;
    padding:14px;
    border:none;
    border-radius:12px;
    outline:none;
}
button{
    margin-top:15px;
    padding:12px 26px;
    border:none;
    border-radius:25px;
    background:#00e5ff;
    font-weight:600;
    cursor:pointer;
}
button:hover{background:#00bcd4}

footer{
    margin-top:60px;
    text-align:center;
    font-size:13px;
    opacity:.7;
}
</style>
</head>

<body>
<div class="container">

<!-- HEADER -->
<div class="header">
    <div>
        <h1>Admin Dashboard</h1>
        <small>
            Welcome, <?php echo htmlspecialchars($_SESSION['display_name']); ?> (Admin)
        </small>
    </div>
    <a href="../logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>

<!-- DASHBOARD CARDS -->
<div class="cards">

    <div class="card">
        <i class="fa-solid fa-magnifying-glass-location"></i>
        <h3>Lost Items</h3>
        <p>View all reported lost items.</p>
        <a href="lost_items.php">Open</a>
    </div>

    <div class="card">
        <i class="fa-solid fa-box-open"></i>
        <h3>Found Items</h3>
        <p>View all found items.</p>
        <a href="found_items.php">Open</a>
    </div>

    <div class="card">
        <i class="fa-solid fa-bullhorn"></i>
        <h3>Announcements</h3>
        <p>Post updates for all users.</p>
        <a href="#announcement">Create</a>
    </div>

    <div class="card">
        <i class="fa-solid fa-user-pen"></i>
        <h3>Edit Profile</h3>
        <p>Change admin display name.</p>
        <a href="edit_profile.php">Edit</a>
    </div>

</div>

<!-- ANNOUNCEMENT -->
<div class="section" id="announcement">
<h2>Post Announcement</h2>
<div class="box">
<form method="post">
<textarea name="announcement" placeholder="Write announcement for all users..." required></textarea>
<button type="submit">
    <i class="fa-solid fa-paper-plane"></i> Publish
</button>
</form>
</div>
</div>

<footer>
© <?php echo date("Y"); ?> Campus Lost & Found | Admin Panel
</footer>

</div>
</body>
</html>
