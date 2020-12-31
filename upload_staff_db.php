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
 	if($csv_record[0]!=''){
 	 	$name = testInput($csv_record[0]);
 	 	$subject = testInput($csv_record[1]);
 	 	$sub_code = testInput($csv_record[2]);
 	 	$sem = testInput($csv_record[3]);
 	 	$dept = testInput($csv_record[4]);
 	 	$division = testInput($csv_record[5]);
 	 	$batch = testInput($csv_record[6]); 
 	 	$work = testInput($csv_record[7]);
 	 	$year = testInput($csv_record[8]);
 	
 	 		if (!empty($name)||!empty($subject)||!empty($sub_code)||!empty($sem)||!empty($dept)||!empty($division)||!empty($batch)||!empty($work)||!empty($years)) {
 	 				$query = "select * from staff where name='$name' and subject='$subject' and sub_code='$sub_code' and sem = '$sem' and dept = '$dept' and division = '$division' and batch = '$batch' and work = '$work' and year='$year'";
 	 					$result = mysqli_query($conn,$query);

 	 					if (!$result->num_rows) {
 	 						$query = "insert into staff values('$name','$subject','$sub_code','$sem','$dept','$division','$batch','$work','$year')";
 	 							mysqli_query($conn,$query);
 	 					}
 	 	 		}
 	 	
 	}
 	// $query = "insert into subjects values('$subject','$sub_code','$dept','$sem','$division')";
 	// mysqli_query($conn,$query);
 	//print_r($csv_record).'<br>';
 }
 fclose($csv_file);
		echo "<script>window.location='upload_staff.php'</script>";
		?>