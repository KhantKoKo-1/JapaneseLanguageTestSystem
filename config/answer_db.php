<?php

function get_answers_by_answer_no($mysqli, $answer_no) {
    $sql = "SELECT
                q.description,
                CASE 
                    WHEN ans.is_correct = 0 THEN 'WRONG'
                    ELSE 'RIGHT'
                END AS status,
                lev.level_name,
                typ.type_name
            FROM 
                answers AS ans
            LEFT JOIN 
                questions AS q ON q.question_id = ans.question_id  
            LEFT JOIN 
                level AS lev ON q.level_id = lev.level_id  
            LEFT JOIN 
                type AS typ ON q.type_id = typ.type_id  
            WHERE 
                ans.answer_no = '$answer_no' 
                AND ans.deleted_by IS NULL 
                AND q.deleted_by IS NULL
                AND lev.deleted_by IS NULL
                AND typ.deleted_by IS NULL";

    $result = $mysqli->query($sql);
    return $result;
}

function get_all_answers_info($mysqli) {
    $sql = "SELECT 
                ans.answer_no,
                MIN(ans.answer_date) AS first_answer_date,
                SUM(ans.score) AS total_score,
                SUM(q.score) AS total_questions_score,
                user.email
            FROM 
                answers AS ans
            LEFT JOIN 
                questions AS q ON q.question_id = ans.question_id  
            LEFT JOIN 
                users AS user ON user.user_id = ans.user_id  
            WHERE 
                ans.deleted_by IS NULL
            GROUP BY 
                ans.answer_no, user.email";

    $result = $mysqli->query($sql);
    return $result;
}

function save_answer($mysqli, $answer_data, $created_by) {
    $currentDateTime = date('Y-m-d H:i:s');
    $answer_date     = $answer_data['answer_date']; 
    $answer_no       = $answer_data['answer_no']; 
    $question_id     = intval($answer_data['question_id']);
    $score           = intval($answer_data['score']);
    $start_time      = $answer_data['start_time'];
    $end_time        = $answer_data['end_time'];
    $is_correct      = $answer_data['is_correct'];
    $created_by      = intval($created_by);
    
    $sql = "INSERT INTO `answers` (`answer_no`, `answer_date`, `start_time`, `end_time`, `is_correct`, `score`, `question_id`, `user_id`, `created_by`, `created_at`) 
            VALUES ('$answer_no', '$currentDateTime', '$start_time', '$end_time', '$is_correct', $score, '$question_id', '$created_by', '$created_by', '$currentDateTime')";
    if($mysqli->query($sql)){
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
    return false;
}

?>