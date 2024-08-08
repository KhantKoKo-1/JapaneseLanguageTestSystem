<?php
if (isset($_GET['question_id'])) {
    $title = 'Edit Question Form';
 } else {
    $title = 'Create Question Form';
 }

require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once ("../../../layout/admin/nav.php");
require_once ("../../../config/level_db.php");
require_once ("../../../config/type_db.php");
require_once ("../../../config/question_db.php");
require_once ("../../../config/quiz_db.php");

$levels = get_all_levels($mysqli);
$types  = get_all_types($mysqli);

$description = $level_id = $type_id =  "";
$score = 0;
$description_err = $quizs_err = $type_err = $level_err = $correct_answer_err =  "";
$correct_answer  = [];
$is_correct      = false;    
$quizzes         = [];
$error_message   =  "";
$success_message =  "";
$success         = false;
$error           = false;
$invalid         = false;

if (isset($_GET['question_id'])) {
    $question_id   = $_GET['question_id'];
    $question_data = get_question_by_id($mysqli, $question_id);
    if ($question_data == NULL) {
        $url =  $base_url . "template/error_pages/404.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
        exit();
    }
    $description   =  $question_data['description'];
    $level_id      =  $question_data['level_id'];
    $type_id       =  $question_data['type_id'];
    $score         =  $question_data['score'];
    $quiz_infos    = get_quizzes_by_question_id($mysqli, $question_id);
    $quiz_description = '';
    while ($quiz_info = $quiz_infos->fetch_assoc()) {
        $quizzes[]    = $quiz_info['description'];
        $is_correct   = $quiz_info['is_correct'];
        if ($is_correct) {
            $correct_answer = htmlspecialchars($quiz_info['description']);                                
        }
    }

 } else { 
    $question_id = '';
 }

$quiz_sub_names = ['A', 'B', 'C', 'D'];

if (isset($_POST['Submit'])) {
    $description    = $mysqli->real_escape_string($_POST["description"]);
    $level_id       = $mysqli->real_escape_string($_POST["level_id"]);
    $type_id        = $mysqli->real_escape_string($_POST["type_id"]);
    $score          = $mysqli->real_escape_string($_POST["score"]);
    $quizzes        = isset($_POST["quizzes"]) ? $_POST["quizzes"] : [];
    $correct_answer = isset($_POST["correct_answer"]) ? $_POST["correct_answer"] : '';

    if ($description == "") {
        $description_err = "Please Enter Description!"; 
        $error = true;
    }

    if ($level_id === '0') {
        $level_err = "Please Select Level!"; 
        $error = true;
    }

    if ($type_id === '0') {
        $type_err = "Please Select Type!"; 
        $error = true;
    }

    if (empty($quizzes) || count($quizzes) < 2) {
        $quizs_err = "Please Add 2 or more quizes";
        $error = true;
    } else {
        foreach ($quizzes as $quiz) {
            // Perform additional validation or processing on each quiz if needed
            if (empty($quiz)) {
                // Handle empty quiz case
                $quizs_err = "One or more quizes are empty";
                $error = true;
                break; // Exit the loop if any quiz is empty
            }
        }
    }

    if ($correct_answer == "") {
        $correct_answer_err = "Please Chooice One For Correct Correct Answer!";
        $error = true;
    }

    if ($error == false) {
        try {
            if ($question_id != "") {
                $result = update_questions($mysqli, $question_id, $description, $level_id, $type_id, $score, $user_id);
                if ($result) {
                    foreach ($quizzes as $index => $quiz) {
                        $quiz_delete_res = delete_quiz($mysqli, $question_id);
                        if ($quiz_delete_res) {
                            $success = true; 
                        } else {
                            $success = false;
                        }
                    }

                    if ($success) {
                        foreach ($quizzes as $index => $quiz) {
                            if ($correct_answer[0] == $quiz) {
                                $is_correct = true;
                            } else {
                                $is_correct = false;
                            }
    
                            $quiz_result = save_quizzes($mysqli, $quiz, $is_correct,$question_id, $user_id);
                            if ($quiz_result) {
                                $success = true;
                            } else {
                                $success = false;
                            }
                        }
                    }

                    if ($success) {
                        $url =  $admin_base_url . "questions/question_list.php?msg=edit";
						echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
						exit();
                    } else {
                        $url =  $admin_base_url . "questions/question_list.php?err=edit";
						echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                        exit();
                    }
                }
            } else {
                $result = save_questions($mysqli, $description, $level_id, $type_id, $score, $user_id);
                if ($result) {
                    $last_inserted_id = $mysqli->insert_id;
                    foreach ($quizzes as $index => $quiz) {
                        if ($correct_answer[0] == $quiz) {
                            $is_correct = true;
                        } else {
                            $is_correct = false;
                        }
                        $quiz_result = save_quizzes($mysqli, $quiz, $is_correct,$last_inserted_id, $user_id);
                        if ($quiz_result) {
                            $success = true;
                        } else {
                            $success = false;
                        }
                    }
                    if ($success) {
                        $url =  $admin_base_url . "questions/question_list.php?msg=create";
						echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                        exit();
                    } else {
                        $url =  $admin_base_url . "questions/question_list.php?err=create";
						echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                        exit();
                    }
                }
        }
    }
        catch (Exception $e) {
            // Handle exceptions (e.g., duplicate entry error)
            $error_message = $e->getMessage();
            $invalid = true;
        }
    }
}

?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1><?php echo $title?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="<?php echo $admin_base_url . 'dashboard/' ?>">Dashboard</a></li>
                    <li class="active"><?php echo $title?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row"> -->
<div class="content mt-3">
    <div class="animated fadeIn">
    <?php if ($success) { ?>
        <div class="alert alert-success mx-auto" role="alert">
            <div class="d-flex justify-content-center">
                <?php echo $success_message ?>
            </div>
        </div>
        <?php } ?>
        <?php if ($invalid) { ?>
        <div class="alert  alert-danger alert-dismissible fade show w-75 mx-auto" role="alert">
                <span class="badge badge-pill badge-danger">Error</span>  <?php echo $error_message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <div class="card">
            <form action="" method="post" class="form-horizontal">
                <div class="">
                    <a href="<?php echo $admin_base_url ?>questions/question_list.php" class="btn btn-info btn-sm ml-1 mt-1">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-header d-flex justify-content-center">
                    <strong>Questions &nbsp;</strong> Form
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-2"><label for="description"
                                class="form-control-label">Description</label></div>
                        <div class="col col-md-9"><textarea name="description" id="description" rows="6"
                                placeholder="Content..." class="form-control"
                                value="<?php echo $description; ?>"><?php echo $description; ?></textarea>
                            <!-- <span class="help-block">Please enter your Level Name</span> -->
                            <?php if ($description_err !== '') { ?>
                            <span class="help-block text-danger"><?php echo $description_err; ?></span>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="row form-group">
                        <div class="col col-md-2"><label for="level" class=" form-control-label">Level</label></div>
                        <div class="col-6 col-md-6">
                            <select name="level_id" id="level" class="form-control">
                                <option value="0" selected>Please Select Level</option>
                                <?php while ($row = $levels->fetch_assoc()) {?>
                                <option value="<?php echo $row['level_id'] ?>"
                                    <?php echo ($level_id == $row['level_id']) ? 'selected' : ''; ?>>
                                    <?php echo $row['level_name'] ?></option>
                                <?php } ?>
                            </select>
                            <?php if ($level_err !== '') { ?>
                                <span class="help-block text-danger"><?php echo $level_err; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-2"><label for="type" class=" form-control-label">Type</label></div>
                        <div class="col-6 col-md-6">
                            <select name="type_id" id="type" class="form-control">
                                <option value="0" selected>Please Select Type</option>
                                <?php while ($row = $types->fetch_assoc()) {?>
                                <option value="<?php echo $row['type_id'] ?>"
                                    <?php echo ($type_id == $row['type_id']) ? 'selected' : ''; ?>>
                                    <?php echo $row['type_name'] ?></option>
                                <?php } ?>
                            </select>
                            <?php if ($type_err !== '') { ?>
                                <span class="help-block text-danger"><?php echo $type_err; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-2"><label for="type" class=" form-control-label">Score</label></div>
                        <div class="col-6 col-md-6">
                                <input type="text" id="score" name="score" placeholder="Enter Score"
                                    class="form-control" value="<?php echo $score; ?>">
                                <!-- <?php if ($score_err !== '') { ?>
                                <span class="help-block text-danger"><?php echo $score; ?></span>
                                <?php } ?> -->
                            </div>
                    </div>
  
                    <div class="row form-group">
                        <div class="col col-md-2"><label for="quiz" class=" form-control-label">
                                Add Quiz</label></div>
                        <div class="col col-md-2">
                            <button type="button" id="" class="btn btn-info btm-sm" data-toggle="modal"
                                data-target="#quizModal">Add quiz</button>
                        </div>
                    </div>
                    <div class="row form-group" id="showQuizs">
                        <div class="col col-md-2"><label for="quiz" class=" form-control-label">
                                Show Quiz</label>
                        </div>
                    </div> 
                    <?php if ($quizs_err !== '') { ?>
                        <div class="col col-md-2"></div>
                            <span class="help-block text-danger"><?php echo $quizs_err; ?></span>
                    </div>
                <?php } ?>
                <?php if ($correct_answer_err !== '') { ?>
                    <span class="help-block text-danger"><?php echo $correct_answer_err ; ?></span>
                <?php } ?>
                  

                <div class="card-footer d-flex justify-content-center">
                    <button type="submit" name="Submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i> Create
                    </button>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Reset
                    </button>
                </div>
        </div>
        <!-- Modal markup -->
    </div>
    </form>
</div>
<!-- </div> -->
</div>
</div>

<div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizLabel">Quiz Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="handleModalClose()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="quizForm">
                    <button type="button" id="addQuiz" class="btn btn-info btn-sm" onclick="addQuizs()">+</button>
                    <div class="form-group" id="inputFieldsContainer">
                        <label for="" class="col-form-label">Quizzes:</label>

                        <?php if (!empty($quizzes)) { ?>
                        <?php for ($i = 0; $i < count($quizzes); $i++) { ?>
                        <div class="row input-container_<?php echo $i; ?> mt-2">
                            <div class="col-10">
                                <input type="text" name="quiz_<?php echo $quiz_sub_names[$i]; ?>"
                                    placeholder="Quiz <?php echo $quiz_sub_names[$i]; ?>"
                                    value="<?php echo $quizzes[$i]; ?>" class="form-control">
                            </div>
                            <div class="col-2">
                                <button type="button" id="quiz_<?php echo $quiz_sub_names[$i]; ?>"
                                    class="btn btn-danger minus_button"
                                    onclick="removeAllInputContainers(<?php echo $i; ?>)">
                                    <span class="fa fa-minus-square-o"></span>
                                </button>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                    onclick="handleModalClose()">Close</button>
                <button type="reset" id="" class="btn btn-danger btn-sm">
                    <i class="fa fa-ban"></i> Reset
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once ("../../../layout/admin/footer.php");
?>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var scoreInput = document.getElementById('score');

            scoreInput.addEventListener('input', function() {
                // Remove all non-digit characters
                var score = this.value.replace(/\D/g, '');
                
                // Limit the length to 9 digits
                var numericScore = Number(score);
                
                if (numericScore > 101) {
                        score =  score.substring(0, 2);; // Set to 100 if greater
                }
                score = score.replace(/^0+/, '') || '0';

                this.value = score;
            });
        });


const container = document.getElementById('inputFieldsContainer');
let addButton = document.getElementById('addQuiz');
let showQuizsContainer = document.getElementById('showQuizs');
let chidShowQuizsContainer = document.getElementById('childShowquiz');
handleModalClose();
const names = ['A', 'B', 'C', 'D'];

function addQuizs() {

    var maxQuizzes = names.length;

    var inputCount = countInputFields(container);

    if (inputCount >= maxQuizzes) {
        // Display error message if maximum quizzes reached
        var quizErrorParagraph = document.getElementById('quiz_error');
        if (!quizErrorParagraph) {
            quizErrorParagraph = document.createElement('p');
            quizErrorParagraph.classList.add('text-danger');
            quizErrorParagraph.id = 'quiz_error';
            quizErrorParagraph.textContent = "Can't add more than 4 quizes";
            container.appendChild(quizErrorParagraph);
        }
        addButton.style.display = 'none'; // Hide add button
    } else {
        // Remove error message if it exists
        var quizErrorParagraph = document.getElementById('quiz_error');
        if (quizErrorParagraph) {
            quizErrorParagraph.remove();
        }

        // Calculate index based on current input count
        var index = inputCount; // Adjust this based on your logic

        // Create row div
        var rowDiv = document.createElement('div');
        rowDiv.classList.add('row', 'input-container_' + index, 'mt-2');

        // Create column for input field (Bootstrap col-10)
        var colInputDiv = document.createElement('div');
        colInputDiv.classList.add('col-10');

        // Create input element
        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'quiz_' + names[index]; // Assign a name from the names array
        input.placeholder = 'Quiz ' + names[index];
        input.classList.add('form-control'); // Add form-control class

        // Append input to column fnames[index]or input field
        colInputDiv.appendChild(input);

        // Create column for icon button (Bootstrap col-2)
        var colButtonDiv = document.createElement('div');
        colButtonDiv.classList.add('col-2');

        // Create button element for icon
        var iconButton = document.createElement('button');
        iconButton.type = 'button';
        iconButton.id = input.name;

        iconButton.classList.add('btn', 'btn-danger', 'minus_button');
        iconButton.onclick = function() {
            removeAllInputContainers(index);
        };

        // Create icon element for FontAwesome icon
        var iconSpan = document.createElement('span');
        iconSpan.classList.add('fa', 'fa-minus-square-o');
        iconButton.appendChild(iconSpan); // Append the icon to the button

        // Append button to column for icon button
        colButtonDiv.appendChild(iconButton);

        // Append columns to row
        rowDiv.appendChild(colInputDiv);
        rowDiv.appendChild(colButtonDiv);

        // Append the row to the main container
        container.appendChild(rowDiv);
    }
}

function removeAllInputContainers(key) {
    var containers = document.querySelectorAll('.input-container_' + key);
    var error_message = document.getElementById('quiz_error');
    console.log(containers)
    containers.forEach(function(container) {
        container.remove();
        updateInputFields(key);

        if (error_message != null) {
            error_message.remove()
            addButton.style.display = 'block';
        }

    });
}

function updateInputFields(key) {
    var inputs = container.querySelectorAll('input[type="text"]');
    var minusButtons = container.querySelectorAll('button');

    inputs.forEach(function(input, idx) {
        input.placeholder = 'quiz_' + names[idx];
        input.name = 'quiz_' + names[idx];
    });

    minusButtons.forEach(function(minusButton, idx) {
        minusButton.id = 'quiz_' + names[idx];
    });
}

function countInputFields(container) {
    var inputFields = container.getElementsByTagName('input');
    return inputFields.length;
}

function handleModalClose() {
    // Retrieve input field values before closing the modal
    let child_container = document.getElementById('childShowquiz');

    // Check if the container exists
    if (child_container !== null) {
        // Remove all child elements inside the container
        while (child_container.firstChild) {
            child_container.removeChild(child_container.firstChild);
        }
        child_container.remove();
    }

    let inputs = document.querySelectorAll('#quizForm input[type="text"]');
    let quizValues = {};

    inputs.forEach(input => {
        quizValues[input.name] = input.value;
    });

    let containerDiv = document.createElement('div');
    containerDiv.id = 'childShowquiz';
    showQuizsContainer.appendChild(containerDiv);

    Object.keys(quizValues).forEach(key => {
    // Create HTML string for each row
    let correctAnswer = <?php echo json_encode($correct_answer); ?>;
    let isChecked     = (quizValues[key] == correctAnswer) ? 'checked' : '';
    let html = `
            <div class="row input-container mt-2">
                <div class="col-8 ml-3">
                    <input type="text" name="quizzes[]" value="${quizValues[key]}" placeholder="Quiz ${key}" class="form-control" readonly>
                </div>
                <div class="col-2">
                    <div class="form-check mt-2">
                        <input type="checkbox" id="${key}_correct" name="correct_answer[]" value="${quizValues[key]}" ${isChecked} class="form-check-input quizes_status" onchange="handleCheckboxChange(this)">
                        <label for="${key}_correct" class="form-check-label">Correct</label>
                    </div>
                </div>
            </div>
        `;
    // Append the HTML string to the container
    containerDiv.innerHTML += html;
});

}

function handleCheckboxChange(checkbox) {
    // Get the parent container of the checkbox

    // Get all checkboxes within the same container
    let checkboxes = document.querySelectorAll('input[type="checkbox"]');
    // Uncheck all checkboxes except the one that was clicked
    checkboxes.forEach(cb => {
        if (cb.id != checkbox.id) {
            cb.checked = false;
        }
    });
}
</script>
</body>

</html>