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


				<button class="login100-form-btn btn_upload" onclick="logout()">Log Out</button>

				<form class="login100-form validate-form" action="fbstart_db.php" method="post">

					<div class="wrap-input100 validate-input m-b-26" data-validate="Class is required">
						<span class="label-input100">Feedback</span>
						<select name="feedback" class="input100">
							<option value="-1">Start Feedback</option>
							<option value="1">Start Feedback First</option>
							<option value="2">Start Feedback Second</option>
							<option value="3">Close Feedback</option>
						</select>
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="start">
							Proceed
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php include 'foot.php'; ?>

</body>

</html>