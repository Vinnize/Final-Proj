<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
    exit();
}

// Fetch conversion data
$query = "SELECT * FROM points_conversions";
$result = mysqli_query($conn, $query);

$conversions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $conversions[] = $row;
}

// Dummy data for items (should match the actual filenames in your img directory)
$items = [
    "Ball pen" => "img/ballpen.png",
    "Yellow Paper" => "img/yellowpaper.png",
    "AquaFlask" => "img/aquaflask.jpg",
    "Keyboard" => "img/Keyboard.png",
    "Mousepad" => "img/mousepad.png",
    "Mouse" => "img/mouse.png",
    "SchoolSupplies" => "img/schoolsupplies.png",
    "Tumbler" => "img/tumbler.png"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Conversions</title>
    <link rel="stylesheet" href="view_conversions.css">
</head>
<body>
    
<div class="container">
    <h1>User Conversions</h1>
    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Item Name</th>
                <th>Item Image</th>
                <th>Item Points</th>
                <th>Conversion Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($conversions as $conversion): ?>
                <tr>
                    <td><?php echo $conversion['user_name']; ?></td>
                    <td><?php echo $conversion['item_name']; ?></td>
                    <td>
                        <?php
                        $item_name = $conversion['item_name'];
                        if (isset($items[$item_name])) {
                            echo "<img src='{$items[$item_name]}' alt='{$item_name}' style='width: 70px; height: auto;'>";
                        } else {
                            echo "Image not available";
                        }
                        ?>
                    </td>
                    <td><?php echo $conversion['item_points']; ?></td>
                    <td><?php echo $conversion['conversion_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="admin_page.php" class="back-btn">Back to Admin Page</a>
</div>
                    
</body>
</html>
