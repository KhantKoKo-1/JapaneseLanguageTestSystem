<?php

function get_all_levels($mysqli)
{
    $sql = "SELECT * FROM `level` WHERE `deleted_by` IS NULL ORDER BY `level_id` DESC";
    $results = $mysqli->query($sql);
    return $results;
}

function get_level_by_id($mysqli, $level_id)
{
    $level_id = intval($level_id);
    $sql = "SELECT * FROM `level` WHERE `level_id` = $level_id AND `deleted_by` IS NULL";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

// function get_level_by_name($mysqli, $level_name, $level_id)
// {
//     $level_id = intval($level_id);
//     $sql = "SELECT * FROM `level` WHERE `level_name`= '$level_name' AND `level_id` != $level_id AND `deleted_by` IS NULL";
//     $result = $mysqli->query($sql);
//     if ($result)  return $result->fetch_assoc();
// }

function update_level($mysqli, $level_name, $updated_by, $level_id)
{
    $level_id = intval($level_id);
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "UPDATE `level` SET `level_name`='$level_name', `updated_by`='$updated_by',`updated_at`='$currentDateTime' WHERE `level_id`= $level_id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function save_level($mysqli, $name, $created_by){
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `level`(`level_name`, `created_by`, `created_at`) VALUES ('$name', $created_by, '$currentDateTime')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}
