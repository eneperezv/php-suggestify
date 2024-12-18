-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2024 a las 01:46:40
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
-- Base de datos: `suggestify`
--
CREATE DATABASE IF NOT EXISTS `suggestify` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `suggestify`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `algorithm` varchar(100) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `timezone` varchar(50) DEFAULT 'UTC',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `timezone`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '1234567890', '$2y$10$QwUQm3lQOrwOSa1/7jB96u9F6X9C8gyTevMkF69xfHbMJeuPHUF5u', 'admin', 'America/Bogota', '2024-12-15 22:38:15', '2024-12-15 22:38:15'),
(2, 'user One', 'operator1@example.com', '2345678901', '$2y$10$QwUQm3lQOrwOSa1/7jB96u9F6X9C8gyTevMkF69xfHbMJeuPHUF5u', 'user', 'America/Bogota', '2024-12-15 22:38:15', '2024-12-15 22:38:15'),
(3, 'user Two', 'operator2@example.com', '3456789012', '$2y$10$QwUQm3lQOrwOSa1/7jB96u9F6X9C8gyTevMkF69xfHbMJeuPHUF5u', 'user', 'America/Bogota', '2024-12-15 22:38:15', '2024-12-15 22:38:15'),
(4, 'Test User', 'user1@example.com', '4567890123', '$2y$10$QwUQm3lQOrwOSa1/7jB96u9F6X9C8gyTevMkF69xfHbMJeuPHUF5u', 'user', 'America/Bogota', '2024-12-15 22:38:15', '2024-12-15 22:38:15'),
(5, 'Test User Two', 'user2@example.com', '5678901234', '$2y$10$QwUQm3lQOrwOSa1/7jB96u9F6X9C8gyTevMkF69xfHbMJeuPHUF5u', 'user', 'America/Bogota', '2024-12-15 22:38:15', '2024-12-15 22:38:15'),
(7, 'Eliezer Navarro Pérez', 'eneperezv@gmail.com', '3016545845', '$2y$10$FFOtaXgkpWD7J3mm4RtHcuxFXRwfSWkyCwdEZR2lpzo9NH7rUTY7q', 'admin', 'America/Bogota', '2024-12-17 00:26:03', '2024-12-17 00:26:03'),
(8, 'Eliezer Navarro P.', 'npeliezere@gmail.com', '3016545845', '$2y$10$OCzhw81/xambvbgKin9wBuFlXTpO/S90Sa5DBk4MmxwAiLFsaSTsi', 'admin', 'America/Bogota', '2024-12-17 00:31:51', '2024-12-17 19:12:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
