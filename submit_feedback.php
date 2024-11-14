<?php
// Include database connection configuration
$host = 'localhost'; // Your database host
$db_name = 'feedback_system'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Connect to the database
$conn = new mysqli($host, $username, $password, $db_name);

session_start();

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in, you can customize this based on your authentication system
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Get logged-in user details
$logged_in_user_name = $_SESSION['user_name']; // This is the logged-in user's name

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the feedback text
    $feedback_text = $_POST['feedback_text'];

    // Sanitize input (for security purposes)
    $feedback_text = htmlspecialchars($feedback_text, ENT_QUOTES, 'UTF-8');

    // Prepare SQL query to insert feedback into the database
    $query = "INSERT INTO feedback (feedback_from, feedback_text) VALUES (?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters to the prepared statement
    $stmt->bind_param("ss", $logged_in_user_name, $feedback_text);

    // Execute the query with the provided values
    if ($stmt->execute()) {
        // Redirect to the home page after successful feedback submission
        header('Location: home.php'); // Change 'home.php' to your desired page
        exit; // Ensure no further code execution
    } else {
        // Handle errors with database interaction
        echo "Error: " . $stmt->error;
    }
}
?>
