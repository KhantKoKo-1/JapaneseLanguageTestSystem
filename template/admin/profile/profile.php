<?php
if (isset($_GET['level_id'])) {
    $title = 'Edit Level Form';
} else { 
    $title = 'Create Level Form';
}

require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once ("../../../config/level_db.php");
$level_name      =  "";
$level_err       =  "";
$error_message   =  "";
$success_message =  "";
$success         = false;
$error           = false;

if (isset($_GET['level_id'])) {
    $level_id = $_GET['level_id'];
    $level_data = get_level_by_id($mysqli, $level_id);
    $level_name  =  $level_data['level_name'];
 } else { 
    $level_id = '';
 }
 

if (isset($_POST['Submit']) && $_POST['Submit'] == 1) {
    $level_name = $mysqli->real_escape_string($_POST["level_name"]);
    if ($level_name == "") {
        $level_err = "Please Enter Level Name!"; 
        $error = true;
    }

    if ($error == false) {
        try {  
            $check_level_name_exist = get_level_by_name($mysqli, $level_name, $level_id);
            if ($check_level_name_exist) {
                $error = true;
                $error_message = "This Level Name is already taken."; 
            } else {
                if ($level_id != '') {
                  $result = update_level($mysqli, $level_name, $user_id, $level_id);
                  if ($result) {
                    $url =  $admin_base_url . "category/level_list.php?msg=edit";
                    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                    exit();
                } else {
                    $url =  $admin_base_url . "category/level_list.php?err=edit";
                    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                    exit();
                }

                } else {
                  $result = save_level($mysqli, $level_name, $user_id);
                  if ($result) {
                    $success = true;
                    $url =  $admin_base_url . "category/level_list.php?msg=create";
                    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                    exit();
                } else {
                    $url =  $admin_base_url . "category/level_list.php?err=create";
                    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                    exit();
                }
                }
            }    
    }
        catch (Exception $e) {
            // Handle exceptions (e.g., duplicate entry error)
            $error_message = $e->getMessage();
            $error = true;
        }
    }
}

?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Create Level</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="<?php echo $admin_base_url . 'dashboard/' ?>">Dashboard</a></li>
                    <li class="active"><?php echo $title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="content mt-3">
    <div class="animated fadeIn">
        <!-- <div class="row"> -->
        <?php if ($error_message != "") { ?>
            <div class="alert  alert-danger alert-dismissible fade show w-75 mx-auto" role="alert">
                <span class="badge badge-pill badge-danger">Error</span>  <?php echo $error_message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <div class="row justify-content-center">

            <div class="card w-75 mt-5">
                <div class="">
                    <a href="<?php echo $admin_base_url ?>category/level_list.php" class="btn btn-secondary btn-sm">Back To List</a>
                </div>
                <div class="card-header d-flex justify-content-center">
                    <?php if($level_id == "") {
                        echo "<strong>Create Level &nbsp;</strong> Form";
                    } else {
                        echo "<strong>Edit Level &nbsp;</strong> Form";
                    }
                    ?>

                </div>
                <form action="" method="post" class="form-horizontal">
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col col-md-2 offset-2 mt-2 bold">
                                <label for="level_name" class="form-control-label">Level Name</label>
                            </div>
                            <div class="col-6 col-md-6">
                                <input type="text" id="level_name" name="level_name" placeholder="Enter Level Name"
                                    class="form-control" value="<?php echo $level_name; ?>">
                                <?php if ($level_err !== '') { ?>
                                <span class="help-block text-danger"><?php echo $level_err; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" value="1" name="Submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i>
                            <?php if($level_id == "") {
                                echo "Create";
                            } else {
                                echo "Edit";
                            }
                            ?>
                        </button>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <button type="reset" id="resetBtn" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?php
require_once ("../../../layout/admin/footer.php");
?>

</body>

</html>