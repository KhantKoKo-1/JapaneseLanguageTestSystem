<?php

function get_all_questions($mysqli) {
    $sql = "SELECT 
            q.question_id,
            q.description,
            q.level_id,
            q.type_id,
            q.score,
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
            q.type_id,
            q.score
            FROM `questions` AS q 
            WHERE q.question_id = $question_id AND q.deleted_by IS NULL";

    $result = $mysqli->query($sql);
    if ($result) return $result->fetch_assoc();
}

function get_valid_type_id_by_level_id($mysqli, $level_id) {
    $level_id = intval($level_id);
    $sql = "SELECT 
            `type_id`
            FROM `questions` 
            WHERE `level_id` = $level_id AND `deleted_by` IS NULL";

    $result = $mysqli->query($sql);
    return $result;
}

function get_question_by_level_id_and_type_id($mysqli, $level_id, $type_id) {
    $level_id = intval($level_id);
    $type_id  = intval($type_id);
    $sql = "SELECT
            `question_id`,
            `description`,
            `level_id`,
            `type_id`,
            `score`
            FROM `questions` 
            WHERE `level_id` = $level_id 
            AND `type_id` = $type_id 
            AND deleted_by IS NULL
            ORDER BY RAND()"; // This shuffles the results
    
    $result = $mysqli->query($sql);
    return $result;    
}

function get_question_count_by_level_id($mysqli, $level_id) {
    $level_id = intval($level_id);

    $sql = "SELECT COUNT(question_id) AS question_count FROM `questions` WHERE `level_id` = $level_id AND deleted_by IS NULL";

    $result = $mysqli->query($sql);
    
    // Fetch the count from the result set
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['question_count'];
    } else {
        return 0; // Or handle the error as needed
    }
}

function get_question_count_by_type_id($mysqli, $type_id) {
    $type_id = intval($type_id);

    $sql = "SELECT COUNT(question_id) AS question_count FROM `questions` WHERE `type_id` = $type_id AND deleted_by IS NULL";

    $result = $mysqli->query($sql);
    
    // Fetch the count from the result set
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['question_count'];
    } else {
        return 0; // Or handle the error as needed
    }
}

function save_questions($mysqli, $description, $level_id, $type_id, $score, $created_by) {
    $currentDateTime = date('Y-m-d H:i:s');
    $level_id   = intval($level_id);
    $type_id    = intval($type_id);
    $score      = intval($score);
    $created_by = intval($created_by);
    $sql = "INSERT INTO `questions`(`description`, `level_id`, `type_id`, `score`,`created_by`, `created_at`) VALUES ('$description', $level_id, $type_id, $score, $created_by, '$currentDateTime')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function update_questions($mysqli, $question_id, $description, $level_id, $type_id, $score, $updated_by)
{
    $question_id = intval($question_id);
    $level_id    = intval($level_id);
    $type_id     = intval($type_id);
    $score       = intval($score);
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "UPDATE `questions` SET `description`='$description',`level_id`='$level_id',`type_id`='$type_id',`score`='$score', `updated_by`='$updated_by',`updated_at`='$currentDateTime' WHERE `question_id`= $question_id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

?>