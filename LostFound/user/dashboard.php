<?php
session_start();

if (
    !isset($_SESSION['user_email']) ||
    $_SESSION['user_role'] !== 'users'
) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    min-height:100vh;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:#fff;
}
.container{
    max-width:1100px;
    margin:auto;
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}
.header h1{
    font-size:26px;
}
.header small{
    opacity:.8;
}
.logout{
    background:#ff4d4d;
    padding:10px 22px;
    border-radius:25px;
    color:#fff;
    text-decoration:none;
    font-size:14px;
}
.logout:hover{
    background:#ff2e2e;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:25px;
}
.card{
    background:rgba(255,255,255,0.15);
    padding:25px;
    border-radius:20px;
    transition:.3s;
}
.card:hover{
    transform:translateY(-6px);
}
.card i{
    font-size:32px;
    color:#00e5ff;
    margin-bottom:12px;
}
.card h3{
    margin-bottom:6px;
}
.card p{
    font-size:14px;
    opacity:.85;
}
.card a{
    display:inline-block;
    margin-top:15px;
    padding:10px 20px;
    background:#fff;
    color:#000;
    border-radius:20px;
    text-decoration:none;
    font-size:14px;
}
.card a:hover{
    background:#000;
    color:#fff;
}

/* FOOTER */
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
        <h1>User Dashboard</h1>
        <small>
            Welcome, <?php echo $_SESSION['user_name']; ?><br>
            <?php echo $_SESSION['user_email']; ?>
        </small>
    </div>
    <a href="../logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>

<!-- DASHBOARD OPTIONS -->
<div class="cards">

    <div class="card">
        <i class="fa-solid fa-magnifying-glass"></i>
        <h3>Report Lost Item</h3>
        <p>Submit details of a lost item.</p>
        <a href="report_lost.php">Open</a>
    </div>

    <div class="card">
        <i class="fa-solid fa-box-open"></i>
        <h3>Report Found Item</h3>
        <p>Report an item you found.</p>
        <a href="report_found.php">Open</a>
    </div>

    <div class="card">
        <i class="fa-solid fa-clipboard-list"></i>
        <h3>My Reports</h3>
        <p>View all items you have reported.</p>
        <a href="my_reports.php">View</a>
    </div>

</div>


<footer>
© <?php echo date("Y"); ?> Campus Lost & Found
</footer>

</div>
</body>
</html>



