-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2025 a las 17:46:45
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
(33, 6, 'Cuentas por pagar');

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
(37, 'Bancos');

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
(1, 2, 'admin', '$2y$10$u6kqmLq.I6.FlwcXlMDJ/.dpAmaKZAZwMKpkXRYxHrRWzla1cycvq', '2025-11-27 12:44:27', '2025-11-27 12:44:53', b'1');

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
  MODIFY `id_egreso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `invitados`
--
ALTER TABLE `invitados`
  MODIFY `id_invitado` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuestos_ahorros`
--
ALTER TABLE `presupuestos_ahorros`
  MODIFY `id_presupuesto_ahorro` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id_transaccion` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_cf`
--
ALTER TABLE `usuarios_cf`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
