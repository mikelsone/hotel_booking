<?php

include('db_connection.php');

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    $sql = "SELECT name, description, price, picture, picture_2, picture_3, square_meters, num_beds, shower_available, kitchen_available FROM rooms WHERE id = $room_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $roomDetails = $result->fetch_assoc();
        echo json_encode($roomDetails);
    } else {
        echo json_encode(['error' => 'Room details not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
