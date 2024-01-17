<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $reservation_id = $_POST["reservation_id"];

    if (isset($_POST["cancel"])) {
        $reservation_sql = "SELECT room_id, start_date, end_date FROM reservations WHERE id = $reservation_id AND user_id = $user_id";
        $reservation_result = $conn->query($reservation_sql);

        if ($reservation_result->num_rows > 0) {
            $reservation_row = $reservation_result->fetch_assoc();

            $update_room_sql = "UPDATE rooms SET availability = 1 WHERE id = " . $reservation_row['room_id'];
            $conn->query($update_room_sql);

            $delete_reservation_sql = "DELETE FROM reservations WHERE id = $reservation_id";
            $conn->query($delete_reservation_sql);

            $message = "Reservation canceled successfully!";
        } else {
            $message = "Invalid reservation or you do not have permission to cancel it.";
        }
    } elseif (isset($_POST["edit"])) {
        $customer_name = $_POST["customer_name"];
        $phone_number = $_POST["phone_number"];
        $email = $_POST["email"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
    
        $update_reservation_sql = "UPDATE reservations SET customer_name = ?, phone_number = ?, email = ?, start_date = ?, end_date = ? WHERE id = ?";
        
        $stmt = $conn->prepare($update_reservation_sql);
        $stmt->bind_param("sssssi", $customer_name, $phone_number, $email, $start_date, $end_date, $reservation_id);
        
        if ($stmt->execute()) {
            $message = "Reservation updated successfully!";
        } else {
            $message = "Error updating reservation: " . $stmt->error;
        }
    
        $stmt->close();
    }
    
}

$reservation_query = "SELECT id, customer_name, phone_number, email, start_date, end_date FROM reservations WHERE user_id = {$_SESSION['user_id']}";
$result = $conn->query($reservation_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Cancel or Edit Reservation - Hotel Booking</title>
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
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
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
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .message-container {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 16px;
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
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
        <h2>Cancel or Edit Reservation</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <form action="" method="post">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" name="customer_name" value="<?= $row['customer_name'] ?>">

                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" value="<?= $row['phone_number'] ?>">

                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?= $row['email'] ?>">

                    
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" value="<?= $row['start_date'] ?>">

                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" value="<?= $row['end_date'] ?>">

                    <input type="hidden" name="reservation_id" value="<?= $row['id'] ?>">

                    <?php if (empty($message)): ?>
                        <input type="submit" name="cancel" value="Cancel">
                        <input type="submit" name="edit" value="Edit">
                    <?php endif; ?>
                </form>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no reservations to cancel or edit.</p>
        <?php endif; ?>
    </main>

    <?php
if (!empty($message)) {
    echo '<div class="message-container">' . $message . '</div>';
}
?>

    <footer>
        &copy; 2024 Hotel Booking. All rights reserved.
    </footer>
</body>
</html>