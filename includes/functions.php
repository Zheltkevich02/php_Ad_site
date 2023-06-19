<?php

// Include the database connection file
require_once 'db_connection.php';

// Function to create a new ad
function createAd($adTitle, $adDescription, $userId) {
    global $conn;

    // Prepare the SQL statement to insert a new ad
   $stmt = $pdo->prepare("INSERT INTO ads (title, description, user_id) VALUES (:title, :description, :user_id)");
	$result = $stmt->execute([
		':title' => $adTitle,
		':description' => $adDescription,
		':user_id' => $userId,
	]);

    return $result;
}

?>


