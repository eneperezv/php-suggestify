-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2024 a las 04:45:58
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
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
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
(5, 'Test User Two', 'user2@example.com', '5678901234', '$2y$10$QwUQm3lQOrwOSa1/7jB96u9F6X9C8gyTevMkF69xfHbMJeuPHUF5u', 'user', 'America/Bogota', '2024-12-15 22:38:15', '2024-12-15 22:38:15');

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
