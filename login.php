<?php include('../config/constants.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nox Cafe Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>
        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset ($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
            }
        ?>
        <br><br>
        <!--Login form starts here-->
        <form action="" method="POST" class = "text-center">
            Username: <br>
            <input type="text" name = "username" placeholder="Enter Username"> <br><br>
            Password: <br>
            <input type="password" name = "password" placeholder="Enter Password"> <br> <br>
            <input type="submit" name ="submit" value = "Login" class="btn-primary"> <br><br>
        </form>
        <!--Login form ends here-->
        <p class="text-center">Created by DEEK.</p>
    </div>
</body>
</html>

<?php
    //check kung nagana submit button
    if(isset($_POST['submit']))
    {
        //get data sa login from sa taas
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //check kung yung nakalagay sa form is nasa database
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //execute query
        $res = mysqli_query($conn, $sql);

        //count rows  to check kung nag eexist yung user
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //userfound tapos login
            $_SESSION['login'] = "<div class = 'success'>Login Successful</div>";
            $_SESSION['user'] = $username; // to check kung naka login si user
            //redirect pa home page ng admin dashboard
            header('location:'.SITEURL.'admin/');

        }
        else
        {
            //No user found
            $_SESSION['login'] = "<div class = 'error text-center'>Login Unsuccessful</div>";
            //redirect pabalik
            header('location:'.SITEURL.'admin/login.php');

        }
    } 
?>