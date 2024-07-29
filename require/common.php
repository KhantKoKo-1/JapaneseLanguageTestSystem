<?php

function getBaseURL() {
    // Get the protocol
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";

    // Get the host
    $host = $_SERVER['HTTP_HOST'];

    // Combine them to get the base URL
    $root_base_url = $protocol . $host;

    // Return the base URL
    return $root_base_url;
}

$root_base_url = getBaseURL();

$base_url = $root_base_url . "/" ."JapaneseLanguageTestSystem/";
$user_base_url = $root_base_url . "/" ."JapaneseLanguageTestSystem/template/user/";
$admin_base_url = $root_base_url . "/" ."JapaneseLanguageTestSystem/template/admin/";
$SHA_KEY  = "Aht2";
date_default_timezone_set('Asia/Yangon');
$admin_enable_status = 0;
$admin_disable_status = 1;
$user_role = 1;
$admin_role = 0;