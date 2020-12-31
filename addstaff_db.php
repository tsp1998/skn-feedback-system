<?php 
	session_start();
 ?>
<?php 
	if(isset($_POST['add_sub'])){
	$name=$_POST["name"];
	$sub_name=$_POST["sub_name"];
	$sub_code=$_POST["sub_code"];
	$div=$_POST["div"];
	$dept=$_POST["dept"];
	$sem = $_POST['sem'];

	include 'tsp.php';
	include 'adjust.php';

	$div = adjDiv($div);
	$sem = adjSem($sem);
	$dept = adjDept($dept);

	$name = testInput($name);
	$sub_name = testInput($sub_name);
	$sub_code = testInput($sub_code);
	

	 include 'db_conn.php';

	 	echo $query = "insert into staff values('$name','$sub_name','$sub_code','$sem','$dept','$div')";
		$result = mysqli_query($conn,$query);
			if($result)
				echo "<script>alert('Staff Added')</script>";
			else
				echo "<script>alert('Staff not Added')</script>";
		}

		echo "<script>window.location='addstaff.php'</script>";
 ?>