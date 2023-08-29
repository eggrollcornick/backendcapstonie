<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype = "multipart/form-data">

            <table class ="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                    <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name ="image" >
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name= "active" value="Yes"> Yes
                        <input type="radio" name= "active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <input type="submit" name ="submit" value ="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Category Form ends  -->

        <?php 
            //check kung naclick submit button
            if(isset($_POST['submit']))
            {
                //echo "clicked";

                //get value from category form
                $title = $_POST['title'];

                //for radio input type check kung may napili
                if(isset($_POST['featured']))
                {
                    //get value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //check kung may image na napili tapos sets the value for image name
                //print_r($_FILES['image']);
                
                //die();//break code
                
                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    //to upload image: needs image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //upload the image only if an image is selected 
                    
                    if($image_name != "")
                    {
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
                        //redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop process
                        die();
                    }
                }

                }
                else
                {
                    //upload image fail and set image name value as blank
                    $image_name=""; 
                }
                //create sql query to insert a category sa db
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";
                $res = mysqli_query($conn, $sql);

                //check kung nag execute query at kung na add yun data
                if($res==TRUE)
                {
                    //query executed and nag add category
                    $_SESSION['add'] = "<div class = 'success'>Category added successfully</div>";
                    //redirect to add category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add'] = "<div class = 'error'>Category Adding Failed</div>";
                    //redirect to add category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
        ?>

    </div>
</div>

<?php include('partials/footer.php');?>