-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 23, 2022 at 05:17 PM
-- Server version: 8.0.31-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `picture` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '../../../uploads/products/PRODUCTS-ICON.png',
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `price`, `name`, `picture`, `stock`) VALUES
(4, '10.00', 'meow heart attack', '../uploads/products/IMG_0256.JPG', 9),
(5, '34.00', 'pointer like $h1t', '../uploads/products/IMG_1353.JPG', 4),
(6, '20.00', '$h1tty c0d3', '../uploads/products/IMG_0715.JPG', 10),
(7, '30.00', 'private ip bea', '../uploads/products/IMG_1215.JPG', 10),
(8, '10.00', 'wowy fill me duh', '../uploads/products/IMG_1290.JPG', 0),
(9, '500.00', 'CCS', '../uploads/products/IMG_0953.JPG', -1),
(10, '40.00', 'resp code in the nutshell', '../uploads/products/IMG_1004.JPG\r\n', 3),
(11, '300.00', 'data scientist ', '../uploads/products/IMG_1220.JPG\r\n', 10),
(12, '30.00', 'bmw roast benz', '../uploads/products/IMG_1297.JPG', 0),
(13, '50.00', 'compression in the nutshell', '../uploads/products/IMG_1229.JPG', 4),
(14, '300.00', 'amdin pls', '../uploads/products/IMG_1262.PNG', 10),
(15, '1000.00', 'how we use github', '../uploads/products/IMG_1296.JPG', 3),
(16, '30.00', 'udp $uck', '../uploads/products/IMG_1315.JPG', 3),
(17, '30.00', 'hecker be like', '../uploads/products/IMG_1316.JPG', 50),
(18, '300.00', 'the war never ended', '../uploads/products/IMG_1321.PNG', 10),
(19, '10.00', 'chemms programming', '../uploads/products/IMG_1372.JPG', 50),
(20, '300.00', 'wtf elon?', '../uploads/products/IMG_1356.JPG', 10),
(21, '30.00', 'random $hjt on the net', '../uploads/products/IMG_1320.JPG', 10),
(22, '10.00', 'me & my friend', '../uploads/products/IMG_1298.JPG\r\n', 3),
(23, '400.00', 'netcat for real', '../uploads/products/IMG_1292.JPG', 2),
(24, '0.00', 'end of the year... ', '../uploads/products/IMG_1358.JPG', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int NOT NULL,
  `username` varchar(200) NOT NULL,
  `userPassword` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `userEmail` varchar(500) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `creditCard` int DEFAULT NULL,
  `avatar` varchar(1000) NOT NULL DEFAULT '../../uploads/avatars/ava.png',
  `balance` decimal(15,2) DEFAULT '0.00',
  `premiumTier` int DEFAULT '0',
  `premireExpire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `userPassword`, `userEmail`, `phone`, `firstname`, `lastname`, `creditCard`, `avatar`, `balance`, `premiumTier`, `premireExpire`) VALUES
(5, 'DUH', '$2y$10$sE8siQaATjePk62k/aeG5OfAsBNkL.afBKmXzUat0FCN0UJLdLA42', '', NULL, NULL, NULL, 123, '../../uploads/avatars/ava.png', '8000.00', 3, '2023-11-23'),
(6, 'VALEN', '$2y$10$ZYIoUPXM5rYLu/B3x/xRzug9ewOsNqzvbCrmOqc71qGRa6uPJSu4K', '', NULL, NULL, NULL, 123, '../uploads/avatars/1505325683-siegel_des_baphomet.jpg', '97000.00', 3, '2023-11-23'),
(7, 'GOD', '$2y$10$pymQOfx/IOAAc/gKhnp/9ukoMw61ZkT/FJacd6JxPhW1kkE0prYyi', '', NULL, NULL, NULL, 123, '../../uploads/avatars/ava.png', '8000.00', 3, '2023-11-23'),
(8, 'HUHU', '$2y$10$iqTKfc54Pfkc5zz3K78AauaA0ncCVaNEs6YoUt34WcnXzSmQbdoES', '', NULL, NULL, NULL, NULL, '../../uploads/avatars/ava.png', '0.00', 0, NULL),
(9, 'MEO', '$2y$10$f6ZOMC2ZSeLwJelIaMCHme3ZYCzjH1WqaVpRm8mtn2NM7bvxR5fou', '', NULL, NULL, NULL, 123, '../../uploads/avatars/ava.png', '3000.00', 3, '2023-11-23'),
(10, 'DOG', '$2y$10$P0OJJow6TBHmyNZ2n5BLXuGV8QvXqqsHryHidHm/f6gEzwiLs/wsi', '', NULL, NULL, NULL, 123, '../../uploads/avatars/ava.png', '7500.00', 3, '2023-11-23'),
(11, 'THU', '$2y$10$LFk7LzdYLZfEPncMYC8JK.Yp6QceB/z8rmK463xl5SQZ80v/rvXQW', '', NULL, NULL, NULL, NULL, '../../uploads/avatars/ava.png', '0.00', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
