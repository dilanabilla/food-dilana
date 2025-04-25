<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "food"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $food = htmlspecialchars(trim($_POST["food"]));
    $rating = (int) $_POST["rating"];
    $feedback = htmlspecialchars(trim($_POST["feedback"]));

    // Basic validation
    if (empty($food) || empty($rating) || empty($feedback)) {
        echo "Please fill in all fields.";
        exit;
    }

    if ($rating < 1 || $rating > 5) {
        echo "Rating must be between 1 and 5.";
        exit;
    }

    // Prepare and insert into table
    $stmt = $conn->prepare("INSERT INTO reviews (food, rating, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $food, $rating, $feedback);

    if ($stmt->execute()) {
        // Redirect after success
        header("Refresh:1; url=homepage.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
