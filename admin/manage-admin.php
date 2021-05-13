<?php include('partials/menu.php'); ?>
        <!-- Main content section starts-->
        <div class="main-content">
            <div class="wrapper">
            <h1>Manage admin</h1>

            </br>
            <?php
                if(isset($_SESSION['add']))
                {
                     echo $_SESSION['add'];  //Displaying Session message
                     unset($_SESSION['add']); //Removing Session message 
                }
                if(isset($_SESSION['delete']))
                {
                     echo $_SESSION['delete'];  //Displaying Session message
                     unset($_SESSION['delete']); //Removing Session message 
                }
                if(isset($_SESSION['update']))
                {
                     echo $_SESSION['update'];  //Displaying Session message
                     unset($_SESSION['update']); //Removing Session message 
                }
                if(isset($_SESSION['user_not_found']))
                {
                     echo $_SESSION['user_not_found'];  //Displaying Session message
                     unset($_SESSION['user_not_found']); //Removing Session message 
                }
                if(isset($_SESSION['psw-not-match']))
                {
                     echo $_SESSION['psw-not-match'];  //Displaying Session message
                     unset($_SESSION['psw-not-match']); //Removing Session message 
                }
            ?>


        <!-- Button to Add Admin -->

            <br />  <br />  </br>
            <a href="add-admin.php" class="btn-primary">Add admin</a>
            <br />  <br />  <br />


            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>


                <?php
                    //Query to get All Admin
                    $sql = "SELECT * FROM tbl_admin";
                    //Execute the Query
                    $res = mysqli_query($conn, $sql);

                    //Check whether the Query is Executed or not
                    if($res==TRUE)
                    {
                        //Count Rows to check whether we have data in database ot not                        
                        $count = mysqli_num_rows($res); //Function to get all the rows in the database
                        $sn = 1; //Create a variable and assign the value
                        if($count>0)
                        {
                            //We have data in database
                            while($rows=mysqli_fetch_assoc($res)) 
                            {
                                //Using while loop to get all the data from the database
                                //And while loop will run as long as we have database

                                //Get individual data
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                //Display the values in our table

                                ?>
                                <tr>
                                    <td><?php echo $sn++ ;?></td>
                                    <td><?php echo $full_name ;?></td>
                                    <td><?php echo $username ;?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php? id=<?php echo $id; ?>" class="btn-primary">Change password</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php? id=<?php echo $id; ?>" class="btn-secondary">Update admin</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php? id=<?php echo $id; ?>" class="btn-danger">Delete admin</a>
                                    </td>
                                </tr>  
                                <?php
                            }   
                        }
                        else{
                            //We dont have data in database
                        }
                    }
                ?>

            </table>
            </div>
        </div>
        <!-- Main content section ends -->
        

    </body>
    <?php include('partials/footer.php'); ?>