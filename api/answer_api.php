<?php 
require_once("../require/common.php");
require_once("../config/db.php");
require_once("../config/answer_db.php");
require_once ("../require/user_authentication.php");
header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);
var_dump($data);
exit();

$answer_result = save_answer($mysqli, )


?>