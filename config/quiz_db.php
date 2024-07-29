<?php

function get_all_quizzes($mysqli)
{
    $sql = "SELECT * FROM `quiz` WHERE `deleted_by` IS NULL";
    $result = $mysqli->query($sql);
    return $result;
}

function get_quizzes_by_question_id($mysqli, $question_id)
{
    $question_id = intval($question_id);
    $sql = "SELECT `description`,`is_correct` FROM `quiz` WHERE `question_id` = $question_id AND `deleted_by` IS NULL";
    $result = $mysqli->query($sql);
    return $result;
}


// function update_quiz($mysqli, $description, $is_correct, $question_id, $updated_by)
// {
//     $currentDateTime = date('Y-m-d H:i:s');
//     $sql = "UPDATE `quiz` SET `description`='$description', `is_correct`='$is_correct',`question_id`='$question_id',`updated_by`=$updated_by,`updated_at`='$currentDateTime' WHERE `c_id`=$c_id";
//     if ($mysqli->query($sql)) {
//         return true;
//     }
//     return false;
// }

function save_quizzes($mysqli, $description, $is_correct, $question_id, $created_by){
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `quiz`(`description`, `is_correct`, `question_id`, `created_by`, `created_at`) VALUES ('$description', '$is_correct', $question_id, $created_by, '$currentDateTime')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_quiz($mysqli, $question_id)
{
    $question_id = intval($question_id);
    $sql = "DELETE FROM `quiz`  WHERE `question_id`=$question_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
