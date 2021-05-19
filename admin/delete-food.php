<?php
//include constants page
    include('../config/constants.php');
    if(isset($_GET['id']) && isset($_GET['image_name']))//&& or AND we use
    {
        //process to Delete
        //1. get ID and image_name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. remove the image if available
        //check whther the image is available or not and delete if available
        if($image_name != "")
        {
            //get the path to remove
            $path = "../assets/img/food/".$image_name;
            //remove image file from folder
            $remove = unlink($path);
            //check whether the img is removed or not
            if($remove == false)
            {
                //failed to remove
                $_SESSION['upload'] = "<div class='error'>Failed to remove</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();

            }
        }

        //3. Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //execute the query
        $res = mysqli_query($conn, $sql);

        //check if the query executed
        //4. redirect to manage food with session message
        if($res == true)
        {
            //food deleted
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{
            //food not deleted
            $_SESSION['delete'] = "<div class='error'>Failed to delete food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }


    }
    else{
        //redirect to manage-food page
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>