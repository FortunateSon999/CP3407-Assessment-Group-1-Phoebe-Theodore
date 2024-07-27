<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

if (isset($_POST['update_profile'])) {
    $update_first_name = mysqli_real_escape_string($conn, $_POST['update_first_name']);
    $update_last_name = mysqli_real_escape_string($conn, $_POST['update_last_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_phone = mysqli_real_escape_string($conn, $_POST['update_phone']);
    $update_age = mysqli_real_escape_string($conn, $_POST['update_age']);

    mysqli_query($conn, "UPDATE `Customer` SET first_name = '$update_first_name', last_name = '$update_last_name', email = '$update_email', phone = '$update_phone', age = '$update_age' WHERE customer_id = '$customer_id'") or die('query failed');

    $old_pass = $_POST['old_pass'];
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
            mysqli_query($conn, "UPDATE `Customer` SET password = '$hashed_new_pass' WHERE customer_id = '$customer_id'") or die('query failed');
            $message[] = 'Password updated successfully!';
        }
    }

    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] == 0) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'profiles/' . basename($update_image);

        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `Customer` SET profile_picture = '$update_image_folder' WHERE customer_id = '$customer_id'") or die('query failed');
            if ($image_update_query) {
                if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
                    $message[] = 'Image updated successfully!';
                } else {
                    $message[] = 'Failed to move uploaded file!';
                }
            } else {
                $message[] = 'Failed to update image in database!';
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
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `Customer` WHERE customer_id = '$customer_id'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if (isset($fetch['profile_picture']) && !empty($fetch['profile_picture'])) {
            echo '<img src="'.$fetch['profile_picture'].'" alt="Profile Picture">';
         } else {
            echo '<img src="profiles/default.png" alt="Default Profile Picture">';
         }
         if (isset($message)) {
            foreach ($message as $msg) {
               echo '<div class="message">'.$msg.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>First Name:</span>
            <input type="text" name="update_first_name" value="<?php echo $fetch['first_name']; ?>" class="box">
            <span>Last Name:</span>
            <input type="text" name="update_last_name" value="<?php echo $fetch['last_name']; ?>" class="box">
            <span>Email:</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <span>Phone:</span>
            <input type="text" name="update_phone" value="<?php echo $fetch['phone']; ?>" class="box">
            <span>Age:</span>
            <input type="number" name="update_age" value="<?php echo $fetch['age']; ?>" class="box">
            <span>Update your picture:</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>Old Password:</span>
            <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
            <span>New Password:</span>
            <input type="password" name="new_pass" placeholder="Enter new password" class="box">
            <span>Confirm Password:</span>
            <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="Update Profile" name="update_profile" class="btn">
      <a href="homepage.php" class="delete-btn">Go Back</a>
   </form>

</div>

</body>
</html>




