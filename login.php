<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "food";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $stmt->bind_result($hashed_password);
  $stmt->fetch();
  if (password_verify($password, $hashed_password)) {
    echo "Login successful. Redirecting...";
    header("Refresh:2; url=homepage.html");
  } else {
    echo "Invalid password.";
  }
} else {
  echo "User not found.";
}

$conn->close();
?>
