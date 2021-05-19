<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br> <br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <br> <br>


        <!-- Add category Form Starts here-->
        
        <form method="POST" action="" enctype="multipart/form-data"/>
            <table class="tbl-30">
                <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Category title">
                </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image"/>
                        
                    </td>
                </tr>
               

                <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
                </tr>
                

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add category" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>
        <!-- Add category Form Ends Here-->


        <?php
        //Check whether the Submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //1. Get the value from category form
                $title = $_POST['title'];
                //For Radio input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get the value from form
                    $featured = $_POST['featured'];
                }
                else{
                    //Set the default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else{
                    $active = "No";
                }

                //Check whether the image is selsected or not and Set the value for img
                if(isset($_FILES['image']['name']))
                {
                    //Upload the image
                    //To upload image we need img name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //Upload img only if image is selected
                    if($image_name != "")
                    {

                        //Auto rename our image
                        $ext = end(explode('.', $image_name));
                        //Rename the image
                        $image_name = "FOOD_CATEGORY_".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../assets/img/category/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);
                        //Check whther the image is uploaded or not
                        //if the img is not uploaded then redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }
                    }    
                }
                else{
                    //Dont upload img and set image_name value as blank
                    $image_name = "";
                }

                //2. SQL Query to insert data in Database
                $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                ";

                //3. Execute the Query and save into database
                $res = mysqli_query($conn, $sql);

                //4. Check whether the query executed or not and data saved or not
                if($res == true)
                {
                    //Query executed and Category Added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    //Redirect to Manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else{
                    //Failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to add Category.</div>";
                    //Redirect to Manage category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        ?>



    </div>
</div>
<?php include('partials/footer.php'); ?>