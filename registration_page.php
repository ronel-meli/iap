<?php
session_start();

// Check if session data exists
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    die("Session data not found. Please start from the beginning.");
}

$name = htmlspecialchars($_SESSION['name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2: Complete Registration</title>
</head>
<body>
    <h2>Hello <?php echo $name; ?>, please complete your registration.</h2>
    <form action="finalize.php" method="POST">
        <label for="course">Course:</label><br>
        <input type="text" id="course" name="course" required><br><br>

        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender" required>
            <option value="">Select...</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>
        
        <button type="submit">Finalize Registration</button>
    </form>
</body>
</html>