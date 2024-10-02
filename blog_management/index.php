<?php 
	session_start();
	require_once('redirect_function.php');
	if (isset($_SESSION['user_data'])) {
		$role = $_SESSION['user_data']['role'];
		redirect($role.'/dashboard.php');
	}

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
	<center>
		<br>
		<span style="color: <?= $_GET['color']??""; ?>"><?= $_GET['msg']??"";?></span>
		<br>
		<br>
		<fieldset>
			<legend>
				LOGIN FORM
			</legend>
			<form action="process.php" method="POST">

				<table border="1" cellpadding="5">
					
					<tr>
						<td>Email</td>
						<td>
							<input type="email" name="email" placeholder="Enter Email" required>
						</td>
					</tr>
					
						<td>Password</td>
						<td>
							<input type="Password" name="password" placeholder="Enter Password" required>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" name="login" value="Login">

						</td>
					</tr>
				</table>
			</form>
		</fieldset>
		<h5>
			Don`t Have Account ? <a href="register.php">SignUp</a>
		</h5>
	</center>
</body>
</html>