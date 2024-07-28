<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['Username']);
    $password = $_POST['Password'];


    // Retrieve the plaintext password and user type from the database for the given username
    $stmt = $conn->prepare('SELECT password, id, type FROM login WHERE mail_id = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $plaintext_password = $row['password'];
        $id = $row['id'];
        $type = $row['type'];
        // echo $id.''.$type.''.$plaintext_password.'';
        
        // Verify the password
        if ($password === $plaintext_password) {
            $_SESSION['id'] = $id;

            // Redirect based on user type
            switch ($type) {
                case 0:
                    header('Location:admin.php');
                    exit;
                case 1:
                    header('Location:doctor.php');
                    exit;
                case 2:
                    header('Location:patient.php');
                    exit;
                default:
                    echo "<script>alert('Login successful!');</script>";
            }
        } else {
            
            echo "<script>alert('Invalid username or password');
        window.location= 'login.html';
        </script>";
        }
    } else {
        echo "<script>alert('Invalid username or password');
        window.location= 'login.html';
        </script>";
    }
}

?>