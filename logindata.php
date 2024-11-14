<?php
// Database configuration
$host = 'localhost'; // Your database host
$db_name = 'feedback_system'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Connect to the database
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start session for login and signup

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate the input (basic validation)
    if (empty($email) || empty($password)) {
        echo "Both fields are required.";
        exit;
    }

    // Query to fetch the user by email
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start session and store user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role']; // Optional: Store role for future use

            // Redirect to feedback form page
            header("Location: feedback_form.php");
            exit;
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found'); window.location.href='login.php';</script>";
    }

    // Close statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
