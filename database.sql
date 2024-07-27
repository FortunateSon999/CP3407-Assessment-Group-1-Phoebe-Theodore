-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2024 at 05:35 PM
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
-- Database: `database`
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
(1, 'Toyota', 'Corolla', 2019, 'White', 'Petrol', 5, 1.8, 'REG003', 0, 65.00, 'Toyota_Corolla.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(2, 'Toyota', 'Fortuner', 2020, 'Silver', 'Diesel', 7, 2.7, 'REG001', 0, 75.00, 'Toyota_Fortuner_SUV.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(3, 'Toyota', 'Hilux', 2021, 'Red', 'Diesel', 5, 2.8, 'REG002', 0, 70.00, 'Toyota_H_Red.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(4, 'Suzuki', 'Swift', 2019, 'Gray', 'Petrol', 5, 1.2, 'REG010', 0, 60.00, 'susuzki_Swift.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(5, 'Suzuki', 'Ertiga', 2022, 'White', 'Petrol', 7, 1.5, 'REG015', 0, 75.00, 'suzuki-ertiga-car-maruti-toyota-innova-suzuki-e87d1a986305c9c69be257cf03353f01.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(6, 'Mercedes-Benz', 'SLS AMG', 2021, 'White', 'Petrol', 2, 6.2, 'REG007', 0, 100.00, 'Merce-B_SLS_AMG.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(7, 'Lexus', 'BMW', 2021, 'White', 'Petrol', 5, 3.5, 'REG011', 0, 90.00, 'Lexus_BMW.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(8, 'Hyundai', 'Tucson', 2021, 'Blue', 'Petrol', 5, 2.0, 'REG014', 0, 85.00, 'HYU_Blue.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(9, 'Honda', 'CR-V', 2018, 'White', 'Petrol', 5, 1.5, 'REG013', 0, 80.00, 'H_CRV_18.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(10, 'BMW', 'M2', 2017, 'Blue', 'Petrol', 4, 3.0, 'REG004', 0, 80.00, 'BMW_M2.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(11, 'Suzuki', 'Swift', 2020, 'Red', 'Petrol', 5, 1.5, 'REG016', 0, 60.00, 'eggred.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(12, 'Suzuki', 'Ertiga', 2022, 'Black', 'Petrol', 7, 1.5, 'REG017', 0, 75.00, 'pngegg0.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(13, 'Toyota', 'Innova Crysta', 2020, 'Black', 'Diesel', 7, 2.4, 'REG018', 0, 80.00, 'pngegg1.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(14, 'Toyota', 'Hilux', 2018, 'Black', 'Diesel', 5, 2.8, 'REG019', 0, 75.00, 'pngegg2.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(15, 'Hyundai', 'Creta', 2021, 'White', 'Petrol', 5, 1.6, 'REG020', 0, 70.00, 'pngegg3.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(16, 'Hyundai', 'Santa Fe', 2018, 'Red', 'Diesel', 5, 2.2, 'REG021', 0, 85.00, 'pngegg4.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(17, 'Hyundai', 'Tucson', 2017, 'Black', 'Petrol', 5, 2.0, 'REG022', 0, 80.00, 'pngegg5.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(18, 'Hyundai', 'Elantra', 2015, 'Red', 'Petrol', 5, 1.8, 'REG023', 0, 60.00, 'pngegg6.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(19, 'Hyundai', 'Sonata', 2017, 'Blue', 'Petrol', 5, 2.4, 'REG024', 0, 65.00, 'pngegg7.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(20, 'BMW', 'M3', 2016, 'White', 'Petrol', 4, 3.0, 'REG025', 0, 90.00, 'pngegg8.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(21, 'Mercedes-Benz', 'A-Class', 2019, 'Black', 'Petrol', 5, 2.0, 'REG026', 0, 95.00, 'pngegg9.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(22, 'Mercedes-Benz', 'CLA-Class', 2018, 'Red', 'Petrol', 5, 2.0, 'REG027', 0, 90.00, 'pngegg10.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(23, 'Mercedes-Benz', 'GLC Coupe', 2020, 'Brown', 'Diesel', 5, 2.1, 'REG028', 0, 100.00, 'pngegg11.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(24, 'BMW', 'X7', 2021, 'Black', 'Petrol', 7, 3.0, 'REG029', 0, 120.00, 'pngegg12.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(25, 'BMW', '4 Series', 2016, 'Black', 'Petrol', 4, 2.0, 'REG030', 0, 85.00, 'pngegg13.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(26, 'Mercedes-Benz', 'S-Class', 2019, 'Black', 'Petrol', 5, 4.0, 'REG031', 0, 150.00, 'pngegg14.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(27, 'Mercedes-Benz', 'Vito', 2020, 'Black', 'Diesel', 8, 2.1, 'REG032', 0, 110.00, 'pngegg15.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(28, 'Toyota', 'Tundra', 2021, 'Blue', 'Petrol', 5, 5.7, 'REG033', 0, 130.00, 'pngegg16.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31'),
(29, 'Toyota', 'Camry', 2020, 'Black', 'Petrol', 5, 2.5, 'REG034', 0, 70.00, 'pngegg17.png', '2024-07-27 06:45:31', '2024-07-27 06:45:31');

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
  `Profile_picture` varchar(255) NOT NULL DEFAULT 'profiles/default.png',
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `age`, `Profile_picture`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', 'password123', '123-456-7890', 28, 'profiles/default.png', 0, '2024-07-27 06:51:19', '2024-07-27 06:51:19'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', 'password123', '234-567-8901', 34, 'profiles/default.png', 0, '2024-07-27 06:51:19', '2024-07-27 06:51:19'),
(3, 'Michael', 'Johnson', 'michael.johnson@example.com', 'password123', '345-678-9012', 22, 'profiles/default.png', 0, '2024-07-27 06:51:19', '2024-07-27 06:51:19'),
(4, 'Emily', 'Davis', 'emily.davis@example.com', 'password123', '456-789-0123', 30, 'profiles/default.png', 0, '2024-07-27 06:51:19', '2024-07-27 06:51:19'),
(5, 'David', 'Wilson', 'david.wilson@example.com', 'password123', '567-890-1234', 26, 'profiles/default.png', 0, '2024-07-27 06:51:19', '2024-07-27 06:51:19'),
(6, 'phoebe', 'chung', 'pc@gmail.com', '$2y$10$uoVLiXiheOPU.HnPnwTPdezwm0zLKLoN693.Zin7wVKFR4jrtIBBW', '1234567890', 15, 'profiles/Wallpaper for MacBook _ desktop Wallpaper _  Aesthetic Minimalist Wallpaper.jpg', 1, '2024-07-27 07:12:47', '2024-07-27 07:54:16');

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
(1, 'Green', '50% off for summer rentals', 50.00, '2024-07-01', '2024-08-01', '2024-07-27 06:47:23', '2024-07-27 06:47:23', '8193458.jpg'),
(2, 'Purple', '15% off for winter rentals', 15.00, '2024-12-01', '2025-01-31', '2024-07-27 06:47:23', '2024-07-27 06:47:23', '44448795_9063058.jpg');

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

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Alice', 'Smith', 'alice.smith@example.com', 'password123', '123-456-7890', 'admin', '2024-07-27 06:50:01', '2024-07-27 06:50:01'),
(2, 'Bob', 'Johnson', 'bob.johnson@example.com', 'password123', '234-567-8901', 'manager', '2024-07-27 06:50:01', '2024-07-27 06:50:01'),
(3, 'Carol', 'Williams', 'carol.williams@example.com', 'password123', '345-678-9012', 'support', '2024-07-27 06:50:01', '2024-07-27 06:50:01'),
(4, 'David', 'Brown', 'david.brown@example.com', 'password123', '456-789-0123', 'support', '2024-07-27 06:50:01', '2024-07-27 06:50:01'),
(5, 'Eve', 'Jones', 'eve.jones@example.com', 'password123', '567-890-1234', 'support', '2024-07-27 06:50:01', '2024-07-27 06:50:01');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `rental_id` (`rental_id`);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
