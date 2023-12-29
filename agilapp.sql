-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-12-2023 a las 20:22:35
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
-- Base de datos: `agilapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_giro`
--

CREATE TABLE `t_giro` (
  `Giro_Codigo` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_horarios_laborales`
--

CREATE TABLE `t_horarios_laborales` (
  `Horario_ID` int(11) NOT NULL,
  `Dias_Habiles` varchar(50) DEFAULT NULL,
  `Horas` varchar(50) DEFAULT NULL,
  `Zona_Horaria` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_imagen`
--

CREATE TABLE `t_imagen` (
  `Imagen_ID` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Create_at` datetime DEFAULT NULL,
  `Update_at` datetime DEFAULT NULL,
  `Url` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_negocio`
--

CREATE TABLE `t_negocio` (
  `Negocio_Dni` int(11) NOT NULL,
  `Numero_Cuenta` int(11) DEFAULT NULL,
  `Nombre_Negocio` varchar(50) DEFAULT NULL,
  `Nombre_Representante_Legal` varchar(50) DEFAULT NULL,
  `Razon_Social` varchar(50) DEFAULT NULL,
  `Tipo_Negocio` int(11) DEFAULT NULL,
  `Direccion` varchar(50) DEFAULT NULL,
  `Lat` varchar(50) DEFAULT NULL,
  `Lon` varchar(50) DEFAULT NULL,
  `Imagen` blob DEFAULT NULL,
  `Dependientes` varchar(50) DEFAULT NULL,
  `Ranking` double DEFAULT NULL,
  `id_giro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_productos`
--

CREATE TABLE `t_productos` (
  `Productos_SKU` int(11) NOT NULL,
  `Nombre_Producto` varchar(50) DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Foto` blob DEFAULT NULL,
  `Descripcion_Producto` varchar(255) DEFAULT NULL,
  `Precio` double DEFAULT NULL,
  `id_negocio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_resena`
--

CREATE TABLE `t_resena` (
  `Resena_ID` int(11) NOT NULL,
  `Opinion` varchar(255) DEFAULT NULL,
  `Ranking` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT 0,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_negocio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_reservas`
--

CREATE TABLE `t_reservas` (
  `Numero_Reserva` int(11) NOT NULL,
  `Hora` datetime DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Minutos` int(11) DEFAULT NULL,
  `Dia` int(11) DEFAULT NULL,
  `id_usuario_reserva` int(11) DEFAULT 0,
  `id_receptor` int(11) DEFAULT 0,
  `id_negocio` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_servicio`
--

CREATE TABLE `t_servicio` (
  `Servicio_ID` int(11) NOT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `Precio` double DEFAULT NULL,
  `Duracion` datetime DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Ranking` double DEFAULT NULL,
  `Imagen` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_usuario`
--

CREATE TABLE `t_usuario` (
  `Usuario_Dni` int(11) NOT NULL,
  `Tipo` int(11) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `Direccion` varchar(50) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `Ranking` double DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `id_negocio` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `t_usuario`
--

INSERT INTO `t_usuario` (`Usuario_Dni`, `Tipo`, `Contrasena`, `Correo`, `Nombre`, `Apellido`, `Direccion`, `img`, `Ranking`, `activo`, `id_negocio`) VALUES
(1, 1, '$2y$10$YtqI7SPwOHdreFpYV8MwFOKuIW4pXhHBgoo8lZbpwl638F4lsYmJa', '12346931@gmail.com', 'Hector', 'Ulises', 'una hotel muy lejano', 'foto23.png', 0, 1, 0),
(1234956, 4, '$2y$10$F25rBqDiAV7mhpqdqTD1HegbCa.bWFYoPsH8HSVWyS63gqkVJEXxO', '112346931@gmail.com', 'testpreuba clave', 'apitest', 'Una casa en un lugar calle 123', 'foto23.png', 0, 1, 0),
(1234961, 4, '$2y$10$qteqVx1buE9h/0tpN2ZADe0x5UUqCiMIlQp2Md3jsPrlYuVhl6cka', '123469@gmail.com', 'testpreuba clave', 'apitest', 'Una casa en un lugar calle 123', NULL, 0, 1, 0),
(111111111, 4, '$2y$10$5ETS4k.0fV18d/fcXjfPGO0SEN8VO5xw0E.BiZRNQdpa15AqAPflS', '1@gmail.com', 'prueba nombre', 'apellido prueba', 'prueba', NULL, 0, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `t_giro`
--
ALTER TABLE `t_giro`
  ADD PRIMARY KEY (`Giro_Codigo`);

--
-- Indices de la tabla `t_horarios_laborales`
--
ALTER TABLE `t_horarios_laborales`
  ADD PRIMARY KEY (`Horario_ID`),
  ADD KEY `horario_usuario` (`id_usuario`);

--
-- Indices de la tabla `t_imagen`
--
ALTER TABLE `t_imagen`
  ADD PRIMARY KEY (`Imagen_ID`);

--
-- Indices de la tabla `t_negocio`
--
ALTER TABLE `t_negocio`
  ADD PRIMARY KEY (`Negocio_Dni`),
  ADD KEY `giro_negocio` (`id_giro`);

--
-- Indices de la tabla `t_productos`
--
ALTER TABLE `t_productos`
  ADD PRIMARY KEY (`Productos_SKU`),
  ADD KEY `negocio_productos` (`id_negocio`);

--
-- Indices de la tabla `t_resena`
--
ALTER TABLE `t_resena`
  ADD PRIMARY KEY (`Resena_ID`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_negocio` (`id_negocio`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `t_reservas`
--
ALTER TABLE `t_reservas`
  ADD PRIMARY KEY (`Numero_Reserva`),
  ADD KEY `reserva_usuario` (`id_usuario_reserva`),
  ADD KEY `reserva_funcionario` (`id_receptor`),
  ADD KEY `reserva_negocio` (`Numero_Reserva`),
  ADD KEY `id_negocio` (`id_negocio`);

--
-- Indices de la tabla `t_servicio`
--
ALTER TABLE `t_servicio`
  ADD PRIMARY KEY (`Servicio_ID`);

--
-- Indices de la tabla `t_usuario`
--
ALTER TABLE `t_usuario`
  ADD PRIMARY KEY (`Usuario_Dni`),
  ADD KEY `usuario_negocio` (`id_negocio`) USING BTREE;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t_horarios_laborales`
--
ALTER TABLE `t_horarios_laborales`
  ADD CONSTRAINT `t_horarios_laborales_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuario` (`Usuario_Dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_negocio`
--
ALTER TABLE `t_negocio`
  ADD CONSTRAINT `giro_negocio` FOREIGN KEY (`id_giro`) REFERENCES `t_giro` (`Giro_Codigo`);

--
-- Filtros para la tabla `t_productos`
--
ALTER TABLE `t_productos`
  ADD CONSTRAINT `t_productos_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `t_negocio` (`Negocio_Dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_resena`
--
ALTER TABLE `t_resena`
  ADD CONSTRAINT `t_resena_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuario` (`Usuario_Dni`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `t_resena_ibfk_2` FOREIGN KEY (`id_negocio`) REFERENCES `t_negocio` (`Negocio_Dni`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `t_resena_ibfk_3` FOREIGN KEY (`id_funcionario`) REFERENCES `t_usuario` (`Usuario_Dni`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `t_reservas`
--
ALTER TABLE `t_reservas`
  ADD CONSTRAINT `t_reservas_ibfk_1` FOREIGN KEY (`id_usuario_reserva`) REFERENCES `t_usuario` (`Usuario_Dni`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `t_reservas_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `t_usuario` (`Usuario_Dni`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `t_reservas_ibfk_3` FOREIGN KEY (`id_negocio`) REFERENCES `t_negocio` (`Negocio_Dni`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `t_servicio`
--
ALTER TABLE `t_servicio`
  ADD CONSTRAINT `servicio_negocio` FOREIGN KEY (`Servicio_ID`) REFERENCES `t_negocio` (`Negocio_Dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
