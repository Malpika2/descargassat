-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-01-2020 a las 21:23:57
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `descargasat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(10) NOT NULL,
  `idSolicitud` varchar(200) DEFAULT NULL,
  `codEstatus` int(5) DEFAULT NULL,
  `EstadoSolicitud` int(5) DEFAULT NULL,
  `mensaje` varchar(100) DEFAULT NULL,
  `idPaquete` varchar(200) DEFAULT NULL,
  `paquete` text,
  `fechaInicial` varchar(30) DEFAULT NULL,
  `fechaFinal` varchar(30) DEFAULT NULL,
  `tipoSolicitud` varchar(50) DEFAULT NULL,
  `token` text,
  `rfc` varchar(30) DEFAULT NULL,
  `cert64` text,
  `key64` text,
  `fechaConsulta` varchar(30) DEFAULT NULL,
  `NumeroCFDIs` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(10) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
