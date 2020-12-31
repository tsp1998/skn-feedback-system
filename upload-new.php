<?php
	session_start();
		$id = $_SESSION['id'];
		if(empty($id)){
			echo "<script>alert('Wrong Information');</script>";
			header("Location:admin-new.php");
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
</head>
<body>
	<h1>Technical World</h1>
	<h2>Admin Panel</h2>	
	<a href="logout-new.php">Log Out</a><br><br>
	<h2>Upload File</h2>
	<form action="upload-db-new.php" method="post" enctype="multipart/form-data">
		Select File : <input type="file" name="file" id='file'>
		<br>
		Location : <input type="text" name="location">
		<br>
		<input type="submit" name="upload" value="Upload">
	</form>

	<br><br><a href="admin-panel-new.php">Goto Admin Panel</a><br>
</body>
</html>