<?php 
require_once("../../require/common.php");
require_once("../../config/db.php");
require_once("../../require/user_authentication.php");
require_once("../../config/type_db.php");
require_once("../../config/level_db.php");
require_once("../../config/question_db.php");
require_once("../../config/quiz_db.php");

$error = false;
if (isset($_GET['level_id']) && isset($_GET['type_id'])) {
    $level_id = $_GET['level_id'];
    $type_id  = $_GET['type_id'];
    $level = get_level_by_id($mysqli, $level_id);
    if ($level == NULL) {
        $error = true;
    }

    $type = get_type_by_id($mysqli, $type_id);
    if ($type == NULL) {
        $error = true;
    }
} else {
    $error = true;
}

if ($error) {
    $url = $base_url . "template/error_pages/404.php";
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
    exit();
} else {
    $questionData = [];

    // Fetch questions based on level and type ID
    $questions = get_question_by_level_id_and_type_id($mysqli, $level_id, $type_id);
    
    while ($question = $questions->fetch_assoc()) {
        $question_id = $question['question_id'];
        $description = $question['description']; // Assuming this field exists
        $score       = $question['score']; // Assuming this field exists
    
        // Fetch quizzes (choices) related to the current question
        $quizzes = get_quizzes_by_question_id($mysqli, $question_id);
        $choices = [];
        $correct_answer_index = 0;
        $i       = 0;
    
        // Collect all choices for the current question
        while ($quiz = $quizzes->fetch_assoc()) {
            $choices[] = $quiz['description'];
            if ($quiz['is_correct'] == True) {
                $correct_answer_index = $i;
            }
            $i++;
        }
    
        $questionData[] = [
            'question_id'=> $question_id,
            'question'   => $description,
            'score'      => $score,
            'choices'    => $choices,
            'answer'     => $correct_answer_index
        ];
    }
    // Encode the array as JSON
    // $jsonQuestions = json_encode($questionData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
}

?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Your Skills</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="<?php echo $base_url?>/assets/user/css/question_style.css" rel="stylesheet">
    <link href="<?php echo $base_url?>/assets/user/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/admin/css/sweetalert/sweetalert.min.css">
</head>

<body>
    <div class="parent-container d-flex justify-content-center" style="height: 90vh;">
        <!-- result sections -->
        <div class="final-result">
            <div id="card">
                <div class="left-result">
                    <h5 style="color:white;">Your Result</h5>
                    <div class="progress">
                        <h1 id="main-score">76 </h1>
                        <!-- <p id="main-of-total"> of 100</p> -->
                    </div>
                    <div class="text">
                        <h2 id="result-text">Great</h2>
                        <p id="result-text-para">you scored higher than 65% of the people who have taken these test</p>
                    </div>
                </div>
                <div class="right-result">
                    <h3>Test Result</h3>
                    <div class="item" style="--i:#4e0fed1f; --j:#2b0785">
                        <i class="fa fa-openid"></i>
                        <h5>Solved Question</h5>
                        <h5 id="solved-ques-no"></h5>
                    </div>
                    <div class="item" style="--i:#0fed341f; --j:#088c06">
                        <i class="fa fa-gavel"></i>
                        <h5>Correct Answer</h5>
                        <h5 id="correct-answer"></h5>
                    </div>
                    <div class="item" style="--i:#d419451f; --j:#ea1123">
                        <i class="fa fa-hacker-news"></i>
                        <h5>Incorrect Answer</h5>
                        <h5 id="incorrect-answer"></h5>
                    </div>
                    <div class="item" style="--i:#d4b2191f; --j:#caa70c">
                        <i class="fa fa-address-card-o"></i>
                        <h5>Final Score</h5>
                        <h5 id="final-score"></h5>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="result-button" id="restart">Restart</button>
                        </div>
                        <div class="col-6">
                            <button class="result-button" id="continue">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- quiz sections -->
        <div class="card mt-4 border border-dark" style="width: 90%;height:90%">
            <div class="card-body">
                <a href="<?php echo $user_base_url ."type.php?level_id=" . $level_id ?>" class="btn btn-danger">Back</a>
                <span class="d-flex justify-content-end">Start Time : <b id="start_time"></b></span>
                
                <div class="row g-5 align-items-center">
                    <div class="quiz">
                        <div id="info">
                            <div id="score">Score : 0</div>
                            <div id="ques-left">Question:1/20</div>
                        </div>
                        <div id="ques-view">

                        </div>
                        <br>
                        <input type="hidden" id="question_id" value="">
                        <div class="question">
                        </div>

                        <div class="choice" id="choiceContainer">
                        </div>
                                <!-- <div class="col-6">

                                <button type="button" class="btn btn-primary btn-lg"ူ
                                </div>
                                <div class="col-6">

                                <button type="button" class="btn btn-primary btn-lg"
                                    style="width: 100%;">Q2</button>
                                </div>
                                <div class="col-6">

                                <button type="button" class="btn btn-primary btn-lg"
                                    style="width: 100%;">Q2</button>
                                </div> -->
                            <!--     -->
                        <!-- </div> -->

                        <div class="ans-btn">
                            <button type="button" class="submit-answer">Submit Answer</button>
                            <a href="#display-final-score" type="button" class="view-results">View Results</a>
                        </div>

                    </div>
                </div>
                    <!-- <div class="final-result">
                        <h1>Your result is</h1>
                        <div class="solved-ques-no">You Solved 10 questions of HTML</div>
                        <div class="right-wrong">3 Were Right and 4 were Wrong</div>
                        <div id="display-final-score">Your Final Score is: 35</div>
                        <div class="remark">Remark: Satisfactory, Keep trying.</div>
                        <button id="restart">Restart Quiz</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    


    <script src="<?php echo $base_url;?>assets/common/js/jquery/jquery-3.7.1.js"></script>
    <script src="<?php echo $base_url?>/assets/user/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url;?>assets/admin/js/sweetalert/sweetalert2.all.min.js"></script>
    <!-- <script src="script.js"></script> -->
</body>
<script>
    let base_url = "<?php echo $base_url; ?>";
    var questions = <?php echo json_encode($questionData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS); ?>;
    
</script>
<script src="<?php echo $base_url . "assets\user\js\question.js"?>"></script>
</html>