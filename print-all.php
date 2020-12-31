<?php 
	session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<body>
	<style type="text/css">
		table{
			font-size: 15px;
		}
		td{
			text-align: center;
			padding: 3px;
		}
	</style>

					<?php 
						$feedback=array(array());
						$feedback2=array(array());
					 ?>
					<?php
						include 'adjust.php';
						$year=$_SESSION['year'];
						$class=$_SESSION['class'];
						$sem=$_SESSION['sem'];
						$fb=$_SESSION['fb'];
						$dept=$_SESSION['dept'];
						$div=$_SESSION['div'];
					  ?>
					<center><h3>SKN Sinhgad College of Engineering, Korti.</h3></center>
					<table width="100%">
						<tr>
							<td width="33%"><b>
								<?php echo strtoupper($dept).'<br>'.strtoupper($class).'-';
									if($sem%2==1)
										echo "1";
									else
										echo "2";
								?></b>
							</td>
							<td width="33%"><center><b>Student Feedback Analysis <?php echo ": ".$fb; ?></b></center>
								<center><b>Class Analysis</b></center>
							</td>
							<td width="33%"><b>Year<br><?php echo ' '.$year.'-'.($year+1).' '; ?></b></td>
						</tr>
					</table>

					
					<br>

					<table width="100%" border="1">
						<tr>
							<td>Excellent - 5</td><td>Very Good - 4</td><td>Good - 3</td><td>Average - 2</td><td>Poor - 1</td>
						</tr>	
					</table>


						<table width="100%" border="1">
						<tr>
							<th rowspan='3' width="7%">Sr. No.</th><th rowspan='3' width="30%">Parameter</th>
							<?php 
								include 'db_conn.php';
								$query = "select name,sub_code,subject from staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='t')";
								$result = mysqli_query($conn,$query);
								if(!$result->num_rows){
										echo "<script>alert('No Feedback for this selection...')</script>";
										echo "<script>window.location='report.php'</script>";
									}
								 $total_cols=$result->num_rows;
								 echo "<th class='header' colspan=".($total_cols).">Theory Courses</th>";
							?>
						</tr>
						<tr>
							<?php
							$subjects=array();
							$staff=array();
							$i=0;
							if($result->num_rows){
								while ($record = $result->fetch_assoc()) {
									$sub_name[$i]=$record['subject'];
									$subjects[$i]=$record['sub_code'];
									echo "<th>".$subjects[$i]."</th>";
										$staff[$i++]=$record['name'];
								}
							}
							?>
						</tr>

						<tr>
							<?php
							for ($i=0; $i < $total_cols; $i++) { 
								echo "<th>".$staff[$i]."</th>";	
							}
							?>
						</tr>

						
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

								$i=0;

								$total_score=array();
								for ($i=0; $i < count($subjects) ; $i++) { 
									$total_score[$i]=0;
								}

								
						 	for ($j=0; $j < 7; $j++) { 
						 		echo "<tr>";
								echo "<td>".($j+1)."</td>";
								echo "<td class='question'>".$questions[$j]."</td>";
							
								for ($i=0; $i < count($subjects); $i++) { 
									$q_num = 'q'.($j+1);
									$query = '';
									$sub = $subjects[$i];
									$find = 'AVG('.$q_num.')';
									$query = "SELECT $find FROM theory WHERE feedback='$fb' and sub_code='$sub' and sem='$sem' and dept='$dept' and division='$div' and year='$year'";
									$result = mysqli_query($conn,$query);
									$record = $result->fetch_assoc();
									if($record[$find]==NULL){
										echo "<script>alert('No Feedback for this selection...')</script>";
										echo "<script>window.location='report.php'</script>";
									}
									$result = $record[$find];
									$total_score[$i] += $result;
									$feedback[$j][$i] = number_format((float)$result,2,'.','');
									echo "<td>".number_format((float)$result,2,'.','')."</td>";
								}
								echo "</tr>";
						 	}

						 	
						 	echo "<tr>";
						 		echo "<td></td>";
						 		echo "<td>Total Score</td>";
						 		for ($i=0; $i < $total_cols; $i++){
						 			$score = $total_score[$i] /= 7;
						 			$feedback[7][$i] = number_format((float)$score,2,'.','');
						 			echo "<td>".number_format((float)$score,2,'.','')."</td>";
						 		}
						 			//echo "<td>".sprintf("%.2f",($total_score[$i] /= 10))."</td>";
						 	echo "</tr>";

						 	echo "<tr>";
						 		echo "<td></td>";
						 		echo "<td>Out of</td>";
						 		for ($i=0; $i < $total_cols; $i++)
						 			echo "<td>".(5)."</td>";
						 	echo "</tr>";
						 	
						 	echo "<tr>";
						 		echo "<td></td>";
						 		echo "<td>Total Percentage</td>";
						 		for ($i=0; $i < $total_cols; $i++){
						 			 $feedback[8][$i] = number_format((float)($total_score[$i]*100/5),2,'.','');
						 			echo "<td>".number_format((float)($total_score[$i]*100/5),2,'.','')."%</td>";
						 		}
						 	echo "</tr>";
						 ?>
						
					</table>



						<table width="100%" border="1">
						 <tr>
						 	<th rowspan='3' width="7%">Sr. No.</th><th class='header' rowspan='3' width="30%">Parameter</th>
						 	<td class='seperator' colspan= <?php echo ($total_cols+2); ?> ><b>Practical Courses</b></td>
						 	<?php 
						 		$query = "select name,sub_code,batch,subject from staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='p')";
								$result = mysqli_query($conn,$query);
								 $total_cols2=$result->num_rows;
							?>
						 </tr>

						 <tr>
							<?php
							$sub_name2=array();
							$subjects2=array();
							$staff2=array();
							$batches=array();
							$i=0;
							if($result->num_rows){
								while ($record = $result->fetch_assoc()) {
										$subjects2[$i]=$record['sub_code'];
										echo "<th>".$subjects2[$i]	."</th>";
										 $sub_name2[$i]=$record['subject'];
										 $batches[$i]=$record['batch'];
										 $staff2[$i++]=$record['name'];
								}
							}
							?>
						</tr>

						

						<tr>
							<?php
							for ($i=0; $i <count($staff2); $i++) { 
								//echo "<th>".$staff2[$i]."</th>";
								echo "<th>".$staff2[$i]."</th>";
							}
							?>
							
						</tr>

						<?php 

	 						function present($array,$key){
						 		for ($i=0; $i < count($array); $i++) { 
						 			if ($array[$i]==$key) {
						 				return true;
						 			}
						 		}
						 		return false;
						 	}

						 	$batch = array();
						 	$count = array();
						 	$j=0;

						 	for ($i=0; $i <count($batches) ; $i++) { 
						 		for ($k=0; $k < strlen($batches[$i]); $k++) { 
						 			$b = $batches[$i][$k];
						 			if (!present($batch,$b)) {
						 				 $query = "SELECT count(DISTINCT id) as total from practical WHERE feedback='$fb' and sem='$sem' and dept='$dept' and division='$div' and year='$year' and batch='$b'";
										$result = mysqli_query($conn,$query);
										$record = $result->fetch_assoc();
										$batch[$j] = $batches[$i][$k];
										$count[$j++] = $record['total'];
						 			}
						 		}
							 	
						 	}

							function br(){echo "<br>";}


						 	$batch_stud = array();
						 	for ($i=0; $i < count($batches); $i++) { 
						 		$total=0;
								for ($k=0; $k < strlen($batches[$i]); $k++) { 
										$index = array_search($batches[$i][$k], $batch);
										$total += $count[$index];
								}
								$batch_stud[$i] = $total;
							}

							$total_score3=array();
								for ($i=0; $i < count($subjects2) ; $i++) { 
									$total_score3[$i]=0;
								}


						 	for ($j=0; $j < 3; $j++) { 
						 		echo "<tr>";
								echo "<td>".($j+7+1)."</td>";
								echo "<td class='question'>".$questions[$j]."</td>";

								$total_score2=array();
								for ($i=0; $i < count($subjects2) ; $i++) { 
									$total_score2[$i]=0;
								}
							
								for ($i=0; $i < count($subjects2); $i++) { 
									$q_num = 'q'.($j+7+1);
									$query = '';
									$sub = $subjects2[$i];
									$b = $batches[$i];
									//$find = 'AVG('.$q_num.')';
									$find = 'SUM('.$q_num.')';
									$total = 0;
									//print_r($result);
									//echo "<br>";
									for ($k=0; $k < strlen($b); $k++) { 
										$query = "SELECT $find FROM practical WHERE feedback='$fb' and sub_code='$sub' and batch = '$b[$k]' and sem='$sem' and dept='$dept' and division='$div' and year='$year'";
										$result = mysqli_query($conn,$query);
										$record = $result->fetch_assoc();
										$total  += $record[$find];
									}

										$total_score2[$i] += $total;	

									if($batch_stud[$i]!=0)
										$total_score2[$i]/=$batch_stud[$i];
									//$total_score2[$i]/=count($results);
									
									$total_score3[$i] += $total_score2[$i];	

									$feedback2[$j][$i] = number_format((float)($total_score2[$i]),2,'.','');
									echo "<td>".number_format((float)($total_score2[$i]),2,'.','')."</td>";
								}
								
								echo "</tr>";
						 	}

						 	
						 	echo "<tr>";
						 		echo "<td></td>";
						 		echo "<td>Total Score</td>";
						 		for ($i=0; $i < $total_cols2; $i++){
						 			$score = $total_score3[$i] /= 3;
						 			$feedback2[3][$i] = number_format((float)$score,2,'.','');
						 			echo "<td>".number_format((float)$score,2,'.','')."</td>";
						 		}
						 			//echo "<td>".sprintf("%.2f",($total_score3[$i] /= 10))."</td>";
						 	echo "</tr>";

						 	echo "<tr>";
						 		echo "<td></td>";
						 		echo "<td>Out of</td>";
						 		for ($i=0; $i < $total_cols2; $i++)
						 			echo "<td>".(5)."</td>";
						 	echo "</tr>";
						 	
						 	echo "<tr>";
						 		echo "<td></td>";
						 		echo "<td>Total Percentage</td>";
						 		for ($i=0; $i < $total_cols2; $i++){
						 			$feedback2[4][$i] = number_format((float)($total_score3[$i]*100/5),2,'.','');
						 			echo "<td>".number_format((float)($total_score3[$i]*100/5),2,'.','')."%</td>";
						 		}
						 	echo "</tr>";

						 ?>
						
					</table>

					<style type="text/css">
						.batch{
							font-size: 15px;
						}
					</style>

					<?php 
							echo "<br><b><center>Total Student Participated for Feedback : <center></b>";
							$query = "SELECT count(DISTINCT id) as total from theory WHERE feedback='$fb' and  sem='$sem' and dept='$dept' and division='$div' and year='$year'";
							$result = mysqli_query($conn,$query);
							$record = $result->fetch_assoc();
							echo "<span class='batch'>Theory : ".$record['total']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

							for ($i=0; $i < count($batch); $i++) {
								$index = array_search($i+1, $batch);
								echo "<span class='batch'>Batch ".($i+1)." : ".$count[$index]."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
						 ?>

						<!-- <?php 
		echo "<br>";
			for ($j=0; $j < 9; $j++) { 
				for ($i=0; $i < count($subjects); $i++) { 
					echo $feedback[$j][$i].' ';
				}
				echo "<br>";
			}
		echo "<br>";
			for ($j=0; $j < 5; $j++) { 
				for ($i=0; $i < count($subjects2); $i++) { 
					echo $feedback2[$j][$i].' ';
				}
				echo "<br>";
			}
		 ?> -->


		 <style type="text/css">
			.table{
				font-size: 19px;
			}
			.td{
				text-align: center;
				padding: 6px;
			}
		</style>


				<?php 
				for ($i=0; $i < count($subjects); $i++) { 
					if(present($subjects2,$subjects[$i])){
						 echo "<center><h3>SKN Sinhgad College of Engineering, Korti.</h3></center>";
						echo "<table class='table' width='100%'>";
						echo "<tr>";
							echo "<td class='td' width='33%'><b>";
								echo strtoupper($dept)."<br>";
								if($div!='-')
									echo "div : ".$div." ";
								echo strtoupper($class)."-";
									if($sem%2==1)
										echo "1";
									else
										echo "2";
								
								echo "</b>";
							echo "</td>";
							echo "<td class='td' width='33%'><center><b>Feedback Analysis : ".$fb."</b></center>";
								echo "<center><b>Class Analysis</b></center>";
							echo "</td>";
							echo "<td class='td' width='33%'><b>Year<br>";
								echo $year.'-'.($year+1); 
							echo "</b></td>";
						echo "</tr>";
					echo "</table>";

					echo "<br>";

					echo "Subject Name - ".$sub_name[$i]."<br><br>";
					echo "Subject Teacher - ".$staff[$i]."<br><br>";

					echo "<table class='table' width='100%' border='1'>";
						echo "<tr>";
							echo "<td class='td'>Excellent - 5</td><td class='td'>Very Good - 4</td><td class='td'>Good - 3</td><td class='td'>Average - 2</td><td class='td'>Poor - 1</td>";
						echo "</tr>	";
					echo "</table>";

					echo "<table class='table' width='100%' border='1'>";
						echo "<tr>";
							echo "<th width='10%'>Sr. No.</th><th width='60%'>Parameter</th>";
							echo "<th width='30%'>Theory Feedback Score</th>";
						echo "</tr>";
							for ($j=0; $j < 7; $j++) { 
						 		echo "<tr>";
								echo "<td class='td'>".($j+1)."</td>";
								echo "<td class='td' class='question'>".$questions[$j]."</td>";
								echo "<td class='td'>".$feedback[$j][$i]."</td>";
								echo "</tr>";
						 	}

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Score</td>";
							echo "<td class='td'>".$feedback[7][$i]."</td>";
							echo "</tr>";

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Out of</td>";
							echo "<td class='td'>".(5)."</td>";
							echo "</tr>";
						 	
						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Percentage</td>";
							echo "<td class='td'>".$feedback[8][$i]."</td>";
							echo "</tr>";
						

						 echo "</table>";

							
						$index = array_search($subjects[$i],$subjects2);
						echo "<table class='table' width='100%' border='1'>";
							echo "<tr>";
							echo "<th width='10%'>Sr. No.</th><th width='60%'>Parameter</th>";
							echo "<th width='30%'>Practical Feedback Score</th>";
							echo "</tr>";
							for ($j=0; $j < 3; $j++) { 
						 		echo "<tr>";
								echo "<td class='td'>".($j+7+1)."</td>";
								echo "<td class='td' class='question'>".$questions[$j]."</td>";
								echo "<td class='td'>".$feedback2[$j][$index]."</td>";
								echo "</tr>";
						 	}

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Score</td>";
							echo "<td class='td'>".$feedback2[3][$index]."</td>";
							echo "</tr>";

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Out of</td>";
							echo "<td class='td'>".(5)."</td>";
							echo "</tr>";
						 	
						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Percentage</td>";
							echo "<td class='td'>".$feedback2[4][$index]."</td>";
							echo "</tr>";
						

						 echo "</table>";
							
							echo "<br><b><center>Total Student Participated for Feedback : <center></b>";
							echo "<span class='batch'>Theory : ".$record['total']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

							for ($i1=0; $i1 < count($batch); $i1++) {
								$index = array_search($i1+1, $batch);
								echo "<span class='batch'>Batch ".($i1+1)." : ".$count[$index]."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							}
						 	}



			 	for ($i=0; $i < count($subjects); $i++) { 
					if(!present($subjects2,$subjects[$i])){
						br();br();br();br();br();
						 echo "<center><h3>SKN Sinhgad College of Engineering, Korti.</h3></center>";
						echo "<table class='table' width='100%'>";
						echo "<tr>";
							echo "<td class='td' width='33%'><b>";
								echo strtoupper($dept)."<br>";
								if($div!='-')
									echo "div : ".$div." ";
								echo strtoupper($class)."-";
									if($sem%2==1)
										echo "1";
									else
										echo "2";
								
								echo "</b>";
							echo "</td>";
							echo "<td class='td' width='33%'><center><b>Feedback Analysis : ".$fb."</b></center>";
								echo "<center><b>Class Analysis</b></center>";
							echo "</td>";
							echo "<td class='td' width='33%'><b>Year<br>";
								echo $year.'-'.($year+1); 
							echo "</b></td>";
						echo "</tr>";
					echo "</table>";

					echo "<br>";

					echo "Subject Name - ".$sub_name[$i]."<br><br>";
					echo "Subject Teacher - ".$staff[$i]."<br><br>";

					echo "<table class='table' width='100%' border='1'>";
						echo "<tr>";
							echo "<td class='td'>Excellent - 5</td><td class='td'>Very Good - 4</td><td class='td'>Good - 3</td><td class='td'>Average - 2</td><td class='td'>Poor - 1</td>";
						echo "</tr>	";
					echo "</table>";

					echo "<table class='table' width='100%' border='1'>";
						echo "<tr>";
							echo "<th width='10%'>Sr. No.</th><th width='60%'>Parameter</th>";
							echo "<th width='30%'>Theory Feedback Score</th>";
						echo "</tr>";
							for ($j=0; $j < 7; $j++) { 
						 		echo "<tr>";
								echo "<td class='td'>".($j+1)."</td>";
								echo "<td class='td' class='question'>".$questions[$j]."</td>";
								echo "<td class='td'>".$feedback[$j][$i]."</td>";
								echo "</tr>";
						 	}

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Score</td>";
							echo "<td class='td'>".$feedback[7][$i]."</td>";
							echo "</tr>";

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Out of</td>";
							echo "<td class='td'>".(5)."</td>";
							echo "</tr>";
						 	
						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Percentage</td>";
							echo "<td class='td'>".$feedback[8][$i]."</td>";
							echo "</tr>";
						

						 echo "</table>";
							
							echo "<br><b><center>Total Student Participated for Feedback : <center></b>";
							echo "<span class='batch'>Theory : ".$record['total']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

							for ($i1=0; $i1 < count($batch); $i1++) {
								$index = array_search($i1+1, $batch);
								echo "<span class='batch'>Batch ".($i1+1)." : ".$count[$index]."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}

							br();br();br();br();br();br();br();br();br();br();
							}
						 	}



		for ($i=0; $i < count($staff2); $i++) { 
					if(!present($staff,$staff2[$i])){
						br();br();br();br();br();
						 echo "<center><h3>SKN Sinhgad College of Engineering, Korti.</h3></center>";
						echo "<table class='table' width='100%'>";
						echo "<tr>";
							echo "<td class='td' width='33%'><b>";
								echo strtoupper($dept)."<br>";
								if($div!='-')
									echo "div : ".$div." ";
								echo strtoupper($class)."-";
									if($sem%2==1)
										echo "1";
									else
										echo "2";
								
								echo "</b>";
							echo "</td>";
							echo "<td class='td' width='33%'><center><b>Feedback Analysis : ".$fb."</b></center>";
								echo "<center><b>Class Analysis</b></center>";
							echo "</td>";
							echo "<td class='td' width='33%'><b>Year<br>";
								echo $year.'-'.($year+1); 
							echo "</b></td>";
						echo "</tr>";
					echo "</table>";

					echo "<br>";

					echo "Subject Name - ".$sub_name2[$i]."<br><br>";
					echo "Subject Teacher - ".$staff2[$i]."<br><br>";

					echo "<table class='table' width='100%' border='1'>";
						echo "<tr>";
							echo "<td class='td'>Excellent - 5</td><td class='td'>Very Good - 4</td><td class='td'>Good - 3</td><td class='td'>Average - 2</td><td class='td'>Poor - 1</td>";
						echo "</tr>	";
					echo "</table>";

							
						$index = array_search($staff2[$i],$staff2);
						echo "<table class='table' width='100%' border='1'>";
							echo "<tr>";
							echo "<th width='10%'>Sr. No.</th><th width='60%'>Parameter</th>";
							echo "<th width='30%'>Practical Feedback Score</th>";
							echo "</tr>";
							for ($j=0; $j < 3; $j++) { 
						 		echo "<tr>";
								echo "<td class='td'>".($j+7+1)."</td>";
								echo "<td class='td' class='question'>".$questions[$j]."</td>";
								echo "<td class='td'>".$feedback2[$j][$index]."</td>";
								echo "</tr>";
						 	}

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Score</td>";
							echo "<td class='td'>".$feedback2[3][$index]."</td>";
							echo "</tr>";

						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Out of</td>";
							echo "<td class='td'>".(5)."</td>";
							echo "</tr>";
						 	
						 	echo "<tr>";
							echo "<td class='td'></td>";
							echo "<td class='td' class='question'>Total Percentage</td>";
							echo "<td class='td'>".$feedback2[4][$index]."</td>";
							echo "</tr>";
						

						 echo "</table>";
							
							echo "<br><b><center>Total Student Participated for Feedback : <center></b>";
							echo "<span class='batch'>Theory : ".$record['total']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

							for ($i1=0; $i1 < count($batch); $i1++) {
								$index = array_search($i1+1, $batch);
								echo "<span class='batch'>Batch ".($i1+1)." : ".$count[$index]."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}

							br();br();br();br();br();br();br();br();br();br();br();br();br();br();br();br();br();br();br();br();
							}
						 	}
						  ?>
					
		
		
</body>
</html>