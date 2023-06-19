<?php
session_start();

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

// User registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Check if username is available
        $checkQuery = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            echo "Username already exists.";
        } else {
            // Insert new user into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

            if ($conn->query($insertQuery) === TRUE) {
                echo "Registration successful. You can now <a href='index.php'>login</a>.";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}

// User authorization
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Check if the entered credentials match any user record in the database
        $selectQuery = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($selectQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                // Set the user session
                $_SESSION['user'] = $username;
                echo "Login successful. Welcome, $username!";
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid username.";
        }
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
</head>
<body>
    <h1>Registration</h1>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="register" value="Register">
    </form>

    <h1>Authorization</h1>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
