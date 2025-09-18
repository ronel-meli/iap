<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    require_once 'conf.php';

    
    $name = $_SESSION['name'] ?? '';
    $email = $_SESSION['email'] ?? '';

    
    $course = $_POST['course'] ?? '';
    $gender = $_POST['gender'] ?? '';


    if (empty($name) || empty($email) || empty($course) || empty($gender)) {
        die("Error: Required data is missing. Please go back and try again.");
    }

    
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO registration (full_name, email, course, gender, reg_date) VALUES (?, ?, ?, ?, NOW())";

    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ssss", $name, $email, $course, $gender);
        if ($stmt->execute()) {
            echo "<h2>Registration successful!</h2>";
            echo "<p>Thank you, " . htmlspecialchars($name) . ", for completing your registration.</p>";

            // Destroy the session after successful registration
            session_destroy();
        } else {
            echo "Error: Could not execute query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();

} else {
    echo "Invalid request method.";
}
?>