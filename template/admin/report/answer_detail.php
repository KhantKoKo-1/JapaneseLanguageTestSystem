<?php
$title = 'Answer Detail Report';
require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once("../../../config/question_db.php");
require_once("../../../config/quiz_db.php");
require_once("../../../config/answer_db.php");

if (isset($_GET['answer_no'])) {
    $answer_no = $_GET['answer_no'];
}

$i = 0;
$results = get_answers_by_answer_no($mysqli, $answer_no);
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
                        <a href="<?php echo $admin_base_url . "report/"?>" class="btn btn-info btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                        <div class="col-12"><strong class="card-title">Answer Detail Table</strong></div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>level</th>
                                    <th>type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $results->fetch_assoc()) {
                                ?>
                                <tr>
                                    <th> <?php echo $i + 1?> </th>
                                    <td> <?php echo $row['level_name']?> </td>
                                    <td> <?php echo $row['type_name']?> </td>
                                    <td> <?php echo $row['description']?> </td>
                                    <?php if($row['status'] == "RIGHT") {?>
                                        <td class="text-center"><span class="badge badge-pill badge-success"><?php echo $row['status'];?></span></td>
                                    <?php } else { ?>
                                        <td class="text-center"><span class="badge badge-pill badge-danger"><?php echo $row['status'];?></span></td>
                                    <?php }?>
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