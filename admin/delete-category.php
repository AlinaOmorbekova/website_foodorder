<?php
//Include constants file
    include('../config/constants.php');
    //check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical img file is available
        if($image_name != "")
        {
            //Image is available. So remove it
            $path = "../assets/img/category/".$image_name;
            //remove the image
            $remove = unlink($path);

            //If failed to remove img then add an error message and stop the process
            if($remove==false)
            {
                //Set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image</div>";
                //redirect
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }

        //Delete data from Database
        //Sql query to delete data
        $sql = "DELETE FROM tbl_category WHERE id=$id";
        //Execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the data delete from database or not
        if($res==true)
        {
            //set success msg and redirect
            $_SESSION['delete'] = "<div class='success'>The category successfully deleted</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else{
            //set success msg and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to delete category</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else{
        //Redirect to Manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>