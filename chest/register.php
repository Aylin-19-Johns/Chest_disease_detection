<?php

include "./connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    $password = $_POST["Password"];
    $type = $_POST["userType"]; // Fetch the user type from the form
    
    // Set approval status based on user type
    $approval = ($type == 1) ? 0 : 1;

    $stmt = $conn->prepare("INSERT INTO login (NAME, MAIL_ID, PASSWORD, TYPE, APPROVAL) VALUES (?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssi", $fullName, $email, $password, $type, $approval);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Successfully Registered!');
        window.location= 'login.html';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>alert('Registration failed!');
    window.location= 'login.html';
    </script>";
}

$conn->close();

?>
