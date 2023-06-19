<?php
session_start();

// Check if the user is logged in
$loggedIn = isset($_SESSION['user']);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "announcement_site";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new ad
if ($loggedIn && isset($_POST['add_ad'])) {
    $adTitle = $_POST['title'];
    $adDescription = $_POST['description'];
    $userId = $_SESSION['user_id'];

    // Validate inputs
    if (empty($adTitle) || empty($adDescription)) {
        echo "Please fill in all fields.";
    } else {
        // Call the createAd function
        $result = createAd($adTitle, $adDescription, $userId);

        if ($result === true) {
            echo "Ad added successfully!";
        } else {
            echo "Error: " . $result;
        }
    }
}



// Get all ads from the database
$selectQuery = "SELECT ads.*, users.username FROM ads INNER JOIN users ON ads.user_id = users.id";
$result = $conn->query($selectQuery);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Announcement Site</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <div class="container">
        <h1>Welcome to the Announcement Site</h1>

        <?php if ($loggedIn): ?>
            <h2>Add New Ad</h2>
            <form id="add-ad-form">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required><br>

                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea><br>

                <input type="submit" name="add_ad" value="Add Ad">
            </form>
        <?php else: ?>
            <p>Please log in to add new ads.</p>
        <?php endif; ?>

        <h2>Ads</h2>
        <div id="ad-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="ad">';
                    echo '<h3>' . $row['title'] . '</h3>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<p>Posted by: ' . $row['username'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No ads found.</p>';
            }
            ?>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
