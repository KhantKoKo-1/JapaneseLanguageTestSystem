<?php
require_once("../../require/common.php");
require_once("../../config/db.php");
require_once("../../config/user_db.php");
// require_once("../../require/admin_authentication.php");

$name = $email = "";
$name_err = $email_err = $password_err =  $comfirm_password_err = "";

$validate    = true;
$success     = false;
$invalid     = false;
$invalid_err = false;

if (isset($_POST['register'])) {
  $name = $mysqli->real_escape_string($_POST["name"]); 
  $email = $mysqli->real_escape_string($_POST["email"]);
  $password = $mysqli->real_escape_string($_POST["password"]);
  $comfirm_password = $mysqli->real_escape_string($_POST["comfirm_password"]);

  if ($name === "") {
    $validate = false;
    $name_err = "Email must not be blank!";
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

  if ($validate) {
    if ($password !== $comfirm_password) {
      $validate = false;
      $comfirm_password_err = "[ Password ] and [ Comfirm Password ] must be same!";
    } else {
      $hash_password = password_hash($password, PASSWORD_DEFAULT);
      try {
      $result = save_user($mysqli, $name, $email,$hash_password);
      if(!$result) {
        $invalid = true;
      } else {
        header("Refresh: 0; url=$base_url");
        exit();
      }
    }
      catch (Exception $e) {
        // Handle exceptions (e.g., duplicate entry error)
        if ($e->getCode() === '23000') {
            $invalid_err = "Duplicate entry error. This email or username is already taken.";
        } else {
            $invalid_err = "" . $e->getMessage();
        }
        $invalid = true;
    }
    }
    
  }}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register Form</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/common/css/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/common/css/vendors/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/common/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/common/css/custom_style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url;?>assets/common/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base_url;?>assets/common/images/favicon-32x32.png">
    <link href="<?php echo $base_url; ?>assets/fonts/google-font.css" rel="stylesheet">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 id="title" class="card-title text-left mb-3 d-flex justify-content-center text-dark">Register</h3>
                            <?php if($invalid) {?>
                            <div class="alert">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                <p><?php echo $invalid_err ?></p>
                            </div>
                            <?php } ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="name" style="color:white" class="form-control _input"
                                        value="<?php echo htmlspecialchars($name);?>">
                                    <p style="color:red"><?= $name_err ?></p>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" style="color:white" class="form-control _input"
                                        value="<?php echo htmlspecialchars($email);?>">
                                    <p style="color:red"><?= $email_err ?></p>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" style="color:white" class="form-control _input">
                                    <p style="color:red"><?= $password_err ?></p>
                                </div>
                                <div class="form-group">
                                    <label>Comfirm Password</label>
                                    <input type="password" name="comfirm_password" style="color:white" class="form-control _input">
                                    <p style="color:red"><?= $comfirm_password_err ?>
                                  </p>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="register"
                                        class="btn btn-primary btn-block enter-btn">Register</button>
                                </div>
                                <p class="sign-up text-center">Already have an Account?<a
                                        href="<?php echo $base_url;?>"> Sign In</a></p>
                                <!-- <p class="terms">By creating an account you are accepting our<a href="#"> Terms &
                                        Conditions</a></p> -->
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="<?php echo $base_url;?>assets/common/js/alert.js"></script>

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