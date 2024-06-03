<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   echo 'Unauthorized access!';
   exit(); // Stop further execution if not logged in
}

$query = "SELECT user_name, year, plastics_dropped, drop_date, SUM(points) as total_points FROM plastic_drops GROUP BY user_name";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
   echo '<table>';
   echo '<thead>';
   echo '<tr><th>User Name</th><th>Year</th><th>Plastics Dropped</th><th>Drop Date</th><th>Total Points</th><th>Action</th></tr>';
   echo '</thead>';
   echo '<tbody>';
   while($row = mysqli_fetch_assoc($result)){
      echo '<tr>';
      echo '<td>' . htmlspecialchars($row['user_name']) . '</td>';
      echo '<td>' . htmlspecialchars($row['year']) . '</td>';
      echo '<td>' . htmlspecialchars($row['plastics_dropped']) . '</td>';
      echo '<td>' . htmlspecialchars($row['drop_date']) . '</td>';
      echo '<td>' . htmlspecialchars($row['total_points']) . '</td>';
      echo '<td><button class="delete-btn" onclick="deleteUser(\'' . htmlspecialchars($row['user_name']) . '\')">Delete</button></td>';
      echo '</tr>';
   }
   echo '</tbody>';
   echo '</table>';
} else {
   echo 'No users have dropped plastics yet.';
}
?>
