<?php 
	session_start();
	$dashboard_of = 'Admin';
	require_once("../connection.php");
	require_once("../session_mantain_roles.php");
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
		<h1>LOGS</h1>
		<p>
			<a href="dashboard.php"  class="logout">Back</a>
			<a href="../logout.php"  class="logout">logout</a>
		</p>
		<br>
		<span style="color: <?= $_GET['color']??""; ?>"><?= $_GET['msg']??"";?></span>
		<?php
		    $page = $_GET['page']??1;

		    $query = "SELECT COUNT(user_id) 'total_records' FROM users";
		    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));
		    $total_records = 0;
		    if ($result->num_rows>0) {
		    	$total_records = mysqli_fetch_assoc($result);
		    	$total_records = $total_records['total_records'];
		    }

		    $length = 5;
		    $offset = ($page-1)*$length;
		    $total_pages = ceil($total_records/$length);
		echo "<br>";

		if ($page>1) {
		?>
		<a href="logs.php?page=<?=$page-1;?>">Previous</a>
		<?php	
		}    
			for ($i=1; $i <= $total_pages; $i++) { 
				$active = ($i==$page)?"active":"";
		?>

		<a href="logs.php?page=<?=$i;?>" class="<?=$active?>"><?=$i;?></a>

		<?php
			}
		if ($page < $total_pages) {
		?>
		<a href="logs.php?page=<?=$page+1;?>">Next</a>

		<?php	
		}	
		echo "<br><br>";
		    
		?>

		<table class="posts" border="1" cellspacing="5" cellpadding="15">
			<tr>
				<th>Sr.No</th>
				<th>Name</th>
				<th>Action</th>
			</tr>
		<?php	
			$i = 1;

			$query = "SELECT * FROM users limit $offset,$length";
			$result = mysqli_query($connection,$query);
			if ($result->num_rows>0) {	
			while($row = mysqli_fetch_assoc($result)){
			extract($row);		
		?>
			<tr>
				<td><?=$i;?></td>
				<td><?= $first_name." ".$last_name; ?></td>
				<td>
					<a href="view_log.php?id=<?=$user_id;?>&username=<?= $first_name.' '.$last_name; ?>">VIEW LOGS</a>
					<a href="view_log_from_file.php?id=<?=$user_id;?>&username=<?= $first_name;?>">VIEW LOGS FROM FILE</a>
				</td>
			</tr>

		<?php
				$i++;
				}
			}
		?>
		</table>
	</center>	

</body>
</html>