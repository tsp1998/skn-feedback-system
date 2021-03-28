<?php
session_start();
?>

<?php
if (isset($_POST['start'])) {
	$start = $_POST['feedback'];
	include 'db_conn.php';
	$query = "update skn_feedback_users set active='$start'";
	if (mysqli_query($conn, $query))
		echo "<script>alert('Feedback $start is Started Now...')</script>";
	echo "<script>window.location='fbstart.php'</script>";
}

?>