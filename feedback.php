<?php 
	session_start();
 ?>


  <?php 
 	include 'db_conn.php';
 	if(!isset($_SESSION['id'])){
 		echo "<script>alert('You must Login First...')</script>";				
		echo "<script>window.location='index.html'</script>";	
 	}
 	$id = $_SESSION['id'];
 	$query = "select * from skn_feedback_users where id='$id'";
		$result = mysqli_query($conn,$query);
		if($result->num_rows>0){
			$row = $result->fetch_assoc();
			$active = $row['active'];
			$_SESSION['active'] = $active;
			if(!$active){
				echo "<script>alert('You have already given feedback...')</script>";				
				echo "<script>window.location='index.html'</script>";
			}else if($active==3){
				echo "<script>alert('Feedback is Closed Now...')</script>";				
				echo "<script>window.location='index.html'</script>";
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
				
				<button class="login100-form-btn btn_upload" onclick="logout()">Log Out</button>

				<h2><center>Student Feedback</center></h2>
				<br>

				<center>
					1. Give your unbiased rating, as you feel genuine.<br>
					2. Enter your rating on differen parameters for the teacher under the subject he/she is teaching.<br>
					3. Give your rating on different parameters in 5 point scale as follows : 
				</center>

				<br>
				<div class="container">
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-2">Excellent - 5</div>
						<div class="column col-sm-2">Very Good - 4</div>
						<div class="column col-sm-2">Good - 3</div>
						<div class="column col-sm-2">Average - 2</div>
						<div class="column col-sm-2">Poor - 1</div>
						<div class="col-sm-1"></div>
					</div>
				</div>
				<br>

				<form class="validate-form" action="feedback_db.php" method="post" onsubmit="return check()">

					<div class="container">
						<div class="row">
							<div class="col-sm-1"></div>
							<div class="column col-sm-1">Sr. No.</div>
							<div class="column col-sm-3">Parameter</div>
							<?php 
									include 'adjust.php';
									date_default_timezone_set('Asia/Kolkata');
									$year = date('Y');
									$class=adjClass($_POST['class']);
									$sem=$_POST['sem'];
									$dept=adjDept($_POST['dept']);
									$div=adjDiv($_POST['div']);
									$batch=$_POST['batch'];

									$_SESSION['year'] = $year;
									$_SESSION['class'] = $class;
									$_SESSION['sem'] = $sem;
									$_SESSION['dept'] = $dept;
									$_SESSION['div'] = $div;
									$_SESSION['batch'] = $batch;

									  $query = "select name,sub_code from skn_feedback_staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='pt' or work='t')";
									$result = mysqli_query($conn,$query);
									if(!$result->num_rows){
											echo "<script>alert('No Feedback for this selection...')</script>";
											echo "<script>window.location='student.php'</script>";
										}
									 $total_cols=$result->num_rows;
									 ?>
							<div class="column col-sm-7">
								Theory Courses
								<div class="row"><div class="col-sm"><br></div></div>
									 <div class="row">
									 	<?php 
									 		 $subjects=array();
											 $staff=array();
											 $i=0;
											 if($result->num_rows){
												while ($record = $result->fetch_assoc()) {
													$subjects[$i]=$record['sub_code'];
													//echo "<th>".$subjects[$i]."</th>";
													// echo "<div class='column box col-sm-2'>".$subjects[$i]."</div>";
													$staff[$i++]=$record['name'];
											 	}
											 }
									 	 ?>
									 </div>
									 <div class="row">
									 	<?php 
									 		for ($i=0; $i < $total_cols; $i++)
												echo "<div class='column box col-sm-2'>".$subjects[$i]."<br>".$staff[$i]."</div>";
											//echo "<th>".$staff[$i]."</th>";	
									 	 ?>
									 </div>
							</div>

							<!-- <div class="col-sm-1"></div> -->
						</div>

						<div class="row">
							<?php 
								$questions=["How Is the teacher's command on the course?",
									"How clearly the teacher explains the topics?",
									"How interactive and interesting the class is?",
									"How competent the teacher is in clarifying doubts?",
									"How clearly the teacher communicates?",
									"How much the teacher solves problems in the class?",
									"What about regular class test and home assignment?",
									"How the teacher responds to your personal needs?",
									"How friendly the teather is?",
									"How regular and punctual the teacher is?"
									];

							 	for ($j=0; $j < 7; $j++) { 
							 	// 	echo "<tr>";
									// echo "<td>".($j+1)."</td>";
									// echo "<td class='question'>".$questions[$j]."</td>";
									// for ($i=0; $i < $total_cols; $i++) { 
									// 	$name='q'.($j+1).$subjects[$i];
									// 	echo "<td>
									// 		<select name='$name' id='$name' class='input100'>
									// 			<option value='-1'></option>
									// 			<option value='1'>1</option>
									// 			<option value='2'>2</option>
									// 			<option value='3'>3</option>
									// 			<option value='4'>4</option>
									// 			<option value='5'>5</option>
									// 		</select>
									// 		</td>";
									// }
									// echo "</tr>";
							 	// }
							 ?>		
							<div class="col-sm-1"></div>
							<div class="column col-sm-1"><?php echo ($j+1); ?></div>
							<div class="column col-sm-3"><?php echo $questions[$j]; ?></div>
							<div class="column col-sm-7">
									 <div class="row">
									 	<?php 
									 		for ($i=0; $i < $total_cols; $i++) { 
											$name='q'.($j+1).$subjects[$i];
											echo "<div class='column box col-sm-2'>
												<select name='$name' id='$name' class='select'>
													<option value='-1'>$subjects[$i]</option>
													<option value='1'>1</option>
													<option value='2'>2</option>
													<option value='3'>3</option>
													<option value='4'>4</option>
													<option value='5'>5</option>
												</select>
											</div>";
										}
									 	 ?>
									 </div>
							</div>
							<?php } ?>
							<!-- <div class="col-sm-1"></div> -->
						</div>
					</div>

					<div class="container">
						<div class="row">
							<div class="col-sm-1"></div>
							<div class="column col-sm-1">Sr. No.</div>
							<div class="column col-sm-3">Parameter</div>
							<?php 
						 		$query = "select name,sub_code,batch from skn_feedback_staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='pt' or work='p')";
								$result = mysqli_query($conn,$query);
								 $total_cols2=$result->num_rows;
					 		 ?>
							<div class="column col-sm-7">
								Practical Courses
								<div class="row"><div class="col-sm"><br></div></div>
									 <div class="row">
									 	<?php 
									 		 $subjects2=array();
											$staff2=array();
											$batches;
											$i=0;
											$count_cols=0;
											if($result->num_rows){
												while ($record = $result->fetch_assoc()) {
													$batches=$record['batch'];
													if(strstr($batches,$batch)){
														$subjects2[$i]=$record['sub_code'];
														//echo "<th>".$subjects2[$i]	."</th>";
														 $staff2[$i++]=$record['name'];
													}
													$count_cols++;
												}
											}
											 
									 	 ?>
									 </div>
									 <div class="row">
									 	<?php 
									 		for ($i=0; $i < count($staff2); $i++)
												echo "<div class='column box col-sm-2'>".$subjects2[$i]."<br>".$staff2[$i]."</div>";
											//echo "<th>".$staff[$i]."</th>";	
									 	 ?>
									 </div>
							</div>

							<!-- <div class="col-sm-1"></div> -->
						</div>


						<div class="row">
							<?php
							 	for ($j=7; $j < 10; $j++) {
							 ?>		
							<div class="col-sm-1"></div>
							<div class="column col-sm-1"><?php echo ($j+1); ?></div>
							<div class="column col-sm-3"><?php echo $questions[$j]; ?></div>
							<div class="column col-sm-7">
									 <div class="row">
									 	<?php 
									 		for ($i=0; $i < count($staff2); $i++) { 
											$name='q'.($j+1).$subjects2[$i];
											echo "<div class='column box col-sm-2'>
												<select name='$name' id='$name' class='select'>
													<option value='-1'>$subjects2[$i]</option>
													<option value='1'>1</option>
													<option value='2'>2</option>
													<option value='3'>3</option>
													<option value='4'>4</option>
													<option value='5'>5</option>
												</select>
											</div>";
										}
										$_SESSION['subjects'] = $subjects;
							 			$_SESSION['staff'] = $staff;
										$_SESSION['subjects2'] = $subjects2;
					 					$_SESSION['staff2'] = $staff2;
									 	 ?>
									 </div>
							</div>
							<?php } ?>
							<div class="col-sm-1"></div>
						</div>

					</div>

				<style type="text/css">
					#req{
						color: red;
						font-size: 20px;
						font-weight: bold;
						display: none;
					}	
				</style>

				<center>
					<span id="req">All Fields are Required...</span>
				</center>
				<br>
				<center>
						<button class="login100-form-btn" name="feedback">
							Submit
						</button>
				</center>
				</form>
				<br>
			</div>
		</div>
	</div>

<?php 
	
 ?>

	<script type="text/javascript">
		function check() {
			var subs = '<?php 
					$subs='';
					for ($i=0; $i < count($subjects); $i++) { 
						$subs = $subs.$subjects[$i].',';
					}
					echo $subs;
				 ?>';
		var subjects = subs.split(",");

			for (var j = 0; j <subjects.length-1; j++) {
				var sub = subjects[j];
				for (var i = 0; i < 7; i++) {
					if (document.getElementById('q'+(i+1)+sub).value==-1) {
						// alert('All Fields are Required');
						document.getElementById('req').style.display='inline';
						return false;
					}
				}
			}

			var subs2 = '<?php 
					$subs2='';
					for ($i=0; $i < count($subjects2); $i++) { 
						$subs2 = $subs2.$subjects2[$i].',';
					}
					echo $subs2;
				 ?>';
			var subjects2 = subs2.split(",");

				for (var j = 0; j <subjects2.length-1; j++) {
					var sub2 = subjects2[j];
					for (var i = 0; i < 3; i++) {
						if (document.getElementById('q'+(i+1+7)+sub2).value==-1) {
							document.getElementById('req').style.display='inline';
							return false;
						}
					}
				}

		}

	</script>
	<?php include 'foot.php'; ?>

</body>
</html>