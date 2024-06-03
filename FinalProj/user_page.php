<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>user page</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>hi, <span>user</span></h3>
      <h1>welcome <span><?php echo $_SESSION['user_name'] ?></span></h1>
      <p>this is an user page</p>
      <div class="button-group">
         <a href="drop_plastic.php" class="btn">DROP A PLASTIC</a>
         <a href="total_points.php" class="btn">YOUR TOTAL POINTS</a>
         <a href="points_convert.php" class="btn">CONVERT YOUR POINTS</a>
         <a href="logout.php" class="btn">LOGOUT</a>
      </div>
   </div>

</div>

</body>
</html>
