<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.html');

} else {
    $id = $_SESSION['id'];

    include('connection.php');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the "answers" table
    $sql = "SELECT name FROM login WHERE type = 1 and approval= 0 ";
    $result = $conn->query($sql);
// echo $result;
    // Close the database connection
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>admin

    </h1>
</body>
</html>