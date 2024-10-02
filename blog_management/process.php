<?php 
	session_start();
	require_once('connection.php');
	require_once('redirect_function.php');
	if (isset($_POST['login'])) {
		extract($_POST);
		$query = "SELECT * FROM users u INNER JOIN roles r
				ON u.role_id = r.role_id WHERE u.email = '{$email}' AND 
		        u.password = '{$password}'";

		$result = mysqli_query($connection,$query);
		if ($result->num_rows > 0) {
			$_SESSION['user_data'] = mysqli_fetch_assoc($result);
			$role  = $_SESSION['user_data']['role']."/dashboard.php";
			date_default_timezone_set("Asia/karachi");
			$user_id = $_SESSION['user_data']['user_id'];
			$login_time = date("Y-m-d H:i:s");

			$query ="INSERT INTO logs VALUES(null,'{$user_id}','{$login_time}',null)";
			$result = mysqli_query($connection,$query);
			if(!$result){
				redirect("index.php?msg=Something Went Wrong..!&color=orangered");
			}
			$log_id = mysqli_insert_id($connection);
			$_SESSION['user_data']['log_id'] = $log_id;
			redirect($role);
			exit;
		}else{
			redirect("index.php?msg=Email/Password Invalid..!&color=orangered");
		}
	}
	else if (isset($_POST['register'])) {
		extract($_POST);
		$gender = $gender??"";
		$query  = "INSERT INTO users VALUES (null,'{$role_id}','{$first_name}','{$last_name}','{$gender}','{$email}','{$password}')";
		$result = mysqli_query($connection,$query);
		if ($result) {
			redirect("register.php?msg=You have been registered successfully..!&color=green");
		}else{
			$msg  = "<br>Registration Failed..!<br>";
			$msg .=  mysqli_error($connection);
			redirect("register.php?msg=".$msg."&color=orangered");
		}
	}
	else if (isset($_POST['update'])) {
		extract($_POST);
		$user_id = $_SESSION['user_data']['user_id'];
		$gender = $gender??"";
		$query  = "UPDATE users SET role_id = '{$role_id}',first_name = '{$first_name}', last_name = '{$last_name}',gender = '{$gender}',email = '{$email}',password = '{$password}' WHERE user_id = '{$user_id}'";
		
		$result = mysqli_query($connection,$query);
		if ($result) {
			$query = "SELECT * FROM users u INNER JOIN roles r
				ON u.role_id = r.role_id WHERE u.user_id = '{$user_id}'";
			$result = mysqli_query($connection,$query);
			if ($result->num_rows > 0) {
				$data = mysqli_fetch_assoc($result);
				$_SESSION['user_data'] = $data;
			}
			redirect("user/dashboard.php?msg=Profile Has been updated successfully..!&color=green");
		}else{
			$msg  = "<br>Updation Failed..!<br>";
			$msg .=  mysqli_error($connection);
			redirect("user/dashboard.php?msg=".$msg."&color=orangered");
		}
	}
	
?>