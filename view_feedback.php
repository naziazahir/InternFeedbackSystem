
<?php
// Include database connection configuration
$host = 'localhost'; // Your database host
$db_name = 'feedback_system'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Connect to the database
$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch feedback from the database
$query = "SELECT feedback_from AS from_user, feedback_text, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($query);

// Initialize an array to hold the feedback data
$feedbacks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Feedback Received</h3>
        <?php foreach ($feedbacks as $feedback): ?>
            <div class="card p-3 mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">From: <?= htmlspecialchars($feedback['from_user']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($feedback['feedback_text']) ?></p>
                    <p class="card-text"><small class="text-muted">Submitted on <?= htmlspecialchars($feedback['created_at']) ?></small></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</body>
</html>