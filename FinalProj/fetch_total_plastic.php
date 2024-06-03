<?php
@include 'config.php';

// Check if the connection is established
if (!$conn) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit();
}

// Fetch total plastic data
$query = "SELECT DATE(drop_date) as drop_date, SUM(plastic_weight) as total_plastic FROM plastic_drops GROUP BY DATE(drop_date)";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    http_response_code(500);
    echo json_encode(["message" => "Query failed: " . mysqli_error($conn)]);
    mysqli_close($conn);
    exit();
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close the database connection
mysqli_close($conn);

echo json_encode($data);
?>
