<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><img src="<?php echo $base_url; ?>assets/admin/images/logo.png"
                    alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="<?php echo $base_url; ?>assets/admin/images/logo2.png"
                    alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="<?php echo $admin_base_url . 'dashboard/' ?>"> <i
                            class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                <h3 class="menu-title">Pages</h3><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Category</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-puzzle-piece"></i><a href="<?php echo $admin_base_url ?>category/level_form.php">Level Form</a></li>
                        <li><i class="fa fa-puzzle-piece"></i><a href="<?php echo $admin_base_url ?>category/level_list.php">Level List</a></li>
                        <li><i class="fa fa-puzzle-piece"></i><a href="<?php echo $admin_base_url ?>category/type_form.php">Type Form</a></li>
                        <li><i class="fa fa-id-badge"></i><a href="<?php echo $admin_base_url ?>category/type_list.php">Type List</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Questions</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-puzzle-piece"></i><a href="<?php echo $admin_base_url ?>questions/question_form.php">Question Form</a></li>
                        <li><i class="fa fa-id-badge"></i><a href="<?php echo $admin_base_url ?>questions/question_list.php">Question List</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Account</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-puzzle-piece"></i><a href="<?php echo $admin_base_url ?>account/account_form.php">Account Form</a>
                        </li>
                        <li><i class="fa fa-id-badge"></i><a href="<?php echo $admin_base_url ?>account/account_list.php">Account List</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->