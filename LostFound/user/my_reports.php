<?php
session_start();
include "../config/db.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* FETCH USER'S LOST + FOUND ITEMS (FIXED ORDER) */
$q = mysqli_query($conn, "
    SELECT * FROM items
    WHERE user_id='$user_id'
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:Poppins,sans-serif;
    background:#f4f6fb;
    padding:20px;
}
.box{
    background:#fff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 15px 30px rgba(0,0,0,0.1);
    max-width:1200px;
    margin:auto;
}
h2{
    text-align:center;
    margin-bottom:20px;
}
.top-links{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}
.top-links a{
    text-decoration:none;
    font-size:14px;
    font-weight:600;
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:left;
    font-size:14px;
}
th{
    background:#f9fafb;
}
.type-lost{
    color:#e74c3c;
    font-weight:600;
}
.type-found{
    color:#2ecc71;
    font-weight:600;
}
.actions a{
    text-decoration:none;
    margin-right:10px;
    font-size:13px;
    font-weight:600;
}
.edit{color:#3498db;}
.delete{color:#e74c3c;}
.back-box{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
}
.empty{
    text-align:center;
    color:#777;
}
</style>
</head>

<body>

<div class="box">

<div class="top-links">
    <div>
        <a href="add_lost.php">➕ Add Lost</a> |
        <a href="add_found.php">➕ Add Found</a>
    </div>
    <a href="../dashboard.php">🏠 Dashboard</a>
</div>

<h2>📄 My Reports</h2>

<table>
<tr>
    <th>#</th>
    <th>Type</th>
    <th>Item Name</th>
    <th>Location</th>
    <th>Description</th>
    <th>Contact</th>
    <th>Action</th>
</tr>

<?php
if(mysqli_num_rows($q) > 0){
    $i = 1;
    while($row = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $i++; ?></td>
    <td class="<?= $row['item_type']=='Lost' ? 'type-lost' : 'type-found'; ?>">
        <?= htmlspecialchars($row['item_type']); ?>
    </td>
    <td><?= htmlspecialchars($row['item_name']); ?></td>
    <td><?= htmlspecialchars($row['location']); ?></td>
    <td><?= htmlspecialchars($row['description']); ?></td>
    <td><?= htmlspecialchars($row['contact']); ?></td>
    <td class="actions">
        <a class="edit" href="edit_item.php?id=<?= $row['id']; ?>">✏️ Edit</a>
        <a class="delete"
           href="delete_item.php?id=<?= $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this item?')">
           🗑 Delete
        </a>
    </td>
</tr>
<?php
    }
}else{
    echo "<tr><td colspan='7' class='empty'>No reports found</td></tr>";
}
?>

</table>

<div class="back-box">
    <button type="button" onclick="history.back()">← Back</button>
</div>

</div>

</body>
</html>
