<?php
    include('../config/constants.php');
    //echo "Delete Page";
    //check kung the id and image_name is set
    
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
         //get the value at delete 
         $id = $_GET['id'];
         $image_name = $_GET['image_name'];

         //remove the image if available
        if($image_name != "")
        {
            //image available.
            $path = "../img/category/".$image_name;
            //remove the image
            $remove = unlink($path);
            
            //if failed to remove image and stops the progress
            if($remove==FALSE)
            {
                //set session message
                $_SESSION ['remove'] = "<div class='error'>Failed to Remove Category Image</div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop process
                die();
            }
        }
         //delete data from database
         //sql query to delete data from database
         $sql = "DELETE FROM tbl_category WHERE id=$id";

         //execute query
         $res = mysqli_query($conn, $sql);
         
         //check kung nadelete sa database
         if($res==TRUE)
         {
            //success message and redirect to manage category
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            //redirect to manage caregory
            header('location:'.SITEURL.'admin/manage-category.php');

         }
         else
         {
            //set  fail message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            //redirect to manage caregory
            header('location:'.SITEURL.'admin/manage-category.php');
         }

    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');

    }
?>