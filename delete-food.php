<?php 
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        //get id and image name  
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the image if available

        if($image_name != "")
        {
            //image available.
            $path = "../img/food/".$image_name;
            //remove the image
            $remove = unlink($path);
            
            //if failed to remove image and stops the progress
            if($remove==FALSE)
            {
                //set session message
                $_SESSION ['upload'] = "<div class='error'>Failed to Remove Food Image</div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop process
                die();
            }
        }
        //delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //execute query
        //check kung gumana yung query and sset session message
        $res = mysqli_query($conn, $sql);
        if($res==TRUE)
        {
            //food deleted
            $_SESSION['delete'] = "<div class = 'success'>Food Deleted!</div>";
            //redirect to manage food with session message
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class = 'error'>Delete Failed.</div>";
            //redirect to manage food with session message
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        

    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorize'] = "<div class = 'error'>Unauthorized Access</div>";
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>