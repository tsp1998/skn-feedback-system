<?php
session_start();
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
				<a class='link' href="staff.php">Staff Records</a>


				<button class="login100-form-btn btn_upload" onclick="logout()">Log Out</button>


				<a href="upload_stud.php">
					<button class="login100-form-btn btn_upload">Upload Student</button>
				</a>
				<a href="upload_staff.php">
					<button class="login100-form-btn btn_upload">Upload Staff</button>
				</a>
			</div>
		</div>
	</div>

	<?php include 'foot.php'; ?>

</body>

</html>