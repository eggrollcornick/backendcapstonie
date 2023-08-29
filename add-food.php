<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
        ?>

        <form action="" method = "POST" enctype ="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name = "title" placeholder = "Food Name"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder = "Food Description"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name = "price" placeholder = "Food Price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                    <input type="file" name = "image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                                //Create php code to display categories from database
                                //create sql para makuha lahat ng active categories sa database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //execute query
                                $res = mysqli_query($conn, $sql);

                                //count rows to check kung may categories
                                $count = mysqli_num_rows($res);

                                //if count is greater than 0, may categories na nakuha else walang category
                                if($count >0 )
                                {
                                    //may categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details ng categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }

                                }
                                else
                                {
                                    //walang category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                                //display on dropdown
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name = "featured" value = "Yes">Yes
                        <input type="radio" name = "featured" value = "No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name = "active" value = "Yes">Yes
                        <input type="radio" name = "active" value = "No">No
                    </td>
                </tr>

                <tr>
                    <td colspan ="2">
                        <input type="submit" name="submit" value ="Add Food" class = "btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php 
            //check kung napindot yung button
            if(isset($_POST['submit']))
            {
                //add the food in database!!
                
                //get the data from form 
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check kung may laman yung radio button ng featured and active
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //setting default Value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //setting default Value
                }

                //upload image if selected
                //check kung napindot yung select image and upload kung selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details nung selected image
                    $image_name = $_FILES['image']['name'];

                    //check kung the image is selected or not and upload image pag selected
                    if($image_name != "")
                    {
                        //image is selected
                        //rename image
                        // get extension of selected image
                        $ext = end(explode('.', $image_name));

                        //create name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; // new image name
                        //upload image
                        //get the src path and destination

                        //source path is the current location of the image
                        $src =$_FILES['image']['tmp_name'];

                        //destination path for the image 
                        $dst = "../img/food/".$image_name;

                        //upload image 
                        $upload = move_uploaded_file($src, $dst);

                        //check kung na upload yung image
                        if($upload==FALSE)
                        {
                            //failed to upload image
                            //redirect to add food page with error message
                            $_SESSION['upload'] = "<div class ='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = "";//setting default value as blank
                }

                //insert pa database yung data sa form
                //create sql query para mag save yung added food
                //pag numeric type yung input ndi na need ng single ()')
                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);
                //redirect with message to manage food.php
                //check kung na insert ba yung data or not

                if($res2==TRUE)
                {
                    //data inserted
                    $_SESSION['add'] = "<div class= 'success'>Food Added Successfully!</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class= 'error'>Food not Added.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>


    </div>
</div>

<?php include('partials/footer.php');?>