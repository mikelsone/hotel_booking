<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM rooms WHERE availability = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Available Rooms - Hotel Booking</title>
    <style>

.room-card {
    width: 440px;
    margin: 20px;
    padding: 25px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center; 
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.room-card strong {
    font-size: 1.4em;
    display: block;
    margin-bottom: 10px;
    padding: 20px;
}

.room-card p {
    margin-bottom: 10px;
}


.room-card .view-more-btn {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: auto; 
}

.room-card .view-more-btn:hover {
    background-color: #2980b9;
}

.room-card form {
    margin-top: auto; 
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #b9b8b8;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

header {
    background-color: #333;
    color: white;
    padding: 20px 0;
    text-align: center;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #555;
}

main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
}

form {
    max-width: 400px;
    width: 100%;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: auto;

}

input[type="submit"]:hover {
    background-color: #45a049;
}

p {
    text-align: center;
}

a.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

a.button:hover {
    background-color: #45a049;
}

footer {
    background-color: #333;
    color: white;
    padding: 10px;
    text-align: center;
}

form {
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

.error-container {
    background-color: #ffdddd;
    color: #f44336;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 16px;
}

.success-container {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 16px;
}

.error-container, .success-container {
    width: 100%;
    max-width: 400px;
    margin: 20px auto;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    align-items: center;
     justify-content: center;
}

.overlay-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    margin: 100px;
    cursor: pointer;
}

.overlay-content p {
    margin-bottom: 10px;
    font-size: 16px;
    line-height: 1.5;
    color: #333;
}

  .overlay-content h3 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
  }

  

@media screen and (max-width: 768px) {
    .room-card {
        width: 100%;
        margin: 10px 0;
        box-sizing: border-box;
        padding: 10px;
    }

    .room-card strong {
        font-size: 1.2em;
        padding: 8px 0;
    }

    .room-card img {
        max-width: 100%;
        height: auto;
    }

    .room-card p {
        margin-bottom: 5px;
    }

    .room-card .view-more-btn {
        padding: 8px 12px;
    }

    .room-card form {
        padding: 10px;
    }

    header {
        padding: 20px 0;
    }

    nav ul li {
        margin-right: 10px;
    }

    nav ul li a {
        padding: 8px 12px;
    }


    .room-card form {
        margin-top: 5px;
        margin-left: 100px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .room-card form input[type="submit"] {
        width: 70%;
        margin-top: 10px; 
    }
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        align-items: center;
        justify-content: center;
    }

    .overlay-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .overlay-content p {
        margin-bottom: 10px;
        font-size: 16px;
        line-height: 1.5;
        color: #333;
    }

    .overlay-content h3 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
}

        @media screen and (max-width: 480px) {
            .room-card strong {
                font-size: 1.1em;
                padding: 6px 0;
            }

            .room-card p {
                margin-bottom: 3px;
            }

            .room-card .view-more-btn {
                padding: 6px 10px;
            }

            header {
                padding: 8px 0;
            }

            nav ul li {
                margin-right: 8px;
            }

            nav ul li a {
                padding: 6px 10px;
            }
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
    <h2>Available Rooms</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="room-card">
            <?php if ($row['picture']): ?>
                <img src="<?= $row['picture'] ?>" alt="<?= $row['name'] ?>" style="max-width: 100%; height: auto;">
            <?php else: ?>
                <p>No image available</p>
            <?php endif; ?>
            <strong><?= $row['name'] ?></strong>
            <p>Description: <?= $row['description'] ?></p>
            <p>Price: €<?= $row['price'] ?></p>
            <button class="view-more-btn" data-room-id="<?= $row['id'] ?>">View more</button>
            <form action="make_reservation.php" method="post">
                <input type="hidden" name="room_id" value="<?= $row['id'] ?>">
                <input type="submit" value="Make Reservation">
            </form>
        </div>
    <?php endwhile; ?>

    <div class="overlay" id="roomOverlay">
        <div class="overlay-content">
            <span class="close-btn" onclick="closeOverlay()">&times;</span>
            <div id="roomDetails"></div>
        </div>
    </div>
</main>

    <footer>
        &copy; 2024 Hotel Booking. All rights reserved.
    </footer>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    var viewMoreButtons = document.querySelectorAll('.view-more-btn');
    viewMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var roomId = this.getAttribute('data-room-id');
            showRoomDetails(roomId);
        });
    });

    var overlayBackdrop = document.getElementById('roomOverlay');
    overlayBackdrop.addEventListener('click', function(event) {
        if (event.target === overlayBackdrop) {
            closeOverlay();
        }
    });
});

function showRoomDetails(roomId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var roomDetails = JSON.parse(xhr.responseText);
            displayRoomDetails(roomDetails);
        }
    };

    xhr.open('GET', 'get_room_details.php?room_id=' + roomId, true);
    xhr.send();
}

function displayRoomDetails(roomDetails) {
    var iconInfo = '<i class="fas fa-info-circle"></i>';
    var iconEuro = '<i class="fas fa-euro-sign"></i>';
    var iconExpand = '<i class="fas fa-expand"></i>';
    var iconBed = '<i class="fas fa-bed"></i>';
    var iconShower = '<i class="fas fa-shower"></i>';
    var iconUtensils = '<i class="fas fa-utensils"></i>';

    var overlayContent = document.getElementById('roomDetails');
    overlayContent.innerHTML = `
        <h3>${roomDetails.name}</h3>
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="${roomDetails.picture}" alt="${roomDetails.name}" style="max-width: 100%; max-height: 400px; height: auto;">
            </div>
            <div class="mySlides fade">
                <img src="${roomDetails.picture_2}" alt="${roomDetails.name}" style="max-width: 100%; max-height: 400px; height: auto;">
            </div>
            <div class="mySlides fade">
                <img src="${roomDetails.picture_3}" alt="${roomDetails.name}" style="max-width: 100%; max-height: 400px; height: auto;">
            </div>
        </div>
        <p>${iconInfo} <strong>Description:</strong> ${roomDetails.description}</p>
        <p>${iconEuro} <strong>Price:</strong> €${roomDetails.price}</p>
        <p>${iconExpand} <strong>Square Meters:</strong> ${roomDetails.square_meters}</p>
        <p>${iconBed} <strong>Number of Beds:</strong> ${roomDetails.num_beds}</p>
        <p>${iconShower} <strong>Shower Availability:</strong> ${roomDetails.shower_available == 1 ? 'Yes' : 'No'}</p>
        <p>${iconUtensils} <strong>Kitchen Availability:</strong> ${roomDetails.kitchen_available == 1 ? 'Yes' : 'No'}</p>
    `;
    
    document.getElementById('roomOverlay').style.display = 'flex';

    var slideIndex = 0;
    showSlides();

    function showSlides() {
        var slides = document.getElementsByClassName("mySlides");
        for (var i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 2500);
    }
}

function closeOverlay() {
    document.getElementById('roomOverlay').style.display = 'none';
}
</script>
</body>
</html>


