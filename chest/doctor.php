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
    $sql = "SELECT a.id, a.name, b.file_loc, b.result FROM login a, patient_disease b WHERE a.id = b.pat_id AND b.doc_id = $id";
    $result = $conn->query($sql);
    $result1 = $conn->query($sql);

    

    // Close the database connection
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash-style.css?v=<?php echo time(); ?>">
    <title>Doctor</title>
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
                        <i class="fas fa-photo-video"></i>Patient</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#results" class="dashboard-nav-dropdown-item">Disease Info</a>
                        <a href="#feedback" class="dashboard-nav-dropdown-item">Feedback</a>
                    </div>
                </div>
                <!-- <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-photo-video"></i>Patient</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#" class="dashboard-nav-dropdown-item">Disease Info</a>
                    </div>
                </div> -->
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
                            <p>Your Account types is: Doctor</p>
                        </div>
                    </div>
                </div>

                <div class='container' id="#results">
                    <?php
                    if ($result->num_rows > 0) {
                        echo '<table>';
                        echo '<tr><th>Name</th><th>File Location</th><th>Result</th></tr>';
                    
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td><a href="#" onclick="showImage(\'' . $row['file_loc'] . '\')">View Image</a></td>'; // Link to show image
                            echo '<td>' . $row['result'] . '</td>';
                            echo '</tr>';
                        }
                    
                        echo '</table>';
                    } else {
                        echo "No results found";
                    }
                    ?>
                </div>
                <div class='container' id="#feedback">
                <form action="sentfeedback.php" method="post" enctype="multipart/form-data" class="upload-form">
                        <input value=<?php echo $id; ?> name="did" hidden>
                        <select name="pid" class="select">
                            <option value="" selected>Select the Patient</option>

                            <?php
                            // Generate options dynamically
                            if ($result1->num_rows > 0) {
                                while ($row = $result1->fetch_assoc()) {
                                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <textarea name="feedback" id="feedback" cols="30" rows="10"></textarea>
                        <input type="submit" value="Sent Feedback" name="submit" class="submit-btn">
                    </form>

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
    <script>
function showImage(imageUrl) {
    // Open a new window with the image
    window.open(imageUrl, 'Image Popup', 'width=600,height=400');
}
</script>
</body>
</html>