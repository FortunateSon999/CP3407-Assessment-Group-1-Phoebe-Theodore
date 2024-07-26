<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}



$customer_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $age = $_POST['age'] ?? '';
    $old_profile_picture = $_POST['old_profile_picture'] ?? '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($age)) {
        $em = "All fields are required";
        header("Location: userprofile.php?error=$em");
        exit();
    }

    $profiles_dir = 'profiles';
    if (!is_dir($profiles_dir)) {
        mkdir($profiles_dir, 0777, true);
    }

    $new_profile_picture = $old_profile_picture;

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $img_name = $_FILES['profile_picture']['name'];
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $error = $_FILES['profile_picture']['error'];

        if ($error === 0) {
            $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ext_lc = strtolower($img_ext);
            $allowed_exs = array('jpg', 'jpeg', 'png');

            if (in_array($img_ext_lc, $allowed_exs)) {
                $new_img_name = uniqid($customer_id, true) . '.' . $img_ext_lc;
                $img_upload_path = $profiles_dir . '/' . $new_img_name;

                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                    if ($old_profile_picture && $old_profile_picture !== 'profiles/default.png' && file_exists($old_profile_picture)) {
                        unlink($old_profile_picture);
                    }
                    $new_profile_picture = $img_upload_path;
                } else {
                    $em = "Sorry, there was an error uploading your file.";
                    header("Location: userprofile.php?error=$em");
                    exit();
                }
            } else {
                $em = "You can only upload JPG, JPEG, or PNG files.";
                header("Location: userprofile.php?error=$em");
                exit();
            }
        } else {
            $em = "Unknown error occurred!";
            header("Location: userprofile.php?error=$em");
            exit();
        }
    }

    $sql = "UPDATE Customer SET first_name=?, last_name=?, email=?, phone=?, age=?, profile_picture=? WHERE customer_id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssssiis", $first_name, $last_name, $email, $phone, $age, $new_profile_picture, $customer_id);

    if ($stmt->execute()) {
        header("Location: userprofile.php?success=Your account has been updated successfully");
        exit();
    } else {
        $em = "Error updating record: " . $stmt->error;
        header("Location: userprofile.php?error=$em");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: userprofile.php");
    exit();
}
?>
