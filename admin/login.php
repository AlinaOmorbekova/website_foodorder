<?php include('../config/constants.php');?>

<html>
    <head>
        <title>Login page - Food order system</title>
        <link rel="stylesheet" href="../assets/css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br> <br>

            
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br> <br>

            <!-- Login form starts here-->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"> <br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter password"> <br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br> <br>
            </form>

            <!-- Loin form ends here-->
            <p class="text-center">Created by Alina Omorbekova</p>
        </div>
    </body>
</html>


<?php
    //Check whether the submit is clicked
    if(isset($_POST['submit']))
    {
        //1. Get the data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL to check whether the user with username exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the Query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User available and Login success
           
            $_SESSION['login'] = "<div class='success text-center'>Login successfully.</div>";
            $_SESSION['user'] = $username;
            //redirect to Home page
            header('location:'.SITEURL.'admin/');
        }
        else{
            //User not available
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
            //Redirect to Home page
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>