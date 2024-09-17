-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 17, 2024 at 07:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DB_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `id_usuario` int(11) DEFAULT NULL,
  `privilegios` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Clientes`
--

CREATE TABLE `Clientes` (
  `id_usuario` int(11) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Mensajes`
--

CREATE TABLE `Mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `contenido` text DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Pedidos`
--

CREATE TABLE `Pedidos` (
  `id_pedido` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Pedido_Servicio`
--

CREATE TABLE `Pedido_Servicio` (
  `id_servicio` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Recibos`
--

CREATE TABLE `Recibos` (
  `id_recibo` int(11) NOT NULL,
  `contenido` text DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Servicios`
--

CREATE TABLE `Servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `address`, `phone`) VALUES
(1, 'juan', '$2y$10$DwLHS3NHAo0jaMJIHOsEAu8Pss1lMDVfqkA8CodYlQp5XBekvMTYu', 'test@example.us', '1600 Fake Street', '6019521325');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `Clientes`
--
ALTER TABLE `Clientes`
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `Mensajes`
--
ALTER TABLE `Mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `Pedido_Servicio`
--
ALTER TABLE `Pedido_Servicio`
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indexes for table `Recibos`
--
ALTER TABLE `Recibos`
  ADD PRIMARY KEY (`id_recibo`);

--
-- Indexes for table `Servicios`
--
ALTER TABLE `Servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Mensajes`
--
ALTER TABLE `Mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Pedidos`
--
ALTER TABLE `Pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Recibos`
--
ALTER TABLE `Recibos`
  MODIFY `id_recibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Servicios`
--
ALTER TABLE `Servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `Admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `Clientes`
--
ALTER TABLE `Clientes`
  ADD CONSTRAINT `Clientes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `Mensajes`
--
ALTER TABLE `Mensajes`
  ADD CONSTRAINT `Mensajes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD CONSTRAINT `Pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `Pedido_Servicio`
--
ALTER TABLE `Pedido_Servicio`
  ADD CONSTRAINT `Pedido_Servicio_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `Servicios` (`id_servicio`),
  ADD CONSTRAINT `Pedido_Servicio_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `Pedidos` (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
