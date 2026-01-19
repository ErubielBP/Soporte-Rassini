-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2025 a las 00:08:42
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
-- Base de datos: `control_soporte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `Id_Empleado` int(11) NOT NULL,
  `Nombres` varchar(60) NOT NULL,
  `ApellidoP` varchar(60) NOT NULL,
  `ApellidoM` varchar(60) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `PasswordHash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`Id_Empleado`, `Nombres`, `ApellidoP`, `ApellidoM`, `UserName`, `Correo`, `PasswordHash`) VALUES
(1, 'Prueba', 'Barbosa', 'Bazan', 'prueba', 'prueba@prueba.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(6725, 'Gabriel', 'Sanchez', 'Sanchez', 'gasanche', 'gasanche@rassini.com', 'a58046d7cf628ff8e35a77163bb1b327e0ceeef30e15945027e3d50d7034d200'),
(9711, 'Jaime', 'Barbosa', 'Gonzales', 'jbarbosa', 'jbarbosa@rassini.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(500002643, 'Erubiel', 'Bueno', 'Perez', 'ebperez', 'ebperez@rassini.com', '6b955db2a96191644d2709b61eadd54dc0577ad1cbc1afd2f50e714e9ae8324d'),
(500002645, 'Ricardo', 'Mendez', 'Bazan', 'rimbazan', 'rimndz@rassini.com', 'f0d72a3fe8f37675fbc230f2088c1be2aa86dc410d8711f2e2c7cc9b7166c10b');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_computo`
--

CREATE TABLE `equipo_computo` (
  `Id_activo` int(11) NOT NULL,
  `Nom_Activo` varchar(80) NOT NULL,
  `Ip_equipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `equipo_computo`
--

INSERT INTO `equipo_computo` (`Id_activo`, `Nom_Activo`, `Ip_equipo`) VALUES
(1, 'Prueba', '198.168.1.1'),
(2, 'Prueba2', '198.168.1.2'),
(5439, 'RFR-L05439', '132.147.1.174');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id_Rol` int(11) NOT NULL,
  `Tipo_Rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id_Rol`, `Tipo_Rol`) VALUES
(1, 'Administrador'),
(2, 'operador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

CREATE TABLE `soporte` (
  `Id_Soporte` int(11) NOT NULL,
  `Fecha_Entrega` date NOT NULL,
  `Fecha_Devolucion` date DEFAULT NULL,
  `Tipo_Soporte` enum('Preventivo','Correctivo','Sistema Operativo','Otros(Especificar)') NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Id_EmpleadoTec` int(11) NOT NULL,
  `Id_activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnico`
--

CREATE TABLE `tecnico` (
  `Id_Empleado` int(11) NOT NULL,
  `Id_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tecnico`
--

INSERT INTO `tecnico` (`Id_Empleado`, `Id_Rol`) VALUES
(6725, 1),
(500002643, 1),
(500002645, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_Empleado` int(11) NOT NULL,
  `Area_Trabajo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_equipo`
--

CREATE TABLE `usuario_equipo` (
  `Id_EquipoUsuario` int(11) NOT NULL,
  `Id_Empleado` int(11) NOT NULL,
  `Id_activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario_equipo`
--

INSERT INTO `usuario_equipo` (`Id_EquipoUsuario`, `Id_Empleado`, `Id_activo`) VALUES
(1, 500002643, 5439);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD UNIQUE KEY `uk_empleado_username` (`UserName`),
  ADD UNIQUE KEY `uk_empleado_correo` (`Correo`);

--
-- Indices de la tabla `equipo_computo`
--
ALTER TABLE `equipo_computo`
  ADD PRIMARY KEY (`Id_activo`),
  ADD UNIQUE KEY `uk_equipo_ip` (`Ip_equipo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_Rol`);

--
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`Id_Soporte`),
  ADD KEY `fk_soporte_tecnico` (`Id_EmpleadoTec`),
  ADD KEY `fk_soporte_equipo` (`Id_activo`);

--
-- Indices de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD KEY `fk_tecnico_rol` (`Id_Rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_Empleado`);

--
-- Indices de la tabla `usuario_equipo`
--
ALTER TABLE `usuario_equipo`
  ADD PRIMARY KEY (`Id_EquipoUsuario`),
  ADD KEY `fk_usu_equipo_usuario` (`Id_Empleado`),
  ADD KEY `fk_usu_equipo_equipo` (`Id_activo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500002647;

--
-- AUTO_INCREMENT de la tabla `equipo_computo`
--
ALTER TABLE `equipo_computo`
  MODIFY `Id_activo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5440;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `soporte`
--
ALTER TABLE `soporte`
  MODIFY `Id_Soporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_equipo`
--
ALTER TABLE `usuario_equipo`
  MODIFY `Id_EquipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `fk_soporte_equipo` FOREIGN KEY (`Id_activo`) REFERENCES `equipo_computo` (`Id_activo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_soporte_tecnico` FOREIGN KEY (`Id_EmpleadoTec`) REFERENCES `tecnico` (`Id_Empleado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD CONSTRAINT `fk_tecnico_empleado` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tecnico_rol` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id_Rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_empleado` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_equipo`
--
ALTER TABLE `usuario_equipo`
  ADD CONSTRAINT `fk_usu_equipo_equipo` FOREIGN KEY (`Id_activo`) REFERENCES `equipo_computo` (`Id_activo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usu_equipo_usuario` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2026 a las 15:38:03
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
-- Base de datos: `control_soporte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `Id_Empleado` int(11) NOT NULL,
  `Nombres` varchar(60) NOT NULL,
  `ApellidoP` varchar(60) NOT NULL,
  `ApellidoM` varchar(60) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `PasswordHash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`Id_Empleado`, `Nombres`, `ApellidoP`, `ApellidoM`, `UserName`, `Correo`, `PasswordHash`) VALUES
(1, 'Prueba', 'Barbosa', 'Bazan', 'prueba', 'prueba@prueba.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(6725, 'Gabriel', 'Sanchez', 'Sanchez', 'gasanche', 'gasanche@rassini.com', 'a58046d7cf628ff8e35a77163bb1b327e0ceeef30e15945027e3d50d7034d200'),
(9711, 'Jaime', 'Barbosa', 'Gonzales', 'jbarbosa', 'jbarbosa@rassini.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(500002643, 'Erubiel', 'Bueno', 'Perez', 'ebperez', 'ebperez@rassini.com', '6b955db2a96191644d2709b61eadd54dc0577ad1cbc1afd2f50e714e9ae8324d'),
(500002645, 'Ricardo', 'Mendez', 'Bazan', 'rimbazan', 'rimndz@rassini.com', 'f0d72a3fe8f37675fbc230f2088c1be2aa86dc410d8711f2e2c7cc9b7166c10b'),
(500002647, 'Carlos', 'Hernandez', 'Lopez', 'carlos.admin', 'carlos.admin@empresa.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(500002648, 'Luis', 'Martinez', 'Garcia', 'luis.oper', 'luis.oper@empresa.com', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'),
(500002649, 'Ana', 'Ramirez', 'Santos', 'ana.oper', 'ana.oper@empresa.com', 'cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc'),
(500002650, 'Jorge', 'Diaz', 'Mendoza', 'jorge.user', 'jorge.user@empresa.com', 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd'),
(500002651, 'Maria', 'Lopez', 'Vega', 'maria.user', 'maria.user@empresa.com', 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'),
(500002652, 'Ricardo', 'Sanchez', 'Torres', 'ricardo.user', 'ricardo.user@empresa.com', 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'),
(500002653, 'Sofia', 'Cruz', 'Nava', 'sofia.user', 'sofia.user@empresa.com', '1111111111111111111111111111111111111111111111111111111111111111'),
(500002654, 'Diana', 'Flores', 'Rios', 'diana.user', 'diana.user@empresa.com', '2222222222222222222222222222222222222222222222222222222222222222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_computo`
--

CREATE TABLE `equipo_computo` (
  `Id_activo` int(11) NOT NULL,
  `Nom_Activo` varchar(80) NOT NULL,
  `Ip_equipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `equipo_computo`
--

INSERT INTO `equipo_computo` (`Id_activo`, `Nom_Activo`, `Ip_equipo`) VALUES
(1, 'Prueba', '198.168.1.1'),
(2, 'Prueba2', '198.168.1.2'),
(5439, 'RFR-L05439', '132.147.1.174'),
(5440, 'PC-OFICINA-01', '192.168.1.21'),
(5441, 'PC-OFICINA-02', '192.168.1.22'),
(5442, 'LAPTOP-RH-01', '192.168.1.31'),
(5443, 'PC-CALIDAD-01', '192.168.1.41'),
(5444, 'LAPTOP-COMP-01', '192.168.1.51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id_Rol` int(11) NOT NULL,
  `Tipo_Rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id_Rol`, `Tipo_Rol`) VALUES
(1, 'Administrador'),
(2, 'operador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

CREATE TABLE `soporte` (
  `Id_Soporte` int(11) NOT NULL,
  `Fecha_Entrega` date NOT NULL,
  `Fecha_Devolucion` date DEFAULT NULL,
  `Tipo_Soporte` enum('Preventivo','Correctivo','Sistema Operativo','Otros(Especificar)') NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Id_EmpleadoTec` int(11) NOT NULL,
  `Id_activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnico`
--

CREATE TABLE `tecnico` (
  `Id_Empleado` int(11) NOT NULL,
  `Id_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tecnico`
--

INSERT INTO `tecnico` (`Id_Empleado`, `Id_Rol`) VALUES
(6725, 1),
(500002643, 1),
(500002645, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_Empleado` int(11) NOT NULL,
  `Area_Trabajo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_equipo`
--

CREATE TABLE `usuario_equipo` (
  `Id_EquipoUsuario` int(11) NOT NULL,
  `Id_Empleado` int(11) NOT NULL,
  `Id_activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario_equipo`
--

INSERT INTO `usuario_equipo` (`Id_EquipoUsuario`, `Id_Empleado`, `Id_activo`) VALUES
(1, 500002643, 5439);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD UNIQUE KEY `uk_empleado_username` (`UserName`),
  ADD UNIQUE KEY `uk_empleado_correo` (`Correo`);

--
-- Indices de la tabla `equipo_computo`
--
ALTER TABLE `equipo_computo`
  ADD PRIMARY KEY (`Id_activo`),
  ADD UNIQUE KEY `uk_equipo_ip` (`Ip_equipo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_Rol`);

--
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`Id_Soporte`),
  ADD KEY `fk_soporte_tecnico` (`Id_EmpleadoTec`),
  ADD KEY `fk_soporte_equipo` (`Id_activo`);

--
-- Indices de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD KEY `fk_tecnico_rol` (`Id_Rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_Empleado`);

--
-- Indices de la tabla `usuario_equipo`
--
ALTER TABLE `usuario_equipo`
  ADD PRIMARY KEY (`Id_EquipoUsuario`),
  ADD KEY `fk_usu_equipo_usuario` (`Id_Empleado`),
  ADD KEY `fk_usu_equipo_equipo` (`Id_activo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500002655;

--
-- AUTO_INCREMENT de la tabla `equipo_computo`
--
ALTER TABLE `equipo_computo`
  MODIFY `Id_activo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5445;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `soporte`
--
ALTER TABLE `soporte`
  MODIFY `Id_Soporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_equipo`
--
ALTER TABLE `usuario_equipo`
  MODIFY `Id_EquipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `fk_soporte_equipo` FOREIGN KEY (`Id_activo`) REFERENCES `equipo_computo` (`Id_activo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_soporte_tecnico` FOREIGN KEY (`Id_EmpleadoTec`) REFERENCES `tecnico` (`Id_Empleado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD CONSTRAINT `fk_tecnico_empleado` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tecnico_rol` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id_Rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_empleado` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_equipo`
--
ALTER TABLE `usuario_equipo`
  ADD CONSTRAINT `fk_usu_equipo_equipo` FOREIGN KEY (`Id_activo`) REFERENCES `equipo_computo` (`Id_activo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usu_equipo_usuario` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
