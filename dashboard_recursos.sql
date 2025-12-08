-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2025 a las 18:15:20
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
-- Base de datos: `dashboard_recursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_descargas`
--

CREATE TABLE `bitacora_descargas` (
  `id_descarga` int(11) NOT NULL,
  `id_recurso_fk` int(11) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacora_descargas`
--

INSERT INTO `bitacora_descargas` (`id_descarga`, `id_recurso_fk`, `ip`, `fecha`) VALUES
(1, 1, '::1', '2025-12-08 07:43:16'),
(2, 2, '::1', '2025-12-08 07:43:26'),
(3, 1, '::1', '2025-12-08 07:54:14'),
(152, 1, '::1', '2025-12-08 14:28:00'),
(153, 1, '::1', '2025-12-08 14:28:26'),
(154, 4, '::1', '2025-12-08 14:36:04'),
(155, 1, '::1', '2025-12-08 17:02:17'),
(156, 2, '::1', '2025-12-08 17:09:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id_recurso` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `autor` varchar(150) DEFAULT NULL,
  `departamento` varchar(150) DEFAULT NULL,
  `empresa` varchar(150) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `lenguaje` varchar(50) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id_recurso`, `nombre`, `autor`, `departamento`, `empresa`, `fecha_creacion`, `descripcion`, `tipo`, `lenguaje`, `archivo`, `eliminado`) VALUES
(1, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'PHP', '08-herencia.zip', 0),
(2, '08 - Herencia', 'DESCONOCIDO', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'JAVA', '08-herencia.zip', 0),
(3, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia\r\nPRUEBA PARA VER SI FUNCIONA LA MODIFICACION', 'zip', 'PHP', '08-herencia.zip', 0),
(4, '07 - Polimorfismo', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: Poliformismo', 'xml', 'PHP', '08-herencia.zip', 0),
(5, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'PHP', '08-herencia.zip', 0),
(6, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'PHP', '08-herencia.zip', 0),
(7, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'PHP', '08-herencia.zip', 0),
(8, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'PHP', '08-herencia.zip', 0),
(9, '08 - Herencia', 'Juan Carlos Conde', 'Docente', 'FCC - BUAP', '2025-11-11', 'Descripcion del pilar de POO: herencia', 'zip', 'PHP', '08-herencia.zip', 1),
(10, 'Herencia', 'NDSBSJDCH', 'MDNFKSJDN', 'DDKNFJ', '2025-12-08', 'MXVNJDFN', 'pdf', 'JAVA', '10_11_25_Uso del Simulador_Ciberseguridad.pdf', 0),
(11, 'Herencia', 'NDSBSJDCH', 'MDNFKSJDN', 'DDKNFJ', '2025-12-08', 'MXVNJDFN', 'pdf', 'JAVA', '10_11_25_Uso del Simulador_Ciberseguridad.pdf', 0),
(12, 'Herencia', 'NDSBSJDCH', 'MDNFKSJDN', 'DDKNFJ', '2025-12-08', 'MXVNJDFN', 'pdf', 'JAVA', '10_11_25_Uso del Simulador_Ciberseguridad.pdf', 0),
(13, 'Herencia', 'NDSBSJDCH', 'MDNFKSJDN', 'DDKNFJ', '2025-12-08', 'MXVNJDFN', 'pdf', 'JAVA', '10_11_25_Uso del Simulador_Ciberseguridad.pdf', 0),
(14, 'Herencia', 'NDSBSJDCH', 'MDNFKSJDN', 'DDKNFJ', '2025-12-08', 'MXVNJDFN', 'pdf', 'JAVA', '10_11_25_Uso del Simulador_Ciberseguridad.pdf', 0),
(15, 'Herencia', 'NDSBSJDCH', 'MDNFKSJDN', 'DDKNFJ', '2025-12-08', 'MXVNJDFN', 'pdf', 'JAVA', '10_11_25_Uso del Simulador_Ciberseguridad.pdf', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora_descargas`
--
ALTER TABLE `bitacora_descargas`
  ADD PRIMARY KEY (`id_descarga`),
  ADD KEY `id_recurso_fk` (`id_recurso_fk`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id_recurso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora_descargas`
--
ALTER TABLE `bitacora_descargas`
  MODIFY `id_descarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `id_recurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora_descargas`
--
ALTER TABLE `bitacora_descargas`
  ADD CONSTRAINT `bitacora_descargas_ibfk_1` FOREIGN KEY (`id_recurso_fk`) REFERENCES `recursos` (`id_recurso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
