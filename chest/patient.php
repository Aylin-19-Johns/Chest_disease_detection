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
    $sql = "SELECT id,name FROM login WHERE type = 1";
    $result = $conn->query($sql);

    $sql1 = "SELECT id,file_loc FROM patient_disease WHERE pat_id = $id";
    $result1 = $conn->query($sql1);

    $sql2 = "SELECT a.name, b.message, b.date FROM login a, doctor_prescribtion b WHERE a.id = b.doc_id AND b.pat_id = $id ORDER BY b.date DESC";
    $result2 = $conn->query($sql2);

    // Close the database connection
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash-style.css?v=<?php echo time(); ?>">
    <title>Patient</title>
</head>
<body>
<div class='dashboard'>
        <div class="dashboard-nav">
            <header>
                <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
                <a href="#" class="brand-logo"><i class="fa-solid fa-graduation-cap"></i><span>ChestDiseasePred</span></a>
            </header>
            <nav class="dashboard-nav-list">
                <a href="#home" class="dashboard-nav-item"><i class="fas fa-home"></i>Home </a>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-photo-video"></i>Check Disease</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#upload" class="dashboard-nav-dropdown-item">Upload Image</a>
                        <a href="#extract" class="dashboard-nav-dropdown-item">Scanning</a>
                    </div>
                </div>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-photo-video"></i>Doctor</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#feedback" class="dashboard-nav-dropdown-item">feedbacks</a>
                    </div>
                </div>
                <div class="nav-item-divider"></div>
                <a href="logout.php" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>
            </nav>
        </div>
        <div class='dashboard-app'>
            <header class='dashboard-toolbar'><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a></header>
            <div class='dashboard-content'>
                <div class='container' id="#home">
                    <div class='card'>
                        <div class='card-header'>
                            <h1>Welcome

                            </h1>
                        </div>
                        <div class='card-body'>
                            <p>Your Account types is: Patient</p>
                        </div>
                    </div>
                </div>

                <div class='container' id="#upload">
                    <form action="fileupload.php" method="post" enctype="multipart/form-data" class="upload-form">
                        <label for="file">Select file to upload:</label>
                        <input type="file" name="file" id="file">
                        <input value=<?php echo $id; ?> name="pid" hidden>
                        <select name="did" class="select">
                            <option value="" selected>Select the Doctor</option>

                            <?php
                            // Generate options dynamically
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <input type="submit" value="Upload file" name="submit" class="submit-btn">
                    </form>
                </div>
                <div class='container' id="#extract">
                <form action="scan.php" method="post" enctype="multipart/form-data" class="upload-form">
                        <!-- <label for="file">Select file to upload:</label>
                        <input type="file" name="file" id="file">
                        <label for="file_name">File name :</label>
                        <input type="text" name="file_name" id="file_name"> -->
                        <select name="file_loc" class="select">
                            <option value="" selected>Select the Scanning File</option>

                            <?php
                            // Generate options dynamically
                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo "<option value='" . $row1["file_loc"] . "'>" . $row1["file_loc"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <input type="submit" value="scan" name="submit" class="submit-btn">
                    </form>
                </div>
                <div class='container' id="#feedback">
                <?php
                    if ($result2->num_rows > 0) {
                        echo '<table>';
                        echo '<tr><th>Name</th><th>Feedback</th><th>Date</th></tr>';
                    
                        // Output data of each row
                        while ($row = $result2->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td> '. $row['message'] . '</td>'; // Link to show image
                            echo '<td>' . $row['date'] . '</td>';
                            echo '</tr>';
                        }
                    
                        echo '</table>';
                    } else {
                        echo "No results found";
                    }
                    ?>

                </div>
                <div class='container' id="#students">
                    
                </div>


            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const mobileScreen = window.matchMedia("(max-width: 990px )");
        $(document).ready(function () {
            $(".dashboard-nav-dropdown-toggle").click(function () {
                $(this).closest(".dashboard-nav-dropdown")
                    .toggleClass("show")
                    .find(".dashboard-nav-dropdown")
                    .removeClass("show");
                $(this).parent()
                    .siblings()
                    .removeClass("show");
            });
            $(".menu-toggle").click(function () {
                if (mobileScreen.matches) {
                    $(".dashboard-nav").toggleClass("mobile-show");
                } else {
                    $(".dashboard").toggleClass("dashboard-compact");
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Get all anchor tags within dashboard-nav-list
            const dashboardNavAnchors = document.querySelectorAll('.dashboard-nav-list a');

            // Get all containers within dashboard-content
            const dashboardContentContainers = document.querySelectorAll('.dashboard-content .container');

            // Function to show the 'home' page when the page loads
            function showHomePage() {
                dashboardContentContainers.forEach(container => {
                    if (container.id === '#home') {
                        container.style.display = 'block'; // Show the 'home' container
                    } else {
                        container.style.display = 'none'; // Hide other containers
                    }
                });
            }

            // Show the 'home' page when the page loads
            showHomePage();

            // Loop through all anchor tags
            dashboardNavAnchors.forEach(anchor => {
                anchor.addEventListener('click', function (event) {
                    const href = this.getAttribute('href');

                    // Check if the link belongs to the dashboard navigation
                    if (href.startsWith('#')) {
                        event.preventDefault(); // Prevent default link behavior

                        // Get the target container ID from the href attribute
                        const targetContainerId = href;

                        // Loop through containers to show/hide based on clicked anchor
                        dashboardContentContainers.forEach(container => {
                            if (container.id === targetContainerId) {
                                container.style.display = 'block'; // Show the target container
                            } else {
                                container.style.display = 'none'; // Hide other containers
                            }
                        });
                    }
                });
            });
        });

    </script>
</body>
</html>