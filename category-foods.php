<?php include('partials-front/menu.php'); ?>



<?php 
    //Check whether the id is passed or not
    if(isset($_GET['category_id']))
    {
        //Category id is set and get the id
        $category_id = $_GET['category_id'];
        //Get the category title based on category id
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
        //Execute the query
        $res = mysqli_query($conn,$sql);

        //Count the rows to check whether the id is valid or not
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            $row=mysqli_fetch_assoc($res);     
            // Get the title
            $category_title = $row['title'];
        }
        else
        {
            //Category not passed
            //Redirect to home page
            header("location:".SITEURL);
        }
    }
    else
    {
        //Category not passed
        //Redirect to home page
        header("location:".SITEURL);
    }

?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2 class="text-white">Foods on <a href="#" class="text-colorful">"<?php echo $category_title;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>


            <?php
                //create SQL query to get foods based on clicked category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);
                //count rows to check whether the category is available
                $count2 = mysqli_num_rows($res2);

                if($count2>0)
                {
                    //category is available
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                      $id = $row2['id'];
                      $title = $row2['title'];
                      $price = $row2['price'];
                      $description = $row2['description'];
                      $image_name = $row2['image_name'];

                      ?>
                      <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                //check if image is available
                                    if($image_name == "")
                                    {
                                        //display message
                                        echo "<div class='error'>Image is not available.</div>";
                                    }
                                    else{
                                        //image available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>assets/img/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php

                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price">$<?php echo $price;?></p>
                                <p class="food-detail">
                                    <?php echo $description;?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                      <?php
                    }  
                }
                else{
                    //category is not available
                    echo "<div class='error'>Food not available.</div>";
                }
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>