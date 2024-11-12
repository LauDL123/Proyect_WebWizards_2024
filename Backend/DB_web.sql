-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-11-2024 a las 05:46:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `DB_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Admin`
--

CREATE TABLE `Admin` (
  `id_usuario` int(11) DEFAULT NULL,
  `privilegios` varchar(255) DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Admin`
--

INSERT INTO `Admin` (`id_usuario`, `privilegios`, `id_admin`) VALUES
(5, 'todos', 1),
(7, 'todos', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `id_usuario` int(11) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`id_usuario`, `direccion`, `id_cliente`) VALUES
(8, 'hola 12020', 1),
(11, 'usuario123', 2),
(13, '23123sadasd', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Mensajes`
--

CREATE TABLE `Mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `contenido` text DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `hora` time DEFAULT NULL,
  `tipo` enum('cliente','cerrajero') DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedidos`
--

CREATE TABLE `Pedidos` (
  `id_pedido` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Pedidos`
--

INSERT INTO `Pedidos` (`id_pedido`, `descripcion`, `direccion`, `estado`, `id_usuario`) VALUES
(11, 'hola si', NULL, 'pendiente', 8),
(12, 'gfgggg', NULL, 'pendiente', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedido_Servicio`
--

CREATE TABLE `Pedido_Servicio` (
  `id_servicio` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Pedido_Servicio`
--

INSERT INTO `Pedido_Servicio` (`id_servicio`, `id_pedido`, `cantidad`) VALUES
(1, 2, NULL),
(4, 2, NULL),
(1, 3, NULL),
(3, 3, NULL),
(1, 4, NULL),
(3, 4, NULL),
(1, 5, NULL),
(3, 5, NULL),
(1, 6, NULL),
(3, 6, NULL),
(1, 7, NULL),
(3, 7, NULL),
(1, 8, NULL),
(3, 8, NULL),
(1, 9, NULL),
(3, 9, NULL),
(4, 9, NULL),
(3, 10, NULL),
(1, 10, NULL),
(4, 10, NULL),
(1, 11, NULL),
(3, 11, NULL),
(4, 11, NULL),
(1, 12, NULL),
(3, 12, NULL),
(4, 12, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Recibos`
--

CREATE TABLE `Recibos` (
  `id_recibo` int(11) NOT NULL,
  `contenido` text DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Servicios`
--

CREATE TABLE `Servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Servicios`
--

INSERT INTO `Servicios` (`id_servicio`, `nombre`, `descripcion`, `imagen`, `visible`) VALUES
(1, 'MyQueEsEsoReaction', 'Que es eso', 'images.jpeg', 1),
(3, 'Apertura de cerraduras', 'apertura de puertas', 'servicio_673150dd335e7.jpg', 1),
(4, 'Duplicado de llaves', 'Duplicamos llaves de cualquier tipo', 'servicio_67315461530fc.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `address`, `phone`, `foto`) VALUES
(5, 'nuevoAdmin', '$2y$10$1gkIcPlZv1oNE0z3stgVu.7Jn9dYG2iBgjpBq0WwpXyU52stPixv2', 'admin@example.com', '123 Admin St', '5551234567', NULL),
(7, 'Admin', '$2y$10$B2bIIIXxmbEHFg2ST7.MyubpA9frWsq5wd/jFDjWDVC4OKMKfzxxG', 'cerrajeriaaranguren4@gmail.com', '123 Admin St', '5551234567', NULL),
(8, 'juan', '$2y$10$4sP0oERqD1A3ptGTH5Tl0.gbtJCbMJJP1rhA1qcHsBNspoU3WHz..', 'juan12@gmail.com', 'hola 12020', '091123456', NULL),
(11, 'usuario1', '$2y$10$JYbdDOD7Vka0xZeOnoJY4OZRy8dxKIne.FC2aIk0uWl3wMUbi4mPS', 'usuario1@gmail.com', 'usuario123', '091123456', NULL),
(13, 'registro2', '$2y$10$qvQZnwZSGACcmhVMtenLOOdNJ2GfAZ2QpQeOyS3bXDcfwY8NPnG1O', 'registro@gmail.com', '23123sadasd', '1321344', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `Mensajes`
--
ALTER TABLE `Mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `idx_estado_pedido` (`estado`);

--
-- Indices de la tabla `Pedido_Servicio`
--
ALTER TABLE `Pedido_Servicio`
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `Recibos`
--
ALTER TABLE `Recibos`
  ADD PRIMARY KEY (`id_recibo`),
  ADD KEY `Recibos_ibfk_1` (`id_pedido`);

--
-- Indices de la tabla `Servicios`
--
ALTER TABLE `Servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `idx_nombre_servicio` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Mensajes`
--
ALTER TABLE `Mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Pedidos`
--
ALTER TABLE `Pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `Recibos`
--
ALTER TABLE `Recibos`
  MODIFY `id_recibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Servicios`
--
ALTER TABLE `Servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `Admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD CONSTRAINT `Clientes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `Mensajes`
--
ALTER TABLE `Mensajes`
  ADD CONSTRAINT `Mensajes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD CONSTRAINT `Pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `Pedido_Servicio`
--
ALTER TABLE `Pedido_Servicio`
  ADD CONSTRAINT `Pedido_Servicio_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `Servicios` (`id_servicio`),
  ADD CONSTRAINT `Pedido_Servicio_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `Pedidos` (`id_pedido`);

--
-- Filtros para la tabla `Recibos`
--
ALTER TABLE `Recibos`
  ADD CONSTRAINT `Recibos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `Pedidos` (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
