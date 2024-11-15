-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2024 a las 05:02:11
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
(2, 'Pastel');

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
(1, 'daniela oropeza', 0, '', 0, 0, 'Dani1234', 'dani');

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
(1, 'Halloween', 15, '2024-11-16', '2024-12-16');

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
(3, '2024-11-15', '0000-00-00', 0, '04:06:06', '00:00:00', 0, 0, 0);

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
(1, 16, 320, 1, 1);

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
(1, 'Latte', 20, 'Cafe con leche texturizada', 0, 1),
(2, 'Serva Negra', 34, 'Chocolate bien pesado', 13, 2),
(3, 'Tres leches', 35, 'Tiene 3 leches', 9, 2);

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
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `IdDescuentos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `IdPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidoproducto`
--
ALTER TABLE `pedidoproducto`
  MODIFY `idPedidoProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
