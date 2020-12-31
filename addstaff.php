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

				<a class='link' href ="admin.php"> Home </a> 
				<a class='link' href ="addstaff.php"> Add Staff </a> 
				<a class='link' href ="report.php">Report</a> 
				
				<button class="login100-form-btn btn_upload" onclick="logout()">Log Out</button>


				<center>Add Staff</center>

				<form class="login100-form validate-form" action="addstaff_db.php" method="post">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Staff Name is required">
						<span class="label-input100">Name</span>
						<input class="input100" type="text" name="name" placeholder="Enter Staff Name">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-26" data-validate="Subject Name is required">
						<span class="label-input100">Subject</span>
						<input class="input100" type="text" name="sub_name" placeholder="Enter Subject Name">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-26" data-validate="Subject Code is required">
						<span class="label-input100">Code</span>
						<input class="input100" type="text" name="sub_code" placeholder="Enter Subject Code">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-26" data-validate="Division is required">
						<span class="label-input100">Division</span>
						<select name="div" class="input100">
							<option value="-1">Division</option>
							<option value="1">A</option>
							<option value="2">B</option>
							<option value="3">C</option>
							<option value="4">D</option>
							<option value="5">E</option>
							<option value="6">-</option>
						</select>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-26" data-validate="Semester is required">
						<span class="label-input100">Semester</span>
						<select name="sem" class="input100">
							<option value="-1">Select Semester</option>
							<option value="1">First Sem</option>
							<option value="2">Second Sem</option>
							<option value="3">Third Sem</option>
							<option value="4">Fourth Sem</option>
							<option value="5">Fifth Sem</option>
							<option value="6">Sixth Sem</option>
							<option value="7">Seventh Sem</option>
							<option value="8">Eighth Sem</option>
						</select>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-26" data-validate="Department is required">
						<span class="label-input100">Department</span>
						 <select name="dept" class="input100">
							<option value="-1">Your Department</option>
							<option value="1">CSE</option>
							<option value="2">Mechanical</option>
							<option value="3">EnTC</option>
							<option value="4">Civil</option>
							<option value="5">Electrical</option>
							<option value="6">First Year</option>
						</select>
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="add_sub">
							Add Subject
						</button>
					</div>
				</form>

			</div>
		</div>
	</div>

	<?php include 'foot.php'; ?>

</body>
</html>