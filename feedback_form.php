<?php
session_start();

// Assuming the logged-in user's details are stored in session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$logged_in_user_id = $_SESSION['user_id'];
$logged_in_user_name = $_SESSION['user_name']; // This will be used to display the logged-in user's name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card p-4 shadow-lg">
            <h3 class="text-center mb-4">Submit Feedback</h3>
            <form action="submit_feedback.php" method="POST">
                <div class="form-group">
                    <label for="feedback_to">Feedback from:</label>
                    <!-- Display logged-in user's name in a read-only input field -->
                    <input type="text" class="form-control" value="<?= htmlspecialchars($logged_in_user_name) ?>" readonly>
                    <input type="hidden" name="feedback_to" value="<?= $logged_in_user_id ?>"> <!-- Hidden input for user ID -->
                </div>
                <div class="form-group">
                    <textarea name="feedback_text" class="form-control" rows="4" placeholder="Enter feedback" required></textarea>
                </div>
                <button type="submit" class="btn btn-info btn-block">Submit Feedback</button>
            </form>
      </div>
    </div>
</body>
</html>
