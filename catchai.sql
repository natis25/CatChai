-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2024 a las 17:00:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `catchai`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `Categoria` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `Categoria`) VALUES
(1, 'Cafe'),
(2, 'Pastel'),
(3, 'Galletas'),
(4, 'Bebida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IdPersona` int(11) NOT NULL,
  `Nombre` char(100) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `Trabajador` tinyint(1) NOT NULL,
  `Administrador` tinyint(1) NOT NULL,
  `Pass` varchar(100) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`IdPersona`, `Nombre`, `Telefono`, `Mail`, `Trabajador`, `Administrador`, `Pass`, `Nombre_usuario`) VALUES
(1, 'Natalia Urrutia', 0, '', 0, 0, '12345678N', 'nati'),
(2, 'Santiago', 0, '', 0, 0, 'YO123456', 'Santiago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `IdDescuentos` int(11) NOT NULL,
  `Descuento` char(100) NOT NULL,
  `Porcentaje` int(11) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`IdDescuentos`, `Descuento`, `Porcentaje`, `FechaInicio`, `FechaFin`) VALUES
(1, 'Halloween', 15, '2024-11-16', '2024-12-16'),
(2, 'Navidad', 10, '2024-12-01', '2024-12-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `IdPedido` int(11) NOT NULL,
  `FechaPedido` date NOT NULL,
  `FechaEntrega` date NOT NULL,
  `PrecioTotal` int(11) NOT NULL,
  `HoraPedido` time NOT NULL,
  `HoraEntrega` time NOT NULL,
  `Cliente_IdPersona` int(11) NOT NULL,
  `Descuentos_IdDescuentos` int(11) NOT NULL,
  `Reporte_idReporte` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`IdPedido`, `FechaPedido`, `FechaEntrega`, `PrecioTotal`, `HoraPedido`, `HoraEntrega`, `Cliente_IdPersona`, `Descuentos_IdDescuentos`, `Reporte_idReporte`, `Estado`) VALUES
(1, '2024-11-08', '0000-00-00', 34, '20:22:54', '00:00:00', 1, 0, 0, 1),
(2, '2024-11-08', '0000-00-00', 20, '20:36:06', '00:00:00', 2, 0, 0, 1),
(3, '2024-11-08', '0000-00-00', 40, '20:39:03', '00:00:00', 1, 0, 0, 1),
(4, '2024-11-08', '0000-00-00', 40, '20:41:11', '00:00:00', 1, 0, 0, 1),
(5, '2024-11-08', '0000-00-00', 40, '20:41:14', '00:00:00', 0, 0, 0, 0),
(6, '2024-11-08', '0000-00-00', 40, '20:42:10', '00:00:00', 0, 0, 0, 0),
(7, '2024-11-08', '0000-00-00', 40, '20:43:13', '00:00:00', 0, 0, 0, 0),
(8, '2024-11-08', '0000-00-00', 89, '20:50:48', '00:00:00', 0, 0, 0, 0),
(9, '2024-11-15', '0000-00-00', 0, '20:27:11', '00:00:00', 0, 0, 0, 0),
(10, '2024-11-15', '0000-00-00', 0, '20:31:47', '00:00:00', 0, 0, 0, 0),
(11, '2024-11-15', '0000-00-00', 0, '20:31:52', '00:00:00', 0, 0, 0, 0),
(12, '2024-11-15', '0000-00-00', 0, '20:32:24', '00:00:00', 0, 0, 0, 0),
(13, '2024-11-22', '0000-00-00', 382, '20:42:42', '00:00:00', 0, 0, 0, 0),
(14, '2024-11-22', '0000-00-00', 68, '20:43:20', '00:00:00', 0, 0, 0, 0),
(15, '2024-11-22', '0000-00-00', 58, '20:53:19', '00:00:00', 0, 0, 0, 0),
(16, '2024-11-22', '0000-00-00', 68, '21:06:41', '00:00:00', 0, 0, 0, 0),
(17, '2024-11-22', '0000-00-00', 138, '21:06:54', '00:00:00', 0, 0, 0, 0),
(18, '2024-11-22', '0000-00-00', 32, '21:07:04', '00:00:00', 0, 0, 0, 0),
(19, '2024-11-29', '0000-00-00', 20, '19:21:12', '00:00:00', 0, 0, 0, 0),
(20, '2024-12-13', '0000-00-00', 86, '03:16:38', '00:00:00', 1, 0, 0, 0),
(21, '2024-12-13', '0000-00-00', 50, '03:16:57', '00:00:00', 0, 0, 0, 0),
(22, '2024-12-13', '0000-00-00', 83, '03:17:06', '00:00:00', 0, 0, 0, 0),
(23, '2024-12-13', '0000-00-00', 54, '03:17:20', '00:00:00', 0, 0, 0, 0),
(24, '2024-12-13', '0000-00-00', 54, '03:17:36', '00:00:00', 0, 0, 0, 0),
(25, '2024-12-13', '0000-00-00', 68, '03:18:03', '00:00:00', 0, 0, 0, 0),
(26, '2024-12-13', '0000-00-00', 102, '05:19:49', '00:00:00', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidoproducto`
--

CREATE TABLE `pedidoproducto` (
  `idPedidoProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioPP` int(11) NOT NULL,
  `Pedido_IdPedido` int(11) NOT NULL,
  `Producto_idProducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidoproducto`
--

INSERT INTO `pedidoproducto` (`idPedidoProducto`, `Cantidad`, `PrecioPP`, `Pedido_IdPedido`, `Producto_idProducto`) VALUES
(1, 1, 34, 1, 2),
(2, 2, 40, 7, 1),
(3, 1, 20, 8, 1),
(4, 1, 34, 8, 2),
(5, 1, 35, 8, 3),
(6, 3, 102, 13, 2),
(7, 8, 280, 13, 3),
(8, 2, 68, 14, 2),
(9, 1, 34, 15, 2),
(10, 2, 24, 15, 4),
(11, 2, 68, 16, 2),
(12, 3, 102, 17, 2),
(13, 3, 36, 17, 4),
(14, 1, 20, 18, 1),
(15, 1, 12, 18, 4),
(16, 1, 20, 19, 1),
(17, 2, 50, 20, 8),
(18, 2, 36, 20, 10),
(19, 2, 50, 21, 8),
(20, 2, 68, 22, 2),
(21, 1, 15, 22, 5),
(22, 1, 18, 23, 7),
(23, 2, 36, 23, 10),
(24, 2, 36, 24, 7),
(25, 1, 18, 24, 10),
(26, 2, 36, 25, 6),
(27, 1, 18, 25, 7),
(28, 1, 14, 25, 9),
(29, 3, 102, 26, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `Producto` char(100) NOT NULL,
  `Precio` int(11) NOT NULL,
  `Descripcion` varchar(1000) NOT NULL,
  `Disponibilidad` int(11) NOT NULL,
  `Categoria_idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `Producto`, `Precio`, `Descripcion`, `Disponibilidad`, `Categoria_idCategoria`) VALUES
(1, 'Latte', 20, 'Cafe con leche texturizada', 20, 1),
(2, 'Serva Negra', 34, 'Chocolate bien pesado', 11, 2),
(3, 'Tres leches', 35, 'Tiene 3 leches', 17, 2),
(4, 'Avena', 12, 'Galleta de avena', 14, 3),
(5, 'Choco chispas', 15, 'Galleta de chocolate', 15, 3),
(6, 'Capuccino', 18, 'Cafe concentrad con leche texturizada', 13, 1),
(7, 'Te chai', 18, 'Te con leche texturizada', 14, 4),
(8, 'Red velvet', 25, 'Chocolate rojo con crema pastelera', 12, 2),
(9, 'Espresso', 14, 'Cafe', 14, 1),
(10, 'Limonada', 18, 'Jugo de limon', 11, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `idReporte` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `VentaTotal` int(11) NOT NULL,
  `GananciaTotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdPersona`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`IdDescuentos`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`IdPedido`);

--
-- Indices de la tabla `pedidoproducto`
--
ALTER TABLE `pedidoproducto`
  ADD PRIMARY KEY (`idPedidoProducto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`idReporte`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `IdDescuentos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `IdPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `pedidoproducto`
--
ALTER TABLE `pedidoproducto`
  MODIFY `idPedidoProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
