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
		<h1>Filling Logs Of <?= $username;?></h1>
		<p>
			<a href="logs.php"  class="logout">Back</a>
			<a href="../logout.php"  class="logout">logout</a>
		</p>
		<br>
		<table class="posts" border="1" cellspacing="5" cellpadding="15">
			<tr>
				<th>Sr.No</th>
				<th>Login Date And Time</th>
				<th>Logout Date And Time</th>
			</tr>
			<?php 
				$file_name = "../logs/".$username.$user_id.".txt";
				if(file_exists($file_name)){
					$file_resource = fopen($file_name, "r");
					$count = 1;
					$i = -2;
					while ($line = fgets($file_resource)) {
						if($count>3){
							$log_time = explode("||",$line);
						?>
						<tr>
							<td><?= $i;?></td>
							<td>
								<?= ($log_time[0])?date('Y-m-d h:i:s A',strtotime($log_time[0])):""; ?>
							</td>
							<td>
								<?= ($log_time[1])?date('Y-m-d h:i:s A',strtotime($log_time[1])):""; ?>
							</td>
						</tr>
						<?php
						}
						$count++;
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