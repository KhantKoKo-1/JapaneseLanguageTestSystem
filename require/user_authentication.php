<?php
session_start();
$authenticated = false;
$user_id = '';

if (isset($_SESSION['user']['user_id']) || isset($_SESSION['user']['email'])) {
    $user_id = $_SESSION['user']['user_id'];
}

// elseif (isset($_COOKIE['id'])) {
//     $user_id = $_COOKIE['id'];
// }

$auth_sql = "SELECT COUNT(user_id) AS total FROM `users` WHERE `user_id` = '$user_id' AND role=$user_role AND deleted_at IS NULL AND deleted_by IS NULL";
$auth_result = $mysqli->query($auth_sql);
while ($auth_row = $auth_result->fetch_assoc()) {
    if ($auth_row['total'] > 0) {
        $authenticated = true;
    }
}

if ($authenticated == false) {
    header("Refresh: 0; url=$base_url");
    exit();
}