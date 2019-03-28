-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-03-2019 a las 01:33:04
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `nombre`, `apellido`) VALUES
(1, 'Edgar Alan ', 'Poe'),
(2, 'Eduardo', 'Galeano'),
(3, 'Naomi', 'Klein'),
(4, 'Noam', 'Chomsky'),
(5, 'J.R.R', 'Tolkien'),
(6, 'Jorge Luis', 'Borges'),
(7, 'Martin', 'Caparros'),
(8, 'Gustavo Adolfo', 'Becquer'),
(9, 'Virginia', 'Woolf'),
(10, 'Howard', 'Lovecraft'),
(11, 'Tara', 'Westover'),
(12, 'Aldous', 'Huxley');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE IF NOT EXISTS `generos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(1, 'Policial'),
(2, 'Fantasia'),
(3, 'Terror'),
(4, 'Drama'),
(5, 'Infantil'),
(6, 'Politico'),
(7, 'Deportes'),
(8, 'Cuento'),
(9, 'Novela'),
(10, 'Poemas'),
(11, 'Ciencia ficcion'),
(12, 'Ensayo'),
(13, 'Geografia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE IF NOT EXISTS `libros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_carga` datetime NOT NULL,
  `id_genero` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `disponible` tinyint(4) NOT NULL DEFAULT '0',
  `imagen` mediumblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `nombre`, `descripcion`, `fecha_carga`, `id_genero`, `id_autor`, `disponible`, `imagen`) VALUES
(3, 'El Silmarillion', '', '2019-03-09 20:30:05', 2, 5, 0, 0x656c5f73696c6d6172696c6c696f6e2e4a5047),
(4, 'Cuentos perdidos', '', '2019-03-09 20:33:05', 2, 5, 0, 0x6375656e746f735f7065726469646f732e4a5047),
(5, 'El aleph', '', '2019-03-09 22:21:13', 8, 6, 0, 0x656c5f616c6570682e4a5047),
(6, 'La biblioteca de Babel', '', '2019-03-09 23:25:44', 8, 6, 0, 0x6c615f6269626c696f746563615f64655f626162656c2e4a5047),
(7, 'El hacedor', '', '2019-03-09 23:26:17', 8, 6, 0, 0x656c5f68616365646f722e4a5047),
(8, 'Rimas y Leyendas', '', '2019-03-09 23:28:35', 10, 8, 0, 0x72696d61735f6c6579656e6461732e4a5047),
(9, 'La carta robada', '', '2019-03-10 18:17:38', 1, 1, 0, 0x6c615f63617274615f726f626164612e6a7067),
(10, 'El escarabajo de oro', '', '2019-03-10 18:18:21', 1, 1, 0, 0x656c5f65736361726162616a6f5f64655f6f726f2e6a7067),
(11, 'El pendulo y el pozo', '', '2019-03-10 18:18:53', 3, 1, 0, 0x656c5f706f7a6f5f795f656c5f70656e64756c6f2e6a7067),
(12, 'El cuervo', '', '2019-03-10 18:19:32', 1, 1, 0, 0x656c5f63756572766f2e6a7067),
(13, 'Manuscrito hallado en una botella', '', '2019-03-10 18:21:23', 11, 1, 0, 0x6d616e7573637269746f5f68616c6c61646f5f656e5f756e615f626f74656c6c612e6a7067),
(14, 'El seÃ±or de los anillos', '', '2019-03-10 18:22:06', 2, 5, 0, 0x656c5f5365c3b16f725f64655f6c6f735f616e696c6c6f732e6a7067),
(15, 'Una habitacion propia', '', '2019-03-10 18:24:31', 12, 9, 0, 0x756e615f68616269746163696f6e5f70726f7069612e6a7067),
(16, 'Al faro', '', '2019-03-10 18:25:33', 9, 9, 0, 0x616c5f6661726f2e6a7067),
(17, 'Las olas', '', '2019-03-10 18:26:26', 9, 9, 0, 0x6c61735f6f6c61732e6a7067),
(18, 'La seÃ±ora Dalloway', '', '2019-03-10 18:27:45', 9, 9, 0, 0x6c615f7365c3b16f72615f64616c6c6f7761792e6a7067),
(19, 'La Voluntad vol 1', '', '2019-03-10 18:31:21', 9, 7, 0, 0x4c615f766f6c756e7461645f766f6c312e6a7067),
(20, 'La Voluntad vol 2', '', '2019-03-10 18:31:47', 9, 7, 0, 0x4c615f766f6c756e7461645f766f6c322e6a7067),
(21, 'La Voluntad vol 3', '', '2019-03-10 18:32:12', 9, 7, 0, 0x4c615f766f6c756e7461645f766f6c332e6a7067),
(22, 'La Historia', '', '2019-03-10 18:33:21', 9, 7, 0, 0x4c615f686973746f7269612e6a7067),
(23, 'Las venas abiertas de America Latina', '', '2019-03-10 18:34:43', 12, 2, 0, 0x4c61735f76656e61735f61626965727461735f64655f616d65726963615f6c6174696e612e6a7067),
(24, 'No logo', '', '2019-03-10 18:37:51', 12, 3, 0, 0x6e6f5f6c6f676f2e6a7067),
(25, 'La bestia en la cueva', '', '2019-03-10 18:45:01', 3, 10, 0, 0x6c615f6265737469615f656e5f6c615f63756576612e6a7067),
(26, 'El extraÃ±o', '', '2019-03-10 18:45:28', 3, 10, 0, 0x656c5f6578747261c3b16f2e6a7067),
(27, 'Los gatos de Ulthar', '', '2019-03-10 18:46:31', 2, 10, 0, 0x6c6f735f6761746f735f64655f756c746861722e6a7067),
(28, 'La llamada de Cthulhu', '', '2019-03-10 18:47:33', 3, 10, 0, 0x6c615f6c6c616d6164615f64655f637468756c68752e6a7067),
(29, 'El horror de Dunwich', '', '2019-03-10 18:48:31', 3, 10, 0, 0x656c5f686f72726f725f64655f64756e776963682e4a5047),
(30, 'La sombra de Innsmouth', '', '2019-03-10 18:49:27', 3, 10, 0, 0x6c615f736f6d6272615f736f6272655f696e6e736d6f7574682e6a7067),
(31, 'Una Educacion', '', '2019-03-10 18:53:01', 12, 11, 0, 0x756e615f656475636163696f6e2e6a7067),
(32, 'Un mundo feliz', '', '2019-03-10 18:54:57', 9, 12, 0, 0x556e5f6d756e646f5f46656c697a2e6a7067);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE IF NOT EXISTS `prestamo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_libro` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `fecha_prestamo` datetime NOT NULL,
  `fecha_devolucion` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id`, `id_libro`, `id_socio`, `fecha_prestamo`, `fecha_devolucion`) VALUES
(1, 3, 4, '2019-03-12 20:32:52', '2019-03-12 20:32:52'),
(3, 14, 3, '2019-03-12 20:43:01', '2019-03-12 20:43:01'),
(4, 15, 4, '2019-03-12 20:45:20', '2019-03-19 20:45:20'),
(6, 12, 5, '2019-03-12 21:10:30', '2019-03-19 21:10:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE IF NOT EXISTS `socios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id`, `nombre`, `apellido`, `email`, `usuario`, `clave`, `fecha_registro`, `nivel`) VALUES
(1, 'Leandro Pablo', 'Suarez', 'lsuarez@gmail.com', 'lsuarez', '9158734e4b7a59bf335376ef2f7dfd33', '2019-03-06 00:00:00', 1),
(3, 'Jorge', 'Peralta', 'jperalta@gmail.com', 'jperalta', 'b9997b28d5310ebdba78513f1f7909ad', '2019-03-12 16:51:09', 0),
(4, 'Paula', 'Gutierrez', 'pguti@gmail.com', 'pgutierrez', 'f7ea063ab0850599aa129191022cdb59', '2019-03-12 17:58:30', 0),
(5, 'Juan Sebastian', 'Lopez', 'junse@gmail.com', 'jlopez', 'c5a1a98649a7874de0def093eb136262', '2019-03-12 21:08:33', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
