<?php
session_start();
if (!(isset($_SESSION['SKNFB_ADMIN']) && $_SESSION['SKNFB_ADMIN'] == 'SKNFB_ADMIN')) {
  echo "<script>window.location='index.html'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SKNFB Staff</title>
</head>

<body>
  <h1>Staff Records</h1>
  <a href="admin.php">Admin Page</a>
  <table>
    <?php
    include 'db_conn.php';
    $query = 'SELECT * FROM skn_feedback_staff WHERE 1';

    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['subject']; ?></td>
          <td><?php echo $row['sub_code']; ?></td>
          <td><?php echo $row['sem']; ?></td>
          <td><?php echo $row['dept']; ?></td>
          <td><?php echo $row['division']; ?></td>
          <td><?php echo $row['batch']; ?></td>
          <td><?php echo $row['work']; ?></td>
          <td><?php echo $row['year']; ?></td>
          <td>
            <form action="remove_staff.php" method="post">
              <input type="hidden" name="staff_id" value="<?php echo $row['staff_id']; ?>">
              <input type="submit" value="Delete">
            </form>
          </td>
        </tr>
    <?php
      }
    }
    ?>
  </table>
</body>

</html>