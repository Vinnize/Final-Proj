<?php
@include 'config.php';

if(isset($_GET['user_name'])){
    $user_name = $_GET['user_name'];
    $query = "DELETE FROM plastic_drops WHERE user_name='$user_name'";
    if(mysqli_query($conn, $query)){
        echo 'User deleted successfully';
    } else {
        echo 'Error deleting user: ' . mysqli_error($conn);
    }
}
?>
