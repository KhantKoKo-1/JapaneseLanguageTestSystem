<?php
session_start();
require_once ("./require/common.php");
require_once ("./config/db.php");
require_once ("./config/user_db.php");
// require_once ("./require/check_cookies.php");

$email = $password = $remember = "";
$email_err = $password_err = $credition_err = "";
$validate = true;
$invalid = false;

if (isset($_POST['login'])) {
  $email = $mysqli->real_escape_string($_POST["email"]);
  $password = $_POST["password"];

  if (isset($_POST['remember'])) {
    $remember = $_POST['remember'];
  }

  if ($email === "") {
    $validate = false;
    $email_err = "Email must not be blank!";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $validate = false;
      $email_err = "Please fill vaild email!";
    }
  }

  if ($password === "") {
    $validate = false;
    $password_err = "Password must not be blank!";
  }

  if ($validate) {
    $user = get_user_by_email($mysqli, $email);

    if (!$user) {
      $invalid = true;
    }

    if ($user) {
      $match = password_verify($password, $user['password']);

      if ($match) {
        while ($user) {
          $id = (int) ($user['user_id']);
          $role = $user['role'];
          if ($remember == '1') {
            setcookie("id", $id, time() + (86400 * 30), "/");
          }

          if ($role == $admin_role) {
            $_SESSION['admin']['user_id'] = $id;
            $_SESSION['admin']['email'] = $user['email'];
            $_SESSION['admin']['username'] = $user['name'];
            $url = $admin_base_url . 'dashboard/';
          } else {
            $_SESSION['user']['user_id'] = $id;
            $_SESSION['user']['email'] = $user['email'];
            $_SESSION['user']['username'] = $user['name'];
            $url = $user_base_url . 'home.php';
          }

          header("Refresh: 0; url=$url");
          exit();
        }

      } else {
        $invalid = true;
      }
    }

    if ($invalid) {
      $credential_err = "Credentials does not match!";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/vendors/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/vendors/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/vendors/owl-carousel-2/owl.carousel.min.css">
  <link rel="stylesheet"
    href="<?php echo $base_url; ?>assets/common/css/vendors/owl-carousel-2/owl.theme.default.min.css">
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/style.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/common/css/custom_style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/common/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
          <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
              <h3 class="card-title d-flex justify-content-center text-left mb-3 text-dark" stt>Login</h3>
              <form method="post">
                <?php if ($invalid) { ?>
                  <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php echo $credential_err; ?>
                  </div>
                <?php } ?>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control p_input" name="email" id="name"
                    value="<?php echo htmlspecialchars($email); ?>">
                  <p style="color:red"><?= $email_err ?></p>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control p_input" name="password" id="pwd">
                  <p style="color:red"><?= $password_err ?></p>
                </div>
                <div class="form-group d-flex justify-content-center">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" value="1" name="remember" id="remember" <?php if ($remember == '1') {
                      echo "checked";
                    } ?>>
                    <label id="remember-label" for="remember" class="form-check-label">Remember Me</label>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block enter-btn" name="login">Login</button>
                </div>
                <p class="sign-up">Don't have an Account?<a href="<?php echo $base_url; ?>template/user/register.php">
                    Sign Up</a></p>
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

  <footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
      <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © YeeMonKyaw.com 2024</span>
    </div>
  </footer>
  <script src="<?php echo $base_url; ?>assets/common/js/alert.js"></script>

</body>

</html>