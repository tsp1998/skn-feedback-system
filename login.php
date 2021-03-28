<?php
session_start();
?>
<?php
if (isset($_POST['login'])) {
	$id = $_POST['id'];
	$pass = $_POST['pass'];

	include 'tsp.php';

	$id = testInput($id);
	$pass = testInput($pass);

	$_SESSION['id'] = $id;
	$_SESSION['pass'] = $pass;

	include 'db_conn.php';

	if ($id == 'admin') {
		$query = "select * from skn_feedback_admin";
		$result = mysqli_query($conn, $query);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if ($row['pass'] == md5($pass)) {
				$_SESSION['SKNFB_ADMIN'] = 'SKNFB_ADMIN';
				echo "<script>window.location='admin.php'</script>";
			}
		}
	} else {
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
			} else {
				if ($row['pass'] == md5($pass)) {
					echo "<script>window.location='student.php'</script>";
				}
			}
		}
	}
	echo "<script>alert('Wrong ID or Password')</script>";
}

echo "<script>window.location='index.html'</script>";
?>