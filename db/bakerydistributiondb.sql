-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 09:19 PM
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
-- Database: `bakerydistributiondb`
--

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` int(11) NOT NULL,
  `location` varchar(60) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`id`, `location`, `amount`) VALUES
(5, 'gboko', 500),
(6, 'makurdi', 200),
(7, 'otukpo', 1000),
(10, 'kanshio', 350);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `fid` int(11) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `message` varchar(600) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `fullname` varchar(60) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`fullname`, `gender`, `phone`, `email`, `message`, `date`, `status`) VALUES
('lola lola', 'female', '09011223344', 'lola@gmail.com', 'have not seen my order', '2020-10-17 18:01:48', 'no'),
('lola alabi', 'female', '09013829585', 'skylinesnow07@gmail.com', 'your product are very good', '2023-10-11 18:45:40', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_id` varchar(60) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `venture` varchar(60) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `location` varchar(60) NOT NULL,
  `address` varchar(500) NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_id`, `fullname`, `venture`, `gender`, `phone`, `email`, `location`, `address`, `reg_date`) VALUES
('CUS-2020/0001', 'lola lola alabi', 'Lola venture', 'Female', '09013829585', 'lola@gmail.com', 'otukpo', 'northbank', '2020-10-17'),
('CUS-2020/0002', 'shosanya razaq', 'Skyline Venture', 'Male', '09013829585', 'razaq4real@gmail.com', 'makurdi', 'makurdi lafia', '2020-10-17');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `or_id` int(11) NOT NULL,
  `cus_id` varchar(60) NOT NULL,
  `p_id` varchar(60) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `date_ordered` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`or_id`, `cus_id`, `p_id`, `product_qty`, `date_ordered`, `status`) VALUES
(76, 'CUS-2020/0001', 'PROD-091910', 1, '2023-10-14 23:39:08', 'received'),
(77, 'CUS-2020/0001', 'PROD-091910', 5, '2023-10-15 17:12:55', 'received'),
(78, 'CUS-2020/0001', 'PROD-333910', 15, '2023-10-17 01:21:14', 'received'),
(79, 'CUS-2020/0001', 'PROD-315610', 11, '2023-10-17 01:21:14', 'received');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(15) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `role`, `status`) VALUES
('admin', 'a', 'admin', 'active'),
('lola@gmail.com', 'a', 'customer', 'active'),
('razaq4real@gmail.com', 'razaq4real@gmail.com', 'customer', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` varchar(40) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_price` varchar(20) NOT NULL,
  `product_image` varchar(60) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `product_name`, `product_price`, `product_image`, `date`) VALUES
('PROD-091910', 'Beans cake', '50', '652af56f7cf118.88368516.jpg', '2023-10-14'),
('PROD-311610', 'Doughnut', '100', '652afa9427d7e4.21695335.png', '2023-10-14'),
('PROD-315610', 'Cake Bread', '300', '652afabcc37274.71362532.jpg', '2023-10-14'),
('PROD-325310', 'Chocolate bread', '500', '652afaf59c18f3.61336640.png', '2023-10-14'),
('PROD-333910', 'Bulter Bread', '750', '652afb233797d2.40014073.jpg', '2023-10-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`or_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
