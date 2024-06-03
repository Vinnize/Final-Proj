<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <link rel="stylesheet" href="admin_page.css">
</head>
<body>
<div class="navbar">
   <span class="hamburger" onclick="toggleSidebar()">&#9776;</span>
</div>
<div class="sidebar" id="sidebar">
   <a href="#" onclick="showAdminContent()">Admin</a>
   <a href="#" onclick="showRegisteredUsers()">Register User</a>
   <a href="#" onclick="showUserConversions()">User Convert</a>
   <a href="#" onclick="showTotalPlastic()">Total Plastic</a>
</div>
<div class="content-container" id="content-container">
   <div class="content">
      <div class="welcome-message">
         <h3>Hi, <span>admin</span></h3>
         <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
         <p>This is an admin page</p>
      </div>
      <div class="button-group">
         <a href="logout.php" class="btn">Logout</a>
      </div>
   </div>
</div>
<script>
   function toggleSidebar() {
      var sidebar = document.getElementById("sidebar");
      if (sidebar.style.display === "block") {
         sidebar.style.display = "none";
      } else {
         sidebar.style.display = "block";
      }
   }

   function showAdminContent() {
      var contentContainer = document.getElementById("content-container");
      contentContainer.innerHTML = `
         <div class="content">
            <div class="welcome-message">
               <h3>Hi, <span>admin</span></h3>
               <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
               <p>This is an admin page</p>
            </div>
            <div class="button-group">
               <a href="logout.php" class="btn">Logout</a>
            </div>
         </div>
      `;
   }

   function showRegisteredUsers() {
      var contentContainer = document.getElementById("content-container");
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "fetch_users.php", true);
      xhr.onload = function() {
         if (this.status === 200) {
            contentContainer.innerHTML = this.responseText;
         } else {
            contentContainer.innerHTML = '<p>Error fetching user data.</p>';
         }
      };
      xhr.send();
   }

   function deleteUser(userName) {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "delete_user.php?user_name=" + encodeURIComponent(userName), true);
      xhr.onload = function() {
         if (this.status === 200) {
            alert(this.responseText);
            showRegisteredUsers(); // Refresh the user list
         } else {
            alert('Error deleting user.');
         }
      };
      xhr.send();
   }

   function showUserConversions() {
      var contentContainer = document.getElementById("content-container");
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "view_conversions.php", true);
      xhr.onload = function() {
         if (this.status === 200) {
            contentContainer.innerHTML = this.responseText;
         } else {
            contentContainer.innerHTML = '<p>Error fetching conversion data.</p>';
         }
      };
      xhr.send();
   }

   function showTotalPlastic() {
      var contentContainer = document.getElementById("content-container");
      contentContainer.innerHTML = '<canvas id="plasticChart"></canvas>';
      var ctx = document.getElementById('plasticChart').getContext('2d');

      var xhr = new XMLHttpRequest();
      xhr.open("GET", "fetch_plastic_data.php", true);
      xhr.onload = function() {
         if (this.status === 200) {
            var data = JSON.parse(this.responseText);
            var dates = data.map(item => item.date);
            var totals = data.map(item => item.total_plastic);

            var chart = new Chart(ctx, {
               type: 'line',
               data: {
                  labels: dates,
                  datasets: [{
                     label: 'Total Plastic Dropped',
                     data: totals,
                     borderColor: 'rgba(75, 192, 192, 1)',
                     borderWidth: 1,
                     fill: false
                  }]
               },
               options: {
                  scales: {
                     x: {
                        type: 'time',
                        time: {
                           unit: 'day'
                        }
                     },
                     y: {
                        beginAtZero: true
                     }
                  }
               }
            });
         } else {
            contentContainer.innerHTML = '<p>Error fetching plastic data.</p>';
         }
      };
      xhr.send();
   }
</script>

</body>
</html>
