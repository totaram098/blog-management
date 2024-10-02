<?php 
	session_start();
	$dashboard_of = 'User';
	require_once("../connection.php");
	require_once("../redirect_function.php");
	require_once("../session_mantain_roles.php");
	$user_id = $_SESSION['user_data']['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Dashboard</title>
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

		a{
			text-decoration: none;
			background: lightgreen;
			color: dimgrey;
			padding: 10px 20px;
			box-shadow: 2px 2px 2px lightgray;
		}
		a.active{
			background: dimgrey;
			color: lightgreen;
			box-shadow: 2px 2px 2px lightgreen;
		}
	</style>
<body>
	<center>
		<h1>USER DASHBOARD</h1>
		<h3>WELCOME TO DASHBOARD, <?= $_SESSION['user_data']['first_name']." ".$_SESSION['user_data']['last_name']?></h3>
		<p>
			<a href="../logout.php"  class="logout">Logout</a>
			<a href="../register.php?id=<?=$user_id;?>"  class="logout">Edit Profile</a>
		</p>
		<span style="color: <?= $_GET['color']??""; ?>"><?= $_GET['msg']??"";?></span>
		<br>
		<?php
		    $page = $_GET['page']??1;

		    $query = "SELECT COUNT(post_id) 'total_records' FROM posts";
		    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));
		    $total_records = 0;
		    if ($result->num_rows>0) {
		    	$total_records = mysqli_fetch_assoc($result);
		    	$total_records = $total_records['total_records'];
		    }

		    $length = 3;
		    $offset = ($page-1)*$length;
		    $total_pages = ceil($total_records/$length);
		echo "<br>";

		if ($page>1) {
		?>
		<a href="dashboard.php?page=<?=$page-1;?>">Previous</a>
		<?php	
		}    
			for ($i=1; $i <= $total_pages; $i++) { 
				$active = ($i==$page)?"active":"";
		?>

		<a href="dashboard.php?page=<?=$i;?>" class="<?=$active?>"><?=$i;?></a>

		<?php
			}
		if ($page < $total_pages) {
		?>
		<a href="dashboard.php?page=<?=$page+1;?>">Next</a>

		<?php	
		}	
		echo "<br><br>";
		    
		?>

		<h3>ALL POSTS</h3>
		<table class="posts" border="1" cellspacing="5" cellpadding="15">
			<tr>
				<th>Post ID</th>
				<th style="width:200px;">Post Title</th>
				<th style="width:600px;">Post Description</th>
				<th>Posted By</th>
				<th>Role</th>
			</tr>
			<?php
				$user_id = $_SESSION['user_data']['user_id'];
				$query = "SELECT r.role,u.user_id,u.first_name,u.last_name,p.* FROM users u INNER JOIN posts p
					ON u.user_id = p.user_id INNER JOIN roles r
					ON r.role_id = u.role_id  LIMIT $offset,$length";
		    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));
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
			</tr>

					<?php	
					}
				}
				else{
					?>
				<tr style="background: orangered;">
					<td colspan="6" align="center" style="color: white;">THERE IS NO ANY POST POSTED YET..!</td>
				</tr>	
					<?php
				}

			?>
		</table>
	</center>
</body>
</html>