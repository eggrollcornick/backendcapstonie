<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            //get id of selected admin
            $id=$_GET['id'];

            //create query to get the details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //execute query
            $res=mysqli_query($conn, $sql);

            if($res==TRUE)
            {
                //check kung may data lolololol
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //get the details
                    //echo "Admin Available";
                    $row = mysqli_fetch_assoc($res);

                    //save username at full name nung admin
                    $full_name = $row['full_name'];
                    $username = $row['username'];

                }
                else
                {
                    //we will get redirected to manage admin
                    header('location'.SITEURL.'admin/manage-adamin.php');
                }
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name;?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username;?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name ="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
                
            </table>

        </form>
    </div>
</div>

<?php 
//check kung na click  ba yung submit button
if(isset($_POST['submit']))
{
    //echo "button clicked"
    //get all the vvalues from form para mag update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //create sql query pang update sa admin
    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id = '$id'
    ";

    //execute query
    $res = mysqli_query($conn, $sql);

    //check kung nagana query
    if($res==TRUE)
    {
        //nag execute yung query tapos nag update si admin
        $_SESSION['update'] = "<div class='success'>Admin Update Success!!</div>";
        //redirect to manage admin
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    { 
        //failed
        $_SESSION['update'] = "<div class='error'>Failed to update. TRY AGAIN!</div>";
        //redirect to manage admin
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
}
?>

<?php include('partials/footer.php')?>