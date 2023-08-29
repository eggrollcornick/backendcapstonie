<?php include('partials/menu.php')?>
<!-- Start ng content menu-->
    <div class= "main-content">
    <div class = "wrapper">
        <h1>MANAGE ADMIN</h1>
        <br/>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//display ng notif about kung success ba o hindi
                unset($_SESSION['add']);//pampawala nung notif sa taas ng button ^_^
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }
            if(isset($_SESSION['pwd-not-match']))
            {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }
            if(isset($_SESSION['change-pwd']))
            {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
            }  
        ?>
        <br/><br/>

        <!-- Button to add admin start-->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>

        <br/><br/><br/>
        <!-- Button end-->
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            //query to display all admins
            $sql = "SELECT * FROM tbl_admin";
            //execute query
            $res = mysqli_query($conn, $sql);

            //check kung nagana
            if($res==TRUE){
                //count rows to check kung may data sa DB 
                $count = mysqli_num_rows($res);//get all rows

                $sn=1; //variable tapos assign balue

                //row counter???
                if($count>0){
                    //may laman
                    while($rows=mysqli_fetch_assoc($res))
                    {
                        //gamit while loop para makuha lahat sa DB admin
                        //while loop gagana basta may data sa db

                        //get individual data
                        $id=$rows['id'];
                        $full_name=$rows['full_name'];
                        $username=$rows['username'];

                        //display value sa table
                        ?>

                        <tr>
                            <td><?php echo $sn++;?>.</td>
                            <td><?php echo $full_name;?></td>
                            <td><?php echo $username;?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else{
                    //walang laman
                }
            }
            ?>
        </table>
</div>
</div>
<!-- dulo ng content menu-->
<?php include('partials/footer.php')?>