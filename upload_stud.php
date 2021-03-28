<?php
session_start();
?>

<?php
if (isset($_FILES['file'])) {

	$errors = array();
	$_SESSION['file_name'] = $file_name = $_FILES['file']['name'];
	$file_size = $_FILES['file']['size'];
	$file_tmp = $_FILES['file']['tmp_name'];
	$file_type = $_FILES['file']['type'];
	$file_ext = explode('.', $_FILES['file']['name']);
	$file_ext = $file_ext[count($file_ext) - 1];
	$file_ext = strtolower($file_ext);
	// echo $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));

	$expensions = array("csv", "xlsx");

	if (in_array($file_ext, $expensions) === false) {
		$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
	}

	if ($file_size > 2097152) {
		$errors[] = 'File size must be excately 2 MB';
	}

	if (empty($errors) == true) {
		move_uploaded_file($file_tmp, "uploads/" . $file_name);
		echo "<script>alert('file Uploaded')</script>";
		echo "<script>window.location ='upload_stud_db.php'</script>";
	} else {
		print_r($errors);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<?php
				include 'header.html';
				?>

				<link rel="stylesheet" type="text/css" href="css/tsp.css">

				<br>

				<a class='link' href="admin.php"> Home </a>
				<a class='link' href="fbstart.php">Start Feedback</a>
				<a class='link' href="report.php">Report</a>

				<button class="login100-form-btn btn_upload" onclick="logout()">Log Out</button>


				<form class="login100-form validate-form" action="" method="post" enctype="multipart/form-data">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">CSV File</span>
						<input class="input100" type="file" name="file" />
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Upload File
						</button>
					</div>
				</form>

</body>

</html>
</div>
</div>
</div>
<?php include 'foot.php'; ?>
</body>

</html>