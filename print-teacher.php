<?php 
	session_start();
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Teacher Report</title>
 </head>
 <body>
 	<?php
		include 'adjust.php';
		$year=$_SESSION['year'];
		$class=$_SESSION['class'];
		$sem=$_SESSION['sem'];
		$fb=$_SESSION['fb'];
		$dept=$_SESSION['dept'];
		$div=$_SESSION['div'];
	  ?>
	  <?php 
		include 'db_conn.php';
		$query = "select name,sub_code,subject from staff where sem='$sem' and dept='$dept' and division='$div' and year='$year' and (work='tp' or work='t')";
		$result = mysqli_query($conn,$query);
		if(!$result->num_rows){
				echo "<script>alert('No Feedback for this selection...')</script>";
				echo "<script>window.location='report.php'</script>";
			}
		 $total_cols=$result->num_rows;
		 $subjects=[];
			$staff=[];
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
	  <select>
	  	<?php 
	  	for ($i=0; $i <count($subject) ; $i++)
	  		echo "<option value='$i'>".$subject[$i]."</option>";
	  	 ?>
	  </select>
 </body>
 </html>