<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$age = $_POST['age'];
$profile_picture = '';

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
    $file_name = $_FILES['profile_picture']['name'];
    $file_size = $_FILES['profile_picture']['size'];
    $file_type = $_FILES['profile_picture']['type'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $profile_picture = 'uploads/' . uniqid() . '.' . $file_ext;
    move_uploaded_file($file_tmp_path, $profile_picture);
}

// Update customer information
if (!empty($profile_picture)) {
    $sql = "UPDATE Customer SET first_name=?, last_name=?, email=?, phone=?, age=?, profile_picture=? WHERE customer_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiis", $first_name, $last_name, $email, $phone, $age, $profile_picture, $customer_id);
} else {
    $sql = "UPDATE Customer SET first_name=?, last_name=?, email=?, phone=?, age=? WHERE customer_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $first_name, $last_name, $email, $phone, $age, $customer_id);
}

if ($stmt->execute()) {
    header("Location: userprofile.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
