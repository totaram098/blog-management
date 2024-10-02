<?php 
	session_start();
	$dashboard_of = 'Admin';
	require_once("../connection.php");
	require_once("../session_mantain_roles.php");
	if (!isset($_GET['id']) && !isset($_GET['username'])) {
		header("location:logs.php");
	}
	$user_id = $_GET['id'];
	$username = $_GET['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard</title>
</head><style>
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
		<h1>Logs Of <?= $username;?></h1>
		<p>
			<a href="logs.php"  class="logout">Back</a>
			<a href="../logout.php"  class="logout">logout</a>
		</p>
		<br>
		<span style="color: <?= $_GET['color']??""; ?>"><?= $_GET['msg']??"";?></span>
		<?php 
			$query = "SELECT * FROM logs WHERE user_id = '{$user_id}'";
			$result = mysqli_query($connection,$query);
			if ($result->num_rows>0) {
		?>

		<table class="posts" border="1" cellspacing="5" cellpadding="15">
			<tr>
				<th>Sr.No</th>
				<th>Login Date And Time</th>
				<th>Logout Date And Time</th>
			</tr>
		<?php	
			$i = 1;	
			while($row = mysqli_fetch_assoc($result)){
			extract($row);		
		?>
			<tr>
				<td><?=$i;?></td>
				<td>
					<?= ($login)?date('Y-m-d h:i:s A',strtotime($login)):""; ?>
				</td>
				<td>
					<?= ($logout)?date('Y-m-d h:i:s A',strtotime($logout)):""; ?>
				</td>
			</tr>

		<?php
				$i++;
				}
			}else{
					?>
					<tr>
						<td colspan="3">
							No Logs Of This User.
						</td>
					</tr>
					<?php
				}
		?>
		</table>
	</center>	

</body>
</html>