<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
   exit(); 
}

$user_name = $_SESSION['user_name'];

// Query to get total points for the user
$totalPointsQuery = "SELECT SUM(points) AS total_points FROM plastic_drops WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $totalPointsQuery);
if($result && mysqli_num_rows($result) > 0){
   $row = mysqli_fetch_assoc($result);
   $totalPoints = $row['total_points'];
} else {
   $totalPoints = 0; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Your Total Points</title>
   <link rel="stylesheet" href="total_points.css">
</head>
<body>
   <div class="container">
      <div class="content">
         <h1>Your Total Points</h1>
         <p>Your current total points: <?php echo $totalPoints; ?></p>
         <a href="user_page.php" class="back-btn">Back</a>
      </div>
   </div>
</body>
</html>

