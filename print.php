<?php
session_start();
?>

<?php

if (isset($_POST['print_all']))
	echo "<script>window.location='print-all.php'</script>";
else if (isset($_POST['print_teacher']))
	echo "<script>window.location='print-teacher.php'</script>";
else if (isset($_POST['print_class']))
	echo "<script>window.location='print-class.php'</script>";
else
	echo "<script>window.location='analysis.php'</script>";
?>