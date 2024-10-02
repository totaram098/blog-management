<?php 
	session_start();
	require_once('connection.php');
	require_once('redirect_function.php');
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
</head>
<style type="text/css">
	fieldset{
		width: 400px;
		padding: 5px;
		background: yellowgreen;
		color: navy;
	}
	table{
		width: 100%;
		padding: 5px;
	}
	td > input,select{
		width: 95%;
		background: none;
		outline: 1px solid navy;
	}
	input[type = "submit"]{
		background: navy;
		color: yellowgreen;
		border: 2px solid yellowgreen;
		padding: 5px;
		cursor: pointer;
		font-weight: bold;
	}
	legend{
		background: navy;
		color: yellowgreen;
		padding: 5px 20px;
	}
</style>
<body>
	<?php
		$query = "SELECT * FROM roles WHERE role != 'Admin'";
		$result = mysqli_query($connection,$query);

		if (isset($_GET['id'])) {
			$edit_query = "SELECT * FROM users WHERE user_id = '{$_GET['id']}'";
			$edit_result = mysqli_query($connection,$edit_query);
			if($edit_result){
				$data = mysqli_fetch_assoc($edit_result);
				extract($data);
				$user_role_id = $role_id;
			}
		}
	?>
	<center>
		<br>
		<span style="color: <?= $_GET['color']??""; ?>"><?= $_GET['msg']??"";?></span>
		<br>
		<br>
		<fieldset>
			<legend>
				<?= (isset($_GET['id']))?"EDIT PROFILE":"REGISTRATION FORM" ;?>
			</legend>
			<form action="process.php" method="POST">

				<table border="1" cellpadding="5">
					<tr>
						<td>First Name</td>
						<td>
							<input type="text" name="first_name" placeholder="Enter First Name" required value="<?= $first_name??"" ;?>">
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td>
							<input type="text" name="last_name" placeholder="Enter last Name"  value="<?= $last_name??"" ;?>">
						</td>
					</tr>
					<tr>
						<td>Gender</td>
						<td>
							<div>
								Male <input type="radio" name="gender" value="Male" <?= (isset($gender)&& ($gender=='Male'))?"checked":"" ;?>>

								Female <input type="radio" name="gender"  value="Female" <?= (isset($gender)&& ($gender=='Female'))?"checked":"" ;?>>
							</div>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>
							<input type="email" name="email" placeholder="Enter Email" required value="<?= $email??"" ;?>">
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td>
							<input type="Password" name="password" placeholder="Enter Password" required  value="<?= $password??"" ;?>">
						</td>
					</tr>
					<tr>
						<td>Role</td>
						<td>
							<select name="role_id" required>
								<?php
									if ($result->num_rows>0) {
										while ($row = mysqli_fetch_assoc($result)) {
											extract($row);
											?>
								<option <?= (isset($user_role_id)&& ($user_role_id==$role_id))?"selected":"" ;?> value="<?=$role_id;?>">
									<?=$role;?>
								</option>
											<?php
										}
									}
								?>
								
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" name="<?= (isset($_GET['id']))?'update':'register' ;?>" 
							value="<?= (isset($_GET['id']))?'Edit Profile':'Sign Up' ;?>">

						</td>
					</tr>
				</table>
			</form>
		</fieldset>
		<h5>
			Have Already Account ? <a href="index.php">Login Here</a>
		</h5>
	</center>
</body>
</html>