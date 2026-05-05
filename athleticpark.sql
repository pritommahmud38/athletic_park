-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 05:34 PM
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
-- Database: `bolt`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(15) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `units` int(5) NOT NULL,
  `total` int(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_code`, `product_name`, `product_desc`, `price`, `units`, `total`, `date`, `email`, `status`) VALUES
(28, 'P101', 'Men’s Premium Trousers Puma – Terry Fabric (Black)', 'Fabric: Crafted from premium-quality Terry fabric, offering a perfect balance of durability and comfort for daily wear.\r\nBrand: Puma – renowned for its fusion of performance and style, delivering sportswear that stands out.\r\nDesign Features\r\nEmbroidery: S', 749, 1, 749, '2025-09-29 18:02:16', 'rokonzaman199@gmail.com', 'Pending'),
(27, 'C101', 'Close Baseball Cap for Men/women', 'Product Type: Cap\r\nMaterial: Foam Net\r\nStylish And Fashionable\r\nGender: Unisex\r\nAge Group: Adults\r\nPattern: Plain\r\nUsage: Outdoors Sport, decoration, promotion,etc\r\nFabric Feature: Common\r\nTrendy design\r\nComfortable to wear\r\nCaps For Men And Women', 249, 1, 249, '2025-09-29 18:02:16', 'rokonzaman199@gmail.com', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` tinytext NOT NULL,
  `product_img_name` varchar(60) NOT NULL,
  `qty` int(5) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `product_img_name`, `qty`, `price`) VALUES
(12, 'C101', 'Close Baseball Cap for Men/women', 'Product Type: Cap\r\nMaterial: Foam Net\r\nStylish And Fashionable\r\nGender: Unisex\r\nAge Group: Adults\r\nPattern: Plain\r\nUsage: Outdoors Sport, decoration, promotion,etc\r\nFabric Feature: Common\r\nTrendy design\r\nComfortable to wear\r\nCaps For Men And Women', 'cap.jpg', 19, 249.00),
(13, 'P101', 'Men’s Premium Trousers Puma – Terry Fabric (Black)', 'Fabric: Crafted from premium-quality Terry fabric, offering a perfect balance of durability and comfort for daily wear.\r\nBrand: Puma – renowned for its fusion of performance and style, delivering sportswear that stands out.\r\nDesign Features\r\nEmbroidery: S', 'pant.jpg', 14, 749.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `district` varchar(100) NOT NULL,
  `division` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(15) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'user',
  `profile_img` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `address`, `phone`, `district`, `division`, `email`, `password`, `type`, `profile_img`) VALUES
(1, 'Rokonuzzaman', 'Rokon', 'Adabor 10', '+8801846062834', 'Dhaka', 'Dhaka', 'rokonzaman@gmail.com', '112233', 'admin', '68dacbe637504.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
