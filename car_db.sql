-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 12, 2024 at 04:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `car_id` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `fuel_type` varchar(20) DEFAULT NULL,
  `seat_number` int(11) DEFAULT NULL,
  `capacity` decimal(3,1) DEFAULT NULL,
  `registration` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`car_id`, `brand`, `model`, `year`, `color`, `fuel_type`, `seat_number`, `capacity`, `registration`, `status`, `price_per_day`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', 'Corolla', 2019, 'White', 'Petrol', 5, 1.8, 'REG003', 1, 65.00, 'Toyota_Corolla.png', '2024-08-10 14:41:57', '2024-08-10 15:22:03'),
(2, 'Toyota', 'Fortuner', 2020, 'Silver', 'Diesel', 7, 2.7, 'REG001', 1, 75.00, 'Toyota_Fortuner_SUV.png', '2024-08-10 14:41:57', '2024-08-11 10:09:33'),
(3, 'Toyota', 'Hilux', 2021, 'Red', 'Diesel', 5, 2.8, 'REG002', 1, 70.00, 'Toyota_H_Red.png', '2024-08-10 14:41:57', '2024-08-11 10:25:34'),
(4, 'Suzuki', 'Swift', 2019, 'Gray', 'Petrol', 5, 1.2, 'REG010', 1, 60.00, 'susuzki_Swift.png', '2024-08-10 14:41:57', '2024-08-11 10:25:38'),
(5, 'Suzuki', 'Ertiga', 2022, 'White', 'Petrol', 7, 1.5, 'REG015', 1, 75.00, 'suzuki-ertiga-car-maruti-toyota-innova-suzuki-e87d1a986305c9c69be257cf03353f01.png', '2024-08-10 14:41:57', '2024-08-11 02:41:40'),
(6, 'Mercedes-Benz', 'SLS AMG', 2021, 'White', 'Petrol', 2, 6.2, 'REG007', 0, 100.00, 'Merce-B_SLS_AMG.png', '2024-08-10 14:41:57', '2024-08-11 10:24:44'),
(7, 'Lexus', 'BMW', 2021, 'White', 'Petrol', 5, 3.5, 'REG011', 1, 90.00, 'Lexus_BMW.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(8, 'Hyundai', 'Tucson', 2021, 'Blue', 'Petrol', 5, 2.0, 'REG014', 1, 85.00, 'HYU_Blue.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(9, 'Honda', 'CR-V', 2018, 'White', 'Petrol', 5, 1.5, 'REG013', 1, 80.00, 'H_CRV_18.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(10, 'BMW', 'M2', 2017, 'Blue', 'Petrol', 4, 3.0, 'REG004', 1, 80.00, 'BMW_M2.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(11, 'Suzuki', 'Swift', 2020, 'Red', 'Petrol', 5, 1.5, 'REG016', 1, 60.00, 'eggred.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(12, 'Suzuki', 'Ertiga', 2022, 'Black', 'Petrol', 7, 1.5, 'REG017', 1, 75.00, 'pngegg0.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(13, 'Toyota', 'Innova Crysta', 2020, 'Black', 'Diesel', 7, 2.4, 'REG018', 1, 80.00, 'pngegg1.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(14, 'Toyota', 'Hilux', 2018, 'Black', 'Diesel', 5, 2.8, 'REG019', 1, 75.00, 'pngegg2.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(15, 'Hyundai', 'Creta', 2021, 'White', 'Petrol', 5, 1.6, 'REG020', 1, 70.00, 'pngegg3.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(16, 'Hyundai', 'Santa Fe', 2018, 'Red', 'Diesel', 5, 2.2, 'REG021', 1, 85.00, 'pngegg4.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(17, 'Hyundai', 'Tucson', 2017, 'Black', 'Petrol', 5, 2.0, 'REG022', 1, 80.00, 'pngegg5.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(18, 'Hyundai', 'Elantra', 2015, 'Red', 'Petrol', 5, 1.8, 'REG023', 1, 60.00, 'pngegg6.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(19, 'Hyundai', 'Sonata', 2017, 'Blue', 'Petrol', 5, 2.4, 'REG024', 1, 65.00, 'pngegg7.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(20, 'BMW', 'M3', 2016, 'White', 'Petrol', 4, 3.0, 'REG025', 1, 90.00, 'pngegg8.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(21, 'Mercedes-Benz', 'A-Class', 2019, 'Black', 'Petrol', 5, 2.0, 'REG026', 1, 95.00, 'pngegg9.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(22, 'Mercedes-Benz', 'CLA-Class', 2018, 'Red', 'Petrol', 5, 2.0, 'REG027', 1, 90.00, 'pngegg10.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(23, 'Mercedes-Benz', 'GLC Coupe', 2020, 'Brown', 'Diesel', 5, 2.1, 'REG028', 1, 100.00, 'pngegg11.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(24, 'BMW', 'X7', 2021, 'Black', 'Petrol', 7, 3.0, 'REG029', 1, 120.00, 'pngegg12.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(25, 'BMW', '4 Series', 2016, 'Black', 'Petrol', 4, 2.0, 'REG030', 1, 85.00, 'pngegg13.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(26, 'Mercedes-Benz', 'S-Class', 2019, 'Black', 'Petrol', 5, 4.0, 'REG031', 1, 150.00, 'pngegg14.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(27, 'Mercedes-Benz', 'Vito', 2020, 'Black', 'Diesel', 8, 2.1, 'REG032', 1, 110.00, 'pngegg15.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(28, 'Toyota', 'Tundra', 2021, 'Blue', 'Petrol', 5, 5.7, 'REG033', 1, 130.00, 'pngegg16.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57'),
(29, 'Toyota', 'Camry', 2020, 'Black', 'Petrol', 5, 2.5, 'REG034', 1, 70.00, 'pngegg17.png', '2024-08-10 14:41:57', '2024-08-10 14:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'profiles/default.png',
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `age`, `profile_picture`, `status`, `created_at`, `updated_at`) VALUES
(1, 'phoebe', 'ni', 'pc@gmail.com', '$2y$10$Fs9UNHsa6fdgDvhGRxjSfOSkllnZZenHlDOCzMi/oaRY8TK51WTT.', '555633857538', 20, 'profiles/default.png', 0, '2024-08-10 14:55:44', '2024-08-11 10:26:40'),
(2, 'John', 'Doe', 'johndoe@example.com', '$2y$10$iYVzTEVNKAwKHnRnWLN/0eSUHw.q49t8BIVKHOjxDwx3kUKE2Hdqa', '1234567890', 30, 'profiles/default.png', 0, '2024-08-11 08:54:45', '2024-08-11 08:54:45'),
(7, 'robert', 'chin', 'chin@gmail.com', '$2y$10$ow80RXfSiCo1HuNDlb6kc.ymeEeoMNss70MsTlKGpNc3ig.bqD6yC', '23456781', 33, 'profiles/default.png', 0, '2024-08-11 10:11:10', '2024-08-11 10:11:10'),
(8, 'chealsea', 'tan', 'Cotan@gmail.com', '$2y$10$5g3NVKZVU1bV/pVojWL9hOU.AYSICWRB22T5xZhAtNn8hrQ.fTqCy', '9999', 23, 'profiles/default.png', 0, '2024-08-11 10:15:04', '2024-08-11 10:20:13'),
(9, 'Theodore', 'Lee', 'Lee0404@gmail.com', '$2y$10$7iQB40I1nKyTXPLcExgBSOyr7Ey0h1cU.OMSBV6e2ua8m7/dbGVLy', '1234567890', 33, 'profiles/default.png', 1, '2024-08-11 10:27:14', '2024-08-11 10:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_until` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `discount_code`, `description`, `discount_percent`, `valid_from`, `valid_until`, `created_at`, `updated_at`, `image_path`) VALUES
(1, 'Green', '50% off for summer rentals', 50.00, '2024-07-01', '2024-12-01', '2024-08-10 14:43:59', '2024-08-10 14:43:59', '8193458.jpg'),
(2, 'Purple', '15% off for winter rentals', 15.00, '2024-08-01', '2025-01-31', '2024-08-10 14:43:59', '2024-08-10 14:43:59', '44448795_9063058.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','manager','support') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frequent_asks`
--

CREATE TABLE `frequent_asks` (
  `id` int(30) NOT NULL,
  `question_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frequent_asks`
--

INSERT INTO `frequent_asks` (`id`, `question_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 6),
(6, 8),
(7, 11),
(8, 13),
(9, 14),
(10, 20),
(11, 21),
(12, 22),
(13, 24);

-- --------------------------------------------------------

--
-- Table structure for table `passwordresetotp`
--

CREATE TABLE `passwordresetotp` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` enum('credit_card','debit_card','paypal','cash') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `rental_id`, `amount`, `payment_date`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 1, 110.50, '2024-08-10', 'cash', '2024-08-10 15:17:19', '2024-08-10 15:17:19'),
(2, 2, 75.00, '2024-08-10', 'credit_card', '2024-08-10 15:50:25', '2024-08-10 15:50:25'),
(3, 3, 120.00, '2024-08-10', 'cash', '2024-08-10 15:59:28', '2024-08-10 15:59:28'),
(4, 4, 0.00, '2024-08-11', 'cash', '2024-08-11 02:34:10', '2024-08-11 02:34:10'),
(5, 5, 225.00, '2024-08-11', 'cash', '2024-08-11 02:41:32', '2024-08-11 02:41:32'),
(6, 6, 225.00, '2024-08-11', 'credit_card', '2024-08-11 09:20:11', '2024-08-11 09:20:11'),
(7, 7, 120.00, '2024-08-11', 'cash', '2024-08-11 10:07:22', '2024-08-11 10:07:22'),
(8, 8, 280.00, '2024-08-11', 'credit_card', '2024-08-11 10:08:48', '2024-08-11 10:08:48'),
(9, 9, 120.00, '2024-08-11', 'cash', '2024-08-11 10:23:33', '2024-08-11 10:23:33'),
(10, 10, 400.00, '2024-08-11', 'credit_card', '2024-08-11 10:24:44', '2024-08-11 10:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(30) NOT NULL,
  `question` text DEFAULT NULL,
  `response_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `response_id`) VALUES
(1, 'What are your rental prices?', 1),
(2, 'Where can I pick up the car?', 2),
(3, 'Do you offer discounts?', 3),
(4, 'How can I book a car?', 4),
(5, 'What payment methods do you accept?', 5),
(6, 'Can I cancel my booking?', 6),
(7, 'Can I modify my booking?', 7),
(8, 'What is the minimum age to rent a car?', 8),
(9, 'Can I add an additional driver?', 9),
(10, 'Is insurance included in the rental?', 10),
(11, 'Do you offer long-term rental discounts?', 11),
(12, 'What types of cars do you have?', 12),
(13, 'What are your office hours?', 13),
(14, 'What documents do I need to rent a car?', 14),
(15, 'What is the late return fee?', 15),
(16, 'Do you offer GPS devices?', 16),
(17, 'Can I rent a child seat?', 17),
(18, 'Where can I view my booking details?', 18),
(19, 'Is smoking allowed in the rental cars?', 19),
(20, 'What should I do if I have an issue with the car?', 20),
(21, 'Who are you?', 21),
(22, 'What can you do?', 22),
(23, 'When are you available?', 23),
(24, 'How can you help me?', 24),
(25, 'Can I speak to a human?', 25),
(26, 'Are you a real person?', 26),
(27, 'What kind of information can you provide?', 27),
(28, 'Can you tell me about your services?', 28),
(29, 'How can you make my experience better?', 29),
(30, 'How do I start?', 30),
(31, 'Hi', 21),
(32, 'Hello', 21),
(33, 'Hey', 21),
(34, 'Bye', 22),
(35, 'Goodbye', 22),
(36, 'Thank you', 23),
(37, 'Thanks', 23),
(38, 'How can I get more help?', 24),
(39, 'Are your cars well-maintained?', 25);

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `rental_date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `status` enum('reserved','completed','cancelled') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `card_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rental_id`, `customer_id`, `car_id`, `emp_id`, `rental_date`, `pickup_time`, `return_date`, `return_time`, `total_price`, `discount_id`, `status`, `created_at`, `updated_at`, `payment_method`, `card_number`, `card_name`) VALUES
(1, 1, 1, NULL, '2024-08-10', '22:56:00', '2024-08-12', '22:56:00', 130.00, NULL, 'cancelled', '2024-08-10 15:17:19', '2024-08-10 15:22:03', 'cash', NULL, NULL),
(2, 1, 2, NULL, '2024-08-10', '23:49:00', '2024-08-11', '12:49:00', 75.00, NULL, 'cancelled', '2024-08-10 15:50:25', '2024-08-10 15:50:38', 'credit_card', '56798746', 'me'),
(3, 1, 4, NULL, '2024-08-10', '23:59:00', '2024-08-12', '13:59:00', 120.00, NULL, 'cancelled', '2024-08-10 15:59:28', '2024-08-10 15:59:40', 'cash', NULL, NULL),
(4, 1, 5, NULL, '2024-08-11', '10:33:00', '2024-08-11', '03:33:00', 0.00, NULL, 'cancelled', '2024-08-11 02:34:10', '2024-08-11 02:39:07', 'cash', NULL, NULL),
(5, 1, 5, NULL, '2024-08-11', '08:40:00', '2024-08-14', '01:40:00', 225.00, NULL, 'cancelled', '2024-08-11 02:41:32', '2024-08-11 02:41:40', 'cash', NULL, NULL),
(6, 1, 2, NULL, '2024-08-11', '20:19:00', '2024-08-14', '17:19:00', 225.00, NULL, 'cancelled', '2024-08-11 09:20:11', '2024-08-11 10:09:33', 'credit_card', '23456', 'TheodoreLee'),
(7, 1, 4, NULL, '2024-08-12', '18:07:00', '2024-08-14', '18:07:00', 120.00, NULL, 'cancelled', '2024-08-11 10:07:22', '2024-08-11 10:09:39', 'cash', NULL, NULL),
(8, 1, 3, NULL, '2024-08-14', '18:07:00', '2024-08-18', '18:08:00', 280.00, NULL, 'cancelled', '2024-08-11 10:08:48', '2024-08-11 10:25:34', 'credit_card', '2345617', 'CHEALSEATAN'),
(9, 1, 4, NULL, '2024-08-13', '18:22:00', '2024-08-15', '18:23:00', 120.00, NULL, 'cancelled', '2024-08-11 10:23:33', '2024-08-11 10:25:38', 'cash', NULL, NULL),
(10, 1, 6, NULL, '2024-08-12', '18:24:00', '2024-08-16', '18:24:00', 400.00, NULL, 'reserved', '2024-08-11 10:24:44', '2024-08-11 10:24:44', 'credit_card', '234268643', 'CHEALSEATAN');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(30) NOT NULL,
  `response_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `response_message`) VALUES
(1, 'Our rental prices start from $60 per day, depending on the car model.'),
(2, 'You can pick up the car at our office, or we can arrange delivery to your location.'),
(3, 'Yes, we offer various discounts. Please provide your discount code.'),
(4, 'You can book a car through our website by selecting your desired car and following the booking process.'),
(5, 'We accept credit cards, debit cards, PayPal, and cash payments.'),
(6, 'Yes, you can cancel your booking up to 24 hours before the pickup time for a full refund.'),
(7, 'Yes, you can modify your booking by contacting our support team.'),
(8, 'You must be at least 21 years old to rent a car from us.'),
(9, 'Yes, additional drivers can be added to your booking for an extra fee.'),
(10, 'All our rentals include basic insurance coverage.'),
(11, 'Yes, we offer long-term rental discounts.'),
(12, 'We have a wide variety of cars, including sedans, SUVs, and luxury vehicles.'),
(13, 'Our office hours are from 8 AM to 8 PM, Monday to Saturday.'),
(14, 'You need to provide a valid driver’s license, a credit card, and proof of insurance.'),
(15, 'The late return fee is $10 per hour, up to a maximum of $50.'),
(16, 'Yes, we offer GPS devices for an additional charge of $5 per day.'),
(17, 'Yes, we have child seats available for $3 per day.'),
(18, 'You can view your booking details in the “My Bookings” section of our website.'),
(19, 'Yes, smoking is strictly prohibited in all our rental cars.'),
(20, 'Please contact our support team for help with any issues. We’re here to assist you.'),
(21, 'Hello! I\'m your virtual assistant, here to help you with your car rental needs.'),
(22, 'I can assist you with booking a car, answering questions about our services, and more!'),
(23, 'I\'m available 24/7 to assist you with any questions or concerns.'),
(24, 'You can ask me anything about our car rental services, and I\'ll do my best to help!'),
(25, 'If you need human assistance, I can connect you with our support team.'),
(26, 'I\'m constantly learning and improving to better assist you with your inquiries.'),
(27, 'I can provide information about prices, availability, discounts, and more.'),
(28, 'Feel free to ask me about our latest car models or available discounts.'),
(29, 'I\'m here to make your car rental experience as smooth as possible!'),
(30, 'Let\'s get started! What can I help you with today?'),
(31, 'Hello! How can I assist you today?'),
(32, 'Goodbye! Have a great day!'),
(33, 'Thank you for reaching out!'),
(34, 'You can contact our support team for any further assistance.'),
(35, 'Our cars are well-maintained and serviced regularly to ensure safety and comfort.');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `customer_id`, `car_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 4, 'good', '2024-08-10 09:48:56'),
(2, 1, 1, 4, 'very good', '2024-08-11 03:18:14'),
(3, 1, 1, 5, 'not bad', '2024-08-11 04:06:08'),
(4, 1, 5, 1, 'meh~~', '2024-08-11 04:06:29'),
(5, 1, 7, 4, 'NOT BAD', '2024-08-11 04:22:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `registration` (`registration`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`),
  ADD UNIQUE KEY `discount_code` (`discount_code`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `frequent_asks`
--
ALTER TABLE `frequent_asks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passwordresetotp`
--
ALTER TABLE `passwordresetotp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`otp_code`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `rental_id` (`rental_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `discount_id` (`discount_id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frequent_asks`
--
ALTER TABLE `frequent_asks`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `passwordresetotp`
--
ALTER TABLE `passwordresetotp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `passwordresetotp`
--
ALTER TABLE `passwordresetotp`
  ADD CONSTRAINT `passwordresetotp_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`rental_id`);

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`),
  ADD CONSTRAINT `rentals_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`),
  ADD CONSTRAINT `rentals_ibfk_4` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`discount_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
