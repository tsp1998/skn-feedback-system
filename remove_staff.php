<?php
session_start();
if (!(isset($_SESSION['SKNFB_ADMIN']) && $_SESSION['SKNFB_ADMIN'] == 'SKNFB_ADMIN')) {
  echo "<script>window.location='index.html'</script>";
}
if(isset($_POST['staff_id'])){
  $staff_id = $_POST['staff_id'];

  include 'db_conn.php';

  $query = "DELETE FROM skn_feedback_staff WHERE staff_id = $staff_id";
  $result = mysqli_query($conn, $query);
  if ($result)
    echo "<script>alert('Staff Deleted')</script>";
  else
    echo "<script>alert('Staff not Deleted')</script>";
}

echo "<script>window.location='staff.php'</script>";