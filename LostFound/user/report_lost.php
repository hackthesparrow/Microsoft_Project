<?php
session_start();
include "../config/db.php";

/* LOGIN OPTIONAL – dekhne ke liye login zaroori ho */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* 🔥 GLOBAL LOST ITEMS (NO user_id filter) */
$q = mysqli_query($conn,"
    SELECT items.*, users.name
    FROM items
    JOIN users ON items.user_id = users.id
    WHERE items.item_type='Lost'
    ORDER BY items.reported_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Lost Items</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:Poppins;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:#fff;
}
.container{
    max-width:900px;
    margin:40px auto;
    padding:20px;
}

.card{
    background:rgba(255,255,255,0.12);
    padding:18px;
    border-radius:16px;
    margin-bottom:15px;
}
.card h3{margin:0}
.card small{opacity:.8}
.empty{
    opacity:.8;
    text-align:center;
    margin-top:40px;
}
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}
.right{
    display:flex;
    align-items:center;
    gap:12px;
}
.dash-btn{
    background:#38ef7d;
    padding:8px 16px;
    border-radius:20px;
    color:#000;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}
.add-btn{
    background:#ff4d4d;
    padding:10px 22px;
    border-radius:25px;
    color:#fff;
    text-decoration:none;
    font-size:14px;
}
.card{
    background:rgba(255,255,255,0.12);
    padding:18px;
    border-radius:16px;
    margin-bottom:15px;
}
.card h3{margin:0}
.card small{opacity:.8}
.empty{
    opacity:.8;
    text-align:center;
    margin-top:40px;

</style>
</head>

<body>
<div class="container">

<div class="header">
    <h2>Lost Items</h2>

    <div class="right">
        <a href="dashboard.php" class="dash-btn">🏠 Dashboard</a>
        <a href="add_lost.php" class="add-btn">+ Add Lost Item</a>
    </div>
</div>



<?php if(mysqli_num_rows($q)==0){ ?>
    <div class="empty">No lost items reported yet.</div>
<?php } ?>

<?php while($row = mysqli_fetch_assoc($q)){ ?>
<div class="card">
    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
    <p><?php echo htmlspecialchars($row['description']); ?></p>
    <small>
        📍 <?php echo htmlspecialchars($row['location']); ?> |
        📞 <?php echo htmlspecialchars($row['contact']); ?> |
        🕒 <?php echo $row['reported_at']; ?>
    </small>
</div>
<?php } ?>


</div>
</body>
</html>
