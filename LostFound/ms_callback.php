<?php
ob_start();
session_start();

require __DIR__ . "/config/ms_config.php";
require __DIR__ . "/config/db.php";

if (!isset($_GET['code'])) {
    header("Location: login.php");
    exit;
}

/* ================= TOKEN REQUEST ================= */
$token_url = "https://login.microsoftonline.com/common/oauth2/v2.0/token";

$data = [
    "client_id"     => MS_CLIENT_ID,
    "client_secret" => MS_CLIENT_SECRET,
    "grant_type"    => "authorization_code",
    "code"          => $_GET['code'],
    "redirect_uri"  => MS_REDIRECT_URI,
    "scope"         => "openid profile email"
];

$options = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/x-www-form-urlencoded",
        "content" => http_build_query($data)
    ]
];

$response = file_get_contents($token_url, false, stream_context_create($options));
$token = json_decode($response, true);

if (!isset($token['access_token'])) {
    die("Token error");
}

/* ================= USER INFO ================= */
$user = file_get_contents(
    "https://graph.microsoft.com/v1.0/me",
    false,
    stream_context_create([
        "http" => [
            "header" => "Authorization: Bearer " . $token['access_token']
        ]
    ])
);
$user = json_decode($user, true);

/* ================= SESSION SECURITY ================= */
session_regenerate_id(true);

/* ================= BASIC SESSION ================= */
$_SESSION['user_name']  = $user['displayName'];
$_SESSION['user_email'] = $user['mail'] ?? $user['userPrincipalName'];

/* ================= ROLE LOGIC ================= */
/*
 Default = users
 Azure App Role me admin assigned hoga to
 ID token me roles[] aata hai
*/
$_SESSION['user_role'] = 'users';

if (isset($token['id_token'])) {
    $parts = explode('.', $token['id_token']);
    if (count($parts) === 3) {
        $payload = json_decode(
            base64_decode(str_replace(['-','_'], ['+','/'], $parts[1])),
            true
        );
        if (isset($payload['roles']) && in_array('admin', $payload['roles'])) {
            $_SESSION['user_role'] = 'admin';
        }
    }
}

/* ================= AUTO USER CREATE ================= */
$name  = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$role  = $_SESSION['user_role'];

$q = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

if (mysqli_num_rows($q) == 0) {

    // user nahi mila → insert
    mysqli_query(
        $conn,
        "INSERT INTO users (name,email,role)
         VALUES ('$name','$email','$role')"
    );

    // 🔥 INSERT ke baad naya user_id lo
    $_SESSION['user_id'] = mysqli_insert_id($conn);

} else {

    // 🔥 user already hai → uska id lo
    $row = mysqli_fetch_assoc($q);
    $_SESSION['user_id'] = $row['id'];
}


/* ================= DIRECT REDIRECT ================= */
if ($_SESSION['user_role'] === 'admin') {
    header("Location: admin/dashboard.php");
    exit;
} else {
    header("Location: user/dashboard.php");
    exit;
}
