-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2024 a las 01:48:14
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
(3, 'Galleta'),
(14, 'Salado'),
(18, 'Te'),
(19, 'Tarta');

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
(1, 'daniela oropeza', 456789, 'd.oropeza@gmail.com', 0, 1, 'Dani1234', 'dani'),
(2, 'Juan Perez', 123456, 'j.perez@gmail.com', 1, 0, 'Juanin1234', 'juanin'),
(3, 'Julio Triviño', 0, '', 0, 0, 'Julio1234', 'juli'),
(4, 'Juan Carlos Bodoque', 0, '', 0, 0, 'JC1234bodoque', 'jc');

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
(1, 'Halloween', 25, '2024-11-16', '2024-12-16'),
(2, 'Navidad', 20, '2024-11-15', '2023-12-23'),
(3, 'Black Friday', 15, '2024-11-15', '2024-11-22');

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
  `Reporte_idReporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`IdPedido`, `FechaPedido`, `FechaEntrega`, `PrecioTotal`, `HoraPedido`, `HoraEntrega`, `Cliente_IdPersona`, `Descuentos_IdDescuentos`, `Reporte_idReporte`) VALUES
(1, '2024-11-14', '0000-00-00', 320, '21:31:38', '00:00:00', 0, 0, 0),
(2, '2024-11-14', '0000-00-00', 104, '21:57:43', '00:00:00', 0, 0, 0),
(3, '2024-11-15', '0000-00-00', 0, '04:06:06', '00:00:00', 0, 0, 0),
(4, '2024-11-15', '0000-00-00', 88, '18:14:15', '00:00:00', 0, 0, 0),
(5, '2024-11-15', '0000-00-00', 88, '18:14:21', '00:00:00', 0, 0, 0),
(6, '2024-11-15', '0000-00-00', 54, '18:19:40', '00:00:00', 0, 0, 0),
(7, '2024-11-15', '0000-00-00', 62, '18:20:26', '00:00:00', 0, 0, 0),
(8, '2024-11-15', '0000-00-00', 28, '18:22:34', '00:00:00', 0, 0, 0),
(9, '2024-11-15', '0000-00-00', 0, '19:28:08', '00:00:00', 0, 0, 0),
(10, '2024-11-15', '0000-00-00', 55, '19:36:49', '00:00:00', 0, 0, 0),
(11, '2024-11-15', '0000-00-00', 100, '20:33:34', '00:00:00', 0, 0, 0),
(13, '2024-11-15', '0000-00-00', 83, '21:00:51', '00:00:00', 0, 0, 0),
(14, '2024-11-15', '0000-00-00', 24, '21:01:54', '00:00:00', 0, 0, 0),
(15, '2024-11-15', '0000-00-00', 80, '21:44:04', '00:00:00', 0, 0, 0),
(16, '2024-11-15', '0000-00-00', 102, '21:44:25', '00:00:00', 0, 0, 0),
(17, '2024-11-29', '0000-00-00', 85, '19:28:37', '00:00:00', 0, 0, 0),
(18, '2024-11-29', '0000-00-00', 46, '20:08:11', '00:00:00', 0, 0, 0),
(19, '2024-11-29', '0000-00-00', 30, '20:13:03', '00:00:00', 0, 0, 0),
(20, '2024-11-29', '0000-00-00', 23, '20:14:48', '00:00:00', 0, 0, 0),
(21, '2024-11-29', '0000-00-00', 15, '20:17:30', '00:00:00', 0, 0, 0),
(22, '2024-11-29', '0000-00-00', 40, '21:14:27', '00:00:00', 0, 0, 0),
(23, '2024-11-29', '0000-00-00', 160, '21:14:55', '00:00:00', 0, 0, 0),
(24, '2024-12-07', '0000-00-00', 100, '00:52:22', '00:00:00', 0, 0, 0);

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
(1, 16, 320, 1, 1),
(2, 1, 20, 4, 1),
(3, 2, 68, 4, 2),
(4, 1, 20, 5, 1),
(5, 2, 68, 5, 2),
(6, 1, 20, 6, 1),
(7, 1, 34, 6, 2),
(8, 1, 20, 7, 1),
(9, 1, 34, 7, 2),
(10, 2, 8, 7, 6),
(11, 1, 20, 8, 1),
(12, 2, 8, 8, 6),
(13, 2, 40, 10, 1),
(14, 1, 15, 10, 4),
(15, 5, 100, 11, 1),
(16, 2, 68, 13, 2),
(17, 1, 15, 13, 4),
(18, 1, 20, 14, 1),
(19, 1, 4, 14, 6),
(20, 4, 80, 15, 1),
(21, 3, 102, 16, 2),
(22, 2, 40, 17, 1),
(23, 3, 45, 17, 4),
(24, 2, 46, 18, 7),
(25, 2, 30, 19, 4),
(26, 1, 23, 20, 7),
(27, 1, 15, 21, 4),
(28, 2, 40, 22, 1),
(29, 2, 68, 23, 2),
(30, 4, 92, 23, 7),
(31, 2, 68, 24, 2),
(32, 2, 8, 24, 6),
(33, 2, 24, 24, 8);

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
(1, 'Latte', 20, 'Cafe con leche texturizada', 10, 1),
(2, 'Serva Negra', 34, 'Porcion de pastel de chocolate bien pesado', 18, 2),
(3, 'Tres leches', 30, 'Porcion de pastel de 3 leches', 11, 2),
(4, 'Americano', 15, 'Cafe negro', 8, 1),
(5, 'Pastel de zanahoria', 25, 'Porcion de pastel de zanahoria con canela', 10, 2),
(6, 'ChocoChispas', 4, 'Galleta de vainilla con chispas de chocolate', 18, 3),
(7, 'Pastel de fresas', 23, 'Porcion de pastel', 13, 2),
(8, 'Te Chai', 12, 'Té Chai', 18, 18),
(9, 'Catpuccino', 23, 'Cafe con leche y chocolate', 33, 1),
(10, 'Pastel de Mocca', 24, 'Pastel de cafe, chocolate y crema', 9, 2);

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
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `IdDescuentos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `IdPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `pedidoproducto`
--
ALTER TABLE `pedidoproducto`
  MODIFY `idPedidoProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
