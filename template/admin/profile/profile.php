<?php
if (isset($_GET['level_id'])) {
    $title = 'Edit Level Form';
} else { 
    $title = 'Create Level Form';
}

require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
// require_once ("../../../config/level_db.php");

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
        <div class="row justify-content-center">

            <div class="card w-75 mt-5">
                <div class="">
                    <a href="<?php echo $admin_base_url ?>category/level_list.php" class="btn btn-secondary btn-sm">Back To List</a>
                </div>
                <div class="card-header d-flex justify-content-center">
                    <?php if(isset($level_id)) {
                        echo "<strong>Create Level &nbsp;</strong> Form";
                    } else {
                        echo "<strong>Edit Level &nbsp;</strong> Form";
                    }
                    ?>

                </div>
                <form action="" method="post" class="form-horizontal">
                    <div class="card-body card-block">
                            <main>
                            <header>
                            <img src="https://i.pravatar.cc/60?img=1" alt="Sally Ramos">
                            <div>
                                <h2>Sally Ramos</h2>
                                <p>@sallytheramos</p>
                            </div>
                            <button type="button">Following</button>
                            </header>
                            <section>
                            <div>
                                <p>Product Designer at @Company.<br>Working on @myproject in my free time</p>
                                <div>
                                <p><span>15k</span> Followers</p>
                                <p><span>7k</span> Following</p>
                                <p>Since April 30, 2023</p>
                                </div>
                            </div>
                            </section>
                        </main>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" value="1" name="Submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i>
                            <?php if(isset($level_id)) {
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