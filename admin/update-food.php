<?php include('partials/menu.php');?>

<?php
    if(isset($_GET['id']))
    {
        //get all the deatils
        $id = $_GET['id'];
        //SQL uery to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //execute the query
        $res2 = mysqli_query($conn, $sql2);
        //get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual values of selelcted food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else{
        //Redirect to manage food page
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class='main-content'>
    <div class='wrapper'>
        <h1>Update Food</h1>

        <br> <br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current image:</td>
                    <td>
                        <?php
                            if($current_image == "")
                            {
                                //image is not available
                                echo "<div class='error'>Image is not available</div>";
                            }
                            else{
                                //image available
                                ?>
                                    <img src="<?php echo SITEURL; ?>assets/img/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select new image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">


                        <?php
                        // Query to get Active categories
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        //Execute the query
                        $res = mysqli_query($conn, $sql);
                        //count rows
                        $count = mysqli_num_rows($res);
                        //check whether the category available or not
                        if($count>0)
                        {
                            //category available
                            while($row = mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];
                                
                                //echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                    <option <?php if($current_category == $category_id){ echo 'selected';}?> value="<?php echo $category_id; ?>"><?php echo $category_title;?></option>
                                <?php
                            }
                        }
                        else{
                            //category not available
                            echo "<option value='0'>Category not available</option>";
                        }

                        ?>


                            <option value="0">Test category</option> 
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=='Yes'){ echo 'checked';}?> type="radio" name="featured" value="Yes">Yes

                        <input <?php if($featured=='No'){ echo 'checked';}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=='Yes'){ echo 'checked';}?> type="radio" name="active" value="Yes">Yes

                        <input <?php if($active=='No'){ echo 'checked';}?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>


        <?php
            if(isset($_POST['submit']))
            {
                //1. get all the Details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];
                //2. upload the image if selelcted
                //check whether Upload button os clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //upload button clicked
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is selected
                    if($image_name!="")
                    {
                        //1.image is selected and need to upload
                        //A. rename the image
                        //get the extention
                        $tmp = explode('.', $image_name);
                        $ext = end($tmp);
                        //create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;

                        //B. upload the image
                        //get the source and dest path

                        //src path
                        $src_path = $_FILES['image']['tmp_name'];
                        //destination
                        $dst_path = "../assets/img/food/".$image_name;
                        //finally upload the image
                        $upload = move_uploaded_file($src_path, $dst_path);

                        //check whether the image uploaded or not
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                            //redirect to manage category page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();

                        }

                        //2. Remove current image if available
                        if($current_image != "")
                        {
                            //current image is available
                            //remove the image
                            $remove_path = "../assets/img/food/".$current_image;
                            $remove = unlink($remove_path);
                            //check whether the image uploaded or not
                            if($remove==false)
                            {
                                //failed to remove current image
                                //set message
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove image.</div>";
                                //redirect to manage category page
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop the process
                                die();

                            }
                        }
                    } 
                    else{
                        $image_name = $current_image;//default image if img is not selected
                    }   
                }
                else{
                    $image_name = $current_image;//default image when button is not clicked
                }

                //3. update food in database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                WHERE id=$id              
                ";
                //execute the SQL query
                $res3 = mysqli_query($conn, $sql3);

                //check whether the query is excuted or not
                if($res3==true)
                {
                    //query executed and query updated
                    $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    //failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                //redirect to Manage food page
            }
        ?>



    </div>
</div> 

<?php include('partials/footer.php');?>