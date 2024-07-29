<?php

function run_seeder($mysqli) {
   try{
      $password = "password";
      $hash_password = password_hash($password, PASSWORD_DEFAULT);
      $currentDateTime = date('Y-m-d H:i:s');
      $admin_sql = "INSERT INTO `users`(`name`,`email`,`password`,`role`,`created_at`) VALUES ('admin','admin@gmail.com','$hash_password',0,'$currentDateTime')";
      $user_sql = "INSERT INTO `users`(`name`,`email`,`password`,`role`,`created_at`) VALUES ('user','user@gmail.com','$hash_password',1,'$currentDateTime')";
      
      if ($mysqli->query($admin_sql) == false) {
         echo "Database seeder have error!";
      }
      if ($mysqli->query($user_sql) == false) {
         echo "Database seeder have error!";
      }
   }catch(Exception $e){
      error_log("Error: " . $e->getMessage(), 0);
   }
   
}
