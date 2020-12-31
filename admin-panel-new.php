<?php
	session_start();
	if(isset($_POST['login'])){
		$id = $_POST['user'];
		$pass = $_POST['pass'];
		if($id=='admin' && md5($pass) == '4b76c1bf9dbe4d2a30138017942225ee'){
			$_SESSION['id'] = $id;
		}else{
			echo "<script>alert('Wrong Information');</script>";
			echo "<script>window.location = 'admin-new.php'</script>";
		}
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
	<a href="upload-new.php">1.Upload php</a>
	<br><br>
</body>
</html>