<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {

    include_once('connection.php');
    // Get the selected file name from the form
    $selectedloc = $_POST['file_loc'];

    // $stmt = $conn->prepare('SELECT file_id,file_location FROM answers_1 WHERE file_name=?');
    // $stmt->bind_param('s', $selectedFileName);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // $row = $result->fetch_assoc();
    // $uploadFolder =  $row['file_location'];
    // $id =  $row['file_id'];

    // Validate the file name (you may want to add additional validation)

    // Assuming your Python script is named "extract_script.py"
    $pythonScript = "chest.py";

    // Define the upload folder path
    

    if (file_exists($selectedloc)) {
        // Build the command to execute the Python script with the file path
        $command = "python $pythonScript $selectedloc";

        // Execute the command and capture the output
        $output = shell_exec($command);
        $parts = explode("step", $output);

        // Get the last element of the array
        $output_string = end($parts);

        // echo $output_string;
        
        // Display the output (you may want to handle this differently, e.g., redirect to a new page)
        // echo "Extraction result: $output";
        $stmt = $conn->prepare('UPDATE patient_disease SET result=? WHERE file_loc=?');
        $stmt->bind_param('ss',$output_string ,$selectedloc);
        $stmt->execute();
        echo '<script>alert("Success") 
						window.location="patient.php"
						</script>';
    } else {
        echo "File not found: $selectedloc";
    }
   
}
?>
