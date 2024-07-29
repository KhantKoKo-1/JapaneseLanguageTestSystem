<?php
$authenticated = false;
$found_cookie  = false;
$user_id = '';

if (isset($_COOKIE['id'])) {
    $user_id = $_COOKIE['id'];
    $found_cookie = true;
}

$auth_sql = "SELECT user_id,role FROM `users` WHERE `user_id` = '$user_id' AND deleted_at IS NULL AND deleted_by IS NULL";
$auth_result = $mysqli->query($auth_sql);
while ($auth_row = $auth_result->fetch_assoc()) {
    if ($auth_row['user_id']) {
        $authenticated = true;
        if ($auth_row['role'] == $admin_role) {
            $url = $admin_base_url . 'dashboard/';
        }
        else if ($auth_row['role'] == $user_role) {
            $url = $user_base_url . 'user.php';
        }
    }
}

if ($authenticated) {
    header("Refresh: 0; url=$url");
    exit();
}