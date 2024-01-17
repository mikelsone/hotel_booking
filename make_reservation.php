<?php
session_start();
include('db_connection.php');

$errors = array();
$successMessage = "";
$roomDetails = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customer_name"], $_POST["email"], $_POST["phone_number"], $_POST["start_date"], $_POST["end_date"])) {
    if (isset($_POST["room_id"])) {
        $room_id = $_POST["room_id"];
        $_SESSION['selected_room_id'] = $room_id; 

        $room_sql = "SELECT * FROM rooms WHERE id = $room_id";
        $room_result = $conn->query($room_sql);
        $roomDetails = $room_result->fetch_assoc();

        if ($roomDetails['availability']) {
            $customer_name = $_POST["customer_name"];
            $email = $_POST["email"];
            $phone_number = $_POST["phone_number"];
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];

            if (strtotime($start_date) === false || strtotime($end_date) === false) {
                $errors[] = "Invalid date format.";
            } else {
                $update_sql = "UPDATE rooms SET availability = 0 WHERE id = $room_id";
                if ($conn->query($update_sql) === TRUE) {
                    $insert_reservation_sql = "INSERT INTO reservations (room_id, user_id, customer_name, email, phone_number, start_date, end_date) VALUES ('$room_id', '{$_SESSION['user_id']}', '$customer_name', '$email', '$phone_number', '$start_date', '$end_date')";
                    if ($conn->query($insert_reservation_sql) === TRUE) {
                        $successMessage = "Reservation successful!";
                    } else {
                        $errors[] = "Error: " . $insert_reservation_sql . "<br>" . $conn->error;
                    }
                } else {
                    $errors[] = "Error updating room availability: " . $conn->error;
                }
            }
        } else {
            $errors[] = "This room is no longer available.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Make Reservation - Hotel Booking</title>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: none;
            border-radius: 4px;
            padding: 12px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        .success-container {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 16px;
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
        }

        .error-container {
            background-color: #ffdddd;
            color: #f44336;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 16px;
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
        <nav class="left-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="available_rooms.php">Rooms</a></li>
                <li><a href="cancel_reservation.php">Cancel</a></li>
            </ul>
        </nav>
        <nav>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Make Reservation</h2>
        
        <?php
        if (!empty($successMessage)) {
            echo '<div class="success-container">' . $successMessage . '</div>';
        }

        if (!empty($errors)) {
            echo '<div class="error-container"><ul>';
            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul></div>';
        }
        ?>
        
        <form action="make_reservation.php" method="post">
            <input type="hidden" name="room_id" value="<?= $_POST['room_id'] ?>">

            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" required>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <input type="submit" value="Make Reservation">
        </form>
    </main>

    <footer>
        &copy; 2024 Hotel Booking. All rights reserved.
    </footer>
    
</body>
</html>
