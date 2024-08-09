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

    mysqli_query($conn, "UPDATE `Customer` SET first_name = '$update_first_name', last_name = '$update_last_name', email = '$update_email', phone = '$update_phone', age = '$update_age' WHERE customer_id = '$customer_id'") or die('Query failed');

    $old_pass = md5($_POST['old_pass']);
    $update_pass = mysqli_real_escape_string($conn, $_POST['update_pass']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if (md5($update_pass) != $old_pass) {
            $message[] = 'Old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'Confirm password not matched!';
        } else {
            $hashed_new_pass = md5($confirm_pass);
            mysqli_query($conn, "UPDATE `Customer` SET password = '$hashed_new_pass' WHERE customer_id = '$customer_id'") or die('Query failed');
            $message[] = 'Password updated successfully!';
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
      $select = mysqli_query($conn, "SELECT * FROM `Customer` WHERE customer_id = '$customer_id'") or die('Query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
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
            <input type="hidden" name="old_pass" value="<?php echo htmlspecialchars($fetch['password']); ?>">
            <span>Old Password:</span>
            <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
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

