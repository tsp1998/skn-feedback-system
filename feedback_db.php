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

<?php 
if (isset($_POST['feedback'])) {
	$year=$_SESSION['year'];
	$sem=$_SESSION['sem'];
	$class=$_SESSION['class'];
	$dept=$_SESSION['dept'];
	$div=$_SESSION['div'];
	$batch=$_SESSION['batch'];
	$fb=$_SESSION['active'];

	include 'db_conn.php';
	$subjects=$_SESSION['subjects'];
	$staff=$_SESSION['staff'];
	$feedback=array(array());
	for ($j=0; $j < 7; $j++) { 
		for ($i=0; $i < count($subjects); $i++) { 
			$feedback[$j][$i]=$_POST['q'.($j+1).$subjects[$i]];
			if ($feedback[$j][$i]==-1) {
				echo "<script>alert('Feedback not Submitted some fields not selected...')</script>";
				echo "<script>window.location='feedback.php'</script>";
			}
		}
	}

	// for ($j=0; $j < 7; $j++) { 
		// 	for ($i=0; $i < count($subjects); $i++) { 
	// 		echo $feedback[$j][$i]." ";
	// 	}
	// 	echo "<br>";
	// }


	$subjects2=$_SESSION['subjects2'];
	$staff2=$_SESSION['staff2'];
	$feedback2=array(array());
	for ($j=0; $j < 3; $j++) { 
		for ($i=0; $i < count($subjects2); $i++) { 
			$feedback2[$j][$i]=$_POST['q'.($j+7+1).$subjects2[$i]];
			if ($feedback2[$j][$i]==-1) {
				echo "<script>alert('Feedback not Submitted some fields not selected...')</script>";
				echo "<script>window.location='feedback.php'</script>";
			}
		}
	}
	// for ($j=0; $j < 3; $j++) { 
	// 	for ($i=0; $i < count($subjects2); $i++) { 
	// 		echo $feedback2[$j][$i]." ";
	// 	}
	// 	echo "<br>";
	// }

// print_r($subjects);
// echo "<br>";
// print_r($subjects2);
// echo "<br>";
// print_r($staff);
// echo "<br>";
// print_r($staff2);
// echo "<br>";


	$id=$_SESSION['id'];
	for ($j=0; $j <count($subjects); $j++) { 
		$query="";
		$query = "insert into skn_feedback_theory values('".$id."','".$fb."','".$year."','".$class."','".$sem."','".$dept."','".$div."','".$subjects[$j]."',";
			for ($i=0; $i < 7; $i++) { 
				$query = $query.$feedback[$i][$j].',';
			}
			$query = substr($query,0,strlen($query)-1).")";
			mysqli_query($conn,$query);
	}



	for ($j=0; $j <count($subjects2); $j++) { 
		$query="";
		$query = "insert into skn_feedback_practical values('".$id."','".$fb."','".$year."','".$class."','".$sem."','".$dept."','".$div."','".$batch."','".$subjects2[$j]."',";
			for ($i=0; $i < 3; $i++) { 
				$query = $query.$feedback2[$i][$j].',';
			}
			$query = substr($query,0,strlen($query)-1).")";
			mysqli_query($conn,$query);
	}

}
		$query = "update skn_feedback_users set active=".(0)." where id='$id'";
		mysqli_query($conn,$query);	
		echo "<script>alert('Thank You Feedback Submitted')</script>";
		echo "<script>window.location='logout.php'</script>";
		echo "<script>window.location='logout.php'</script>";

 ?>