<?php
$servername = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "2EaE5hB4F1CebaE62-34C44b1bC2d1fA";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
