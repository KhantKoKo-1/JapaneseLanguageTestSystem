<?php

function get_all_questions($mysqli) {
    $sql = "SELECT 
            q.question_id,
            q.description,
            q.level_id,
            q.type_id,
            lev.level_name,
            typ.type_name 
            FROM questions AS q 
            LEFT JOIN level AS lev ON q.level_id = lev.level_id 
            LEFT JOIN type AS typ ON q.type_id = typ.type_id 
            WHERE q.deleted_by IS NULL
            ORDER BY q.question_id DESC";

    $result = $mysqli->query($sql);
    return $result;
}

function get_question_by_id($mysqli, $question_id) {
    $question_id = intval($question_id);
    $sql = "SELECT 
            q.question_id,
            q.description,
            q.level_id,
            q.type_id
            FROM `questions` AS q 
            WHERE q.question_id = $question_id AND q.deleted_by IS NULL";

    $result = $mysqli->query($sql);
    if ($result) return $result->fetch_assoc();
}

function get_question_by_level_id_and_type_id($mysqli, $level_id, $type_id) {
    $level_id = intval($level_id);
    $type_id  = intval($type_id);
    $sql = "SELECT 
            question_id,
            description,
            level_id,
            type_id
            FROM `questions` 
            WHERE `level_id` = $level_id AND `type_id` = $type_id AND deleted_by IS NULL";

    $result = $mysqli->query($sql);
    return $result;
}

function save_questions($mysqli, $description, $level_id, $type_id, $created_by) {
    $currentDateTime = date('Y-m-d H:i:s');
    $level_id   = intval($level_id);
    $type_id    = intval($type_id);
    $created_by = intval($created_by);
    $sql = "INSERT INTO `questions`(`description`, `level_id`, `type_id`, `created_by`, `created_at`) VALUES ('$description', $level_id, $type_id, $created_by, '$currentDateTime')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function update_questions($mysqli, $question_id, $description, $level_id, $type_id, $updated_by)
{
    $question_id = intval($question_id);
    $level_id    = intval($level_id);
    $type_id     = intval($type_id);
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "UPDATE `questions` SET `description`='$description',`level_id`='$level_id',`type_id`='$type_id', `updated_by`='$updated_by',`updated_at`='$currentDateTime' WHERE `question_id`= $question_id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

?>