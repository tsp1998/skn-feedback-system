<?php 
	if(isset($_POST['upload'])){
		 $target_dir = $_POST['location']."/";
		 $target_file = $target_dir.basename($_FILES['file']['name']);
		 $_FILES['file']['name'];
		if (file_exists($target_file))
			unlink($target_file);

		if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file))
			echo "<script>alert('File is uploaded');</script>";
		else
			echo "<script>alert('File is not uploaded');</script>";

		// echo "<script>window.location = 'upload-new.php'</script>";
		
	}
	
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>tsp</title>
 </head>
 <body>
 <a href="upload-new.php">Go to Upload Page</a>
 </body>
 </html>