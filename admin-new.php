<!DOCTYPE html>
<html>

<head>
	<title>Admin Page</title>
</head>

<body>
	<h1>Technical World</h1>
	<h2>Admin Page</h2>
	<form action="admin-panel-new.php" method="post">
		<table>
			<tr>
				<td>User</td>
				<td><input type="text" name="user"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="pass"></td>
			</tr>
		</table>
		<input type="submit" name="login" value="Login">
	</form>
</body>

</html>