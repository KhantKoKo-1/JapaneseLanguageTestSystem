<?php
$title = 'Report';
require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once("../../../config/question_db.php");
require_once("../../../config/quiz_db.php");
require_once("../../../config/answer_db.php");

$i = 0;
$answers = get_all_answers_info($mysqli);

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
                        <div class="col-11"><strong class="card-title">Report Table</strong></div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Answer No</th>
                                    <th>Answer Date</th>
                                    <th>Total Score</th>
                                    <th>Answered By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $answers->fetch_assoc()) {
                                $answer_no   = $row['answer_no'];
                                $answer_date = $row['first_answer_date'];
                                $total_score = $row['total_score'];
                                $email       = $row['email'];
                                $total_questions_score = $row['total_questions_score'];
                                $url   = $admin_base_url . "report/answer_detail.php?answer_no=". $answer_no;
                             ?>
                                <tr>
                                    <th> <?php echo $i + 1?> </th>
                                    <td> <?php echo $answer_no?> </td>
                                    <td> <?php echo $answer_date?> </td>
                                    <td> <?php echo $total_score . "/" . $total_questions_score?> </td>
                                    <td> <?php echo $email?> </td>
                                    <td>
                                        <a href="<?php echo $url?>" class="btn btn-info btn-sm"><i class="fa fa-info-circle"></i> View Detail </a>
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