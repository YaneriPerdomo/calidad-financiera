-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2025 a las 00:56:48
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
-- Base de datos: `calidad_financiera`
--
CREATE DATABASE IF NOT EXISTS `calidad_financiera` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `calidad_financiera`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

DROP TABLE IF EXISTS `actividades`;
CREATE TABLE `actividades` (
  `id_actividad` int(10) NOT NULL,
  `actividad` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id_actividad`, `actividad`) VALUES
(1, 'Propietario/a'),
(2, 'Gerente o Supervisor/a'),
(3, 'Empleado/a'),
(4, 'Profesional'),
(5, 'Docente'),
(6, 'Estudiante'),
(7, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_egreso`
--

DROP TABLE IF EXISTS `categorias_egreso`;
CREATE TABLE `categorias_egreso` (
  `id_categoria_egreso` int(10) NOT NULL,
  `categoria` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_egreso`
--

INSERT INTO `categorias_egreso` (`id_categoria_egreso`, `categoria`) VALUES
(3, 'Comida'),
(6, 'Deudas'),
(5, 'Entretenimiento '),
(4, 'Otros'),
(2, 'Servicios'),
(1, 'Vivienda');

--
-- Disparadores `categorias_egreso`
--
DROP TRIGGER IF EXISTS `trigger_categoria_egreso_transacciones_actualizar`;
DELIMITER $$
CREATE TRIGGER `trigger_categoria_egreso_transacciones_actualizar` BEFORE DELETE ON `categorias_egreso` FOR EACH ROW BEGIN
    UPDATE egresos
    SET id_categoria_egreso = 4
    WHERE id_categoria_egreso = 						OLD.id_categoria_egreso;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

DROP TABLE IF EXISTS `egresos`;
CREATE TABLE `egresos` (
  `id_egreso` int(10) NOT NULL,
  `id_categoria_egreso` int(10) NOT NULL,
  `egreso` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `egresos`
--

INSERT INTO `egresos` (`id_egreso`, `id_categoria_egreso`, `egreso`) VALUES
(17, 4, 'Otros gastos'),
(32, 3, 'Comida Rapida'),
(33, 6, 'Cuentas por pagar'),
(36, 6, 'Deuda Financiera a Corto Plazo'),
(37, 6, 'Deuda de Vivienda'),
(46, 2, 'Costos de internet'),
(47, 2, 'Facturas de luz'),
(48, 2, 'Suscripciones a servicios de streaming'),
(49, 2, 'Seguros de vehículo'),
(50, 2, 'Costos de matrícula'),
(51, 2, 'Pagos de alquiler'),
(52, 2, 'Pagos de préstamos'),
(53, 2, 'Materiales de oficina'),
(54, 1, 'Alquiler'),
(55, 5, 'Netflix'),
(56, 5, 'Videojuegos'),
(57, 5, 'Entradas a cines'),
(58, 5, 'Salidas a restaurantes'),
(59, 5, 'Gimnasio'),
(60, 5, 'Compras de libros'),
(61, 3, 'Comida del mes');

--
-- Disparadores `egresos`
--
DROP TRIGGER IF EXISTS `trigger_egreso_eliminado_transacciones_actualizar`;
DELIMITER $$
CREATE TRIGGER `trigger_egreso_eliminado_transacciones_actualizar` BEFORE DELETE ON `egresos` FOR EACH ROW BEGIN
    UPDATE transacciones
    SET id_egreso = 17
    WHERE id_egreso = OLD.id_egreso;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE `ingresos` (
  `id_ingreso` int(10) NOT NULL,
  `ingreso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id_ingreso`, `ingreso`) VALUES
(7, 'Otros'),
(37, 'Bancos'),
(40, 'Cuentas por cobrar '),
(41, 'Documentos por cobrar'),
(42, 'Efectivo '),
(49, 'Caja');

--
-- Disparadores `ingresos`
--
DROP TRIGGER IF EXISTS `trigger_ingreso_eliminado_transacciones_actualizar`;
DELIMITER $$
CREATE TRIGGER `trigger_ingreso_eliminado_transacciones_actualizar` BEFORE DELETE ON `ingresos` FOR EACH ROW BEGIN
    UPDATE transacciones
    SET id_ingreso = 7
    WHERE id_ingreso = OLD.id_ingreso;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitados`
--

DROP TABLE IF EXISTS `invitados`;
CREATE TABLE `invitados` (
  `id_invitado` int(10) NOT NULL,
  `id_usuario` int(10) DEFAULT NULL,
  `id_persona` int(10) DEFAULT NULL,
  `nombre` varchar(33) DEFAULT NULL,
  `apellido` varchar(33) DEFAULT NULL,
  `correo_electronico` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
  `id_persona` int(10) NOT NULL,
  `id_actividad` int(10) DEFAULT NULL,
  `id_usuario` int(10) DEFAULT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `apellido` varchar(40) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `id_actividad`, `id_usuario`, `nombre`, `apellido`, `correo_electronico`) VALUES
(1, 1, 2, 'Yaneri', 'Perdomo', 'perdomopaolabarrios@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos_ahorros`
--

DROP TABLE IF EXISTS `presupuestos_ahorros`;
CREATE TABLE `presupuestos_ahorros` (
  `id_presupuesto_ahorro` int(10) NOT NULL,
  `id_persona` int(10) DEFAULT NULL,
  `monto_total` decimal(20,3) DEFAULT NULL,
  `porcentaje_ahorro` int(11) NOT NULL DEFAULT 0,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuestos_ahorros`
--

INSERT INTO `presupuestos_ahorros` (`id_presupuesto_ahorro`, `id_persona`, `monto_total`, `porcentaje_ahorro`, `fecha`) VALUES
(1, 1, 5292.000, 15, '2025-01-15'),
(2, 1, 99.000, 10, '2025-03-06'),
(3, 1, 222.000, 0, '2025-07-03'),
(4, 1, 2848.000, 0, '2025-08-06'),
(5, 1, 6297.000, 0, '2025-10-01'),
(6, 1, 20177.000, 50, '2025-09-02'),
(7, 1, 5499.000, 65, '2025-06-05'),
(8, 1, 8873.000, 73, '2025-02-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id_rol` int(10) NOT NULL,
  `rol` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'Usuario'),
(2, 'admin'),
(3, 'invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
CREATE TABLE `transacciones` (
  `id_transaccion` int(10) NOT NULL,
  `id_persona` int(10) DEFAULT NULL,
  `id_egreso` int(10) DEFAULT NULL,
  `id_ingreso` int(10) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `valor_bs` decimal(10,3) DEFAULT 0.000,
  `notas` text DEFAULT NULL,
  `anulado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`id_transaccion`, `id_persona`, `id_egreso`, `id_ingreso`, `fecha`, `valor_bs`, `notas`, `anulado`) VALUES
(1, 1, NULL, 37, '2025-01-06 18:10:31', 1323.320, '', 0),
(2, 1, NULL, 37, '2025-01-08 18:10:39', 1323.320, '', 0),
(3, 1, NULL, 42, '2025-01-16 18:14:04', 1323.320, '', 0),
(4, 1, NULL, 7, '2025-01-22 18:14:15', 1323.320, '', 0),
(5, 1, NULL, 42, '2025-03-05 18:55:04', 123.320, '', 0),
(6, 1, 36, NULL, '2025-03-20 18:55:18', 23.320, '', 0),
(7, 1, NULL, 42, '2025-07-02 19:02:26', 1323.340, '', 0),
(8, 1, NULL, 37, '2025-07-17 19:02:35', 2232.000, 'Ingresos que obtuve gracias a mi emprendimiento', 0),
(9, 1, 50, NULL, '2025-07-18 19:03:00', 3332.330, 'Pago cancelado para acceder a las clases de verano universitarias', 0),
(10, 1, NULL, 42, '2025-08-01 19:13:25', 3000.000, NULL, 0),
(11, 1, 55, NULL, '2025-08-08 19:13:52', 500.530, '', 1),
(12, 1, 60, NULL, '2025-08-16 19:14:21', 150.320, 'Me compre un libro de programación PHP', 0),
(13, 1, NULL, 41, '2025-10-01 19:17:46', 2323.320, '', 0),
(14, 1, NULL, 49, '2025-10-02 19:17:52', 150.320, '', 0),
(15, 1, 58, NULL, '2025-10-03 19:18:08', 1323.320, '', 0),
(16, 1, 54, NULL, '2025-10-16 19:18:18', 500.530, '', 0),
(17, 1, 48, NULL, '2025-10-17 19:18:49', 500.530, '', 0),
(18, 1, NULL, 37, '2025-10-18 19:19:13', 22443.760, '', 0),
(19, 1, 61, NULL, '2025-10-22 19:20:08', 10645.650, '', 0),
(20, 1, 49, NULL, '2025-10-24 19:23:09', 5645.540, '', 0),
(21, 1, NULL, 42, '2025-09-03 19:23:28', 500.530, '', 1),
(22, 1, NULL, 40, '2025-09-04 19:25:46', 2746.740, 'Cerrado', 0),
(23, 1, NULL, 37, '2025-09-06 19:25:58', 3332.330, 'Primera cuota cobrada del cliente Abraham', 0),
(24, 1, NULL, 37, '2025-09-11 19:26:13', 15423.430, 'Pago movil del cliente de Abraham', 0),
(25, 1, 53, NULL, '2025-09-19 19:27:36', 1323.320, 'Limpieza pagada para mi oficina de trabajo remoto', 0),
(26, 1, NULL, 37, '2025-06-05 19:39:21', 6000.000, '', 0),
(27, 1, 57, NULL, '2025-06-12 19:41:08', 500.530, 'Lunes a precio medio en Metrosol con mis amigos', 0),
(28, 1, NULL, 37, '2025-02-08 19:49:59', 2232.000, '', 0),
(29, 1, NULL, 37, '2025-02-05 19:50:07', 6493.480, '', 0),
(30, 1, NULL, 42, '2025-02-08 19:50:14', 500.530, '', 0),
(31, 1, NULL, 37, '2025-02-09 19:50:25', 150.320, '', 0),
(32, 1, 32, NULL, '2025-02-12 19:50:36', 500.530, '', 0),
(33, 1, 59, NULL, '2025-02-21 19:50:53', 1323.340, 'Cancelada porque me voy a cambiar de gimnasio.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_cf`
--

DROP TABLE IF EXISTS `usuarios_cf`;
CREATE TABLE `usuarios_cf` (
  `id_usuario` int(10) NOT NULL,
  `id_rol` int(10) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_cf`
--

INSERT INTO `usuarios_cf` (`id_usuario`, `id_rol`, `usuario`, `clave`, `fecha_creacion`, `ultimo_acceso`, `estado`) VALUES
(1, 2, 'admin', '$2y$10$u6kqmLq.I6.FlwcXlMDJ/.dpAmaKZAZwMKpkXRYxHrRWzla1cycvq', '2025-11-27 12:44:27', '2025-11-27 19:45:41', b'1'),
(2, 1, 'yaneri2020', '$2y$10$S5YFh6PKIObVCS5QOM6ur.1qaGknaKbxwF6WRpF56A.QkKXOm6W9O', '2025-11-27 17:52:06', '2025-11-27 19:45:50', b'1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `categorias_egreso`
--
ALTER TABLE `categorias_egreso`
  ADD PRIMARY KEY (`id_categoria_egreso`),
  ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id_egreso`),
  ADD KEY `id_categoria_egreso` (`id_categoria_egreso`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`);

--
-- Indices de la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD PRIMARY KEY (`id_invitado`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `presupuestos_ahorros`
--
ALTER TABLE `presupuestos_ahorros`
  ADD PRIMARY KEY (`id_presupuesto_ahorro`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id_transaccion`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `transacciones_ibfk_2` (`id_egreso`),
  ADD KEY `transacciones_ibfk_01` (`id_ingreso`);

--
-- Indices de la tabla `usuarios_cf`
--
ALTER TABLE `usuarios_cf`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias_egreso`
--
ALTER TABLE `categorias_egreso`
  MODIFY `id_categoria_egreso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id_egreso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `invitados`
--
ALTER TABLE `invitados`
  MODIFY `id_invitado` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuestos_ahorros`
--
ALTER TABLE `presupuestos_ahorros`
  MODIFY `id_presupuesto_ahorro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id_transaccion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `usuarios_cf`
--
ALTER TABLE `usuarios_cf`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD CONSTRAINT `egresos_ibfk_1` FOREIGN KEY (`id_categoria_egreso`) REFERENCES `categorias_egreso` (`id_categoria_egreso`);

--
-- Filtros para la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD CONSTRAINT `invitados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios_cf` (`id_usuario`),
  ADD CONSTRAINT `invitados_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`),
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios_cf` (`id_usuario`);

--
-- Filtros para la tabla `presupuestos_ahorros`
--
ALTER TABLE `presupuestos_ahorros`
  ADD CONSTRAINT `presupuestos_ahorros_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_01` FOREIGN KEY (`id_ingreso`) REFERENCES `ingresos` (`id_ingreso`) ON DELETE SET NULL,
  ADD CONSTRAINT `transacciones_ibfk_03` FOREIGN KEY (`id_ingreso`) REFERENCES `ingresos` (`id_ingreso`) ON DELETE SET NULL,
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`id_egreso`) REFERENCES `egresos` (`id_egreso`) ON DELETE SET NULL,
  ADD CONSTRAINT `transacciones_ibfk_3` FOREIGN KEY (`id_egreso`) REFERENCES `egresos` (`id_egreso`) ON DELETE SET NULL,
  ADD CONSTRAINT `transacciones_ibfk_5` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_cf`
--
ALTER TABLE `usuarios_cf`
  ADD CONSTRAINT `usuarios_cf_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
