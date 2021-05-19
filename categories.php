<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                //Display all the categories 
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                //execute the query
                $res = mysqli_query($conn, $sql);
                //count rows to check whether the category is available
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //category is available
                    while($row = mysqli_fetch_assoc($res))
                    {
                      $id = $row['id'];
                      $title = $row['title'];
                      $image_name = $row['image_name'];
                      
                      ?>
                      
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id;?>">
                        <div class="box-3 float-container">
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
                                    <img src="<?php echo SITEURL; ?>assets/img/category/<?php echo $image_name; ?>" width="400" height="400" alt="Pizza" class="img-responsive img-curve">
                                    <?php

                                }
                            ?>

                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                        </a>

                      <?php
                    }
                    
                }
                else{
                    //category is not available
                    echo "<div class='error'>Categories not found.</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>