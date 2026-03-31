-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-03-2026 a las 06:37:14
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hospital_pro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambulancias`
--

CREATE TABLE `ambulancias` (
  `id_amb` int(11) NOT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `km_recorrido` int(11) DEFAULT NULL,
  `estado_mecanico` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambulancias`
--

INSERT INTO `ambulancias` (`id_amb`, `placa`, `km_recorrido`, `estado_mecanico`) VALUES
(1, 'XYZ-123', 15000, 'Bueno'),
(2, 'ABC-789', 45000, 'Dañado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camas_hosp`
--

CREATE TABLE `camas_hosp` (
  `id_cama` int(11) NOT NULL,
  `piso` int(11) DEFAULT NULL,
  `estado_cama` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camas_hosp`
--

INSERT INTO `camas_hosp` (`id_cama`, `piso`, `estado_cama`) VALUES
(1, 1, 'Ocupada'),
(2, 2, 'Libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE `citas_medicas` (
  `id_cita` int(11) NOT NULL,
  `especialidad` varchar(50) DEFAULT NULL,
  `estado_cita` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas_medicas`
--

INSERT INTO `citas_medicas` (`id_cita`, `especialidad`, `estado_cita`, `fecha`, `id_paciente`) VALUES
(1, 'Pediatría', 'Cumplida', '2024-03-10', 1),
(2, 'Odontología', 'Cancelada', '2024-03-11', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emergencias`
--

CREATE TABLE `emergencias` (
  `id_em` int(11) NOT NULL,
  `triaje` int(11) DEFAULT NULL,
  `tiempo_espera_min` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `emergencias`
--

INSERT INTO `emergencias` (`id_em`, `triaje`, `tiempo_espera_min`, `fecha`) VALUES
(1, 1, 5, '2024-03-10'),
(2, 4, 120, '2024-03-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_med`
--

CREATE TABLE `equipos_med` (
  `id_equipo` int(11) NOT NULL,
  `nombre_equipo` varchar(100) DEFAULT NULL,
  `estado_uso` varchar(20) DEFAULT NULL,
  `dias_para_mantenimiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos_med`
--

INSERT INTO `equipos_med` (`id_equipo`, `nombre_equipo`, `estado_uso`, `dias_para_mantenimiento`) VALUES
(1, 'Resonador Magnético', 'En uso', 5),
(2, 'Monitor Signos', 'Disponible', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `metodo_pago`, `monto`, `fecha_pago`) VALUES
(1, 'Efectivo', 50000.00, '2024-03-01'),
(2, 'Tarjeta', 120000.00, '2024-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias_clin`
--

CREATE TABLE `historias_clin` (
  `id_hist` int(11) NOT NULL,
  `enfermedad` varchar(100) DEFAULT NULL,
  `alergias` varchar(100) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historias_clin`
--

INSERT INTO `historias_clin` (`id_hist`, `enfermedad`, `alergias`, `id_paciente`) VALUES
(1, 'Gripa Aviar', 'Polvo', 1),
(2, 'Gastritis', 'Ninguna', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos_aseo`
--

CREATE TABLE `insumos_aseo` (
  `id_aseo` int(11) NOT NULL,
  `articulo` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `area_uso` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `insumos_aseo`
--

INSERT INTO `insumos_aseo` (`id_aseo`, `articulo`, `cantidad`, `area_uso`) VALUES
(1, 'Jabón Quirúrgico', 20, 'Urgencias'),
(2, 'Cloro', 5, 'Pisos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorio`
--

CREATE TABLE `laboratorio` (
  `id_lab` int(11) NOT NULL,
  `tipo_examen` varchar(50) DEFAULT NULL,
  `resultado` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `laboratorio`
--

INSERT INTO `laboratorio` (`id_lab`, `tipo_examen`, `resultado`, `fecha`) VALUES
(1, 'Sangre', 'Normal', '2024-03-05'),
(2, 'Orina', 'Alterado', '2024-03-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id_med` int(11) NOT NULL,
  `nombre_med` varchar(100) DEFAULT NULL,
  `stock_actual` int(11) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`id_med`, `nombre_med`, `stock_actual`, `stock_minimo`, `precio`) VALUES
(1, 'Acetaminofén Jarabe', 50, 100, 15000.00),
(2, 'Ibuprofeno 500mg', 200, 50, 800.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id_medico` int(11) NOT NULL,
  `nombre_medico` varchar(100) DEFAULT NULL,
  `especialidad` varchar(50) DEFAULT NULL,
  `turno` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id_medico`, `nombre_medico`, `especialidad`, `turno`) VALUES
(1, 'Dr. House', 'Diagnóstico', 'Noche'),
(2, 'Dra. Polo', 'Pediatría', 'Mañana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_pers`
--

CREATE TABLE `nomina_pers` (
  `id_nom` int(11) NOT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `sueldo` decimal(10,2) DEFAULT NULL,
  `faltas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nomina_pers`
--

INSERT INTO `nomina_pers` (`id_nom`, `cargo`, `sueldo`, `faltas`) VALUES
(1, 'Enfermera', 4600000.00, 1),
(2, 'Secretaria', 1900000.00, 2),
(8, 'Plomero', 1000000.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `genero` enum('M','F','Otro') DEFAULT NULL,
  `eps` varchar(50) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre`, `edad`, `genero`, `eps`, `fecha_ingreso`) VALUES
(1, 'Juanito Alimaña', 5, 'M', 'Sura', '2024-03-01'),
(2, 'Pepa Pig', 25, 'F', 'Coomeva', '2024-03-02'),
(3, 'Pedro Picapiedra', 45, 'M', 'Sura', '2024-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pqr_quejas`
--

CREATE TABLE `pqr_quejas` (
  `id_pqr` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pqr_quejas`
--

INSERT INTO `pqr_quejas` (`id_pqr`, `tipo`, `estado`, `id_paciente`, `fecha`) VALUES
(1, 'Queja', 'Pendiente', 1, '2024-03-05'),
(2, 'Sugerencia', 'Resuelto', 2, '2024-03-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_prov` int(11) NOT NULL,
  `nombre_empresa` varchar(100) DEFAULT NULL,
  `monto_deuda` decimal(10,2) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_prov`, `nombre_empresa`, `monto_deuda`, `calificacion`) VALUES
(1, 'Meditech SA', 5000000.00, 5),
(2, 'Farmasur', 200000.00, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_med`
--

CREATE TABLE `recetas_med` (
  `id_receta` int(11) NOT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `cantidad_med` int(11) DEFAULT NULL,
  `fecha_receta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas_med`
--

INSERT INTO `recetas_med` (`id_receta`, `id_medico`, `cantidad_med`, `fecha_receta`) VALUES
(1, 1, 3, '2024-03-08'),
(2, 2, 1, '2024-03-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Operativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fk_rol` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nombre_completo`, `username`, `password`, `fk_rol`, `fecha_registro`) VALUES
(1, 'Ana Garcia', 'admin_ana', '$2y$10$D1hh0sSOYZv4.PQ3ZAN9TOfEE2bUW8wK2NS8ZoAZNsg00ONlZEVSy', 1, '2024-01-10'),
(2, 'Luis Perez', 'oper_luis', '$2y$10$vOmEh4MEPUPu2bHg/NO88uFxig0ZynQu8JOC16eLfoIEjL7zb9CC2', 2, '2024-01-15'),
(3, 'Maria Lopez', 'admin_maria', '$2y$10$hGe72gARcOLPoPqSMoM8ZuV6ueI8iqF6KW5QJEfR5DrjLvfQayh2y', 1, '2024-02-01'),
(5, 'David Botero', 'oper_david', '$2y$10$B0yoLdS2i87CSM5rPxxGaOUjq2djXVMe.Kpc/2Yxytn38rhyMBVcG', 2, '2026-03-30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambulancias`
--
ALTER TABLE `ambulancias`
  ADD PRIMARY KEY (`id_amb`);

--
-- Indices de la tabla `camas_hosp`
--
ALTER TABLE `camas_hosp`
  ADD PRIMARY KEY (`id_cama`);

--
-- Indices de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `emergencias`
--
ALTER TABLE `emergencias`
  ADD PRIMARY KEY (`id_em`);

--
-- Indices de la tabla `equipos_med`
--
ALTER TABLE `equipos_med`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `historias_clin`
--
ALTER TABLE `historias_clin`
  ADD PRIMARY KEY (`id_hist`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `insumos_aseo`
--
ALTER TABLE `insumos_aseo`
  ADD PRIMARY KEY (`id_aseo`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id_lab`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id_med`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id_medico`);

--
-- Indices de la tabla `nomina_pers`
--
ALTER TABLE `nomina_pers`
  ADD PRIMARY KEY (`id_nom`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `pqr_quejas`
--
ALTER TABLE `pqr_quejas`
  ADD PRIMARY KEY (`id_pqr`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_prov`);

--
-- Indices de la tabla `recetas_med`
--
ALTER TABLE `recetas_med`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_rol` (`fk_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambulancias`
--
ALTER TABLE `ambulancias`
  MODIFY `id_amb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `camas_hosp`
--
ALTER TABLE `camas_hosp`
  MODIFY `id_cama` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `emergencias`
--
ALTER TABLE `emergencias`
  MODIFY `id_em` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `equipos_med`
--
ALTER TABLE `equipos_med`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historias_clin`
--
ALTER TABLE `historias_clin`
  MODIFY `id_hist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `insumos_aseo`
--
ALTER TABLE `insumos_aseo`
  MODIFY `id_aseo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `id_lab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id_med` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nomina_pers`
--
ALTER TABLE `nomina_pers`
  MODIFY `id_nom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pqr_quejas`
--
ALTER TABLE `pqr_quejas`
  MODIFY `id_pqr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_prov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recetas_med`
--
ALTER TABLE `recetas_med`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD CONSTRAINT `citas_medicas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

--
-- Filtros para la tabla `historias_clin`
--
ALTER TABLE `historias_clin`
  ADD CONSTRAINT `historias_clin_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

--
-- Filtros para la tabla `pqr_quejas`
--
ALTER TABLE `pqr_quejas`
  ADD CONSTRAINT `pqr_quejas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

--
-- Filtros para la tabla `recetas_med`
--
ALTER TABLE `recetas_med`
  ADD CONSTRAINT `recetas_med_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`fk_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
