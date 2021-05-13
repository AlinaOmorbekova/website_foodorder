<?php
    //Authorization access control
    //Check whether the user is logged in or not
	if(!isset($_SESSION['user']))//if user session is not set
	{
		//User isnot logged in
		//Redirect message to login page
		
		$_SESSION['no-login-message'] = "<div class='error'>Please login to access Admin Panel</div>";
		header('location:'.SITEURL.'admin/login.php');
	}
     
?>