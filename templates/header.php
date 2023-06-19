<!-- header.php -->
<header>
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        // Display the user's name and logout button
        echo 'Welcome, ' . $_SESSION['user'] . '! | <a href="logout.php">Logout</a>';
    } else {
        // Display authorization or registration buttons
        echo '<a href="users.php">Login</a> | <a href="users.php">Register</a>';
    }
    ?>
</header>
