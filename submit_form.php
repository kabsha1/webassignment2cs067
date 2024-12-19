
<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donors";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donors_name = $_POST['Donors_Name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['Address'];
    $occupation = $_POST['Occupation'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $date_of_birth = $_POST['date_of_birth'];
    $bio = $_POST['bio'];

    // Insert data into database
    $sql = "INSERT INTO donors (donors_name, email, password, address, occupation, gender, blood_group, date_of_birth, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $donors_name, $email, $password, $address, $occupation, $gender, $blood_group, $date_of_birth, $bio);

    if ($stmt->execute()) {
        echo "<div style='text-align: center; color: green; font-size: 20px;'>Form submitted successfully!</div>";
    } else {
        echo "<div style='text-align: center; color: red; font-size: 20px;'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Fetch and display the last submitted data (single row)
$sql = "SELECT * FROM donors ORDER BY id DESC LIMIT 1"; // Get the last inserted row
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2 style='text-align:center;'>Last Submitted Data</h2>";
    echo "<table style='width: 80%; margin: 20px auto; border-collapse: collapse; text-align: left;'>";
    echo "<tr style='background-color: #4CAF50; color: white;'>
            <th style='padding: 10px;'>ID</th>
            <th style='padding: 10px;'>Name</th>
            <th style='padding: 10px;'>Email</th>
            <th style='padding: 10px;'>Address</th>
            <th style='padding: 10px;'>Occupation</th>
            <th style='padding: 10px;'>Gender</th>
            <th style='padding: 10px;'>Blood Group</th>
            <th style='padding: 10px;'>Date of Birth</th>
            <th style='padding: 10px;'>Bio</th>
          </tr>";

    $row = $result->fetch_assoc(); // Fetch the single row
    echo "<tr style='border-bottom: 1px solid #ddd;'>
            <td style='padding: 10px;'>{$row['id']}</td>
            <td style='padding: 10px;'>{$row['donors_name']}</td>
            <td style='padding: 10px;'>{$row['email']}</td>
            <td style='padding: 10px;'>{$row['address']}</td>
            <td style='padding: 10px;'>{$row['occupation']}</td>
            <td style='padding: 10px;'>{$row['gender']}</td>
            <td style='padding: 10px;'>{$row['blood_group']}</td>
            <td style='padding: 10px;'>{$row['date_of_birth']}</td>
            <td style='padding: 10px;'>{$row['bio']}</td>
          </tr>";

    echo "</table>";
} else {
    echo "<p style='text-align: center;'>No data submitted yet.</p>";
}

$conn->close();
?>

