-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2018 a las 22:48:51
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `astoil`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cost_center`
--

CREATE TABLE `cost_center` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int(11) NOT NULL,
  `user_last_updated_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Codigo interno de la empresa',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `cost_center_id` int(11) NOT NULL,
  `suggested_price` float NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_min` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int(11) NOT NULL,
  `user_last_updated_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `product_type_id`, `cost_center_id`, `suggested_price`, `description`, `stock`, `stock_min`, `created_at`, `updated_at`, `user_created_id`, `user_last_updated_id`, `active`) VALUES
(1, 'A0001', 'GUANTES MEDIO PASEO ', 2, 0, 57.5, 'guantes', 0, 100, '2018-08-31 19:48:56', '2018-08-31 19:48:56', 0, 0, 1),
(2, 'A0002', 'GUANTES BAQUETA ', 2, 0, 0, '', 0, 50, '2018-08-31 19:55:10', '2018-08-31 19:55:10', 0, 0, 1),
(3, 'A0003 ', 'GUANTES DE SOLDADOR ROJO', 2, 0, 0, '', 0, 10, '2018-08-31 21:03:19', '2018-08-31 21:03:19', 0, 0, 1),
(4, 'A0004', '', 0, 0, 0, '', 0, 0, '2018-08-31 21:03:30', '2018-08-31 21:03:30', 0, 0, 1),
(5, 'A0004', 'GUANTES DE SOLDADOR AMARILLOS', 2, 0, 0, '', 0, 10, '2018-08-31 21:03:55', '2018-08-31 21:03:55', 0, 0, 1),
(6, 'A0005', 'GUANTES MOTEADO ', 2, 0, 0, '', 0, 50, '2018-08-31 21:04:33', '2018-08-31 21:04:33', 0, 0, 1),
(7, 'A0006', 'GUANTES NITRILO MULTIFLEX', 2, 0, 0, '', 0, 0, '2018-08-31 21:04:59', '2018-08-31 21:04:59', 0, 0, 1),
(8, 'A0007', 'GUANTES NITRILO PUÑO CORTO', 2, 0, 0, '', 0, 0, '2018-08-31 21:05:37', '2018-08-31 21:05:37', 0, 0, 1),
(9, 'A0008', 'GUANTES NITRILO PUÑO TEJIDO ', 2, 0, 0, '', 0, 0, '2018-08-31 21:06:05', '2018-08-31 21:06:05', 0, 0, 1),
(10, 'A0009', 'PROTECTOR AUDITIVO DESCARTABLE ', 2, 0, 0, '', 0, 0, '2018-08-31 21:06:45', '2018-08-31 21:06:45', 0, 0, 1),
(11, 'A0010', 'PROTECTOR AUDITIVITO 3M', 2, 0, 0, '', 0, 0, '2018-08-31 21:07:17', '2018-08-31 21:07:17', 0, 0, 1),
(12, 'A0011', 'ANTEOJOS DE SEGURIDAD TRANSPARENTES', 2, 0, 0, '', 0, 0, '2018-08-31 21:08:30', '2018-08-31 21:08:30', 0, 0, 1),
(13, 'A0012', 'ANTEOJOS DE SEGURIDAD OSCUROS', 2, 0, 0, '', 0, 0, '2018-08-31 21:09:35', '2018-08-31 21:09:35', 0, 0, 1),
(14, 'A0012', '', 0, 0, 0, '', 0, 0, '2018-08-31 21:09:22', '2018-08-31 21:09:22', 0, 0, 1),
(15, 'A0013', 'GORROS SOLDADOR', 2, 0, 0, '', 0, 0, '2018-08-31 21:10:00', '2018-08-31 21:10:00', 0, 0, 1),
(16, 'A0014', 'MANGAS SOLDADOR', 2, 0, 0, '', 0, 0, '2018-08-31 21:10:27', '2018-08-31 21:10:27', 0, 0, 1),
(17, 'A0015', 'CUBREBOTA SOLDADOR', 2, 0, 0, '', 0, 0, '2018-08-31 21:11:08', '2018-08-31 21:11:08', 0, 0, 1),
(18, 'A0016', 'CASCO SEGURIDAD ROJO ', 2, 0, 0, '', 0, 0, '2018-08-31 21:11:35', '2018-08-31 21:11:35', 0, 0, 1),
(19, 'A0017', 'CASCO SEGURIDAD BLANCO', 2, 0, 0, '', 0, 0, '2018-08-31 21:12:03', '2018-08-31 21:12:03', 0, 0, 1),
(20, 'A0018', 'MAMELUCOS DESCARTABLES', 2, 0, 0, '', 0, 0, '2018-08-31 21:13:43', '2018-08-31 21:13:43', 0, 0, 1),
(21, 'A0019', 'ARNES PARA CASCO SEGURIDAD', 2, 0, 0, '', 0, 0, '2018-08-31 21:14:19', '2018-08-31 21:14:19', 0, 0, 1),
(22, 'A0019', 'BARBIJOS', 2, 0, 0, '', 0, 0, '2018-08-31 21:14:48', '2018-08-31 21:14:48', 0, 0, 1),
(23, 'A0020', 'MENTONERAS PARA CASCO ', 2, 0, 0, '', 0, 0, '2018-08-31 21:19:02', '2018-08-31 21:19:02', 0, 0, 1),
(24, 'A0021', 'ANTIPARRAS ', 2, 0, 0, '', 0, 0, '2018-08-31 21:19:18', '2018-08-31 21:19:18', 0, 0, 1),
(25, 'B0001', 'RESMAS PAPEL A4', 1, 0, 0, '', 0, 0, '2018-08-31 21:24:28', '2018-08-31 21:24:28', 0, 0, 1),
(26, 'B0002', 'RESMAS PAPEL OFICIO ', 1, 0, 0, '', 0, 0, '2018-08-31 21:26:17', '2018-08-31 21:26:17', 0, 0, 1),
(27, 'B0003', 'ETIQUETAS AUTODHESIVAS ', 1, 0, 0, '', 0, 0, '2018-08-31 21:26:09', '2018-08-31 21:26:09', 0, 0, 1),
(28, 'B0004', 'FOLIOS OFICIO ', 1, 0, 0, '', 0, 0, '2018-09-03 17:54:51', '2018-09-03 17:54:51', 0, 0, 1),
(29, 'B0005 ', 'FOLIOS A4 ', 1, 0, 0, '', 0, 0, '2018-09-03 17:55:12', '2018-09-03 17:55:12', 0, 0, 1),
(30, 'B0006', 'CINTA DE EMBALAR ', 1, 0, 0, '', 0, 0, '2018-09-03 17:55:39', '2018-09-03 17:55:39', 0, 0, 1),
(31, 'B0007', 'SOBRE PAPEL MADERA A4 ', 1, 0, 0, '', 0, 0, '2018-09-03 17:56:16', '2018-09-03 17:56:16', 0, 0, 1),
(32, 'B0008', 'SOBRE PAPEL MADERA OFICIO ', 1, 0, 0, '', 0, 0, '2018-09-03 17:56:44', '2018-09-03 17:56:44', 0, 0, 1),
(33, 'B0009 ', 'CD´S', 1, 0, 0, '', 0, 0, '2018-09-03 17:59:07', '2018-09-03 17:59:07', 0, 0, 1),
(34, 'B0010', 'CARPETAS TAPA CRISTAL A4 ', 1, 0, 0, '', 0, 0, '2018-09-03 17:59:54', '2018-09-03 17:59:54', 0, 0, 1),
(35, 'B0011 ', 'CARPETAS COLGANTES A4 ', 1, 0, 0, '', 0, 0, '2018-09-03 18:01:21', '2018-09-03 18:01:21', 0, 0, 1),
(36, 'B0012', 'PLANCHAS DE PVC ', 1, 0, 0, '', 0, 0, '2018-09-03 18:01:51', '2018-09-03 18:01:51', 0, 0, 1),
(37, 'B0013', 'LAPICERAS BIC AZUL ', 1, 0, 0, '', 0, 0, '2018-09-03 18:02:37', '2018-09-03 18:02:37', 0, 0, 1),
(38, 'B0014 ', 'LAPICERA BIC NEGRA ', 1, 0, 0, '', 0, 0, '2018-09-03 18:03:19', '2018-09-03 18:03:19', 0, 0, 1),
(39, 'B0015', 'MARCADOR DE PIZZARRA', 1, 0, 0, '', 0, 0, '2018-09-03 18:04:08', '2018-09-03 18:04:08', 0, 0, 1),
(40, 'B0016', 'CORRECTOR EN CINTA ', 1, 0, 0, '', 0, 0, '2018-09-03 18:04:33', '2018-09-03 18:04:33', 0, 0, 1),
(41, 'B0017', 'REPUESTO DE ABROCHADORA X 100u', 1, 0, 0, '', 0, 0, '2018-09-03 18:05:27', '2018-09-03 18:05:27', 0, 0, 1),
(42, 'B0018', 'CLIPS X 100u ', 1, 0, 0, '', 0, 0, '2018-09-03 18:07:02', '2018-09-03 18:07:02', 0, 0, 1),
(43, 'B0019', 'CARPETAS OFICIO ', 1, 0, 0, '', 0, 0, '2018-09-03 18:07:31', '2018-09-03 18:07:31', 0, 0, 1),
(44, 'B0020 ', 'CARPETAS A4 ', 1, 0, 0, '', 0, 0, '2018-09-03 18:07:50', '2018-09-03 18:07:50', 0, 0, 1),
(45, 'B0021', 'RESALTADORES (COLOR) ', 1, 0, 0, '', 0, 0, '2018-09-03 18:10:08', '2018-09-03 18:10:08', 0, 0, 1),
(46, 'C0001', 'CEMENTO X 50 KILOS ', 3, 0, 0, '', 0, 0, '2018-09-03 21:01:05', '2018-09-03 21:01:05', 0, 0, 1),
(47, 'C0002', 'CAL X 25 KILOS ', 3, 0, 0, '', 0, 0, '2018-09-03 21:00:54', '2018-09-03 21:00:54', 0, 0, 1),
(48, 'C0003', 'ALAMBRE ROMBOIDAL ', 3, 0, 0, '', 0, 0, '2018-09-03 21:01:38', '2018-09-03 21:01:38', 0, 0, 1),
(49, 'B0022', 'ACA', 1, 0, 0, '', 0, 0, '2018-09-03 21:02:18', '2018-09-03 21:02:24', 0, 0, 0),
(50, 'C0004', 'MEMBRANA PARA TECHO ', 3, 0, 0, '', 0, 0, '2018-09-04 15:56:16', '2018-09-04 15:56:16', 0, 0, 1),
(51, 'C0005 ', 'ALAMBRE 17/15', 3, 0, 0, '', 0, 0, '2018-09-04 15:56:49', '2018-09-04 15:56:49', 0, 0, 1),
(52, 'C0006 ', 'LOSETA GRIS 40 X 40 ', 3, 0, 0, '', 0, 0, '2018-09-04 15:57:31', '2018-09-04 15:57:31', 0, 0, 1),
(53, 'C0007 ', 'MARTILLO DE CARPINTERO ', 3, 0, 0, '', 0, 0, '2018-09-04 16:05:43', '2018-09-04 16:05:43', 0, 0, 1),
(54, 'C0008 ', 'SERRUCHO ', 3, 0, 0, '', 0, 0, '2018-09-04 16:06:25', '2018-09-04 16:06:25', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int(11) NOT NULL,
  `user_last_updated_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_type`
--

INSERT INTO `product_type` (`id`, `name`, `description`, `created_at`, `updated_at`, `user_created_id`, `user_last_updated_id`, `active`) VALUES
(1, 'LIBRERIA ', '', '2018-08-31 21:26:34', '2018-08-31 21:26:34', 0, 0, 1),
(2, 'SEGURIDAD', 'Elementos de Seguridad, Ropa, etc', '2018-08-31 19:42:55', '2018-08-31 19:42:55', 0, 0, 1),
(3, 'OBRAS PUBLICAS', 'artículos de construcción y herramientas', '2018-09-03 20:59:48', '2018-09-03 20:59:48', 0, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cost_center`
--
ALTER TABLE `cost_center`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cost_center`
--
ALTER TABLE `cost_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
