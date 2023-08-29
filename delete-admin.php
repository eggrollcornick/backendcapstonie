<?php 
    //include constants
    include('../config/constants.php');

    //get the id of the admin na idedelete
    $id = $_GET['id'];

    //create sql query para ma remove admin
    $sql = "DELETE FROM tbl_admin WHERE  id=$id";

    //execute query 
    $res = mysqli_query($conn, $sql);

    //check kung nagana query

    if($res==TRUE)
    {
        //query executed success
        //echo "admin deleted";
        //create session to display message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>"; 
        //redirect to manage admin page!!
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to delete admin
        //echo "failed to delete admin";
        $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    //redirect to manage admin tapos may message kung success or error
?>