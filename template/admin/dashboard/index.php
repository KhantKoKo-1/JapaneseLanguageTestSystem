<?php 
$title = 'Dashboard';

require_once("../../../layout/admin/header.php");
require_once("../../../layout/admin/sidebar.php");
require_once("../../../layout/admin/nav.php");
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">

    <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-flat-color-1">
            <div class="card-body pb-0">
                <div class="dropdown float-right">
                    <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button"
                        id="dropdownMenuButton1" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <div class="dropdown-menu-content">
                            <a class="dropdown-item" href="<?php echo $admin_base_url ?>category/level_form.php">Level
                                Form</a>
                            <a class="dropdown-item" href="<?php echo $admin_base_url ?>category/level_list.php">Level
                                List</a>
                            <a class="dropdown-item" href="<?php echo $admin_base_url ?>category/type_form.php">Type
                                Form</a>
                            <a class="dropdown-item" href="<?php echo $admin_base_url ?>category/type_list.php">Type
                                List</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-0">
                    <span class="count">4</span>
                </h4>
                <p class="text-light"> Category </p>

                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                    <canvas id="widgetChart"></canvas>
                </div>

            </div>

        </div>
    </div>
    <!--/.col-->


    <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-flat-color-1">
            <div class="card-body pb-0">
                <div class="dropdown float-right">
                    <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button"
                        id="dropdownMenuButton3" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                        <div class="dropdown-menu-content">
                            <a class="dropdown-item"
                                href="<?php echo $admin_base_url ?>questions/question_form.php">Question Form</a>
                            <a class="dropdown-item"
                                href="<?php echo $admin_base_url ?>questions/question_list.php">Question List</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-0">
                    <span class="count">2</span>
                </h4>
                <p class="text-light">Question</p>

            </div>

            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                <canvas id="widgetChart3"></canvas>
            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-flat-color-1">
            <div class="card-body pb-0">
                <div class="dropdown float-right">
                    <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button"
                        id="dropdownMenuButton4" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                        <div class="dropdown-menu-content">
                            <a class="dropdown-item"
                                href="<?php echo $admin_base_url ?>account/account_form.php">Account Form</a>
                            <a class="dropdown-item"
                                href="<?php echo $admin_base_url ?>account/account_list.php">Account List</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-0">
                    <span class="count">2</span>
                </h4>
                <p class="text-light">Account</p>

                <div class="chart-wrapper px-3" style="height:70px;" height="70">
                    <canvas id="widgetChart4"></canvas>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo $admin_base_url ?>report/index.php" class="card text-white bg-flat-color-1"
            style="cursor:pointer;">
            <div class="card-body pb-0">
                <h4 class="mb-0">
                    <span class="count">1</span>
                </h4>
                <p class="text-light">Report</p>

                <div class="chart-wrapper px-3" style="height:70px;" height="70">
                    <canvas id="widgetChart"></canvas>
                </div>

            </div>
        </a>
    </div>
    <!--/.col-->


</div> <!-- .content -->
</div><!-- /#right-panel -->

<?php 
require_once("../../../layout/admin/footer.php");
?>

<script src="<?php echo $base_url;?>assets/admin/vendors/chart/Chart.bundle.min.js"></script>
<script src="<?php echo $base_url;?>assets/admin/js/dashboard.js"></script>
<script src="<?php echo $base_url;?>assets/admin/js/widgets.js"></script>

</body>

</html>