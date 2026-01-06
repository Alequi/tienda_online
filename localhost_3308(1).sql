-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3308
-- Tiempo de generación: 06-01-2026 a las 11:42:40
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
-- Base de datos: `tienda_online`
--
CREATE DATABASE IF NOT EXISTS `tienda_online` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tienda_online`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `categoria` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `precio_anterior` decimal(10,2) NOT NULL DEFAULT 0.00,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`codigo`, `nombre`, `descripcion`, `categoria`, `stock`, `precio`, `imagen`, `precio_anterior`, `activo`) VALUES
('ani-1', 'Anillo de ónix', 'Plata de Ley 925\r\nTamaño de la piedra: 9x7mm\r\nTallas disponibles: 16, 19\r\n', 2, 5, 26.90, 'ani-1.jpg', 0.00, 1),
('ani-2', 'Anillo de Labradorita', 'Anillo con Labradorita\r\nPlata de Ley 925\r\nTamaño de la piedra: 8x8mm\r\nTallas disponibles: 12, 14, 17, 19', 2, 5, 25.90, 'ani-2.jpg', 0.00, 1),
('col-1', 'Collar Coratione Labradorita ', 'Collar Coratione de Labradorita facetada\r\nFabricado en Plata de Ley 925\r\nAcabado en Plata Rodiada\r\nCierre ajustable de 40 a 40 + 5 cm', 3, 5, 25.90, 'col-1.jpg', 0.00, 1),
('col-2', 'Collar Stella Labradorita', 'Fabricado en Plata de Ley 925\r\nAcabado en Baño de Oro 18k 5μm\r\nCierre ajustable de 40 a 40 + 5  cm', 3, 5, 26.90, 'col-2.jpg', 0.00, 1),
('pen-1', 'Pendientes \'Ninsun\' - Piedra de Luna', 'Mineral: Piedra de Luna natural facetada de alta calidad\r\nCierre: Gancho\r\nTamaño cabujon: 12*16mm, 9*7,30mm, 8*6mm', 4, 5, 59.90, 'pen-1.jpg', 0.00, 1),
('pen-2', 'Pendientes \'Kishar \' - Labradorita', 'Diseñados para mujeres que caminan con fuerza, incluso en medio del caos.\r\nLos pendientes ‘Kisha’ no son solo una joya sofisticada: son un amuleto de protección energética envuelto en belleza etérea.', 4, 5, 69.90, 'pen-2.jpg', 0.00, 1),
('pul-1', 'Pulsera de Citrino', 'Pulsera de Citrino Potenciado Bola Lisa\r\nLongitud aproximada: 16-19 cm.\r\nProcedencia: Brasil', 1, 5, 24.90, 'pul-1.jpg', 0.00, 1),
('pul-2', 'Pulsera de curazo verde', 'Pulsera de Cuarzo Verde Bola Lisa\r\nLongitud aproximada: 16-18cm\r\nProcedencia: Brasil', 1, 5, 14.90, 'pul-2.jpg', 16.90, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `categoriaPadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`codigo`, `nombre`, `activo`, `categoriaPadre`) VALUES
(1, 'Pulseras', 1, NULL),
(2, 'Anillos', 1, NULL),
(3, 'Colgantes', 1, NULL),
(4, 'Pendientes', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineapedido`
--

CREATE TABLE `lineapedido` (
  `numPedido` int(11) NOT NULL,
  `numLinea` int(11) NOT NULL,
  `codArticulo` varchar(8) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('creado','preparado','enviado','cancelado') NOT NULL DEFAULT 'creado',
  `dniUsuarios` varchar(9) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(75) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `localidad` varchar(30) DEFAULT NULL,
  `provincia` varchar(30) DEFAULT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `rol` enum('admin','editor','anonimo','registrado') NOT NULL DEFAULT 'anonimo',
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `clave`, `nombre`, `apellidos`, `direccion`, `localidad`, `provincia`, `telefono`, `email`, `rol`, `activo`) VALUES
('30356307X', '$2y$10$ycaZUvNgLChdI9pp/3LgjOUw2L0h/a4CM3Tal2y/KSHlHWyoJpfnS', 'Alejandro', 'Quivera', 'Av Alfonso XII', 'Elche', 'Alicante', '636910718', 'a.quivera1991@gmail.com', 'registrado', 1),
('49393285A', '$2y$10$9F0a2xRlMKxFU5TGLBNAY.QzNT5kzmZY5YG8IrXpvX7/YZuqNcI12', 'Fructuoso', 'Quiroz Velasco', 'Ctra. Bailén-Motril, 76', 'Montizón', 'Jaén', '764324804', 'FructuosoQuirozVelasco@gustr.c', 'registrado', 1),
('74012761A', '$2y$10$aXjodNQ6fojMGn.hxIvkm.52npOKLiHXk2FdYVGhqNwpxUksIzzIO', 'Carmen', 'Martinez', 'Calle Sant Francesc Xavier 6', 'Elche', 'Alicante', '604327027', 'carmen@gmail.com', 'registrado', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria_ibfk_1` (`categoriaPadre`);

--
-- Indices de la tabla `lineapedido`
--
ALTER TABLE `lineapedido`
  ADD PRIMARY KEY (`numPedido`,`numLinea`),
  ADD KEY `codArticulo` (`codArticulo`),
  ADD KEY `codArticulo_2` (`codArticulo`),
  ADD KEY `numPedido` (`numPedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD UNIQUE KEY `idPedido` (`idPedido`),
  ADD KEY `codUsuarios` (`dniUsuarios`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `telefono` (`telefono`),
  ADD KEY `email` (`email`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`categoriaPadre`) REFERENCES `categoria` (`codigo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `lineapedido`
--
ALTER TABLE `lineapedido`
  ADD CONSTRAINT `lineapedido_ibfk_1` FOREIGN KEY (`codArticulo`) REFERENCES `articulos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `lineapedido_ibfk_2` FOREIGN KEY (`numPedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`dniUsuarios`) REFERENCES `usuarios` (`dni`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
