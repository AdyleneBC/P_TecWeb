-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2025 a las 18:26:09
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
-- Base de datos: `login_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('visitor','admin') NOT NULL DEFAULT 'visitor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password_hash`, `role`) VALUES
(1, 'yop', 'yop@gmail.com', '$2y$10$d4GZcvH8QvP589JDK3BizufcQfknN5Ah830jSPziQwpe5vSgX/XVK', 'visitor'),
(5, 'yop1', 'yop1@gmail.com', '$2y$10$4O1IwEDHAWOq1yIwm36ge.4zHM0aSOU6gdt1TtmvH0i9xwXB4N8Ve', 'visitor'),
(6, 'prueba', 'prueba@gmail.com', '$2y$10$wf8gNLpfjl.Tif15Y69kzu4XwGsOVK58eqcH65x9.shmE7iqwQxXa', 'visitor'),
(7, 'prueba2', 'prueba2@gmail.com', '$2y$10$2J5wmlwPidTvnVc22uKLauFAmZoBWiFfRFfMuA7VSdk7Kp2mASCie', 'visitor'),
(8, 'persona', 'persona@gmail.com', '$2y$10$URpEGH8OfAjqFa1CkMUyve2LSb2loOhcmwB37KlS44pD9U0ciTgna', 'visitor'),
(9, 'perla', 'perla@gmail.com', '$2y$10$D/clceyrIfSX7Bj3b8w6ZO2D5e9Uc11dRvcgbXsw21PD39mD7/bwS', 'visitor'),
(12, 'hola', 'hola@gmail.com', '$2y$10$JpvNrDzVgUR2u2mf/SNtPO3.J/HPeJRq1gLHNJ1TzzDiCXBbUD72u', 'visitor'),
(13, 'karla', 'karlaaa@gmail.com', '$2y$10$hG5clb2VoPE4i.q0cCZDoeSmtTaB8gDecyhLM6eJ/bWEw73SvgwAm', 'visitor'),
(14, 'yoop', 'yoop@productapp.com', '$2y$10$4zNO3pJhaLrwJ/WxT/sj1O/FEl2P5ec7QPfv5c/Mb4/f7nCn53sQ2', 'admin'),
(15, 'Montse', 'montse@productapp.com', '$2y$10$pOcWWU8uyrgU3uMnNp6HC.N4ykLPUiVIpdEEZvBK1LCVzw5PP5R5e', 'admin'),
(16, 'Rafaela', 'rafaela@gmail.com', '$2y$10$9.rIdG/g3ZeDU.C8wapQR.1nKS04xOqzXvfx5UfmnRCiHeXs1Mh8y', 'visitor'),
(17, 'cesar', 'cesarlopez@gmail.com', '$2y$10$XlwWV8fd/z7hyYTfmc1PgOAqPKidOMzXVLRRIl0U/DuhQsBb5GWI2', 'visitor'),
(18, 'ramon', 'ramonort@productapp.com', '$2y$10$kiQbnJkhP17ZWZHcJBdii.ZELLn68VtvWH5IPz2F3wD10DW/YvMLS', 'admin'),
(20, 'josue', 'jblo@producapp.com', '$2y$10$1pMWAx2yywXWHyAqOdZ2puVvVfMiEcyN1PiTd.2V53eCynmUunq/2', 'visitor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
