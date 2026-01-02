<?php
session_start();
include "config/db.php";

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pass  = $_POST['password'];

    $q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' LIMIT 1");

    if(mysqli_num_rows($q)==1){
        $row = mysqli_fetch_assoc($q);

        if(password_verify($pass, $row['password'])){
            
            // ✅ SESSION SET3
            $_SESSION['user_id']      = $row['id'];
            $_SESSION['user_email']   = $row['email'];
            $_SESSION['user_role']    = $row['role'];
            $_SESSION['display_name'] = $row['display_name'];

            // ✅ ROLE BASED REDIRECT
            if($row['role'] == 'admin'){
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit;

        } else {
            echo "Wrong password";
        }
    } else {
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Microsoft Login | Campus Lost & Found</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:#fff;
}
.login-box{
    width:100%;
    max-width:420px;
    background:rgba(255,255,255,0.12);
    padding:40px;
    border-radius:20px;
    backdrop-filter:blur(12px);
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
    text-align:center;
}
.login-box h2{
    margin-bottom:10px;
}
.login-box p{
    opacity:0.85;
    margin-bottom:25px;
    font-size:14px;
}
.ms-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    background:#ffffff;
    color:#000;
    padding:14px;
    border-radius:30px;
    font-weight:600;
    text-decoration:none;
    transition:all 0.35s ease;
    position:relative;
    overflow:hidden;
}
.ms-btn:hover{
    background:#000000;
    color:#ffffff;
    transform:translateY(-3px) scale(1.02);
    box-shadow:0 14px 30px rgba(0,0,0,0.35);
}
.ms-btn:active{
    transform:scale(0.96);
    box-shadow:0 6px 15px rgba(0,0,0,0.4);
}
.ms-btn::before{
    content:"";
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,0.25),
        transparent
    );
    transition:0.6s;
}
.ms-btn:hover::before{
    left:100%;
}
.ms-btn img{
    width:22px;
    filter:invert(0);
    transition:0.3s;
}
.ms-btn:hover img{
    filter:invert(1);
}

.back{
    margin-top:20px;
}
.back a{
    color:#fff;
    opacity:0.8;
    text-decoration:none;
}
.back a:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>Campus Lost & Found</h2>
    <p>Sign in using your campus Microsoft account</p>

    <a class="ms-btn" href="ms_login.php">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg">
        Sign in with Microsoft
    </a>

    <div class="back">
        <a href="index.php">← Back to Home</a>
    </div>
</div>

</body>
</html>
