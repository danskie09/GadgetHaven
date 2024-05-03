-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 08:23 PM
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
-- Database: `gadget`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(50) NOT NULL,
  `product_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `quantity` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `user_id`, `quantity`) VALUES
(30, 3, 20, 2),
(104, 25, 21, 1),
(105, 26, 21, 1),
(106, 5, 21, 1),
(107, 29, 21, 2),
(116, 10, 19, 1),
(117, 28, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(50) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Smartphones'),
(2, 'Laptops'),
(3, 'Accessories'),
(4, 'Featured'),
(5, 'On Sale');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(2, 21, 'Dan Dan', 'riama@gmail.com', '7677678766', 'test123'),
(3, 19, 'daniel', 'r@r', '7677678766', 'gfdgd'),
(4, 19, 'daniel', 'r@r', '0999', 'ljj');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `gcash` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `total_products` varchar(200) NOT NULL,
  `total_price` int(50) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `method`, `gcash`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(41, 19, 'cash on delivery', '', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'Realme GT- Master Edition (16990 x 1) - IPhone 15 Pro (70990 x 1) - ASUS ROG DELTA S HEADSET (2690 x 1) - ', 90670, '2023-12-18 18:33:56', 'finished'),
(42, 19, 'gcash', 'wallpaperflare.com_wallpaper (7).jpg', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'ZTE Nubia Red Magic 9 Pro (24999 x 1) - ', 24999, '2023-12-19 03:31:34', 'pending'),
(43, 19, 'cash on delivery', '', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'Acer ASPIRE 3 - A314 (30986 x 1) - ', 30986, '2023-12-19 03:31:48', 'pending'),
(44, 19, 'cash on delivery', '', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'Realme GT- Master Edition (16990 x 1) - ', 16990, '2023-12-19 03:33:05', 'pending'),
(45, 21, 'cash on delivery', '', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'IPhone 15 Pro (70990 x 1) - Acer ASPIRE 3 - A314 (30986 x 1) - Asus Vivobook GO 15 OLED (37995 x 1) - ASUS ROG DELTA S HEADSET (2690 x 4) - Realme GT- Master Edition (16990 x 1) - ', 167721, '2023-12-19 04:26:58', 'pending'),
(46, 19, 'gcash', 'wallpaperflare.com_wallpaper (8).jpg', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'Samsung Galaxy Tab S7 (27000 x 1) - Lenovo Legion i5 (29000 x 1) - ASUS CETRA EARPHONE (2690 x 1) - ', 58690, '2023-12-21 23:35:25', 'pending'),
(47, 19, 'gcash', 'wallpaperflare.com_wallpaper (6).jpg', '555, canada, ddddddddd, India', 'Acer Aspire 5 (32000 x 3) - Realme GT- Master Edition (16990 x 1) - ZTE Nubia Red Magic 9 Pro (24999 x 1) - ', 137989, '2023-12-21 23:54:55', 'pending'),
(48, 19, 'cash on delivery', '', 'Purok Yellow Tops, Dumaguete City, Negros Oriental', 'Realme GT- Master Edition (16990 x 4) - IPhone 15 Pro (70990 x 1) - ', 138950, '2024-01-02 20:16:29', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(50) NOT NULL,
  `category_id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(50) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `price`, `image`) VALUES
(3, 1, 'Cherry Aqua S10', 7999, 'aquas10.jpg'),
(4, 1, 'Realme GT- Master Edition', 16990, 'realme.png'),
(5, 1, 'IPhone 15 Pro', 70990, 'download.jpg'),
(6, 1, 'ZTE Nubia Red Magic 9 Pro', 24999, 'download (1).jpg'),
(7, 2, 'Acer ASPIRE 3 - A314', 30986, 'l1.webp'),
(8, 3, 'ASUS TUF H3 GAMING HEADSET', 2125, 'A1.webp'),
(9, 1, 'Nothing Phone A065', 32990, 'm2.webp'),
(10, 2, 'APPLE Macbook Air 2020', 65500, 'l2.webp'),
(11, 2, 'BMAX Y13 13.3\" N4120', 18300, 'l3.webp'),
(12, 2, 'INFINIX INbook X1 Core I3', 24990, 'l4.webp'),
(13, 3, 'ASUS CETRA EARPHONE', 2690, 'A2.webp'),
(14, 3, 'ASUS ROG DELTA S HEADSET', 2690, 'A3.webp'),
(16, 3, 'DELTA FORCE USB GAMING MOUSE', 990, 'A6webp.webp'),
(18, 3, 'NORGICOOL USB KEYBOARD', 2990, 'A7.webp'),
(20, 3, 'SILVERTEC S3(RG)EARPHONE', 299, 'A9.webp'),
(21, 2, 'LENOVO Ideapad Gaming 3', 55000, 'l5.webp'),
(22, 2, 'Asus Vivobook GO 15 OLED', 37995, 'l6.png'),
(23, 1, 'Huawei Y6P', 5678, 'm8.webp'),
(25, 4, 'Samsung Galaxy Tab S7', 27000, 'tab.png'),
(26, 4, 'Acer Aspire 5', 32000, '1.webp'),
(28, 5, 'Mac Book Air 13', 47899, 'LAPAPP0093_1.webp'),
(29, 5, 'Lenovo Legion i5', 29000, 'lenovo-82au00j8.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `password`) VALUES
(16, 'e', 'e', 'r@r', '123'),
(17, 'ggfdf', 'sdfd', 'r@r', 'vv'),
(18, 'john', 'doe', 'y@y', 'yy'),
(19, 'James', 'Doe', 'James@Doe', 'jd'),
(20, 'Van Ashleigh', 'ffff', 'v@n', 'ff'),
(21, 'Dan', 'Dan', 'riama@gmail.com', 'chsk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
