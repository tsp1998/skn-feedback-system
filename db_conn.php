<?php  
$servername = "sql311.epizy.com";
$username = "epiz_27596670";
$password = "NEFQyJPrIlRQX";
$dbname = "epiz_27596670_skn";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>