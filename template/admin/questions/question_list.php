<?php
$title = 'Question Table List';
require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once("../../../config/question_db.php");
require_once("../../../config/quiz_db.php");

if (isset($_GET['msg'])) {
    $success = true;
    switch ($_GET['msg']) {
        case 'create':
            $success_message = 'Question create is success'; 
            break;
        case 'edit':
            $success_message = 'Question update is success'; 
            break;
        case 'delete':
            $success_message = 'Question delete is success'; 
            break;
        default:
            // Default case or additional handling
            break;
    }
}

if (isset($_GET['err'])) {
  $error = true;
  switch ($_GET['err']) {
      case 'create':
          $error_message = 'Question create is fail'; 
          break;
      case 'edit':
          $error_message = 'Question update is fail'; 
          break;
      case 'delete':
          $error_message = 'Question delete is fail'; 
          break;
      default:
          // Default case or additional handling
          break;
  }
}

$i = 0;
$questions = get_all_questions($mysqli);

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

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-10"><strong class="card-title">Question Table</strong></div>
                        <div class="col-2 d-flex justify-content-end mt-1">
                            <a href="<?php echo $admin_base_url ?>questions/question_form.php" class="btn btn-success btn-xs">
                                <i class="fa fa-plus-circle"></i> Create
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Level</th>
                                    <th>Type</th>
                                    <th>Score</th>
                                    <th>Quiz</th>
                                    <th>Correct Quiz</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($question = $questions->fetch_assoc()) {
                                $question_id = $question['question_id'];
                                $description = $question['description'];
                                $level_name  = $question['level_name'];
                                $type_name   = $question['type_name'];
                                $score       = $question['score'];
                                $quiz_infos  = get_quizzes_by_question_id($mysqli, $question_id);
                                $quiz_description = '';
                                $correct_answer   = '';
                                $j = 0;
                                while ($quiz_info = $quiz_infos->fetch_assoc()) {
                                    if ($j == 0) {
                                        $quiz_description = $quiz_info['description'];
                                    } else {
                                        $quiz_description = $quiz_description . ' , ' . $quiz_info['description'];
                                    }

                                    $is_correct = $quiz_info['is_correct'];

                                    if ($is_correct) {
                                        $correct_answer = $quiz_info['description'];
                                    }
                                    $j ++;                                
                                }
                                $edit_url   = $admin_base_url . "questions/question_form.php?question_id=" . $question_id;
                                $delete_url = $admin_base_url . "questions/question_delete.php?question_id=" . $question_id;  
                             ?>
                                <tr>
                                    <th> <?php echo $i + 1?> </th>
                                    <td> <?php echo $description?> </td>
                                    <td> <?php echo $level_name?> </td>
                                    <td> <?php echo $type_name?> </td>
                                    <td> <?php echo $score?> </td>
                                    <td> <?php echo $quiz_description?> </td>
                                    <td> <?php echo $correct_answer?> </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>

                                            <div class="dropdown-menu">

                                                <a href="<?php echo $edit_url?>" class="dropdown-item"><i
                                                        class="fa fa-pencil"></i> Edit </a>
                                                <a href="javascript:void(0)" class="dropdown-item"
                                                    onclick="confirmDelete('<?php echo $delete_url; ?>')">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<?php
require_once ("../../../layout/admin/footer.php");
require_once ("../../../layout/admin/table_footer.php");
?>


</body>

</html>