
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
<?php


// Get form data
$Donors_Name = $_POST['Donors_Name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$address = $_POST['Address'];
$occupation = $_POST['Occupation'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$blood_group = $_POST['interests'][0];  // Assuming one radio button is selected for blood group
$bio = $_POST['bio'];

// Create MySQL connection
$conn = new mysqli('localhost', 'root', '', 'blood_donors');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);  // Ensure there's no error here
} else {
    // Prepare the INSERT query
    $stmt = $conn->prepare("INSERT INTO blooddonorlist (Donors_Name, email, password, confirm_password, address, occupation, gender, date_of_birth, blood_group, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if the statement preparation was successful
    if ($stmt === false) {
        die('Error in preparing the statement: ' . $conn->error);
    }

    // Bind parameters ('ssssssssss' means all parameters are strings)
    $stmt->bind_param("ssssssssss", $Donors_Name, $email, $password, $confirm_password, $address, $occupation, $gender, $date_of_birth, $blood_group, $bio);

    // Execute the query
    if ($stmt->execute()) {
        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;  // Show error if query fails
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
