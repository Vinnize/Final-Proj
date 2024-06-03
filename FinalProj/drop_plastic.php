<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
   exit(); // Stop further execution if not logged in
}

if(isset($_POST['submit'])){
   $user_name = $_SESSION['user_name'];
   $year = $_POST['year'];
   $plastics_dropped = (int)$_POST['plastics_dropped'];
   $drop_date = $_POST['drop_date'];
   $points = $plastics_dropped; // 1 plastic = 1 point

   // Insert the drop plastic data into the database
   $insert = "INSERT INTO plastic_drops(user_name, year, plastics_dropped, points, drop_date) VALUES('$user_name', '$year', '$plastics_dropped', '$points', '$drop_date')";
   if(mysqli_query($conn, $insert)){
      $success = "Plastics dropped successfully! You earned $points points.";
   } else {
      $error = "Error dropping plastics. Please try again.";
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Drop a Plastic</title>
   <link rel="stylesheet" href="drop_plastic.css">

</head>
<body>
   <div class="container">
      <div class="content">
         <h1>Drop a Plastic</h1>
         <h2>Welcome, <span><?php echo $_SESSION['user_name']; ?></span></h2>
         <p>Fill out the form below to drop plastics and earn points.</p>
         <?php
         if(isset($success)){
            echo '<span class="success-msg">'.$success.'</span>';
         }
         if(isset($error)){
            echo '<span class="error-msg">'.$error.'</span>';
         }
         ?>
         <form action="" method="post">
            <input type="text" name="year" required placeholder="Enter your year">
            <input type="number" name="plastics_dropped" required placeholder="Enter the number of plastics">
            <input type="datetime-local" name="drop_date" required placeholder="Select drop date and time">
            <input type="submit" name="submit" value="Drop Plastics" class="form-btn">
         </form>
         <a href="user_page.php" class="back-btn">Back</a>
      </div>
   </div>
</body>
</html>
