<?php include('partials/menu.php'); ?>
        <!-- Main content section starts-->
        <div class="main-content">
            <div class="wrapper">
                <h1>Update order</h1>
                
                <br />  <br />  <br />



                <?php
                //check whether id is set or not
                    if(isset($_GET['id']))
                    {
                        //get the order deatils
                        $id=$_GET['id'];
                        //get all other details 
                        //sql query to get the order details
                        $sql = "SELECT * FROM tbl_order WHERE id=$id";
                        //execute the query
                        $res = mysqli_query($conn, $sql);
                        //count rows
                        $count=mysqli_num_rows($res);

                        if($count==1)
                        {
                            //detail available
                            $row = mysqli_fetch_assoc($res);

                            $food=$row['food'];
                            $price=$row['price'];
                            $quantity=$row['quantity'];
                            $status=$row['status'];
                            $customer_name=$row['customer_name'];
                            $customer_contact=$row['customer_contact'];
                            $customer_email=$row['customer_email'];
                            $customer_address=$row['customer_address'];

                        }
                        else{
                            //detail not available
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }
                    }
                    else{
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                ?>



                <form action="" method="POST">
                <table class="tbl-30">
                <tr>
                    <td>Food Name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><b>$<?php echo $price; ?></b></td>
                </tr>
                <tr>
                    <td>Qty:</td>
                    <td>
                        <input type="number" name="quantity" value="<?php echo $quantity; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=='Ordered'){ echo 'selected';}?> value="Ordered">Ordered</option>
                            <option <?php if($status=='On delivery'){ echo 'selected';}?> value="On delivery">On delivery</option>
                            <option <?php if($status=='Delivered'){ echo 'selected';}?> value="Delivered">Delivered</option>
                            <option <?php if($status=='Cancelled'){ echo 'selected';}?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>


                <tr>
                    
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
                
                </table>
                </form>

                <?php
                    if(isset($_POST['submit']))
                    {
                        //1. get all the Details from the form
                        $id = $_POST['id'];
                        $price = $_POST['price'];
                        $quantity = $_POST['quantity'];

                        $total = $price * $quantity;

                        $status = $_POST['status'];

                        $customer_name = $_POST['customer_name'];
                        $customer_contact = $_POST['customer_contact'];
                        $customer_email = $_POST['customer_email'];
                        $customer_address = $_POST['customer_address'];

                        //update the value
                        $sql2 = "UPDATE tbl_order SET
                            quantity=$quantity,
                            total=$total,
                            status='$status',
                            customer_name='$customer_name',
                            customer_contact='$customer_contact',
                            customer_email='$customer_email',
                            customer_address='$customer_address'
                            WHERE id=$id
                        ";

                        //execute the SQL query
                        $res2 = mysqli_query($conn, $sql2);

                        //check whether the query is excuted or not
                        if($res2==true)
                        {
                            //query executed and query updated
                            $_SESSION['update'] = "<div class='success'>Order updated successfully.</div>";
                            header('location:'.SITEURL.'admin/manage-order.php');
                        }
                        else{
                            //failed to update food
                            $_SESSION['update'] = "<div class='error'>Failed to update order.</div>";
                            header('location:'.SITEURL.'admin/manage-order.php');
                        }
                        //redirect to Manage order page
                    }    
                ?>      

            </div>    
        </div>
<?php include('partials/footer.php'); ?>        