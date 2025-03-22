-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2025 a las 18:48:39
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
(1, 'Propietario o Socio'),
(2, 'Gerente o Supervisor'),
(3, 'Empleado'),
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

DROP TABLE IF EXISTS `egresos`;
CREATE TABLE `egresos` (
  `id_egreso` int(10) NOT NULL,
  `id_categoria_egreso` int(10) NOT NULL,
  `egresos` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE `ingresos` (
  `id_ingreso` int(10) NOT NULL,
  `ingreso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Volcado de datos para la tabla `invitados`
--

INSERT INTO `invitados` (`id_invitado`, `id_usuario`, `id_persona`, `nombre`, `apellido`, `correo_electronico`) VALUES
(1, 58, 9, 'dasdas', 'ra', 'dasd'),
(3, 60, 9, '3234', '324', 'fsfsdp'),
(4, 61, 9, 'Glisdaly', 'perdomo', 'perdomo@gmail.comds'),
(5, 62, 9, ' dasdas', 'dsad', ' dasd'),
(6, 64, 9, ' dsadddd', 'dsaddghtr', ' sdsa'),
(7, 66, 9, '65u65u6', 'u65u65', ' u65u6'),
(8, 68, 9, ' 65652                     ', 'u65u', ' 65u65                     ');

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
(1, 3, 32, 'Yaneri', 'Perdomo', 'perdomopaolabrriosw@gmail.com'),
(2, 5, 35, 'Paola', 'Yaneri3', 'dustin@gmail.com'),
(3, 6, 36, 'Yaireli', 'Perdomo', 'yayiperdomo@gmail.com'),
(4, 2, 38, 'Antonio', 'Perdomo', 'tonoperdomo@gmail.com'),
(5, 2, 42, 'Antonio332', 'Perdomo', 'tonoperdo32m3o@gmail.com'),
(6, 2, 43, 'Antonio3332', 'Perdomo', 'tonoperdo323m3o@gmail.com'),
(7, 2, 53, 'Emily', 'perdomo', 'emilytia4@gmas'),
(8, 2, 54, 'diaman', 'perdomo', 'diamancito@gmail.com'),
(9, 3, 55, 'Fanny', 'Perdomo', 'fannyperdomo@gmail.com'),
(14, 5, 75, 'diaman', 'diaman', 'diaman@gmail.comd'),
(15, 1, 76, 'leonard', 'perdomo', 'leonadbarroso@gmail.com');

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
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL,
  `id_rol` int(10) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `usuario`, `clave`, `ultimo_acceso`) VALUES
(32, 1, 'Yaneri33', '123', NULL),
(35, 1, 'taka', '123', NULL),
(36, 1, 'Yayi3', '$2y$10$jCqMpx2jzeI.0/kx5RHaHOj7pFFZ5Tt4lyWYZ7DVeJ9hsXNs.OSqC', '2025-03-20 09:19:03'),
(38, 1, 'Toño', '$2y$10$.G3bvMekQMoS1/uKKQruxOIBCaey6IwKIe95H3CXNABcv74Xj.qRO', '2025-03-20 09:16:09'),
(42, 1, 'Toño3', '$2y$10$zziLpSWqSaLDRAybmGLdCeoOXWyb.uDVzvFPRzA.Njj2uzP29o31u', NULL),
(43, 1, 'Toño33', '$2y$10$qLyMeEGO7lTDTCzbA20Hw.ZaT229ysmbWhF7WCFCP/93mukkemsjy', NULL),
(53, 1, 'emilita', '$2y$10$KcULseyUE7LQgipggGctquAUKDE1baLyIvjJRm8UJ.phH6HMUZLei', NULL),
(54, 1, 'diaman', '$2y$10$cgpJcAtg6Ytkyhml6DyLFOE2j03/sIq2SEQt3jVlxjie8jm014z4K', NULL),
(55, 1, 'Fanny3', '$2y$10$S/5M.Hpptg9C/HsonF4W3uAB.WZcbuHPpWqV28VTxpznBtxLJl85u', '2025-03-20 09:17:27'),
(58, NULL, NULL, '$2y$10$C1rN4PVwKaCyl07LifDlSufg05AYSpr4N4G7ojUE9QhP9.CNarI5S', NULL),
(60, 3, 'rwerwe', '$2y$10$FQMnx/MmGS15KfX6m7ij9OBI19/eA80d7EsCSHbgPHMtFLQpFbp1G', NULL),
(61, 3, 'glisday', '$2y$10$/uJXZRv4U0AaatjAp2jr7O/gD/MC90Pv9A.Ouj6CJA6zLxg/MqgFS', '2025-03-20 09:18:28'),
(62, 3, 'dsad', '$2y$10$iAVhedtJD1luai38W1AO/uA2BEtLdkIznwbtknNFqBDIEy3DkDVoW', NULL),
(64, 3, ' htrh', '$2y$10$CPpAFA2ZdbSZeOb5EjNsdeQKZ4wBUApTHfiLAdTSSg9vjWWDVKcQW', NULL),
(66, 3, 'u65u', '$2y$10$NDsHPnxOxkRXyPxU/q0mG.FROD2blSuqoHV5muX21yu39mjCvIyy2', NULL),
(68, 3, '33 dsadsa', '$2y$10$yiEpk99EpyG6.f28syRUI.eXbCaEbWnxaOBubPa0VRxtvSVXZj0WO', NULL),
(73, 2, 'admin', '$2y$10$E1n9CYVK84p3QMyhhi1ucOn9qiLVDZWmjYdxk1VLf5dCH0c/7QNli', '2025-03-20 11:31:27'),
(75, 1, 'diaman2024', '$2y$10$MqHQx6VUPJOUMVALCp6yRumCS/Z50rYL4liWnYMy777tuJ8d63vzK', '2025-03-20 09:25:38'),
(76, 1, 'leonard', '$2y$10$GvH2TmP2UiR4S4ObZo0LBuNwXRT9hdy6xC4RAMPx/SstKhRXy/kKC', '2025-03-20 11:47:46');

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
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
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
  MODIFY `id_categoria_egreso` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id_egreso` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invitados`
--
ALTER TABLE `invitados`
  MODIFY `id_invitado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
  ADD CONSTRAINT `invitados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `invitados_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`),
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
