-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-05-2025 a las 21:38:23
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
-- Base de datos: `tareas_online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaborador`
--

CREATE TABLE `colaborador` (
  `id_tarea` int(11) NOT NULL,
  `usuario_colaborador` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL,
  `id_colaborador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colaborador`
--

INSERT INTO `colaborador` (`id_tarea`, `usuario_colaborador`, `estado`, `id_colaborador`) VALUES
(17, 'joaquinemunoz04@gmail.com', 1, 4),
(18, 'joaquinemunoz04@gmail.com', 0, 6),
(18, 'chichia_62@yahoo.com.ar', 1, 7),
(21, 'chichia_62@yahoo.com.ar', 1, 8),
(21, '12345@gmail.com', 1, 9),
(19, 'chichia_62@yahoo.com.ar', 1, 10),
(17, 'joaquin04@gmail.com', 1, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subtarea`
--

CREATE TABLE `subtarea` (
  `id_tarea` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `responsable` varchar(50) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `tema` varchar(50) NOT NULL,
  `id_sub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subtarea`
--

INSERT INTO `subtarea` (`id_tarea`, `descripcion`, `estado`, `prioridad`, `comentario`, `responsable`, `fecha_vencimiento`, `tema`, `id_sub`) VALUES
(17, 'Crear un inventario de pertenencias', 1, 1, 'asdasdasd', 'joaquinemunoz04@gmail.com', '2025-05-13', 'pertenecias', 12),
(18, 'terminar el frontend de la pagina', 0, 2, '', 'chichia_62@yahoo.com.ar', NULL, 'frondend ', 13),
(22, 'definir', 2, 1, NULL, NULL, NULL, 'Definir temas y formatos de contenido.', 14),
(22, 'a', 2, 2, NULL, NULL, NULL, 'Investigar tendencias y palabras clave relevantes.', 15),
(21, 'a', 0, 2, '', 'chichia_62@yahoo.com.ar', NULL, 'Determinar el propósito y el formato del evento', 16),
(21, 'b', 0, 2, '', '12345@gmail.com', NULL, 'Elaborar el presupuesto.', 17),
(19, 'Planificar la agenda y las actividades.', 0, 1, '', 'chichia_62@yahoo.com.ar', NULL, 'Planificar', 18),
(22, 'si', 0, 1, NULL, 'chichia_62@yahoo.com.ar', '2025-05-31', 'ontratar una empresa de mudanzas o coordinar ayuda', 19),
(17, 'ontratar una empresa de mudanzas o coordinar ayuda.', 0, 1, NULL, 'joaquin04@gmail.com', NULL, ' coordinar ayuda', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `tema` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `prioridad` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_recordatorio` date DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `responsable` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarea`
--

INSERT INTO `tarea` (`tema`, `descripcion`, `prioridad`, `estado`, `fecha_vencimiento`, `fecha_recordatorio`, `color`, `id_tarea`, `responsable`) VALUES
('Planificación de una Mudanza Residencial', 'planificaion', 1, 0, '2025-05-13', NULL, 'red', 17, 'chichia_62@yahoo.com.ar'),
('Proyecto Veterinaria', 'creando una veterinaria', 1, 0, '2025-05-26', '2025-05-20', '#e9ec18', 18, 'gonza123@gmail.com'),
('Planificación de Lanzamiento de Producto', 'Planificar todo lo necesario para el lanzamiento', 1, 0, '2025-05-31', '2025-05-20', '#e9ec18', 19, 'joaquinemunoz04@gmail.com'),
(' Desarrollo de una Nueva Característica de Softwar', 'desarrollar una nueva caracteristica', 2, 0, '2025-06-08', '2025-05-31', '#f32222', 20, 'joaquinemunoz04@gmail.com'),
('Organización de un Evento Interno de la Empresa', 'si', 0, 0, '2025-06-18', '2025-05-31', '#3fe51a', 21, 'joaquinemunoz04@gmail.com'),
('Creación de Contenido para Redes Sociales', 'se', 0, 3, '2025-06-14', NULL, '#3fe51a', 22, 'joaquinemunoz04@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `mail` varchar(30) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`mail`, `contraseña`, `nombre_usuario`) VALUES
('12345@gmail.com', 'asdasdasdasdasdasd', 'as'),
('chichia_62@yahoo.com.ar', '$2y$10$PWrnTqnQtSUufogVFfDpxODQzgazRM5oWJEbgGHfKNR', 'tarea'),
('gonza123@gmail.com', '$2y$10$IEDV/oh7oKiH5vxFWXHd8eBhwjjXxmIQYuab8zI.u8psA.84WFi4K', ''),
('joaquin04@gmail.com', 'asdadsasdasasdasd', 'jijo'),
('joaquinemunoz04@gmail.com', '$2y$10$8audNlS95p7Fd.GdTNYrHOBZ0xm39I/9AJsFeYYXY5UwJJ4sNOxH2', 'tarea');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`id_colaborador`),
  ADD KEY `id_tarea` (`id_tarea`),
  ADD KEY `usuario_colaborador` (`usuario_colaborador`);

--
-- Indices de la tabla `subtarea`
--
ALTER TABLE `subtarea`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_tarea` (`id_tarea`),
  ADD KEY `responsable` (`responsable`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `responsable` (`responsable`),
  ADD KEY `responsable_2` (`responsable`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`mail`),
  ADD KEY `mail` (`mail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  MODIFY `id_colaborador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `subtarea`
--
ALTER TABLE `subtarea`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `colaborador`
--
ALTER TABLE `colaborador`
  ADD CONSTRAINT `colaborador_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tarea` (`id_tarea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `colaborador_ibfk_2` FOREIGN KEY (`usuario_colaborador`) REFERENCES `usuario` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subtarea`
--
ALTER TABLE `subtarea`
  ADD CONSTRAINT `subtarea_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tarea` (`id_tarea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subtarea_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
