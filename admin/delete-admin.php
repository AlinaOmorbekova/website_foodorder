<?php
//Include constants.php file
include('../config/constants.php');

//1. get the ID of admin to delelte it
$id = $_GET['id'];

//2. create SQL query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";
//Execute the query
$res = mysqli_query($conn, $sql);
//Check whether the query executed successfully or not
if($res==true)
{
    //Query executed successfully and admin delelted
    $_SESSION['delete'] = "<div class='success'>Admin Deleted successfully.</div>";
    //redirect to Manage Admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
    //Failed to delete admin
    //Create session variable to show the message
    $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try again later</div>";
    //redirect to Manage Admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
//3. Redirect to Manage Admin page with message(success/error)

?>