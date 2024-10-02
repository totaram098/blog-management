<?php 
	session_start();
	require_once("connection.php");
	require_once("redirect_function.php");
	$role = $_SESSION['user_data']['role'];

	if (isset($_POST['add_post'])) {
		$user_id = $_SESSION['user_data']['user_id'];
		extract($_POST);
		$title = htmlspecialchars($title);
		$description = htmlspecialchars($description);
		$query = "INSERT INTO posts VALUES(NULL,'{$user_id}','{$title}','{$description}')";
		$result = mysqli_query($connection,$query);
		if ($result) {
			$last_id = mysqli_insert_id($connection);
			redirect($role."/dashboard.php?msg=Post ID : ".$last_id." Added Successfully..!&color=green");
		}else{
			redirect($role."/dashboard.php?msg=Post Not Added..!&color=orangered");

		}
	}
	else if (isset($_POST['edit_post'])) {
		extract($_POST);
		$description = htmlspecialchars($description,true);
		$title = htmlspecialchars($title,true);
		$query = "UPDATE  posts SET title = '{$title}',
		description ='{$description}' WHERE post_id = '{$post_id}'";
		$result = mysqli_query($connection,$query);
		if ($result) {
			redirect($role."/dashboard.php?msg=Post ID : ".$post_id." Updated Successfully..!&color=green");
		}else{
			redirect($role."/dashboard.php?msg=Post Not Updated..!&color=orangered");

		}
	}
	else if (isset($_GET['action']) && $_GET['action']=='delete') {
		extract($_GET);
		$query = "DELETE FROM posts WHERE post_id = '{$post_id}'";
		$result = mysqli_query($connection,$query);
		if ($result) {
			redirect($role."/dashboard.php?msg=Post ID : ".$post_id." Deleted Successfully..!&color=green");
		}else{
			redirect($role."/dashboard.php?msg=Post Not Deleted..!&color=orangered");

		}
	}

?>