<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br> <br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form method="POST" action="" enctype="multipart/form-data"/>
            <table class="tbl-30">

            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Title of the food">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <td>Select image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                    <?php
                        //create PHP code to display categories from database
                        //1. Create SQL to get all active categories from Database
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        //executing the query
                        $res = mysqli_query($conn, $sql);

                        //count rows to check whether we have categories
                        $count = mysqli_num_rows($res);

                        if($count>0)
                        {
                            //we have categories
                            while($row = mysqli_fetch_assoc($res))
                            {
                                //get the details of categories
                                $id = $row['id'];
                                $title = $row['title'];

                                ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                            }
                        }
                        else{
                            //we dont have categories
                            ?>
                                <option value="0">No category found</option>

                            <?php
                        }
                    ?>

                    </select>
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
                        <input type="submit" name="submit" value="Add food" class="btn-secondary">
                    </td>
            </tr>



            </table>
        </form>


       <?php
        if(isset($_POST['submit']))
        {
            //1. get the data from Form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

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

            //2. Upload the image if selected
            //Check whether the image is selsected or not and Set the value for img
            if(isset($_FILES['image']['name']))
            {
                //get the details of selected image
                $image_name = $_FILES['image']['name'];

                //check whether the image is selected
                if($image_name!="")
                {
                    //image is selected
                    //A. rename the image
                    //get the extention
                    $ext = end(explode('.',$image_name));
                    //create new name for image
                    $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;

                    //B. upload the image
                    //get the source and dest path

                    //src path
                    $src = $_FILES['image']['tmp_name'];
                    //destination
                    $dst = "../assets/img/food/".$image_name;

                    //finally upload the image
                    $upload = move_uploaded_file($src, $dst);

                    //check whether the image uploaded or not
                    if($upload==false)
                    {
                        //set message
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        //redirect to add category page
                        header('location:'.SITEURL.'admin/add-food.php');
                        //stop the process
                        die();

                    }
                }
            }
            else{
                $image_name = "";//set deafult value
            }
             //3. Insert into Database
                //SQL query
                //for Numerical we dont use '' to pass the value, but for Strings we must have it
                $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                ";

                //execute the Query
                $res2 = mysqli_query($conn, $sql2);
                //check whether the data inserted or not
                if($res2 == true)
                {
                    //the Data is inserted
                    $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

                }
                else{
                    //the Data is not inserted
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

        }
       ?>

    </div>
</div>




<?php include('partials/footer.php'); ?>


