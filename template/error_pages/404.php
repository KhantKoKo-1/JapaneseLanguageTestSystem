<?php 
   require_once("../../require/common.php");
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Error Page</title>
    <link rel="stylesheet" href="<?php echo $base_url;?>assets/common/css/error.css" />
    <script src="<?php echo $base_url;?>assets/common/js/kit.fontawesome.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container">
      <div class="gif">
        <img src="<?php echo $base_url;?>assets/common/images/giphy.gif" alt="gif_ing" />
      </div>
      <div class="content">
        <h1 class="main-heading">This page is gone.</h1>
        <p>
          ...maybe the page you're looking for is not found or never existed.
        </p>
        <button onclick="window.history.back()">
            <i class="far fa-hand-point-left"></i>&nbsp;&nbsp;Back
        </button>
      </div>
    </div>
  </body>
</html>
