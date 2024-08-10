<?php
session_start();
include 'db_connection.php';

$customer_id = $_SESSION['customer_id'];

if (isset($_POST['update_profile'])) {
    $update_first_name = mysqli_real_escape_string($conn, $_POST['update_first_name']);
    $update_last_name = mysqli_real_escape_string($conn, $_POST['update_last_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_phone = mysqli_real_escape_string($conn, $_POST['update_phone']);
    $update_age = mysqli_real_escape_string($conn, $_POST['update_age']);

    // Update customer details
    $stmt = $conn->prepare("UPDATE `Customer` SET first_name = ?, last_name = ?, email = ?, phone = ?, age = ? WHERE customer_id = ?");
    $stmt->bind_param("ssssii", $update_first_name, $update_last_name, $update_email, $update_phone, $update_age, $customer_id);
    $stmt->execute();

    // Password change logic
    $old_pass = mysqli_real_escape_string($conn, $_POST['old_pass']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);

    if (!empty($old_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        $stmt = $conn->prepare("SELECT password FROM `Customer` WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $stmt->bind_result($stored_pass);
        $stmt->fetch();
        $stmt->close();

        // Debugging: Check the hashed old password
        // Verify the old password
        if (!password_verify($old_pass, $stored_pass)) {
         $message[] = 'Old password not matched!';
     } elseif ($new_pass != $confirm_pass) {
         $message[] = 'Confirm password not matched!';
     } else {
         // Hash the new password before storing it
         $hashed_new_pass = password_hash($confirm_pass, PASSWORD_DEFAULT);
         $stmt = $conn->prepare("UPDATE `Customer` SET password = ? WHERE customer_id = ?");
         $stmt->bind_param("si", $hashed_new_pass, $customer_id);

         if ($stmt->execute()) {
             if ($stmt->affected_rows > 0) {
                 $message[] = 'Password updated successfully!';
             } else {
                 $message[] = 'Password update failed or no changes were made!';
             }
         } else {
             $message[] = 'Error: ' . $stmt->error;
         }
     }
 }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>
   <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
   
<div class="update-profile-container">

   <?php
      $stmt = $conn->prepare("SELECT * FROM `Customer` WHERE customer_id = ?");
      $stmt->bind_param("i", $customer_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         $fetch = $result->fetch_assoc();
      }
   ?>

   <form action="" method="post" class="update-profile-form">
      <?php
         if (isset($message)) {
            foreach ($message as $msg) {
               echo '<div class="message">'.$msg.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>First Name:</span>
            <input type="text" name="update_first_name" value="<?php echo htmlspecialchars($fetch['first_name']); ?>" class="box">
            <span>Last Name:</span>
            <input type="text" name="update_last_name" value="<?php echo htmlspecialchars($fetch['last_name']); ?>" class="box">
            <span>Email:</span>
            <input type="email" name="update_email" value="<?php echo htmlspecialchars($fetch['email']); ?>" class="box">
            <span>Phone:</span>
            <input type="text" name="update_phone" value="<?php echo htmlspecialchars($fetch['phone']); ?>" class="box">
            <span>Age:</span>
            <input type="number" name="update_age" value="<?php echo htmlspecialchars($fetch['age']); ?>" class="box">
         </div>
         <div class="inputBox">
            <span>Old Password:</span>
            <input type="password" name="old_pass" placeholder="Enter previous password" class="box">
            <span>New Password:</span>
            <input type="password" name="new_pass" placeholder="Enter new password" class="box">
            <span>Confirm Password:</span>
            <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="Update Profile" name="update_profile" class="btn">
      <a href="mybooking.php" class="mybooking-btn">View My Booking</a>
      <a href="homepage.php" class="delete-btn">Go Back</a>
   </form>

</div>

</body>
</html>

