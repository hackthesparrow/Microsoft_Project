<?php
session_start();
include "../config/db.php";

/* ADMIN AUTH CHECK (SAME AS DASHBOARD) */
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

/* DELETE LOST ITEM */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM items WHERE id='$id' AND item_type='Lost'");
    header("Location: lost_items.php");
    exit;
}

/* FETCH ALL LOST ITEMS */
$q = mysqli_query($conn,"
    SELECT items.*, users.name, users.email
    FROM items
    JOIN users ON items.user_id = users.id
    WHERE items.item_type='Lost'
    ORDER BY items.reported_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin - Lost Items</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins;
    background:#0f2027;
    color:#fff;
    padding:30px;
}
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}
.back-btn{
    padding:8px 18px;
    background:#00e5ff;
    color:#000;
    text-decoration:none;
    border-radius:20px;
    font-weight:600;
}
.back-btn:hover{background:#00bcd4}
.card{
    background:#1e293b;
    padding:20px;
    border-radius:14px;
    margin-bottom:15px;
}
.actions{
    margin-top:10px;
}
.delete-btn{
    background:#ff4d4d;
    color:#fff;
    padding:6px 14px;
    border-radius:16px;
    text-decoration:none;
    font-size:13px;
}
.delete-btn:hover{background:#ff2e2e}
small{opacity:.85}
</style>
</head>

<body>

<div class="top-bar">
    <h2>📌 All Lost Items</h2>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<?php if(mysqli_num_rows($q)==0){ ?>
    <p>No lost items reported yet.</p>
<?php } ?>

<?php while($row=mysqli_fetch_assoc($q)){ ?>
<div class="card">
    <h3><?= htmlspecialchars($row['item_name']) ?></h3>
    <p><?= htmlspecialchars($row['description']) ?></p>
    <small>
        👤 <?= htmlspecialchars($row['name']) ?> (<?= $row['email'] ?>)<br>
        📍 <?= htmlspecialchars($row['location']) ?> |
        📞 <?= htmlspecialchars($row['contact']) ?><br>
        🕒 <?= $row['reported_at'] ?>
    </small>

    <div class="actions">
        <a class="delete-btn"
           href="lost_items.php?delete=<?= $row['id'] ?>"
           onclick="return confirm('Are you sure you want to delete this lost item?')">
           🗑 Delete
        </a>
    </div>
</div>
<?php } ?>

</body>
</html>
