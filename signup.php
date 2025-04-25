<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "food"; // Use your DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if username already exists
$check = $conn->prepare("SELECT * FROM users WHERE username=?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  echo "Username already exists!";
} else {
  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  echo "Signup successful. <a href='login.html'>Login here</a>";
}

$conn->close();
?>
