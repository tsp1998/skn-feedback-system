<?php 
	session_start();
 ?>

<?php  
function testInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}

include 'db_conn.php';
$file_name = $_SESSION['file_name'];
$csv_file=fopen('uploads/'.$file_name, 'r');
 while(! feof($csv_file)){
 	$csv_record=fgetcsv($csv_file);
 	 $id = testInput($csv_record[0]);
 	 $pass = md5(testInput($csv_record[1]));

 	if (!empty($id)||!empty($pass)) {
 	 				$query = "select * from skn_feedback_users where id='$id'";
 	 					$result = mysqli_query($conn,$query);

 	 					if (!$result->num_rows) {
 	 						 	$query = "insert into skn_feedback_users values('$id','$pass',1)";
 	 							mysqli_query($conn,$query);
 	 					}
 	 	 		}
 	 	
 	}
 	//print_r($csv_record).'<br>';
 	fclose($csv_file);
		echo "<script>window.location='upload_stud.php'</script>";
		?>