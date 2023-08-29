<?php include('partials/menu.php')?>

<?php 
    //check kung naka set ba yung id
    if(isset($_GET['id']))
    {
        //get all the deatils
        $id = $_GET['id'];

        //sql query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        $res2 = mysqli_query($conn, $sql2);

        //get value based sa query na na execute
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual values of selected food

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        //redirect o manage food 
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method ="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name ="title" value = "<?php echo $title;?>"placeholder ="Food Name">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5"><?php echo $description?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name ="price" value = "<?php echo $price; ?>"placeholder="Price of Food">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if($current_image== "")
                            {
                                //no image
                                echo "<div class= 'error'>No Image Added</div>";
                            }
                            else
                            {
                                //imaghe availble
                                ?>
                                    <img src="<?php echo SITEURL;?>img/food/<?php echo $current_image;?>"width ="150px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name ="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                        <?php 
                        //query top get all active catgories 
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        //execute query
                        $res = mysqli_query($conn, $sql);
                        //count rows
                        $count = mysqli_num_rows($res);

                        //check kung available yung query
                        if($count>0)
                        {
                            //category available
                            while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details ng categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <!--code para mag display yung categories sa dropdown-->
                                        <option <?php if($current_category==$id){echo "selected";}?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                        }
                        else
                        {
                            //category not availble
                            echo "<options value='0'>Category not Availble.</options>";
                        }
                        ?>
                        </select>
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

        <?php 
            //check kung napindot click
            if(isset($_POST['submit']))
            {
                //get all details 
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                //upload image na selected
                //cheeck kung nagana button ng image
                if(isset($_FILES['image']['name']))
                {
                    //upload button 
                    $image_name = $_FILES['image']['name']; // new image name
                    //check kung available yung file
                    if($image_name!="")
                    {
                        //image available
                        //rename image 
                        $ext = end(explode('.', $image_name));//gets extension

                        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;//rename image

                        //get the source path at destination path

                        $src_path = $_FILES['image']['tmp_name'];//source path ng file
                        $dst_path = "../img/food/".$image_name; //destination path

                        //upload image 
                        $upload = move_uploaded_file($src_path, $dst_path);

                        //check kung na upload image
                        if($upload==FALSE)
                        {
                            //failed to upload
                            $_SESSION['upload'] = "<div class ='error'>Failed to upload new image</div>";
                            //redirect to manage food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop process
                            die();
                        }
                    }
                    //remove lumang image
                    if($current_image!="")
                    {
                        //remove image if available
                        //remove image
                        $remove_path = "../img/food/".$current_image;

                        $remove = unlink($remove_path);

                        //check kung na remove image
                        if($remove==FALSE)
                        {
                            //failed to remove current image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                            //redirect to manage food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
                
                //update food sa db
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";
                //execute query
                $res3 = mysqli_query($conn, $sql3);

                //check kung gumana query
                if($res3 == TRUE)
                {
                    //query executed
                    $_SESSION['update'] = "<div class='success'>Food Updated!</div>";
                    //redirect to manage food
                    header('location:'.SITEURL.'admin/manage-food.php');
                } 
                else
                {
                    //failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    //redirect to manage food
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }?>
    </div>
</div>

<?php include('partials/footer.php')?>