<?php
require_once("./common.php");
session_start();
if (isset($_GET['type']) && $_GET['type'] == 'admin' ) {
    unset($_SESSION['admin']) ;
} else {
    unset($_SESSION['user']) ;
}


unset($_COOKIE['id']);

header("Refresh: 0; url=$base_url");
exit();
?>