<?php 
	require_once('redirect_function.php');
	if (!isset($_SESSION['user_data'])) {
		redirect('../index.php');
	}else{
		$role = $_SESSION['user_data']['role'];
		if($dashboard_of != $role){
			redirect('../'.$role.'/dashboard.php');
		}
		
	}

?>