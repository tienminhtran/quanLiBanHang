<?php
	
	if(isset($_GET["flag"])&&$_GET["flag"]==1)
	{
		session_start();
		// remove all session variables
		session_unset();

		// destroy the session
		session_destroy();
		header("Location:login.php");
		exit;
	}
	
	
?>