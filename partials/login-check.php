<?php
    //authorization - access control
    //check kung naka login si user
    if(!isset($_SESSION['user']))// if user NOT(!) set
    {
        //user not logged in
        //redirect to login
        $_SESSION['no-login-message'] = "<div class = 'error text-center'>Please Login to acces Admin Panel</div>";
        header('location:'.SITEURL.'admin/login.php');

    }

?>