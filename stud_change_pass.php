<?php 
	session_start();
 ?>

<?php 
	if (isset($_POST['change_pass'])) {
		$id = $_SESSION['id'];
		$pass = $_SESSION['pass'];
		$pass_old = $_POST['pass_old'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		if($pass!=$pass_old){
			echo "<script>alert('Old Password Incorrect')</script>";
			echo "<script>window.location='stud_change_pass.php'</script>";
		}else if($pass1!=$pass2){
			echo "<script>alert('Password Not Match')</script>";
			echo "<script>window.location='stud_change_pass.php'</script>";
		}else{
			include 'db_conn.php';
			$pass1=md5($pass1);
			$query = "update skn_feedback_users set pass = '$pass1' where id = '$id'";
			$result = mysqli_query($conn,$query);
			if ($result){
				echo "<script>alert('Password Changed Successfully')</script>";
				echo "<script>window.location='student.php'</script>";
			}else{
				echo "<script>alert('Password not Changed')</script>";
				echo "<script>window.location='stud_change_pass.php'</script>";
			}
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
				<div class="login100-form-title"
					style="background-image: url(images/bg-01.jpg);">
					<span class="login100-form-title-1"> SKN Feedback System<br>
						Student Page
					</span>
				</div>

				<style type="text/css">
					.link{
						font-size: 18px;
						margin: 8px;
						font-weight: bold;
					}
				</style>

				<br>
				
				<a class='link' href ="student.php"> Home </a> 
				<a class='link' href ="feedback.php">Give Feedback</a> 
				<a class='link' href ="stud_profile.php"> Profile </a> 
				<a class='link' href ="stud_change_pass.php">Change Password </a> 
				<a class='link' href ="suggestion.php"> Suggestions </a> 
				
				<a href ="logout.php">
					<button class="login100-form-btn btn_upload">Log Out</button>
				</a>
				
				<form class="login100-form validate-form" action="" method="post">

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Old</span>
						<input class="input100" type="password" name="pass_old" placeholder="Enter Old password">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">New</span>
						<input class="input100" type="password" name="pass1" placeholder="Enter New password">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Confirm</span>
						<input class="input100" type="password" name="pass2" placeholder="Confirm password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="change_pass">
							Change Password
						</button>
					</div>
				</form>

			</div>
		</div>
	</div>

	<?php include 'foot.php'; ?>

</body>
</html>