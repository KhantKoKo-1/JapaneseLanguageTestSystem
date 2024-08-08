<?php
$base_dir = __DIR__;
require_once($base_dir . '/z_db_seeder.php');
require_once($base_dir . '/user_db.php');
$mysqli = new mysqli("localhost", "root", "");

if ($mysqli->connect_error) {
    echo "Error occuring";
}

function create_db($mysqli)
{
    $sql = "CREATE DATABASE IF NOT EXISTS `language_test_system`";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function select_db($mysqli)
{
    if ($mysqli->select_db("language_test_system")) {
        return true;
    }
    return false;
}

function create_table($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `user_id` INT AUTO_INCREMENT,
        `name` VARCHAR(20) NOT NULL,
        `email` VARCHAR(45) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `role` TINYINT NOT NULL DEFAULT 1 COMMENT '0 for admin, 0 for user',
        `created_by` INT COMMENT '0 for created by user',
        `created_at` DATETIME NOT NULL,
        `updated_by` INT DEFAULT NULL,
        `updated_at` DATETIME DEFAULT NULL,
        `deleted_by` INT DEFAULT NULL,
        `deleted_at` DATETIME DEFAULT NULL,
        PRIMARY KEY(`user_id`)
    )";

   if ($mysqli->query($sql) === false) {
        echo "Error creating user table: " . $mysqli->error;
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `level`(
        `level_id` INT AUTO_INCREMENT, 
        `level_name` VARCHAR (100) NOT NULL,
        `created_by` INT NOT NULL,
        `created_at` DateTime NOT NULL,
        `updated_by` INT DEFAULT NULL,
        `updated_at` DateTime DEFAULT NULL,
        `deleted_by` INT DEFAULT NULL,
        `deleted_at` DateTime DEFAULT NULL,
        PRIMARY KEY(`level_id`)
        ) ";

       if ($mysqli->query($sql) === false) {
        echo "Error creating level table: " . $mysqli->error;
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `type`(
        `type_id` INT AUTO_INCREMENT , 
        `type_name` VARCHAR (100) NOT NULL,
        `created_by` INT NOT NULL,
        `created_at` DateTime NOT NULL,
        `updated_by` INT DEFAULT NULL,
        `updated_at` DateTime DEFAULT NULL,
        `deleted_by` INT DEFAULT NULL,
        `deleted_at` DateTime DEFAULT NULL,
         PRIMARY KEY(`type_id`)
        ) ";

       if ($mysqli->query($sql) === false) {
        echo "Error creating type table: " . $mysqli->error;
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `questions`(
        `question_id` INT AUTO_INCREMENT,
        `description` TEXT NOT NULL,
        `level_id` INT NOT NULL,
        `type_id` INT NOT NULL,
        `score` INT DEFAULT 0,
        `created_by` INT NOT NULL,
        `created_at` DateTime NOT NULL,
        `updated_by` INT DEFAULT NULL,
        `updated_at` DateTime DEFAULT NULL,
        `deleted_by` INT DEFAULT NULL,
        `deleted_at` DateTime DEFAULT NULL,
        PRIMARY KEY(`question_id`),
        FOREIGN KEY(`level_id`) REFERENCES `level`(`level_id`),
        FOREIGN KEY(`type_id`) REFERENCES `type`(`type_id`)
        )";

        if ($mysqli->query($sql) === false) {
        echo "Error creating questions table: " . $mysqli->error;
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `quiz`(
        `q_id` INT AUTO_INCREMENT,
        `description` VARCHAR(255) NOT NULL,
        `is_correct` BOOLEAN NOT NULL,
        `question_id` INT NOT NULL,
        `created_by` INT NOT NULL,
        `created_at` DateTime NOT NULL,
        `updated_by` INT DEFAULT NULL,
        `updated_at` DateTime DEFAULT NULL,
        `deleted_by` INT DEFAULT NULL,
        `deleted_at` DateTime DEFAULT NULL,
        PRIMARY KEY(`q_id`),
        FOREIGN KEY(`question_id`) REFERENCES `questions`(`question_id`)
        )";
   
    if ($mysqli->query($sql) === false) {
    echo "Error creating quizz table: " . $mysqli->error;
    return false; }

    $sql = "CREATE TABLE IF NOT EXISTS `answers` (
        `answer_id` INT AUTO_INCREMENT,
        `answer_no` VARCHAR(20) NOT NULL,
        `answer_date` DateTime NOT NULL,
        `start_time` TIME NOT NULL,
        `end_time` TIME NOT NULL,
        `is_correct` BOOLEAN NOT NULL,
        `score` INT DEFAULT 0,
        `question_id` INT NOT NULL,
        `user_id` INT NOT NULL,
        `created_by` INT NOT NULL,
        `created_at` DateTime NOT NULL,
        `updated_by` INT DEFAULT NULL,
        `updated_at` DateTime DEFAULT NULL,
        `deleted_by` INT DEFAULT NULL,
        `deleted_at` DateTime DEFAULT NULL,
        PRIMARY KEY (`answer_id`),
        FOREIGN KEY (`question_id`) REFERENCES `questions`(`question_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
    )";

     if ($mysqli->query($sql) === false) {
        echo "Error creating answers table: " . $mysqli->error;
        return false;
    }
}


create_db($mysqli);
select_db($mysqli);
create_table($mysqli);
$count = count_user($mysqli);

if ($count == 0) {
    run_seeder($mysqli);
}