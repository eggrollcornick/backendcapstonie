<?php
    //include constants 
    include ('../config/constants.php');
    //delete or destroy??? all session
    session_destroy();//unset $_session ['user']
    //redirect to login
    header('location:'.SITEURL.'admin/login.php');
?>