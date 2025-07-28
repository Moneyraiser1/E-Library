<?php

session_start(); // make sure this is included
require_once '../Controller/Users.php';
require_once '../includes/alertify.php';
$users = new Users();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reg_submit'])) {
    // sanitize input
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);
    $rpassword = trim($_POST['rpassword']);

        $result = $users->Register($username, $fname, $lname, $email, $password, $address, $phone, $rpassword);
        if($result){
            $_SESSION['msg'] = 'Registration successful. Please verify your email.';
            $_SESSION['msg_type'] = 'success';
            header('Location: verify.php');
            exit();
        } else {
            $_SESSION['msg'] = ''.$result.'';
            $_SESSION['msg_type'] = 'error';
            exit();
        }
    }
     include_once '../Controller/Users.php';
    $users = new Users();

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $userPassword = $_POST['userpassword'];
        $log_msg = "";
        $result = $users->Login($email, $userPassword);
        if(!$users->Login($email, $userPassword)){
            $_SESSION['msg'] = '';
            $_SESSION['msg_type'] = 'success';
            exit();
        }else{
            
        }
    }
    if(isset($_SESSION['username'])): 
        header('index.php');
    endif;  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System - Auth</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Alertify CSS -->
    <link rel="stylesheet" href="../assets/css/alertify.min.css"/>
    <link rel="stylesheet" href="../assets/css/default.min.css"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- jQuery -->
    <script src="../assets/js/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Alertify JS -->
    <script src="../assets/js/alertify.min.js"></script>
</head>


   