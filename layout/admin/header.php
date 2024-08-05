<?php

require_once("../../../require/common.php");
require_once("../../../config/db.php");
require_once ("../../../require/authentication.php");

?>

<!doctype html>
<html class="no-js" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <!-- <meta name="description" content="Sufee Admin - HTML5 Admin Template"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/css/custom_style.css">
    <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'> -->
    <link href="<?php echo $base_url;?>assets/admin/pnotify.all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/css/sweetalert/sweetalert.min.css">

    
</head>

<body>