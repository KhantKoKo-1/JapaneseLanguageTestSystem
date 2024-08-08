<?php
if(isset($_GET['user_id'])) {
    if (isset($_GET['type'])) {
        $title = 'Change Password Form';
    } else {
        $title = 'Edit Account Form';
    }
} else { 
    $title = 'Create Account Form';
}
require_once ("../../../layout/admin/header.php");
require_once ("../../../layout/admin/sidebar.php");
require_once ("../../../layout/admin/nav.php");
require_once("../../../config/user_db.php");

$user_name = $id = $old_password_err = $type = $role = $email = $password = $comfirm_password =  "";
$user_name_err = $role_err = $email_err = $password_err =  $comfirm_password_err = "";

$pattern  = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/';
$validate = true;
$invalid  = false;
$success  = false;
$invalid_err     = "";
$success_message = "";
$success_message = "";


if (isset($_GET['user_id'])) {
    if (isset($_GET['type'])) {
        $type = $_GET['type']; 
    }
    $id   = $_GET['user_id'];
    $user_data = get_user_by_id($mysqli, $id);
    if ($user_data == NULL) {
        $url =  $base_url . "template/error_pages/404.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
        exit();
    }
    $user_name = $user_data['name'];
    $email     = $user_data['email'];
    $role      = $user_data['role'];
 }

if (isset($_POST['register']) && $_POST['register'] == 2) {
  if ($type == "") {  
        $user_name = $mysqli->real_escape_string($_POST["username"]); 
        $email     = $mysqli->real_escape_string($_POST["email"]);
        $role      = isset($_POST["role"]) ? $_POST["role"] : '';
  } else {
        $old_password  = $mysqli->real_escape_string($_POST["old_password"]);
  }

  if ($id == "" || $type != "") {
    $password  = $mysqli->real_escape_string($_POST["password"]);
    $comfirm_password = $mysqli->real_escape_string($_POST["comfirm_password"]);
  }


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

  if ($id == "" || $type != "") {
    if ($type != "") {
        if ($old_password === "") {
            $validate = false;
            $old_password_err = "Old password must not be blank!";
    }
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
}

  if ($role === "") {
      $validate = false;
      $role_err = "Please Choose Role!";
  }

  if ($validate) {
      try {
        $check_email_exist = get_user_by_email($mysqli, $email, $id);
        if ($check_email_exist){
            $error = true;
            $invalid = true;
            $invalid_err = "This email is already taken."; 
        } else {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            if ($id && $type == "") {
                $result  = update_user_info($mysqli, $user_name, $email, $role, $user_id, $id);
                $message = "Edit User Info Successful!";
                if ($result) {
                    $url = $admin_base_url . "account/account_list.php?msg=editInfo";
                } else {
                    $url = $admin_base_url . "account/account_list.php?err=editInfo";
                }    
            } else if ($id && $type != "") {
                $user = get_user_by_id($mysqli, $id);
                $match = password_verify($old_password, $user['password']);
                if ($match) {
                    $result  = update_user_password($mysqli, $hash_password, $user_id, $id);
                    if ($result) {
                        $url = $admin_base_url . "account/account_list.php?msg=editPassword";
                    } else {
                        $url = $admin_base_url . "account/account_list.php?err=editPassword";
                    }
                } else {
                    $validate = false;
                    $old_password_err = "Old password does not match";
                }
            } else {
                $result  = save_user($mysqli, $user_name, $email, $hash_password, $role, $user_id);
                if ($result) {
                    $url = $admin_base_url . "account/account_list.php?msg=create";
                } else {
                    $url = $admin_base_url . "account/account_list.php?err=create";
                }
            }

            if ($validate) {
                if($result) {
                    $success = true;
                    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
                    exit();
                }
            }
        }
      }
      catch (Exception $e) {
        // Handle exceptions (e.g., duplicate entry error)
        if ($e->getCode() === '23000') {
            $invalid_err = "Duplicate entry error. This email or username is already taken.";
        } else {
            $invalid_err = "An error occurred: " . $e->getMessage();
        }
        $error = true;
        $invalid = true;
    }
    
 }
}


?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1><?php echo $title; ?></h1>
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
<!-- <div class="row"> -->
<div class="content mt-3">
    <div class="animated fadeIn">
        <?php if ($invalid) { ?>
        <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto" role="alert">
            <span class="badge badge-pill badge-danger">Error</span> <?php echo $invalid_err ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php } ?>

        <div class="card">
            <div class="">
                <a href="<?php echo $admin_base_url ?>account/account_list.php" class="btn btn-info btn-sm ml-1 mt-1">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-header d-flex justify-content-center fw-bold"><?php echo $title; ?></div>
            <div class="card-body card-block">
                <form action="" method="post" class="">
                    <?php if ($type == "") { ?>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control"
                                value="<?php echo $user_name ?>">
                        </div>
                        <?php if (!$validate) { ?>
                        <span class="help-block text-danger"><?php echo $user_name_err ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                            <input type="text" id="email" name="email" placeholder="Email" class="form-control"
                                value="<?php echo $email ?>">
                        </div>
                        <?php if (!$validate) { ?>
                        <span class="help-block text-danger"><?php echo $email_err ?></span>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php if ($type != "") { ?>
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" id="old_password" name="old_password" placeholder="Old Password"
                                class="form-control" value="">
                        </div>
                        <?php if (!$validate) { ?>
                        <span class="help-block text-danger"><?php echo $old_password_err ?></span>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php if ($id == "" || $type != "") { ?>
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" id="password" name="password" placeholder="Password"
                                class="form-control" value="<?php echo $password ?>">
                            <div class="input-group-addon"><span style="cursor: pointer;"
                                    onclick="togglePasswordVisibility(1)"><i id="eye-icon1"
                                        class="fa fa-eye fa-sm"></i></span>
                            </div>
                        </div>
                        <?php if (!$validate) { ?>
                        <span class="help-block text-danger"><?php echo $password_err ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" id="comfirm_password" name="comfirm_password"
                                placeholder="comfirm_password" class="form-control"
                                value="<?php echo $comfirm_password ?>">
                            <div class="input-group-addon"><span style="cursor: pointer;"
                                    onclick="togglePasswordVisibility(2)"><i id="eye-icon2"
                                        class="fa fa-eye fa-sm"></i></span>
                            </div>
                        </div>
                        <?php if (!$validate) { ?>
                        <span class="help-block text-danger"><?php echo $comfirm_password_err ?></span>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php if ($type == "") { ?>
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <div class="form-check-inline form-check">
                                <label for="admin" class="form-check-label" style="cursor:pointer;">
                                    <input type="radio" id="admin" name="role" value="<?php echo $admin_role ?>"
                                        class="form-check-input"
                                        <?php echo ($role == $admin_role) ? 'checked' : ''; ?>>Admin
                                </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="user" class="form-check-label" style="cursor:pointer;">
                                    <input type="radio" id="user" name="role" value="<?php echo $user_role?>"
                                        class="form-check-input"
                                        <?php echo ($role == $user_role) ? 'checked' : ''; ?>>User
                                </label>
                            </div>
                            <?php if (!$validate) { ?>
                            <span class="help-block text-danger"><?php echo $role_err ?></span>
                            <?php } ?>
                        </div>
                        </br>
                        <?php } ?>
                        <div class="form-actions form-group">
                            <button type="submit" name="register" value="2"
                                class="btn btn-success btn-sm">Create</button>
                            <button type="reset" id="resetBtn" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php
require_once ("../../../layout/admin/footer.php");
?>
<script>
function togglePasswordVisibility(key) {
    if (key == 1) {
        if ($('#password').prop('type') == 'password') {
            $('#password').prop('type', 'text');
            $('#eye-icon1').removeClass('fa fa-eye');
            $('#eye-icon1').addClass('fa fa-eye-slash');
        } else {
            $('#password').prop('type', 'password');
            $('#eye-icon1').removeClass('fa fa-eye-slash');
            $('#eye-icon1').addClass('fa fa-eye');
        }
    } else {
        if ($('#comfirm_password').prop('type') == 'password') {
            $('#comfirm_password').prop('type', 'text');
            $('#eye-icon2').removeClass('fa fa-eye');
            $('#eye-icon2').addClass('fa fa-eye-slash');
        } else {
            $('#comfirm_password').prop('type', 'password');
            $('#eye-icon2').removeClass('fa fa-eye-slash');
            $('#eye-icon2').addClass('fa fa-eye');
        }
    }
}
</script>

</body>

</html>