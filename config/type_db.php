<?php

function get_all_types($mysqli)
{
    $sql = "SELECT * FROM `type` WHERE `deleted_at` IS NULL ORDER BY `type_id` DESC";
    $result = $mysqli->query($sql);
    return $result;
}

function get_type_by_id($mysqli, $type_id)
{
    $type_id = intval($type_id);
    $sql = "SELECT * FROM `type` WHERE `type_id`= $type_id AND `deleted_by` IS NULL";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_type_by_name($mysqli, $type_name, $type_id)
{
    $type_id = intval($type_id);
    $sql = "SELECT * FROM `type` WHERE `type_name`= '$type_name' AND `type_id` != $type_id AND `deleted_by` IS NULL ORDER BY `type_id` DESC";
    $result = $mysqli->query($sql);
    if ($result) return $result->fetch_assoc();
}

function update_type($mysqli, $type_name, $updated_by, $type_id)
{
    $type_id = intval($type_id);
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "UPDATE `type` SET `type_name`='$type_name', `updated_by`='$updated_by',`updated_at`='$currentDateTime' WHERE `type_id`= $type_id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}


function save_type($mysqli, $name, $created_by){
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `type`(`type_name`, `created_by`, `created_at`) VALUES ('$name', $created_by, '$currentDateTime')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_type($mysqli, $c_id)
{
    $sql = "DELETE FROM `type`  WHERE `c_id`=$c_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}