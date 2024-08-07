<?php
$title = "Profile";
require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
$user_name = $id = $old_password_err = $type = $role = $email = $password = $comfirm_password =  "";
$user_name_err = $email_err = $password_err =  $comfirm_password_err = "";
$validate  = true;
$user_data = get_user_by_id($mysqli, $user_id);
$user_name = $user_data['name'];
$email     = $user_data['email'];
$role      = $user_data['role'];
$success_message = "";
$error_message   = "";
$show_profile    = "";
$show_password   = "";

if ($role == $admin_role) {
   $role_name = "admin";
} else {
   $role_name = "admin"; 
}

if (isset($_POST['save']) && $_POST['save'] == "Save Changes") {
    $show_profile  = "show active";
    $show_password = "";
    $user_name     = $mysqli->real_escape_string($_POST["username"]); 
    $email         = $mysqli->real_escape_string($_POST["email"]);
  
    if ($user_name === "") {
        $validate = false;
        $user_name_err = "Email must not be blank!";
    }
  
    if ($email === "") {
      $validate  = false;
      $email_err = "Email must not be blank!";
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validate     = false;
        $email_err = "Please fill vaild email!";
      }
    }
  
    if ($validate) {
        try {
          $check_email_exist = get_user_by_email($mysqli, $email, $user_id);
          if ($check_email_exist){
              $error = true;
              $invalid = true;
              $error_message = "This email is already taken."; 
          } else {
            $role = $admin_role;
            $result  = update_user_info($mysqli, $user_name, $email, $role, $user_id, $user_id);
            if ($result) {
                $_SESSION['admin']['username'] = $user_name;
                $_SESSION['admin']['email']    = $email; 
                $success_message = "Your account infomation is update success!";           
            } else {
                $error_message = "Something was wrong! Please Try Again Later!";
            }    
          }
        }
        catch (Exception $e) {
          // Handle exceptions (e.g., duplicate entry error)
          if ($e->getCode() === '23000') {
              $error_message = "Duplicate entry error. This email or username is already taken.";
          } else {
              $error_message = "An error occurred: " . $e->getMessage();
          }
          $invalid = true;
      }
    }
}

if (isset($_POST['changePassword']) && $_POST['changePassword'] == "Change Password") {
    $show_password    = "show active";
    $show_profile     = "";
    $old_password     = $mysqli->real_escape_string($_POST["old_password"]);
    $password         = $mysqli->real_escape_string($_POST["password"]);
    $comfirm_password = $mysqli->real_escape_string($_POST["comfirm_password"]);
  
    if ($old_password === "") {
        $validate = false;
        $old_password_err = "Old password must not be blank!";
    }
      
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }
    else {
        if (strlen($password) > 30) {
            $validate = false;
            $password_err .= 'Password is greater than 30 charaters!';
        } elseif (strlen($password) < 6) {
            $validate = false;
            $password_err .= 'Password must be minimum length of 6 characters!';    
        }    
        // } elseif (!preg_match($pattern, $password)) {
        //     $validate = false;
        //     $password_err .= 'Password must be at least [ one uppercase letter,one lowercase letter,one digit ]!';
        // }
    }
  
    if ($comfirm_password === "") {
        $validate = false;
        $comfirm_password_err = "Comfirm password must not be blank!";
    }

    if ($password !== $comfirm_password) {
        $validate = false;
        $comfirm_password_err = "[ Password ] and [ Comfirm Password ] must be same!";
    }
  
    if ($validate) {
        try {
            $user = get_user_by_id($mysqli, $user_id);
            $match = password_verify($old_password, $user['password']);
            if ($match) {
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $result        = update_user_password($mysqli, $hash_password, $user_id, $user_id);
                if ($result) {
                    $url = $admin_base_url . "account/account_list.php?msg=editPassword";
                } else {
                    $url = $admin_base_url . "account/account_list.php?err=editPassword";
                }
            } else {
                $validate = false;
                $old_password_err = "Old password does not match";
            }
  
            if ($validate) {
                if($result) {
                    $success_message = "Your account have been updated password!";
                }
            }
        } catch (Exception $e) {
            $error_message = "An error occurred: " . $e->getMessage();
        }
    }
}

if($show_profile == "" && $show_password == "") {
    $show_overview = "show active";;
} else {
    $show_overview   = "";
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
        <?php if ($success_message != "") {?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo $success_message;?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php }?>
        <?php if ($error_message != "") {?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?php echo $error_message;?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php }?>
        <div class="row justify-content-center">
            <!-- <div class="card w-75 mt-5"> -->
            <form action="" method="post" class="form-horizontal">
                <section class="bg-light py-3 py-md-5 py-xl-8">
                    <div class="container">
                        <div class="row gy-4 gy-lg-0">
                            <div class="col-12 col-lg-4 col-xl-3">
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <div class="card widget-card border-light shadow-sm">
                                            <div class="card-header text-bg-primary">Welcome, <?php echo $user_name?>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    <img src="<?php echo $base_url;?>assets/admin/images/admin.jpg"
                                                        class="img-fluid rounded-circle" alt="Luna John">
                                                </div>
                                                <h5 class="text-center mb-1"><?php echo $user_name?></h5>
                                                <p class="text-center text-secondary mb-4"><span
                                                        class="badge badge-pill badge-info"><?php echo $role_name?></span>
                                                </p>
                                                <!-- <div class="d-grid m-0">
                                                    <button class="btn btn-outline-primary" type="button">Back</button>
                                                </div> -->
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
                                                <button class="nav-link <?php echo $show_overview != "" ? 'active' : ''; ?>" id="overview-tab" data-bs-toggle="tab"
                                                    data-bs-target="#overview-tab-pane" type="button" role="tab"
                                                    aria-controls="overview-tab-pane"
                                                    aria-selected="false">Overview</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?php echo $show_profile ?>" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#profile-tab-pane" type="button" role="tab"
                                                    aria-controls="profile-tab-pane"
                                                    aria-selected="false">Profile</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?php echo $show_password ?>" id="password-tab" data-bs-toggle="tab"
                                                    data-bs-target="#password-tab-pane" type="button" role="tab"
                                                    aria-controls="password-tab-pane"
                                                    aria-selected="false">Password</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-4" id="profileTabContent">
                                            <div class="tab-pane fade <?php echo $show_overview ?>" id="overview-tab-pane"
                                                role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                                                <h5 class="mb-3">Profile</h5>
                                                <div class="row g-0">
                                                    <div
                                                        class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                        <div class="p-2">Name</div>
                                                    </div>
                                                    <div
                                                        class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                        <div class="p-2"><?php echo $user_name?></div>
                                                    </div>
                                                    <div
                                                        class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                        <div class="p-2">Job</div>
                                                    </div>
                                                    <div
                                                        class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                        <div class="p-2"><span
                                                                class="badge badge-pill badge-info"><?php echo $role_name?></span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                        <div class="p-2">Email</div>
                                                    </div>
                                                    <div
                                                        class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                        <div class="p-2"><?php echo $email?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade <?php echo $show_profile ?>" id="profile-tab-pane" role="tabpanel"
                                                aria-labelledby="profile-tab" tabindex="0">
                                                <form action="#!" method="POST" class="row gy-3 gy-xxl-4">
                                                    <!-- <div class="col-12">
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
                                                    </div> -->
                                                    <div class="col-12 col-md-12">
                                                        <label for="inputFirstName" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="username"
                                                            id="inputFirstName" value="<?php echo $user_name; ?>">
                                                        <span
                                                            class="help-block text-danger"><?php echo $user_name_err ?></span>
                                                    </div>
                                                    <div class="col-12 col-md-12">
                                                        <label for="inputEmail" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            id="inputEmail" value="<?php echo $email; ?>">
                                                        <span
                                                            class="help-block text-danger"><?php echo $email_err ?></span>
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <input type="submit" class="btn btn-primary" name="save"
                                                            value="Save Changes" />
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade <?php echo $show_password ?>" id="password-tab-pane" role="tabpanel"
                                                aria-labelledby="password-tab" tabindex="0">
                                                <form action="" method="POST">
                                                    <div class="row gy-3 gy-xxl-4">
                                                        <div class="col-12">
                                                            <label for="currentPassword" class="form-label">Current
                                                                Password</label>
                                                            <input type="password" class="form-control"
                                                                name="old_password" id="currentPassword">
                                                        <span
                                                            class="help-block text-danger"><?php echo $old_password_err ?></span>        
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="newPassword" class="form-label">New
                                                                Password</label>
                                                            <input type="password" class="form-control"
                                                               name="password" id="newPassword">
                                                            <span
                                                               class="help-block text-danger"><?php echo $password_err ?></span>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="confirmPassword" class="form-label">Confirm
                                                                Password</label>
                                                            <input type="password" name="comfirm_password" class="form-control"
                                                                id="confirmPassword">
                                                            <span
                                                                class="help-block text-danger"><?php echo $comfirm_password_err ?></span>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="submit" name="changePassword"
                                                                class="btn btn-primary" value="Change Password" />
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
<?php
require_once ("../../../layout/admin/footer.php");
?>

</body>

</html>