<?php

require_once("../../require/common.php");
require_once("../../config/db.php");
require_once ("../../require/user_authentication.php");

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
        <link href="<?php echo $base_url?>/assets/user/css/css2.css" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="<?php echo $base_url;?>assets/common/css/vendors/font-awesome/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/> -->
        <!-- <link rel="stylesheet" href="<?php echo $base_url;?>assets/user/vendors/font-awesome/css/font-awesome.min.css"> -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"> -->
        <!-- <link href="<?php echo $base_url?>/assets/user/css/bootstrap-icons.min.css" rel="stylesheet"> -->

        <!-- Libraries Stylesheet -->
        <link href="<?php echo $base_url?>/assets/user/css/animate/animate.min.css" rel="stylesheet">
        <link href="<?php echo $base_url?>/assets/user/css/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="<?php echo $base_url?>/assets/user/css/bootstrap.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/css/sweetalert/sweetalert.min.css">

        <!-- Template Stylesheet -->
        <link href="<?php echo $base_url?>/assets/user/css/style.css" rel="stylesheet">

    </head>

<body>