-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 12:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `room_id`, `customer_name`, `email`, `phone_number`, `start_date`, `end_date`, `user_id`) VALUES
(1, 3, 'Miks', 'mikijooo@gmail.com', '22356742', '2024-01-22', '2024-02-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `square_meters` int(11) DEFAULT NULL,
  `num_beds` int(11) DEFAULT NULL,
  `shower_available` tinyint(1) DEFAULT NULL,
  `kitchen_available` tinyint(1) DEFAULT NULL,
  `picture_2` varchar(255) DEFAULT NULL,
  `picture_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`, `picture`, `price`, `availability`, `square_meters`, `num_beds`, `shower_available`, `kitchen_available`, `picture_2`, `picture_3`) VALUES
(3, 'Executive Suite', 'Exclusive suite with extra amenities', 'https://a0.muscache.com/im/pictures/miso/Hosting-13903824/original/82d996fb-d7c4-46a8-a713-febd281cd69f.jpeg?im_w=720', 300.00, 1, 75, 3, 1, 0, 'https://a0.muscache.com/im/pictures/miso/Hosting-13903824/original/b0f5f933-1f0b-4f89-b6e6-7b0c2f4dfacd.jpeg?im_w=1200', 'https://a0.muscache.com/im/pictures/26c03651-2618-4286-98e3-5c82691bb5bb.jpg?im_w=720'),
(4, 'Deluxe Suite', 'Spacious and luxurious suite with a view', 'https://a0.muscache.com/im/pictures/airflow/Hosting-1112254/original/e6bed0e6-6190-4119-bd80-d12d369cea19.jpg?im_w=1200', 200.00, 1, 50, 2, 1, 1, 'https://a0.muscache.com/im/pictures/airflow/Hosting-1112254/original/d995f036-944f-4c03-9075-ccda657976ee.jpg?im_w=720', 'https://a0.muscache.com/im/pictures/airflow/Hosting-1112254/original/5528110b-6535-4dbe-ae98-2f8d5488170c.jpg?im_w=720'),
(5, 'Standard Room', 'Comfortable room with essential amenities', 'https://a0.muscache.com/im/pictures/7053c1c6-c63e-4717-9fbf-84c3205a94a8.jpg?im_w=720', 100.00, 1, 25, 1, 1, 0, 'https://a0.muscache.com/im/pictures/8b3d230e-a42e-4d25-b428-ee13d332dc8e.jpg?im_w=720', 'https://a0.muscache.com/im/pictures/miso/Hosting-8167664/original/76436a03-e2a7-454a-ba2c-9b4c021653ac.jpeg?im_w=720'),
(6, 'Grand Suite', 'Extravagant suite with many amenities', 'https://a0.muscache.com/im/pictures/2c2c598a-72b7-4d36-a52e-34ff6a974397.jpg?im_w=1200', 500.00, 1, 70, 3, 1, 1, 'https://a0.muscache.com/im/pictures/25bb535c-4a54-44a2-8089-370c298c3f7e.jpg?im_w=720', 'https://a0.muscache.com/im/pictures/975ed0ec-64ed-4d73-b98f-dad50be475ae.jpg?im_w=720');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Miks', '$2y$10$/4ziUuQ8XJezLHj/kei10.5x2QTo4knJ2wm3YLLVJ3UEzGIdFvBsa'),
(2, 'Anna', '$2y$10$qJlw3ZbYoWTwmDJnfMCdtOSqM/aLYpd1/LloMiG7ZtHtm0KKksr9K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
