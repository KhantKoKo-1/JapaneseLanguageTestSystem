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
    <link href="<?php echo $base_url?>/assets/user/css/css2.css" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet"
        href="<?php echo $base_url;?>assets/common/css/vendors/font-awesome/css/font-awesome.min.css">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo $base_url?>/assets/user/css/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo $base_url?>/assets/user/css/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo $base_url?>/assets/user/css/bootstrap.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/css/sweetalert/sweetalert.min.css">

    <!-- Template Stylesheet -->
    <link href="<?php echo $base_url?>/assets/user/css/style.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/fonts/google-font.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo $base_url;?>assets/common/images/apple-touch-icon1.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?php echo $base_url;?>assets/common/images/favicon-32x32-1.png">
</head>

<body>