<?php
require_once("./common.php");
session_start();
session_destroy();
unset($_COOKIE['id']);

header("Refresh: 0; url=$base_url");
exit();
?>