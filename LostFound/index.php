<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Campus Lost & Found</title>
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
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:#ffffff;
    min-height:100vh;
}
header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 60px;
}
.logo{
    font-size:24px;
    font-weight:700;
}
nav a{
    color:#fff;
    margin-left:20px;
    text-decoration:none;
    font-weight:500;
}
nav a:hover{
    text-decoration:underline;
}

/* HERO */
.hero{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:60px;
    flex-wrap:wrap;
}
.hero-text{
    max-width:600px;
}
.hero-text h1{
    font-size:42px;
    line-height:1.3;
    margin-bottom:20px;
}
.hero-text span{
    color:#38ef7d;
}
.hero-text p{
    font-size:16px;
    opacity:0.9;
    margin-bottom:30px;
}
.btn-group a{
    display:inline-block;
    padding:14px 28px;
    margin-right:15px;
    border-radius:30px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
}
.btn-primary{
    background:#38ef7d;
    color:#000;
}
.btn-primary:hover{
    background:#2ddf6f;
}
.btn-outline{
    border:2px solid #fff;
    color:#fff;
}
.btn-outline:hover{
    background:#fff;
    color:#000;
}

/* ANIMATED IMAGE */
.hero-img{
    max-width:420px;
    margin-top:30px;
}
.hero-img img{
    width:100%;
    animation: float 3s ease-in-out infinite;
}
@keyframes float{
    0%{ transform: translateY(0); }
    50%{ transform: translateY(-15px); }
    100%{ transform: translateY(0); }
}

/* FEATURES */
.section{
    padding:60px;
    text-align:center;
}
.section h2{
    font-size:32px;
    margin-bottom:20px;
}
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
    margin-top:40px;
}
.card{
    background:rgba(255,255,255,0.1);
    padding:30px;
    border-radius:20px;
    backdrop-filter:blur(10px);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-10px);
    background:rgba(255,255,255,0.15);
}

footer{
    text-align:center;
    padding:20px;
    opacity:0.8;
    font-size:14px;
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
    <div class="logo">🎒 Campus Lost & Found</div>
    <nav>
        <a href="login.php">Home</a>
        <a href="login.php">Lost Items</a>
        <a href="login.php">Found Items</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-text">
        <h1>Lost Something on Campus?<br>
        <span>We Help You Find It.</span></h1>

        <p>
        A secure campus platform where students can report,
        search, and recover lost and found items efficiently.
        </p>

        <div class="btn-group">
            <a href="login.php" class="btn-primary">Report Lost Item</a>
            <a href="login.php" class="btn-outline">Report Found Item</a>
        </div>
    </div>

    <!-- ✅ ANIMATED IMAGE BACK -->
    <div class="hero-img">
        <img src="https://cdn-icons-png.flaticon.com/512/4202/4202843.png"
             alt="Campus Lost and Found">
    </div>
</section>

<!-- FEATURES -->
<section class="section">
    <h2>Why Campus Lost & Found?</h2>

    <div class="cards">
        <div class="card">
            <h3>🔍 Easy Search</h3>
            <p>Search lost and found items quickly using smart filters.</p>
        </div>

        <div class="card">
            <h3>⚡ Fast Matching</h3>
            <p>Automatically connects lost items with matching found reports.</p>
        </div>

        <div class="card">
            <h3>🔐 Secure Access</h3>
            <p>Login required to view or submit item reports.</p>
        </div>
    </div>
</section>

<footer>
    © <?php echo date("Y"); ?> Campus Lost & Found | Built for Students
</footer>

</body>
</html>
