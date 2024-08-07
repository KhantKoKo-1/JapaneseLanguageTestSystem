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
                <form action="" method="post" class="form-horizontal">
                <section class="bg-light py-3 py-md-5 py-xl-8">  
                    <div class="container">
                    <div class="row gy-4 gy-lg-0">
                        <div class="col-12 col-lg-4 col-xl-3">
                        <div class="row gy-4">
                            <div class="col-12">
                            <div class="card widget-card border-light shadow-sm">
                                <div class="card-header text-bg-primary">Welcome, Ethan Leo</div>
                                <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="./assets/img/profile-img-1.jpg" class="img-fluid rounded-circle" alt="Luna John">
                                </div>
                                <h5 class="text-center mb-1">Ethan Leo</h5>
                                <p class="text-center text-secondary mb-4">Project Manager</p>
                                <div class="d-grid m-0">
                                    <button class="btn btn-outline-primary" type="button">Back</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12 col-lg-8 col-xl-9">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-tab-pane" type="button" role="tab" aria-controls="overview-tab-pane" aria-selected="true">Overview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-tab-pane" type="button" role="tab" aria-controls="password-tab-pane" aria-selected="false">Password</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-4" id="profileTabContent">
                                <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                                <h5 class="mb-3">Profile</h5>
                                <div class="row g-0">
                                    <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                    <div class="p-2">First Name</div>
                                    </div>
                                    <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                    <div class="p-2">Ethan</div>
                                    </div>
                                    <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                    <div class="p-2">Job</div>
                                    </div>
                                    <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                    <div class="p-2">Project Manager</div>
                                    </div>
                                    <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                    <div class="p-2">Email</div>
                                    </div>
                                    <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                    <div class="p-2">leo@example.com</div>
                                    </div>
                                </div>
                                </div>
                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <form action="#!" class="row gy-3 gy-xxl-4">
                                    <div class="col-12">
                                    <div class="row gy-2">
                                        <label class="col-12 form-label m-0">Profile Image</label>
                                        <div class="col-12">
                                        <img src="./assets/img/profile-img-1.jpg" class="img-fluid" alt="Luna John">
                                        </div>
                                        <div class="col-12">
                                        <a href="#!" class="d-inline-block bg-primary link-light lh-1 p-2 rounded">
                                            <i class="fa fa-upload"></i>
                                        </a>
                                        <a href="#!" class="d-inline-block bg-danger link-light lh-1 p-2 rounded">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                    <label for="inputFirstName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="inputFirstName" value="Ethan">
                                    </div>
                                    <div class="col-12 col-md-12">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail" value="leo@example.com">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                                </div>
                                <div class="tab-pane fade" id="password-tab-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                                <form action="#!">
                                    <div class="row gy-3 gy-xxl-4">
                                    <div class="col-12">
                                        <label for="currentPassword" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="currentPassword">
                                    </div>
                                    <div class="col-12">
                                        <label for="newPassword" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="newPassword">
                                    </div>
                                    <div class="col-12">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirmPassword">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </section>
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