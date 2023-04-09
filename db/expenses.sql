

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `expenses`
-- --------------------------------------------------------
DROP DATABASE IF  EXISTS `expenses`;
CREATE DATABASE IF NOT EXISTS `expenses`;
USE `expenses`;

-- Table structure for table `categories`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL,
  `categoriesCreatedAt` DATE,
	`categoriesUpdatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `categories`
-- --------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `color`, `categoriesCreatedAt`) 
VALUES
(1, 'Food', '#DE1F59', NOW()),
(2, 'Home', '#DE1FAA', NOW()),
(3, 'Cloths', '#B01FDE', NOW()),
(4, 'Game', '#681FDE', NOW()),
(5, 'Travels', '#1FAADE', NOW());


-- Table structure for table `expenses`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category_id` int(5) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `expensesCreatedAt` DATE,
	`expensesUpdatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `expenses`
-- --------------------------------------------------------
INSERT INTO `expenses` (`id`, `title`, `category_id`, `amount`, `date`, `id_user`, `expensesCreatedAt`)
 VALUES
(1, 'prueba', 3, 12.40, '2020-03-21', 5, NOW()),
(2, 'starbucks', 1, 60.00, '2020-03-21', 5, NOW()),
(4, 'Regalo de cumpleaños mamá', 2, 1200.00, '2020-03-22', 5, NOW()),
(5, 'Nintendo Switch', 4, 4600.00, '2020-03-26', 5, NOW()),
(6, 'Viaje a Nueva York', 5, 20000.00, '2020-01-25', 5, NOW()),
(7, 'Chocolates Ferrero', 1, 140.00, '2020-03-27', 5, NOW()),
(10, 'sdsdsd', 1, 2323.00, '2020-04-03', 5, NOW()),
(11, 'sadas', 1, 232.00, '2020-04-03', 5, NOW()),
(12, 'sadas', 3, 11.00, '2020-04-03', 5, NOW()),
(13, 'sdsd', 5, 23.00, '2020-04-03', 5, NOW()),
(14, 'sdsd', 5, 23.00, '2020-04-03', 5, NOW()),
(19, 'Chilis', 1, 300.00, '2020-01-01', 5, NOW()),
(20, 'juego de Halo', 4, 1100.00, '2020-04-04', 5, NOW()),
(21, 'Uñas', 3, 200.00, '2020-04-09', 6, NOW()),
(23, 'pastillas para la tos', 2, 21.00, '2020-06-06', 5, NOW()),
(24, 'Ropa nueva', 3, 300.00, '2020-06-04', 5, NOW()),
(25, 'juego Nintendo', 2, 200.00, '2020-07-12', 5, NOW());


-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `budget` float(10,2) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userCreatedAt` DATE,
	`userUpdatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dumping data for table `users`
-- --------------------------------------------------------
INSERT INTO `users` ( `id`, `username`, `password`, `role`, `budget`, `photo`, `name`, `userCreatedAt`) 
VALUES
(5, 'Merci4dev', '$2y$10$0aOmd1LTFHtBLCEtDrJgy.xxs7FArnOlzHXLrviwP85LWS.XbxsNO', 'user', 100.00, 'd8eb8c58160f13143d4c6ef11c34b57a.png', 'Marcos Rivas', NOW());

-- Indexes for dumped tables
-- Indexes for table `categories`
-- --------------------------------------------------------
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);


-- Indexes for table `expenses`
-- --------------------------------------------------------
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_expense` (`id_user`),
  ADD KEY `id_category_expense` (`category_id`);


-- Indexes for table `users`
-- --------------------------------------------------------
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);


-- AUTO_INCREMENT for dumped tables
-- AUTO_INCREMENT for table `categories`
-- --------------------------------------------------------
ALTER TABLE `categories`
  MODIFY `id` int(5) AUTO_INCREMENT, AUTO_INCREMENT=6;


-- AUTO_INCREMENT for table `expenses`
-- --------------------------------------------------------
ALTER TABLE `expenses`
  MODIFY `id` int(20) AUTO_INCREMENT, AUTO_INCREMENT=26;


-- AUTO_INCREMENT for table `users`
-- --------------------------------------------------------
ALTER TABLE `users`
  MODIFY `id` int(11) AUTO_INCREMENT, AUTO_INCREMENT=8;


-- Constraints for dumped tables
-- Constraints for table `expenses`
-- --------------------------------------------------------
ALTER TABLE `expenses`
  ADD CONSTRAINT `id_category_expense` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `id_user_expense` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

GRANT ALL PRIVILEGES ON expenses.* TO 'myuser'@'localhost' IDENTIFIED BY 'mypassword';

SHOW GRANTS FOR 'myuser'@'localhost';
