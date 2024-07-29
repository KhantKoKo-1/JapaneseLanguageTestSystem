<?php

function count_user($mysqli)
{
    $sql = "SELECT * FROM `users` WHERE `deleted_by` IS NULL ORDER BY `user_id` DESC";
    $result = $mysqli->query($sql);
    $num_row = 0;
    if ($result) {
        $num_row = $result->num_rows;
    }
    return $num_row;
}

function get_all_users($mysqli, $user_id)
{
    $sql = "SELECT * FROM `users` WHERE `user_id` != '$user_id' AND `deleted_by` IS NULL";
    $result = $mysqli->query($sql);
    return $result;
}

function get_user_by_email($mysqli, $email, $id = '')
{
    $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `user_id` != '$id' AND `deleted_by` IS NULL";
    $result = $mysqli->query($sql);

    return $result->fetch_assoc();
}

function get_user_by_id($mysqli, $user_id)
{
    $sql = "SELECT * FROM `users` WHERE `user_id` = '$user_id' AND `deleted_by` IS NULL";
    $result = $mysqli->query($sql);

    return $result->fetch_assoc();
}

function save_user($mysqli, $name, $email, $hash_password, $role = 1 ,$created_by = 1)
{
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `users`(`name`,`email`,`password`, `role`, `created_by`, `created_at`) VALUES ('$name','$email','$hash_password',$role,$created_by,'$currentDateTime')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_user_password($mysqli, $hash_password, $updated_by , $id)
{
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "UPDATE `users` SET `password` = '$hash_password', `updated_by`='$updated_by',`updated_at`='$currentDateTime' WHERE `user_id`= $id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_user_info($mysqli, $name, $email, $role, $updated_by , $id)
{
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "UPDATE `users` SET `name` = '$name',`email` = '$email',`role` = $role, `updated_by`='$updated_by',`updated_at`='$currentDateTime' WHERE `user_id`= $id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

