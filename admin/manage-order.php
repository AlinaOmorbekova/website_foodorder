<?php include('partials/menu.php'); ?>
        <!-- Main content section starts-->
        <div class="main-content">
            <div class="wrapper">
            <h1>Manage order</h1>
            
            <br />  <br />  <br />
            <?php
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>    
            <br> <br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Order date</th>
                    <th>Status</th>
                    <th>Customer name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>




                <?php
                    //get all the data from database
                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC";//display the latest order first
                    //execute the query
                    $res = mysqli_query($conn, $sql);
                    //serial number
                    $sn=1;
                    //count rows
                    $count = mysqli_num_rows($res);
                    if($count>0)
                    {
                        //order available
                        while($row = mysqli_fetch_assoc($res))
                        {
                            //get all the order deatils
                            $id=$row['id'];
                            $food=$row['food'];
                            $price=$row['price'];
                            $quantity=$row['quantity'];
                            $total=$row['total'];
                            $order_date=$row['order_date'];
                            $status=$row['status'];
                            $customer_name=$row['customer_name'];
                            $customer_contact=$row['customer_contact'];
                            $customer_email=$row['customer_email'];
                            $customer_address=$row['customer_address'];

                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?>.</td>
                                    <td><?php echo $food; ?></td>
                                    <td>$<?php echo $price; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td>$<?php echo $total; ?></td>
                                    <td><?php echo $order_date; ?></td>


                                    <td>
                                        <?php 
                                            //ordered, on delivery, delivered, cancelled
                                            if($status=='Ordered')
                                            {
                                                echo "<label>$status</label>";
                                            }
                                            elseif($status=='On delivery')
                                            {
                                                echo "<label style='color: orange;'>$status</label>";
                                            }
                                            elseif($status=='Delivered')
                                            {
                                                echo "<label style='color: green;'>$status</label>";
                                            }
                                            elseif($status=='Cancelled')
                                            {
                                                echo "<label style='color: red;'>$status</label>";
                                            }
                                        ?>
                                    </td>


                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $customer_contact; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                    <td><?php echo $customer_address; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update order</a>
                                    
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                    else{
                        //order not available
                        echo "<tr><td colspan='12' class='error'>Orders not available</td></tr>";
                    }
                ?>

            </table>
            </div>
        </div>
        <!-- Main content section ends -->
        

    </body>
    <?php include('partials/footer.php'); ?>