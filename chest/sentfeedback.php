<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    include('connection.php');

    $pid = $_POST["pid"];
    $did = $_POST["did"];
    $feedback = $_POST["feedback"];

    // Validate that required fields are not empty
    if (!empty($pid) && !empty($feedback)) {
       

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the statement
        $stmt = $conn->prepare("INSERT INTO doctor_prescribtion (doc_id, pat_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $did, $pid, $feedback);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Successfully Sent Feedback');
            window.location= 'doctor.php';
            </script>";
            echo "Feedback sent successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('Please fill all the fields.');
        window.location= 'doctor.php';
        </script>";
        echo "Please fill all the fields.";
    }
}
?>
