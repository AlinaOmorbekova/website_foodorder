<?php include('partials/menu.php'); ?>
<!-- Main content section starts-->
<div class="main-content">
            <div class="wrapper">
            <h1>Change password</h1>

            <br> <br>

            <?php
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                }
            ?>
            <form action="" method="$_POST">
                <table class="tbl-30">
                <tr>
                <td>Current password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current password">
                </td>
                </tr>

                <tr>
                <td>New password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New password">
                </td>
                </tr>

                <tr>
                <td>Confirm password:</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm password">
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change password" class="btn-secondary">
                    </td>
                </tr>

                </table>
            </form>
            </div>
</div>       


<?php
    if(isset($_POST['submit']))
    {
        echo "clicked";
    }
?>


<?php include('partials/footer.php'); ?>
