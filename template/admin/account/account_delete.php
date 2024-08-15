<?php
require_once("../../../require/common.php");
require_once("../../../config/db.php");
require_once ("../../../require/admin_authentication.php");

$user_id = (int)$_GET['user_id'];
$auth_id = isset($_SESSION['admin']['user_id'])             // Check if admin user_id is set in session
    ? $_SESSION['admin']['user_id']                         // If yes, assign admin user_id
    : (isset($_SESSION['user']['user_id'])                  // If no, check if regular user_id is set in session
        ? $_SESSION['user']['user_id']                      // If yes, assign regular user_id
        : (isset($_COOKIE['id'])                            // If no, check if id is set in cookie
            ? $_COOKIE['id']                                // If yes, assign id from cookie
            : null                                          // If none of the above, assign null
          )
      );
$date = date('Y-m-d H:i:s');

$sql = "UPDATE `users` SET 
        `deleted_at` = '$date',
        `deleted_by` = '$auth_id'
        WHERE `user_id` = '$user_id'";
 $result = $mysqli->query($sql);

 if($result) {
    $url =  $admin_base_url . "account/account_list.php?msg=delete";
    header("Refresh: 0; url=$url");
    exit();
 } else {
    $url =  $admin_base_url . "account/account_list.php?err=delete";
    header("Refresh: 0; url=$url");
    exit();
 }
?>