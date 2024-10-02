<?php 

	$hostname = "localhost";
	$username = "root";
	$password = "";
	$database = "blog_management";
	mysqli_report(false);

	$connection = mysqli_connect($hostname,$username,$password,$database) ;
	if (mysqli_connect_errno()) {
		echo "Connection Failed..!<br>";
		echo "Error No : ".mysqli_connect_errno();
		echo "<br>Error Message : ".mysqli_connect_errno();
		die();
	}
?>