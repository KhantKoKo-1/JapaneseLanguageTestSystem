<?php 
require_once("../require/common.php");
require_once("../config/db.php");
require_once("../config/answer_db.php");
require_once ("../require/user_authentication.php");
header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

$answer_result = save_answer($mysqli, $data, $user_id);

if ($answer_result) {
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} else {
    echo json_encode([
        'status' => 'fail',
        'message' => "fail save answer!"
    ]);
}

?>