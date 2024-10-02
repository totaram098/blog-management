<?php 
	session_start();
	$dashboard_of = 'Editor';
	require_once("../connection.php");
	require_once("../redirect_function.php");
	require_once("../session_mantain_roles.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Editor Dashboard</title>
</head>
	<style>
		*{
			color: dimgrey;
		}
		h1,h3{
			text-align: center;
			box-shadow: 3px 3px 3px dimgrey;
			background: lightgreen;
			padding: 10px;
		}
		p{
			text-align: right;
		}
		.logout{
			text-decoration: none;
			background: lightgreen;
			border: 2px solid grey;
			padding: 10px 20px;

		}
		fieldset{
			width: 600px;
			background: lightgreen;
		}
		td > input,td > textarea{
			background: lightgreen;
			width: 100%;
		}
		input[type="submit"],input[type="reset"]{
			padding: 5px;
			background: lightgreen;
		}
		table{
			width: 100%;
			text-align: left;
		}
		legend{
			color: lightgreen;
			background: white;
			border: 1px solid lightgray;
			padding: 5px 15px;
		}
		.posts tr{
			background: lightgray;
		}
		.posts tr:first-child{
			background: lightgreen;
		}
		.posts tr:nth-child(even){
			background: white;
		}
		.posts{
			text-align: center;
		}
		.posts a{
			border: 2px solid lightgreen;
			padding: 10px 20px;
		}
	</style>
<body>
	<center>
		<h1>EDITOR DASHBOARD</h1>
		<h3>WELCOME TO DASHBOARD, <?= $_SESSION['user_data']['first_name']." ".$_SESSION['user_data']['last_name']?></h3>
		<p>
			<a href="../logout.php"  class="logout">Logout</a>
		</p>
		<br>
		<span style="color: <?= $_GET['color']??""; ?>"><?= $_GET['msg']??"";?></span>
		<br>
		<br>
		<fieldset>
			<?php if (isset($_GET['action']) && $_GET['action']=="edit"){
				extract($_GET);
				$query = "SELECT * FROM posts WHERE post_id = '{$post_id}'";
				$result = mysqli_query($connection,$query);
				$row = mysqli_fetch_assoc($result);
				extract($row);
			} ?>
				
			<legend><?= (isset($_GET['action']) && $action=='edit')?"Edit":"ADD"; ?> POST</legend>
			<form action="../manage_posts.php" method="POST">
				<table cellspacing="10">
					<input type="hidden" name="post_id" value="<?= $post_id??"";?>">
					<tr>
						<th>Post Title</th>
						<td><input type="text" name="title" value="<?= $title??"";?>"></td>
					</tr>
					<tr>
						<th>Post Description</th>
						<td>
							<textarea name="description" rows="5"><?= $description??"";?></textarea>
						</td>

					</tr>
					<tr align="center">
						<td colspan="2">
							<div>
								<input type="submit" name="<?=(isset($_GET['action']) && $action=='edit')?'edit':'add'; ?>_post" value="<?=(isset($_GET['action']) && $action=='edit')?'Edit':'ADD'; ?> Post">
								<input type="reset" value="Cancel">
							</div>
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
		<br>
		<hr>
		<br>
		<h3>ALL POSTS</h3>
		<table class="posts" border="1" cellspacing="5" cellpadding="15">
			<tr>
				<th>Post ID</th>
				<th style="width:200px;">Post Title</th>
				<th style="width:500px;">Post Description</th>
				<th>Posted By</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
			<?php
				$user_id = $_SESSION['user_data']['user_id'];
				$query = "SELECT r.role,u.user_id,u.first_name,u.last_name,p.* FROM users u INNER JOIN posts p
					ON u.user_id = p.user_id INNER JOIN roles r
					ON r.role_id = u.role_id 
					WHERE u.user_id = '{$user_id}'
					ORDER BY p.post_id DESC";
				$result = mysqli_query($connection,$query);	
				if ($result->num_rows>0) {
					while ($row = mysqli_fetch_assoc($result)) {
						extract($row);
					?>
			<tr>
				<td><?= $post_id; ?></td>
				<td><?= $title; ?></td>
				<td><?= $description; ?></td>
				<td><?= $first_name ." ".$last_name; ?></td>
				<td><?= $role; ?></td>
				<td>
					<a href="#" post_id ="<?= $post_id;?>"   onclick="confrim_edit(this)">Edit</a>
					<a href="#" post_id ="<?= $post_id;?>"  onclick="confrim_delete(this)">Delete</a>
				</td>
			</tr>

					<?php	
					}
				}
				else{
					?>
				<tr style="background: orangered;">
					<td colspan="6" align="center" style="color: white;">You Have Not Posted Any Post Yet..!</td>
				</tr>	
					<?php
				}

			?>
		</table>
	</center>
	<script src="../confirmation.js"></script>
</body>
</html>