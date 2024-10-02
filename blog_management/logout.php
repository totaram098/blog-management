<?php 
	session_start();
	require_once('connection.php');
	date_default_timezone_set("Asia/karachi");
	$user_id = $_SESSION['user_data']['user_id'];
	$logout_time = date("Y-m-d H:i:s");
	$log_id = $_SESSION['user_data']['log_id'];

	$query ="UPDATE logs SET logout = '{$logout_time}' WHERE log_id = '{$log_id}'";
	$result = mysqli_query($connection,$query);
	if (!$result) {
		header("location:".$_SESSION['user_data']['role']."/dashboard.php?msg=Something Went Wrong.!&color=green");
		exit;
	}
	$file_name = "logs/".$_SESSION['user_data']['first_name'].$_SESSION['user_data']['user_id'].".txt";

	$query = "SELECT * FROM logs WHERE log_id = '{$log_id}'";
	$result = mysqli_query($connection,$query);
	$file_exists = file_exists($file_name);
	$file_resource = fopen($file_name, "a");
	if(!$file_exists){
		$heading  = "__________________________________________\n";
		$heading .= "\tLogin Time\t||\tlogout Time\t\n";
		$heading .= "__________________________________________\n";
		fwrite($file_resource,$heading);
	}
	if ($result->num_rows>0) {
		$row = mysqli_fetch_assoc($result);
		extract($row);
		$heading = "$login\t||\t$logout\n";
		fwrite($file_resource,$heading);
	}
	session_destroy();
	header("location:index.php?msg=You are logged out now..!&color=green");
?>