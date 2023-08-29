<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

</br></br></br>

        <?php
        if(isset($_SESSION['add']))//check kung naka set yung session or hindi
        {
            echo $_SESSION['add'];//display
            unset($_SESSION['add']);//remove
        }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your Name"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter Username"></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        
    </div>
</div>

<?php include('partials/footer.php');?>

<?php
//process ng value sa form tapos save sa Database

//button click checker
if(isset($_POST['submit']))
{
    //button clicked 
    //echo"Button Clicked";

    //get data sa form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encryp using md5 nagiging 12931239861231(random) sya 

    //SQL Query pang save sa DB Nox
    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
    ";

    //pang execute ng query at pang save ng data sa DB <3 
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //pange check kung kumana si execute 
    if($res==TRUE)
    {
        //data iserted
        //echo "Data Inserted";
        //create session variable to display message
        $_SESSION['add'] = "<div class = 'success'>Admin Added Successfully!</div>";
        //redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //failed to insert
        //echo "Failed to insert";
        //create session variable to display message
        $_SESSION['add'] = "Failed to Add Admin!";
        //redirect page to add admin
        header("location:".SITEURL.'admin/add-admin.php');


    }

}

?>