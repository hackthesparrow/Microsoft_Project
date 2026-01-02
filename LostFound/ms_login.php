<?php
require __DIR__ . "/config/ms_config.php";

$scope = "openid profile email";

$auth_url =
"https://login.microsoftonline.com/common/oauth2/v2.0/authorize?" .
"client_id=" . MS_CLIENT_ID .
"&response_type=code" .
"&redirect_uri=" . urlencode(MS_REDIRECT_URI) .
"&response_mode=query" .
"&scope=" . urlencode($scope);

header("Location: $auth_url");
exit;
