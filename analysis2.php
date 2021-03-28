<?php
session_start();
?>


<?php
include 'db_conn.php';
if (!isset($_SESSION['id'])) {
	echo "<script>alert('You must Login First...')</script>";
	echo "<script>window.location='index.html'</script>";
}
$id = $_SESSION['id'];
$query = "select * from skn_feedback_users where id='$id'";
$result = mysqli_query($conn, $query);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$active = $row['active'];
	$_SESSION['active'] = $active;
	if (!$active) {
		echo "<script>alert('You have already given feedback...')</script>";
		echo "<script>window.location='index.html'</script>";
	} else if ($active == 3) {
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

				<h2>
					<center>Student Feedback</center>
				</h2>
				<br>

				<?php
				include 'adjust.php';
				if (isset($_POST['proceed'])) {
					$year = $_POST['year'];
					$sem = $_POST['sem'];
					$fb = $_POST['feedback'];
					$class = adjClass($_POST['class']);
					$dept = adjDept($_POST['dept']);
					$div = adjDiv($_POST['div']);
				} else {
					$year = $_SESSION['year'];
					$sem = $_SESSION['sem'];
					$fb = $_SESSION['feedback'];
					$class = $_SESSION['class'];
					$dept = $_SESSION['dept'];
					$div = $_SESSION['div'];
				}
				?>

				<br>
				<div class="container">
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="column2 col-sm-1">
							<?php echo strtoupper($dept) . '<br>' . strtoupper($class) . '-';
							if ($sem % 2 == 1)
								echo "1";
							else
								echo "2";
							?>
						</div>
						<div class="col-sm-2"></div>
						<div class="column2 col-sm-3">
							<center><b>Student Feedback Analysis <?php echo ": " . $fb; ?></b></center>
							<center><b>Class Analysis</b></center>
						</div>
						<div class="col-sm-2"></div>
						<div class="column2 col-sm-1">
							<b>Year<br><?php echo ' ' . $year . '-' . ($year + 1) . ' '; ?></b>
						</div>
					</div>
				</div>
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

				<?php

				$_SESSION['year'] = $year;
				$_SESSION['class'] = $class;
				$_SESSION['fb'] = $fb;
				$_SESSION['sem'] = $sem;
				$_SESSION['dept'] = $dept;
				$_SESSION['div'] = $div;
				//$_SESSION['batch'] = $batch;

				include 'db_conn.php';
				$query = "select name,sub_code from skn_feedback_staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='t')";
				$result = mysqli_query($conn, $query);
				if (!$result->num_rows) {
					echo "<script>alert('No Feedback for this selection...')</script>";
					echo "<script>window.location='report.php'</script>";
				}
				$total_cols = $result->num_rows;
				?>

				<div class="container">
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1">Sr. No.</div>
						<div class="column col-sm-3">Parameter</div>

						<div class="column col-sm-7">
							Theory Courses
							<div class="row">
								<div class="col-sm"><br></div>
							</div>
							<div class="row">
								<?php
								$subjects = array();
								$staff = array();
								$i = 0;
								if ($result->num_rows) {
									while ($record = $result->fetch_assoc()) {
										$subjects[$i] = $record['sub_code'];
										//echo "<th>".$subjects[$i]."</th>";
										// echo "<div class='column box col-sm-2'>".$subjects[$i]."</div>";
										$staff[$i++] = $record['name'];
									}
								}
								?>
							</div>
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols; $i++)
									echo "<div class='column box col-sm-2'>" . $subjects[$i] . "<br>" . $staff[$i] . "</div>";
								//echo "<th>".$staff[$i]."</th>";	
								?>
							</div>
						</div>

						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<?php
						$questions = [
							"How Is the teacher's command on the course?",
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

						$i = 0;

						$total_score = array();
						for ($i = 0; $i < count($subjects); $i++) {
							$total_score[$i] = 0;
						}

						for ($j = 0; $j < 7; $j++) {

						?>
							<div class="col-sm-1"></div>
							<div class="column col-sm-1"><?php echo ($j + 1); ?></div>
							<div class="column col-sm-3"><?php echo $questions[$j]; ?></div>
							<div class="column col-sm-7">
								<div class="row">
									<?php
									for ($i = 0; $i < $total_cols; $i++) {
										$q_num = 'q' . ($j + 1);
										$query = '';
										$sub = $subjects[$i];
										$find = 'AVG(' . $q_num . ')';
										$query = "SELECT $find from skn_feedback_theory WHERE feedback='$fb' and sub_code='$sub' and sem='$sem' and dept='$dept' and division='$div' and year='$year'";
										$result = mysqli_query($conn, $query);
										$record = $result->fetch_assoc();
										if ($record[$find] == NULL) {
											echo "<script>alert('No Feedback for this selection...')</script>";
											echo "<script>window.location='report.php'</script>";
										}
										$result = $record[$find];
										$total_score[$i] += $result;
										echo "<div class='column box col-sm-2'>" . $subjects[$i] . "<br>" . number_format((float)$result, 2, '.', '') . "</div>";
									}
									?>
								</div>
							</div>
						<?php } ?>
						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1"></div>
						<div class="column col-sm-3">Total Score</div>
						<div class="column col-sm-7">
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols; $i++) {
									$score = $total_score[$i] /= 7;
									echo "<div class='column box col-sm-2'>" . $subjects[$i] . "<br>" . number_format((float)$score, 2, '.', '') . "</div>";
								}
								?>
							</div>
						</div>
						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1"></div>
						<div class="column col-sm-3">Out of</div>
						<div class="column col-sm-7">
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols; $i++) {
									echo "<div class='column box col-sm-2'>5</div>";
								}
								?>
							</div>
						</div>
						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1"></div>
						<div class="column col-sm-3">Total Percentage</div>
						<div class="column col-sm-7">
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols; $i++)
									echo "<div class='column box col-sm-2'>" . $subjects[$i] . "<br>" . number_format((float)($total_score[$i] * 100 / 5), 2, '.', '') . "%</div>";
								?>
							</div>
						</div>
						<!-- <div class="col-sm-1"></div> -->
					</div>
				</div>

				<?php
				$query = "SELECT count(DISTINCT id) as total from skn_feedback_theory WHERE feedback='$fb' and  sem='$sem' and dept='$dept' and division='$div' and year='$year'";
				$result = mysqli_query($conn, $query);
				$record = $result->fetch_assoc();
				echo "<br>";
				echo "<center><h5>Total Student Participated for Feedback = " . $record['total'] . "</h5><center>";
				echo "<br>";
				?>


				<?php
				$query = "select name,sub_code,batch from skn_feedback_staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='p')";
				$result = mysqli_query($conn, $query);
				$total_cols2 = $result->num_rows;
				?>


				<div class="container">
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1">Sr. No.</div>
						<div class="column col-sm-3">Parameter</div>

						<div class="column col-sm-7">
							Practical Courses
							<div class="row">
								<div class="col-sm"><br></div>
							</div>
							<div class="row">
								<?php
								$subjects2 = array();
								$staff2 = array();
								$batches = array();
								$i = 0;
								if ($result->num_rows) {
									while ($record = $result->fetch_assoc()) {
										$subjects2[$i] = $record['sub_code'];
										$batches[$i] = $record['batch'];
										$staff2[$i++] = $record['name'];
									}
								}
								?>
							</div>
							<div class="row">
								<?php
								for ($i = 0; $i < count($staff2); $i++)
									echo "<div class='column box col-sm-2'>" . $subjects2[$i] . "<br>" . $staff2[$i] . "</div>";
								//echo "<th>".$staff[$i]."</th>";	
								?>
							</div>
						</div>

						<!-- <div class="col-sm-1"></div> -->
					</div>

					<?php
					function present($array, $key)
					{
						for ($i = 0; $i < count($array); $i++) {
							if ($array[$i] == $key) {
								return true;
							}
						}
						return false;
					}


					$batch = array();
					$count = array();
					$j = 0;

					for ($i = 0; $i < count($batches); $i++) {
						for ($k = 0; $k < strlen($batches[$i]); $k++) {
							$b = $batches[$i][$k];
							if (!present($batch, $b)) {
								$query = "SELECT count(DISTINCT id) as total from skn_feedback_practical WHERE feedback='$fb' and sem='$sem' and dept='$dept' and division='$div' and year='$year' and batch='$b'";
								$result = mysqli_query($conn, $query);
								$record = $result->fetch_assoc();
								$batch[$j] = $batches[$i][$k];
								$count[$j++] = $record['total'];
							}
						}
					}

					function br()
					{
						echo "<br>";
					}
					?>

					<div class="row">
						<?php
						$batch_stud = array();
						for ($i = 0; $i < count($batches); $i++) {
							$total = 0;
							for ($k = 0; $k < strlen($batches[$i]); $k++) {
								$index = array_search($batches[$i][$k], $batch);
								$total += $count[$index];
							}
							$batch_stud[$i] = $total;
						}

						$total_score3 = array();
						for ($i = 0; $i < count($subjects2); $i++) {
							$total_score3[$i] = 0;
						}

						for ($j = 0; $j < 3; $j++) {

						?>
							<div class="col-sm-1"></div>
							<div class="column col-sm-1"><?php echo ($j + 7 + 1); ?></div>
							<div class="column col-sm-3"><?php echo $questions[$j + 7]; ?></div>
							<div class="column col-sm-7">
								<div class="row">
									<?php
									$total_score2 = array();
									for ($i = 0; $i < count($subjects2); $i++) {
										$total_score2[$i] = 0;
									}

									for ($i = 0; $i < count($subjects2); $i++) {
										$q_num = 'q' . ($j + 7 + 1);
										$query = '';
										$sub = $subjects2[$i];
										$b = $batches[$i];
										$find = 'SUM(' . $q_num . ')';
										$total = 0;
										for ($k = 0; $k < strlen($b); $k++) {
											$query = "SELECT $find from skn_feedback_practical WHERE feedback='$fb' and sub_code='$sub' and batch = '$b[$k]' and sem='$sem' and dept='$dept' and division='$div' and year='$year'";
											$result = mysqli_query($conn, $query);
											$record = $result->fetch_assoc();
											$total += $record[$find];
										}

										$total_score2[$i] += $total;

										if ($batch_stud[$i] != 0)
											$total_score2[$i] /= $batch_stud[$i];
										//$total_score2[$i]/=count($results);

										$total_score3[$i] += $total_score2[$i];
										// echo "<td>".number_format((float)($total_score2[$i]),2,'.','')."</td>";
										echo "<div class='column box col-sm-2'>" . $subjects2[$i] . "<br>" . number_format((float)($total_score2[$i]), 2, '.', '') . "</div>";
									}
									?>
								</div>
							</div>
						<?php } ?>
						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1"></div>
						<div class="column col-sm-3">Total Score</div>
						<div class="column col-sm-7">
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols2; $i++) {
									$score = $total_score3[$i] /= 3;
									echo "<div class='column box col-sm-2'>" . $subjects2[$i] . "<br>" . number_format((float)$score, 2, '.', '') . "</div>";
								}
								?>
							</div>
						</div>
						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1"></div>
						<div class="column col-sm-3">Out of</div>
						<div class="column col-sm-7">
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols; $i++) {
									echo "<div class='column box col-sm-2'>5</div>";
								}
								?>
							</div>
						</div>
						<!-- <div class="col-sm-1"></div> -->
					</div>

					<div class="row">
						<div class="col-sm-1"></div>
						<div class="column col-sm-1"></div>
						<div class="column col-sm-3">Total Percentage</div>
						<div class="column col-sm-7">
							<div class="row">
								<?php
								for ($i = 0; $i < $total_cols2; $i++)
									echo "<div class='column box col-sm-2'>" . $subjects[$i] . "<br>" . number_format((float)($total_score3[$i] * 100 / 5), 2, '.', '') . "%</div>";
								?>
							</div>
						</div>
						<!-- <div class="col-sm-1"></div> -->
					</div>
				</div>
				<style type="text/css">
					.batch {
						padding: 2%;
						font-size: 20px;
					}
				</style>

				<br>
				<?php

				echo "<center><h5>Total Student Participated for Feedback : </h5><center><br>";
				for ($i = 0; $i < count($batch); $i++) {
					$index = array_search($i + 1, $batch);
					echo "<span class='batch'>Batch " . ($i + 1) . " = " . $count[$index] . "</span>";
				}

				?>


				<style type="text/css">
					#req {
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
									$subs = '';
									for ($i = 0; $i < count($subjects); $i++) {
										$subs = $subs . $subjects[$i] . ',';
									}
									echo $subs;
									?>';
			var subjects = subs.split(",");

			for (var j = 0; j < subjects.length - 1; j++) {
				var sub = subjects[j];
				for (var i = 0; i < 7; i++) {
					if (document.getElementById('q' + (i + 1) + sub).value == -1) {
						// alert('All Fields are Required');
						document.getElementById('req').style.display = 'inline';
						return false;
					}
				}
			}

			var subs2 = '<?php
										$subs2 = '';
										for ($i = 0; $i < count($subjects2); $i++) {
											$subs2 = $subs2 . $subjects2[$i] . ',';
										}
										echo $subs2;
										?>';
			var subjects2 = subs2.split(",");

			for (var j = 0; j < subjects2.length - 1; j++) {
				var sub2 = subjects2[j];
				for (var i = 0; i < 3; i++) {
					if (document.getElementById('q' + (i + 1 + 7) + sub2).value == -1) {
						document.getElementById('req').style.display = 'inline';
						return false;
					}
				}
			}

		}
	</script>
	<?php include 'foot.php'; ?>

</body>

</html>