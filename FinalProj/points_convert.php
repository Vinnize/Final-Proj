<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
    exit();
}

$user_name = $_SESSION['user_name'];

// Function to fetch user points from the plastic_drops table
function getUserPoints($conn, $user_name) {
    $query = "SELECT SUM(points) AS total_points FROM plastic_drops WHERE user_name='$user_name'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    return isset($row['total_points']) ? $row['total_points'] : 0; // Handle case when user has no points
}

$user_points = getUserPoints($conn, $user_name);

// Dummy data for items you can convert points to
$items = [
    ["name" => "Ball pen", "image" => "img/ballpen.png", "points" => 5],
    ["name" => "Yellow Paper", "image" => "img/yellowpaper.png", "points" => 2],
    ["name" => "AquaFlask", "image" => "img/aquaflask.jpg", "points" => 100],
    ["name" => "Keyboard", "image" => "img/Keyboard.png", "points" => 50],
    ["name" => "Mousepad", "image" => "img/mousepad.png", "points" => 15],
    ["name" => "Mouse", "image" => "img/mouse.png", "points" => 40],
    ["name" => "SchoolSupplies", "image" => "img/schoolsupplies.png", "points" => 25],
    ["name" => "Tumbler", "image" => "img/tumbler.png", "points" => 30],
    // Add more items as needed
];

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $item_points = (int)$_POST['item_points'];

    $user_points = getUserPoints($conn, $user_name); // Fetch user points again before conversion

    if ($user_points >= $item_points) {
        // Deduct points from user
        $new_points = $user_points - $item_points;

        // Insert the conversion into points_conversions table
        $insert_conversion_query = "INSERT INTO points_conversions (user_name, item_name, item_points, conversion_date) 
                                    VALUES ('$user_name', '$item_name', '$item_points', NOW())";
        if (mysqli_query($conn, $insert_conversion_query)) {
            // Update the user's points in the plastic_drops table
            $update_query = "UPDATE plastic_drops SET points='$new_points' WHERE user_name='$user_name'";
            if (mysqli_query($conn, $update_query)) {
                $message = "You have successfully converted your points for a $item_name!";
                $_SESSION['user_points'] = $new_points; // Update the points in the session
            } else {
                $message = "Error updating points: " . mysqli_error($conn);
            }
        } else {
            $message = "Error inserting conversion data: " . mysqli_error($conn);
        }
    } else {
        $message = "You do not have enough points to convert for a $item_name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Convert Points</title>
    <link rel="stylesheet" href="points_convert.css">
</head>
<body>
    
<div class="container">
    <h1>Convert Your Points</h1>
    <p>Your current points: <?php echo $user_points; ?></p>
    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    <div class="items">
        <?php foreach ($items as $item): ?>
            <div class="item">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                <h2><?php echo $item['name']; ?></h2>
                <p><?php echo $item['points']; ?> points</p>
                <form method="POST">
                    <input type="hidden" name="item_name" value="<?php echo $item['name']; ?>">
                    <input type="hidden" name="item_points" value="<?php echo $item['points']; ?>">
                    <button type="submit" class="btn-convert">Convert</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="user_page.php" class="back-btn">Back</a>
</div>

</body>
</html>
