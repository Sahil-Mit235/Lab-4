<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $address = htmlspecialchars($_POST['address']);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, dob, gender, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $dob, $gender, $address);

    if ($stmt->execute()) {
        echo "<h1>Form Submitted Successfully</h1>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Phone Number:</strong> $phone</p>";
        echo "<p><strong>Date of Birth:</strong> $dob</p>";
        echo "<p><strong>Gender:</strong> $gender</p>";
        echo "<p><strong>Address:</strong> $address</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($action == 'update') {
        $name = htmlspecialchars($_GET['name']);
        $email = htmlspecialchars($_GET['email']);
        $phone = htmlspecialchars($_GET['phone']);
        $dob = htmlspecialchars($_GET['dob']);
        $gender = htmlspecialchars($_GET['gender']);
        $address = htmlspecialchars($_GET['address']);

        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, dob=?, gender=?, address=? WHERE id=?");
        $stmt->bind_param("ssssssi", $name, $email, $phone, $dob, $gender, $address, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == 'delete') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == 'search') {
        $searchTerm = htmlspecialchars($_GET['search']);
        $stmt = $conn->prepare("SELECT * FROM users WHERE name LIKE ? OR email LIKE ?");
        $searchTerm = "%$searchTerm%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
                    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                    echo "<p><strong>Phone Number:</strong> " . $row['phone'] . "</p>";
                    echo "<p><strong>Date of Birth:</strong> " . $row['dob'] . "</p>";
                    echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
                    echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "No records found.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
