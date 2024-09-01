<?php
$title = 'Type Table List';
require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once("../../../config/type_db.php");
require_once("../../../config/question_db.php");

$types = get_all_types($mysqli);
$i = 0;
$success = false;
$error   = false;
$success_message = $error_message = "";

if (isset($_GET['msg'])) {
    $success = true;
    switch ($_GET['msg']) {
        case 'create':
            $success_message = 'Type create is success'; 
            break;
        case 'edit':
            $success_message = 'Type update is success'; 
            break;
        case 'delete':
            $success_message = 'Type delete is success'; 
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
          $error_message = 'Type create is fail'; 
          break;
      case 'edit':
          $error_message = 'Type update is fail'; 
          break;
      case 'delete':
          $error_message = 'Type delete is fail'; 
          break;
      default:
          // Default case or additional handling
          break;
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

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-10 col-md-10"><strong class="card-title">Type Table</strong></div>
                        <div class="col-2 d-flex justify-content-end mt-1">
                            <a href="<?php echo $admin_base_url ?>category/type_form.php"
                                class="btn btn-success btn-xs">
                                <i class="fa fa-plus-circle"></i> Create
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($type = $types->fetch_assoc()) {
                                $type_id    = $type['type_id'];
                                $edit_url   = $admin_base_url . "category/type_form.php?type_id=" . $type_id;
                                $delete_url = $admin_base_url . "category/type_delete.php?type_id=" . $type_id;
                                $question_count = get_question_count_by_type_id($mysqli, $type_id);
                            ?>

                                <tr>
                                    <td><?php echo $i + 1 ?></td>
                                    <td><?php echo $type['type_name']; ?></td>
                                    <td>
                                        <a href="<?php echo $edit_url?>" class="btn btn-info btn-sm"><i
                                                class="fa fa-pencil"></i> Edit </a>
                                        <?php if ($question_count == 0) {?>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('<?php echo $delete_url; ?>')">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                        <?php } ?>
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