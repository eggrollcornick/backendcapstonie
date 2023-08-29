<?php include ('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>


        <br><br>

        <?php 
        
            //check kung yung id ay naka set or hindi
            if(isset($_GET['id'])) 
            {
                //get id and all details
                //echo "get data ";
                $id = $_GET['id'];
                //create sql query to get all details

                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //execute query
                $res = mysqli_query($conn, $sql);

                //count the rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //get all data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                }
                else
                {
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        ?>
        <form action="" method ="POST" enctype="multipart/form-data">
        <table class ="tbl-30">
            
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name ="title" value ="<?php echo $title;?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php 
                        if($current_image != "")
                        {
                            //display the image 
                            ?>
                            <img src="<?php echo SITEURL;?>img/category/<?php echo $current_image;?>"width ="150px">
                            <?php
                        }
                        else
                        {
                            //display message
                            echo "<div class = 'error'>Image Not Added.</div>";
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image: </td>
                <td>
                    <input type="file" name ="image" >
                </td>
            </tr>
            
            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){ echo "checked";} ?> type="radio" name = "featured" value="Yes">Yes
                    <input <?php if($featured=="No"){ echo "checked";} ?> type="radio" name = "featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name = "active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name = "active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                <input type="hidden" name = "current_image" value = "<?php echo $current_image;?>">
                <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                <input type="submit" name ="submit" value ="Update Category" class="btn-secondary">
            </td>
            </tr>
        </table>
        </form>
        

        <!-- submit button functions -->
        <?php
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //get all the values from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                
                //update new  image if selected
                //check kung selected ba yung image or hindi
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name = $_FILES['image']['name'];

                    //check kung available yung image 
                    if($image_name !="")
                    {
                        //image available
                    //upload the new image

                     //auto rename image 
                    //get file extension
                    $ext = end(explode('.', $image_name));

                    //rename image
                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //magiging may underscore tapos numbers
                    
                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../img/category/".$image_name;

                    //upload image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check kung yung image is uploaded or not then stop the process with error message
                    if($upload==FALSE)
                    {
                        $_SESSION['upload'] = "<div class = 'error'>Image failed to upload</div>";
                        //redirect to manage category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //stop process
                        die();
                    }

                        //remove the current image 
                        if($current_image != "")
                        {
                            $remove_path = "../img/category/".$current_image;
                            //unlink - pang remove ng file
                            $remove = unlink($remove_path);
    
                            //check kung image is removed or not
                            //if failed to remove. Display message and stop process
                            if($remove==FALSE)
                            {
                                //failed to remove
                                $_SESSION['failed-remove'] = "<div class = 'error'>Failed to Remove Current Image</div>";
                                //redirect to manage admin
                                header('location:'.SITEURL.'admin/manage-category.php');
                                //stops the process
                                die();
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else 
                {
                    $image_name = $current_image;
                }

                //upload to database 
                $sql2 = "UPDATE tbl_category SET 
                    title= '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id='$id'
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //redirect to manage category with message

                //check kung nag execute query
                if($res2==TRUE)
                {
                    //category updated
                    $_SESSION['update'] ="<div class = 'success'>Category Updated.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //update failed 
                    $_SESSION['update'] ="<div class = 'error'>Category Update Failed.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>


        </div>
    </div>

<?php include ('partials/footer.php'); ?>