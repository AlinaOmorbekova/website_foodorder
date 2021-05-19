<?php include('partials-front/menu.php'); ?>



<?php
    //check whether food id is set or not
    if(isset($_GET['food_id']))
    {
        //get the food ID and details of selelcted food
        $food_id = $_GET['food_id'];

        //get the deatils of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        //execute the query
        $res = mysqli_query($conn, $sql);
        //count rows to check whether the category is available
        $count = mysqli_num_rows($res);
        //check if food ia available
        if($count==1)
        {
            //we have data
            //get the data from databse
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else{
            //we dont have data
            //redirect to Home page
            header('location:'.SITEURL);
        }
    }
    else{
        //redirect to Home page
        header('location:'.SITEURL);
    }
?>




    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend style="color:#FBEEE6">Selected Food</legend>

                    <div class="food-menu-img">

                    <?php
                        //check whther the image is available or not
                        if($image_name == "")
                        {
                            //image not available
                            echo "<div class='error'>Image not available.</div>";
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
                        <h3 style="color:#FBEEE6"><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price" style="color:#FBEEE6">$<?php echo $price;?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label" style="color:#FBEEE6">Quantity</div>
                        <input type="number" name="quantity" class="input-responsive" style="color:#1B2631" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend style="color:#FAD7A0">Delivery Details</legend>
                    <div class="order-label" style="color:#FBEEE6">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Alina" class="input-responsive" required>

                    <div class="order-label" style="color:#FBEEE6">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. +996xxx" class="input-responsive" required>

                    <div class="order-label" style="color:#FBEEE6">Email</div>
                    <input type="email" name="email" placeholder="E.g. alina.omorbekova@gmail.com" class="input-responsive" required>

                    <div class="order-label" style="color:#FBEEE6">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>



            <?php
                //check if submit button clicked
                if(isset($_POST['submit']))
                {
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];

                    $total = $price * $quantity;

                    $order_date = date("Y-m-d h:i:sa");//get Order Date
                    $status = "Ordered"; //ordered, on delivery, delivered, cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //save the order in database
                    //create sql to save the data
                    $sql2 = "INSERT INTO tbl_order SET
                        food='$food',
                        price=$price,
                        quantity=$quantity,
                        total=$total,
                        order_date='$order_date',
                        status='$status',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                    ";
                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);
                    //check whether query executed or not
                    if($res2==true)
                    {
                        //query executed and order saved
                        //set message
                        $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
                        //redirect to home page
                        header('location:'.SITEURL);
                    }
                    else{
                        //set message
                        $_SESSION['order'] = "<div class='error text-center''>Failed to order food.</div>";
                        //redirect to home page
                        header('location:'.SITEURL);
                    }

                }
            ?>



        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>