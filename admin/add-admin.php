<?php include('partials/menu.php'); ?>
<!-- Main content section starts-->
    <div class="main-content">
        <div class="wrapper">
            <h1>Add admin</h1>

            <br>
            <?php
                if(isset($_SESSION['add'])) //Check wherether the session is set or not
                {
                     echo $_SESSION['add'];  //Displaying Session message
                     unset($_SESSION['add']); //Removing Session message 
                }
            ?>

            <br> <br>

            <form action="" method="POST">

            <table class="tbl-30">
            <tr>
            <td>Full name:</td>
            <td>
                <input type="text" name="full_name" placeholder="Enter your Name">
            </td>
            </tr>

            <tr>
            <td>User name:</td>
            <td>
                <input type="text" name="username" placeholder="Your Username">
            </td>
            </tr>

            <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="password" placeholder="Your Password">
            </td>
            </tr>

            <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Add admin" class="btn-secondary">
            </td>
            </tr>
            </table>

            </form>
        </div>
    </div>
<?php include('partials/footer.php'); ?>


<?php
// Process the info from Form and save it in the Database

//Check whether the Submit button is clicked or not
    //Button clicked 
    if(isset($_POST['submit']))
    {
        //1. Get the Data from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Encrypting password with md5

        //2. SQL Query to save data to Database
        $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
        ";
        echo $sql;

        //3. Execute Query and save data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_connect_error());

        //4. Check whether the (Query is executed) data isinserted or not and show appropriate message
         //4. Check where the (Query is executed) data is inserted or not and display appropriate message
         if($res == TRUE){
            //Data inserted
            //echo "Data inserted";
            //Create a Session variable to display message
            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            //Data not inserted
            //echo "Data not inserted";
            //Create a Session variable to display message
            $_SESSION['add'] = "Fail to add Admin";
            //Redirect page to Manage Admin
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }

      


?>