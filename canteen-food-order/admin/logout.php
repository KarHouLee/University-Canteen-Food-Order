<?php 
    //Include constants.php for SITEURL
    include('../config/constans.php');

    //1. Destrory the session
    session_destroy();// Unsets $_SESSION['user']

    //2. Redirest to Login Page
    header('location:'.SITEURL.'admin/login.php');
?>