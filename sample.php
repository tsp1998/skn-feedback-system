<?php 
	include 'db_conn.php';
	$query = "delete from skn_feedback_theory where 1";
	if(mysqli_query($conn,$query))
		echo "<script>alert('Theory Truncated')</script>";
	$query = "delete from skn_feedback_practical where 1";
	if(mysqli_query($conn,$query))
		echo "<script>alert('practical Truncated')</script>";
	echo "<script>window.location='index.html'</script>";
 ?>