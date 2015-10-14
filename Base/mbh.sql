-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2015 a las 22:32:08
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mbh`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adjuntos_cliente`
--

CREATE TABLE IF NOT EXISTS `adjuntos_cliente` (
  `adjuntos_cliente_id` int(11) NOT NULL,
  `adjuntos_cliente_tipo_adjunto_id` int(11) NOT NULL,
  `adjuntos_cliente_cliente_id` int(11) NOT NULL,
  `adjuntos_cliente_direccion` varchar(300) NOT NULL,
  `adjuntos_cliente_descripcion` varchar(300) NOT NULL,
  `adjuntos_cliente_nombre` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajuste`
--

CREATE TABLE IF NOT EXISTS `ajuste` (
  `ajuste_id` int(11) NOT NULL,
  `ajuste_descripcion` varchar(200) NOT NULL,
  `ajuste_porcentaje` float NOT NULL,
  `ajuste_fecha` date NOT NULL,
  `ajuste_monto` double(20,2) NOT NULL,
  `ajuste_obra_civil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aplicacion`
--

CREATE TABLE IF NOT EXISTS `aplicacion` (
  `app_id` int(11) NOT NULL,
  `app_nombre` varchar(45) NOT NULL,
  `app_baja` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `aplicacion`
--

INSERT INTO `aplicacion` (`app_id`, `app_nombre`, `app_baja`) VALUES
(5, 'MBH', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE IF NOT EXISTS `asistencia` (
  `asistencia_id` int(11) NOT NULL,
  `asistencia_estado` char(1) NOT NULL,
  `asistencia_fecha` date NOT NULL,
  `asistencia_obrero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `categoria_id` int(11) NOT NULL,
  `categoria_descripcion` varchar(200) NOT NULL,
  `categoria_nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `cliente_id` int(11) NOT NULL,
  `cliente_apellido` varchar(255) NOT NULL,
  `cliente_nombre` varchar(255) NOT NULL,
  `cliente_tipo_doc_id` int(11) NOT NULL,
  `cliente_nro_doc` int(11) NOT NULL,
  `cliente_direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cliente_localidad_id` int(11) DEFAULT NULL,
  `cliente_CUIL` varchar(255) DEFAULT NULL,
  `cliente_CBU` varchar(255) DEFAULT NULL,
  `cliente_fecha_inicio` date DEFAULT NULL,
  `cliente_telefono` varchar(255) DEFAULT NULL,
  `cliente_estado_id` int(11) DEFAULT NULL,
  `cliente_fecha_nacimiento` date DEFAULT NULL,
  `cliente_usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cliente_id`, `cliente_apellido`, `cliente_nombre`, `cliente_tipo_doc_id`, `cliente_nro_doc`, `cliente_direccion`, `cliente_localidad_id`, `cliente_CUIL`, `cliente_CBU`, `cliente_fecha_inicio`, `cliente_telefono`, `cliente_estado_id`, `cliente_fecha_nacimiento`, `cliente_usuario_id`) VALUES
(1, 'CEPEDA', 'LILIANA INES', 1, 6841180, '41 Nº 736 E/ 8 Y 9', 72, '27068411802', '', '2010-04-22', '0221-4272409', 3, '1942-01-20', NULL),
(2, 'D´ALESSANDRO', 'MARIA INES', 1, 22669100, '42 Nº 1028 E/ 15 Y 16', 72, '27226691001', '', '2010-04-22', '0221-4256235', 3, '1972-03-29', NULL),
(3, 'MURA', 'MIRTHA ESTELA', 1, 10317737, '1 Nº 1197 E/ 57 Y 58 1º B', 72, '27103177370', '', '2010-04-22', '0221-4642577', 2, '1950-12-17', NULL),
(4, 'LOPEZ', 'FERNANDO GABRIEL', 1, 27528244, '17 Nº 2256', 72, '20275282449', '', '2010-04-23', '0221-4578613', 3, '1979-07-28', NULL),
(5, 'CEPEDA', 'LILIANA INES', 1, 6841180, '41 Nº 576 1/2 E/ 6Y7', 72, '27068411802', '', '2010-04-29', '0221-4272409', 3, '1942-01-20', NULL),
(6, 'AGUILERA', 'NORMA ESTHER', 1, 18484367, 'PASAJE LA GLORIETA Nº 555', 79, '27184843671', '', '2010-05-03', '02268-491106', 3, '2005-06-20', NULL),
(7, 'QUIÑONES', 'MARTA OFELIA', 1, 5972836, 'HIPOLITO YRIGOYEN Nº 14', 48, '27059728364', '', '2010-05-07', '02268-491106', 1, '1949-02-12', NULL),
(8, 'BARRAGUE', 'MARIA CLAUDIA', 1, 18333269, '152 Nº 1878 E/ 70 Y 71', 72, '23183332694', '', '2010-05-07', '0221-4503417', 1, '1966-03-28', NULL),
(9, 'VALENTI', 'LEONARDO DANIEL', 1, 29403992, '145 Nº 1727 E/ 67 Y 68', 72, '23294039929', '', '2010-05-10', '0221-4506796', 3, '1982-05-25', NULL),
(10, 'BATH', 'LEONARDO RAFAEL', 1, 26428612, 'MITRE 612 E/ BELGICA Y PJE LAVALLE', 72, '20264286124', '', '2010-05-11', '0221-4601189', 1, '1978-01-17', NULL),
(11, 'VEGA', 'SILVIA LEANDRA', 1, 24074178, '37 Nº 1911 E/ 133 Y 134', 72, '20240741785', '', '2010-05-13', '0221-4793847', 3, '1975-01-10', NULL),
(12, 'RODA', 'JULIA NORMA', 1, 18693974, 'GENOVA 132', 72, '27186939749', '', '2010-05-14', '011-44500874', 3, '1966-11-07', NULL),
(13, 'CIMINO', 'HUGO DOMINGO', 1, 8349233, '603 Nº 512 E/ 5 Y 6', 72, '20083492334', '', '2010-05-14', '0221-4869680', 1, '1946-08-09', NULL),
(14, 'MARTINEZ ROCCA', 'ANA MARIA', 1, 6216867, '441 S/Nº E/ 136 Y 137', 72, '27062168671', '', '2010-05-14', '0221-4742822', 1, '1949-10-30', NULL),
(15, 'CITARELLI', 'SILVIA ANAHI', 1, 18212627, '209 S/N E/ 519 Y 519 BIS', 72, '27182126271', '', '2010-05-17', '0221-4917898', 1, '1967-01-15', NULL),
(16, 'SCUFFI', 'EDGARDO ENRIQUE', 1, 10753506, 'L N ALEM 179', 72, '20107535064', '', '2010-05-17', '02268-491176/491078', 1, '1953-01-23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
  `contrato_id` int(11) NOT NULL,
  `contrato_bibliorato` varchar(50) NOT NULL,
  `contrato_caja_numero` varchar(50) NOT NULL,
  `contrato_cliente_id` int(11) NOT NULL,
  `contrato_fecha` date NOT NULL,
  `contrato_monto` double(20,2) NOT NULL,
  `contrato_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota`
--

CREATE TABLE IF NOT EXISTS `cuota` (
  `cuota_id` int(11) NOT NULL,
  `cuota_descripcion` varchar(200) NOT NULL,
  `cuota_fecha_vencimiento` datetime NOT NULL,
  `cuota_monto` float NOT NULL,
  `cuota_numero` int(11) NOT NULL,
  `cuota_porcentaje_recargo` float NOT NULL,
  `cuota_unidad_funcional_id` int(11) NOT NULL,
  `cuota_movimiento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad_obrero`
--

CREATE TABLE IF NOT EXISTS `especialidad_obrero` (
  `especialidad_obrero_id` int(11) NOT NULL,
  `especialidad_obrero_descripcion` varchar(200) NOT NULL,
  `especialidad_obrero_nombre` varchar(45) NOT NULL,
  `especialidad_obrero_sueldo_basico` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad_proveedor`
--

CREATE TABLE IF NOT EXISTS `especialidad_proveedor` (
  `especialidad_proveedor_id` int(11) NOT NULL,
  `especialidad_proveedor_descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `estado_id` int(11) NOT NULL,
  `estado_descripcion` varchar(200) NOT NULL,
  `estado_baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`estado_id`, `estado_descripcion`, `estado_baja`) VALUES
(1, 'Activo', 0),
(2, 'Inactivo', 0),
(3, 'Ejecutado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_civil`
--

CREATE TABLE IF NOT EXISTS `estado_civil` (
  `estado_civil_id` int(11) NOT NULL,
  `estado_civil_nombre` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_civil`
--

INSERT INTO `estado_civil` (`estado_civil_id`, `estado_civil_nombre`) VALUES
(1, 'Soltero'),
(2, 'Casado'),
(3, 'Separado'),
(4, 'Divorciado'),
(5, 'Viudo'),
(6, 'Unidad de hecho'),
(7, 'Union Civil'),
(8, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cliente`
--

CREATE TABLE IF NOT EXISTS `estado_cliente` (
  `estado_id` int(11) NOT NULL,
  `estado_descripcion` varchar(200) NOT NULL,
  `estado_baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_cliente`
--

INSERT INTO `estado_cliente` (`estado_id`, `estado_descripcion`, `estado_baja`) VALUES
(1, 'Activo', 0),
(2, 'Inactivo', 0),
(3, 'Ejecutado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_herramienta`
--

CREATE TABLE IF NOT EXISTS `estado_herramienta` (
  `estado_herramienta_id` int(11) NOT NULL,
  `estado_herramienta_descripcion` varchar(200) NOT NULL,
  `estado_herramienta_nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido_compra`
--

CREATE TABLE IF NOT EXISTS `estado_pedido_compra` (
  `estado_pedido_compra_id` int(11) NOT NULL,
  `estado_pedido_compra_descripcion` varchar(50) NOT NULL,
  `estado_pedido_compra_baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_uf`
--

CREATE TABLE IF NOT EXISTS `estado_uf` (
  `estado_uf_id` int(11) NOT NULL,
  `estado_uf_descripcion` varchar(50) NOT NULL,
  `estado_uf_baja` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_uf`
--

INSERT INTO `estado_uf` (`estado_uf_id`, `estado_uf_descripcion`, `estado_uf_baja`) VALUES
(1, 'Libre', 0),
(2, 'Ocupado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudio_alcanzado`
--

CREATE TABLE IF NOT EXISTS `estudio_alcanzado` (
  `estudio_id` int(11) NOT NULL,
  `estudio_nombre` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudio_alcanzado`
--

INSERT INTO `estudio_alcanzado` (`estudio_id`, `estudio_nombre`) VALUES
(1, 'S/E'),
(2, 'Primario'),
(3, 'Secundario'),
(4, 'Terciario'),
(5, 'Universitario'),
(6, 'Posgrado'),
(7, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `factura_id` int(11) NOT NULL,
  `factura_fecha_generacion` date NOT NULL,
  `factura_fecha_vencimiento` date NOT NULL,
  `factura_numero` int(11) NOT NULL,
  `factura_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE IF NOT EXISTS `factura_detalle` (
  `factura_detalle_id` int(11) NOT NULL,
  `factura_detalle_cantidad` int(11) NOT NULL,
  `factura_detalle_monto` float NOT NULL,
  `factura_detalle_material_id` int(11) NOT NULL,
  `factura_detalle_factura_id` int(11) NOT NULL,
  `factura_detalle_factura_proveedor_id` int(11) NOT NULL,
  `factura_detalle_movimiento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_proveedor`
--

CREATE TABLE IF NOT EXISTS `factura_proveedor` (
  `factura_proveedor_id` int(11) NOT NULL,
  `factura_proveedor_fecha` datetime NOT NULL,
  `factura_proveedor_numero` int(11) NOT NULL,
  `factura_proveedor_proveedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta`
--

CREATE TABLE IF NOT EXISTS `herramienta` (
  `herramienta_id` int(11) NOT NULL,
  `herramienta_descripcion` varchar(200) NOT NULL,
  `herramienta_nombre` varchar(45) NOT NULL,
  `herramienta_estado_herramienta_id` int(11) NOT NULL,
  `herramienta_obra_yeseria_id` int(11) DEFAULT NULL,
  `herramienta_obra_civil_id` int(11) DEFAULT NULL,
  `herramienta_fecha_compra` date NOT NULL,
  `herramienta_fecha_ultima_reparacion` date NOT NULL,
  `herramienta_codigo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hito`
--

CREATE TABLE IF NOT EXISTS `hito` (
  `hito_id` int(11) NOT NULL,
  `hito_nombre` varchar(45) NOT NULL,
  `hito_plazo_estimado_dias` int(11) NOT NULL,
  `hito_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hito`
--

INSERT INTO `hito` (`hito_id`, `hito_nombre`, `hito_plazo_estimado_dias`, `hito_estado`) VALUES
(1, 'Hito 1', 13, 1),
(2, 'Hito 2', 18, 1),
(3, 'Hito 3', 15, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE IF NOT EXISTS `licencia` (
  `licencia_id` int(11) NOT NULL,
  `licencia_fecha_comienzo` datetime NOT NULL,
  `licencia_fecha_fin` datetime NOT NULL,
  `licencia_nota` varchar(200) NOT NULL,
  `licencia_path_certificado` varchar(45) NOT NULL,
  `licencia_tipo_licencia` int(11) NOT NULL,
  `licencia_obrero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE IF NOT EXISTS `localidad` (
  `localidad_id` int(11) NOT NULL,
  `localidad_nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`localidad_id`, `localidad_nombre`) VALUES
(1, 'ALMIRANTE BROWN'),
(2, 'ADOLFO ALSINA'),
(3, 'ALBERTI'),
(4, 'AVELLANEDA'),
(5, 'AYACUCHO'),
(6, 'AZUL'),
(7, 'BARADERO'),
(8, 'BAHIA BLANCA'),
(9, 'BERISSO'),
(10, 'JUAREZ'),
(11, 'BALCARCE'),
(12, 'BOLIVAR'),
(13, 'BRAGADO'),
(14, 'ARRECIFES'),
(15, 'BERAZATEGUI'),
(16, 'CAMPANA'),
(17, 'CORONEL BRANDSEN'),
(18, 'CHACABUCO'),
(19, 'CORONEL DORREGO'),
(20, 'CARLOS CASARES'),
(21, 'CAPITAL FEDERAL'),
(22, 'CHIVILCOY'),
(23, 'CARLOS TEJEDOR'),
(24, 'CORONEL ROSALES'),
(25, 'CAÑUELAS'),
(26, 'COLON'),
(27, 'CORONEL PRINGLES'),
(28, 'CARMEN DE ARECO'),
(29, 'CAPITAN SARMIENTO'),
(30, 'CASTELLI'),
(31, 'CHASCOMUS'),
(32, 'CORONEL SUAREZ'),
(33, 'DAIREAUX'),
(34, 'DE LA COSTA -SAN CLEMENTE'),
(35, 'DOLORES'),
(36, 'ESTEBAN ECHEVERRIA'),
(37, 'ENSENADA'),
(38, 'ESCOBAR'),
(39, 'EXALTACION DE LA CRUZ'),
(40, 'EZEIZA'),
(41, 'FLORENTINO AMEGHINO'),
(42, 'FLORENCIO VARELA'),
(43, 'GENERAL ALVEAR'),
(44, 'GENERAL BELGRANO'),
(45, 'GENERAL LAMADRID'),
(46, 'GENERAL ALVARADO'),
(47, 'GREGORIO DE LAFERRERE'),
(48, 'GENERAL GUIDO'),
(49, 'GENERAL LAS HERAS'),
(50, 'GENERAL VILLEGAS'),
(51, 'GENERAL LAVALLE'),
(52, 'GENERAL MADARIAGA'),
(53, 'GENERAL ARENALES'),
(54, 'GONZALEZ CHAVEZ'),
(55, 'GENERAL PINTO'),
(56, 'GENERAL RODRIGUEZ'),
(57, 'GENERAL SARMIENTO'),
(58, 'GUAMINI'),
(59, 'GENERAL VIAMONTE'),
(60, 'GENERAL PAZ'),
(61, 'HURLINGHAM'),
(62, 'HIPOLITO YRIGOYEN-HENDERSON'),
(63, 'ITUZAINGO'),
(64, 'JUNIN'),
(65, 'LANUS'),
(66, 'LOBERIA'),
(67, 'LAS FLORES'),
(68, 'LINCOLN'),
(69, 'SAN JUSTO'),
(70, 'LEANDRO N. ALEM'),
(71, 'LOBOS'),
(72, 'LA PLATA'),
(73, 'LAPRIDA'),
(74, 'LUJAN'),
(75, 'LOMAS DE ZAMORA'),
(76, 'MAGDALENA'),
(77, 'MERCEDES'),
(78, 'MONTE HERMOSO'),
(79, 'MAIPU'),
(80, 'MERLO'),
(81, 'MONTE'),
(82, 'MORON'),
(83, 'MAR DEL PLATA'),
(84, 'MAR CHIQUITA'),
(85, 'MORENO'),
(86, 'MALVINAS ARGENTINAS'),
(87, 'MARCOS PAZ'),
(88, 'NAVARRO'),
(89, 'NECOCHEA'),
(90, 'NUEVE DE JULIO'),
(91, 'OLAVARRIA'),
(92, 'LOCALIDAD DE OTRAS PROVINCIAS'),
(93, 'CARMEN DE PATAGONES'),
(94, 'PERGAMINO'),
(95, 'PELLEGRINI'),
(96, 'PEHUAJO'),
(97, 'PILA'),
(98, 'PILAR'),
(99, 'PINAMAR'),
(100, 'PUAN'),
(101, 'QUILMES'),
(102, 'RAMALLO'),
(103, 'RIVADAVIA'),
(104, 'ROJAS'),
(105, 'ROQUE PEREZ'),
(106, 'RAUCH'),
(107, 'SALADILLO'),
(108, 'SAAVEDRA'),
(109, 'SAN CAYETANO'),
(110, 'SAN FERNANDO'),
(111, 'SAN ANDRES DE GILES'),
(112, 'SAN ISIDRO'),
(113, 'SALTO'),
(114, 'SAN MARTIN'),
(115, 'SAN NICOLAS'),
(116, 'SUIPACHA'),
(117, 'SALLIQUELO'),
(118, 'SAN PEDRO'),
(119, 'SAN ANTONIO DE ARECO'),
(120, 'SAN MIGUEL'),
(121, 'SAN VICENTE'),
(122, 'TAPALQUE'),
(123, 'TRES DE FEBRERO-CASEROS'),
(124, 'TIGRE'),
(125, 'TRENQUE LAUQUEN'),
(126, 'TANDIL'),
(127, 'TORDILLO-GENERAL CONESA'),
(128, 'TORNQUIST'),
(129, 'TRES LOMAS'),
(130, 'TRES ARROYOS'),
(131, 'VEINTICINCO DE MAYO'),
(132, 'VILLA GESELL'),
(133, 'VILLARINO'),
(134, 'VICENTE LOPEZ'),
(135, 'ZARATE'),
(136, 'JOSE C. PAZ'),
(137, 'MONTE GRANDE'),
(138, 'PRESIDENTE PERON-GUERNICA'),
(139, 'PUNTA INDIO'),
(140, 'ISIDRO CASANOVA'),
(141, 'PUNTA ALTA'),
(142, 'OTRA LOCALIDAD DE LA PROVINCIA'),
(143, 'ADROGUE'),
(144, 'AEROPUERTO EZEIZA'),
(145, 'AGUSTIN ROCA'),
(146, 'ALASTUEY'),
(147, 'ALDO BONZI'),
(148, 'ALEJANDRO KORN'),
(149, 'ALFONSO'),
(150, 'ALGARROBO'),
(151, 'ALSINA'),
(152, 'ALVAREZ DE TOLEDO'),
(153, 'ALVAREZ JONTE'),
(154, 'AMERICA'),
(155, 'ANGEL ETCHEVERRY'),
(156, 'ANTONIO CARBONI'),
(157, 'ARANA'),
(158, 'ARBOLEDAS'),
(159, 'ARENAZA'),
(160, 'ARGERICH'),
(161, 'ARIEL'),
(162, 'ARISTOBULO DEL VALLE'),
(163, 'ARRIBE¾OS'),
(164, 'ARROYO CORTO'),
(165, 'ARROYO DULCE'),
(166, 'ARROYO VENADO'),
(167, 'ARTURO SEGUI'),
(168, 'ASCENSION'),
(169, 'ATALAYA'),
(170, 'ATUCHA'),
(171, 'AZCUENAGA'),
(172, 'AZOPARDO'),
(173, 'BAHIA SAN BLAS'),
(174, 'BAIGORRITA'),
(175, 'BAJO HONDO'),
(176, 'BANCALARI'),
(177, 'BANDERALO'),
(178, 'BANFIELD'),
(179, 'BARRIO BCO. PCIA.'),
(180, 'BARRIO EL CARMEN'),
(181, 'BARRIO MARITIMO'),
(182, 'BARRIO TALLERES'),
(183, 'BARTOLOME BAVIO'),
(184, 'BATAN'),
(185, 'BAYAUCA'),
(186, 'BECCAR'),
(187, 'BELLA VISTA'),
(188, 'BELLOCQ'),
(189, 'BENAVIDEZ'),
(190, 'BERNAL'),
(191, 'BERUTTI'),
(192, 'BILLINGHURST'),
(193, 'BLAQUIER'),
(194, 'BO. C. SALLES'),
(195, 'BO. CASTELLI'),
(196, 'BO. GRAL. MOSCONI'),
(197, 'BO. LA FLORIDA'),
(198, 'BO. LAS MELLIZAS'),
(199, 'BO. MORENO'),
(200, 'BO. SAN JORGE'),
(201, 'BO. SAN MARTIN'),
(202, 'BO. SANDRINA'),
(203, 'BO. STA. TERESITA'),
(204, 'BO. SUIZO'),
(205, 'BO. YAGUARON'),
(206, 'BOCAYUVA'),
(207, 'BORDENAVE'),
(208, 'BOSQUES'),
(209, 'BOULOGNE'),
(210, 'BURZACO'),
(211, 'CABILDO'),
(212, 'CACHARI'),
(213, 'CADRET'),
(214, 'CANNING'),
(215, 'CAPILLA DEL SE¾OR'),
(216, 'CAPITAN CASTRO'),
(217, 'CARABELAS'),
(218, 'CARAPACHAY'),
(219, 'CARDENAL CAGLIERO'),
(220, 'CARHUE'),
(221, 'CARILO'),
(222, 'CARLOS BEGUERIE'),
(223, 'CARLOS KEEN'),
(224, 'CARLOS M. NAON'),
(225, 'CARLOS SALAS'),
(226, 'CARLOS SPEGAZZINI'),
(227, 'CARLOS T. SOURIGUES'),
(228, 'CASBAS'),
(229, 'CASCADA'),
(230, 'CASTELAR'),
(231, 'CAZON'),
(232, 'CERNADAS'),
(233, 'CHAPADMALAL'),
(234, 'CHASICO'),
(235, 'CHILAVERT'),
(236, 'CHILLAR'),
(237, 'CHURRUCA'),
(238, 'CITY BELL'),
(239, 'CIUDAD EVITA'),
(240, 'CIUDADELA'),
(241, 'CLARAZ'),
(242, 'CLAROMECO'),
(243, 'CLAYPOLE'),
(244, 'COBO'),
(245, 'COLONIA HINOJO'),
(246, 'COLONIA LA CAPILLA'),
(247, 'COLONIA MAURICIO'),
(248, 'COLONIA NIEVE'),
(249, 'COLONIA SAN MARTIN'),
(250, 'COLONIA SAN MIGUEL'),
(251, 'COLONIA SAN PEDRO'),
(252, 'COLONIA SERE'),
(253, 'COMANDANTE OTAMENDI'),
(254, 'COMODORO PY'),
(255, 'CONESA'),
(256, 'COPETONAS'),
(257, 'CORONEL BOERR'),
(258, 'CORONEL VIDAL'),
(259, 'CORTINES'),
(260, 'COSTA DEL ESTE'),
(261, 'CROTTO'),
(262, 'CRUCECITA'),
(263, 'CUCULLU'),
(264, 'CURA MALAL'),
(265, 'CURARU'),
(266, 'DARREGUEIRA'),
(267, 'DE BARY'),
(268, 'DE LA CANAL'),
(269, 'DE LA GARMA'),
(270, 'DEL CARRIL'),
(271, 'DEL VISO'),
(272, 'DELFIN HUERGO'),
(273, 'DENNEHY'),
(274, 'DIECISEIS DE JULIO'),
(275, 'VILLA DORREGO'),
(276, 'DIEGO GAYNOR'),
(277, 'DIQUE LUJAN'),
(278, 'DOCE DE OCTUBRE'),
(279, 'DOCK SUD'),
(280, 'DOMSELAAR'),
(281, 'DON BOSCO'),
(282, 'DON TORCUATO'),
(283, 'DOYLE'),
(284, 'DUDIGNAC'),
(285, 'DUFAUR'),
(286, 'DUGGAN'),
(287, 'E. S. ZEBALLOS'),
(288, 'EL CARMEN'),
(289, 'EL DIQUE'),
(290, 'EL DIVISORIO'),
(291, 'EL JAGsEL'),
(292, 'EL LIBERTADOR'),
(293, 'EL PALOMAR'),
(295, 'EL PARAISO'),
(296, 'EL PATO'),
(297, 'EL PENSAMIENTO'),
(298, 'EL PORVENIR'),
(299, 'EL TALAR DE PACHECO'),
(300, 'EL TRIGO'),
(301, 'EL TRIUNFO'),
(302, 'ELVIRA'),
(303, 'EMILIO AYARZA'),
(304, 'EMILIO BUNGE'),
(305, 'ENERGIA'),
(306, 'ESPARTILLAR'),
(307, 'ESQUINA DE CROTTO'),
(308, 'ESTACION LAZZARINO'),
(309, 'ESTRUGAMOU'),
(310, 'EZPELETA'),
(311, 'FATIMA'),
(312, 'FELIPE SOLA'),
(313, 'FERNANDO MARTI'),
(314, 'FERRE'),
(315, 'FLORIDA'),
(316, 'FORTIN ACHA'),
(317, 'FORTIN OLAVARRIA'),
(318, 'FORTIN TIBURCIO'),
(319, 'FRANCISCO ALVAREZ'),
(320, 'FRANCISCO MAGNANO'),
(321, 'FRANKLIN'),
(322, 'FULTON'),
(323, 'GAHAN'),
(324, 'GAMBIER'),
(325, 'GANDARA'),
(326, 'GARDEY'),
(327, 'GARIN'),
(328, 'GARRE'),
(329, 'GDOR. MONTEVERDE'),
(330, 'GENERAL CERRI'),
(331, 'GENERAL HORNOS'),
(332, 'GENERAL MANSILLA'),
(333, 'GENERAL O''BRIEN'),
(334, 'GENERAL PACHECO'),
(335, 'GENERAL PIRAN'),
(336, 'GERLI'),
(337, 'GERMANIA'),
(338, 'GIRODIAS'),
(339, 'GLEW'),
(340, 'GOBERNADOR CASTRO'),
(341, 'GOBERNADOR J.COSTA'),
(342, 'GOBERNADOR UDAONDO'),
(343, 'GOLDNEY'),
(344, 'GONZALEZ CATAN'),
(345, 'GONZALEZ MORENO'),
(346, 'GOROSTIAGA'),
(347, 'GOUIN'),
(348, 'GOWLAND'),
(349, 'GOYENA'),
(350, 'GRAND BOURG'),
(351, 'GRUNBEIN'),
(352, 'GUERRERO'),
(353, 'GUERRICO'),
(354, 'GUILLERMO E HUDSON'),
(355, 'HAEDO'),
(356, 'HALE'),
(357, 'HILARIO ASCASUBI'),
(358, 'HORTENSIA'),
(359, 'HUANGUELEN'),
(360, 'IGNACIO CORREA'),
(361, 'INDIO RICO'),
(362, 'INES INDART'),
(363, 'ING. JUAN ALLAN'),
(364, 'ING.PABLO NOGUES'),
(365, 'INGENIERO BUDGE'),
(366, 'INGENIERO MASCHWITZ'),
(367, 'INGENIERO MONETA'),
(368, 'INGENIERO THOMPSON'),
(369, 'INGENIERO WHITE'),
(370, 'IRALA'),
(371, 'IRAOLA'),
(372, 'IRINEO PORTELA'),
(373, 'ISLA LOS LAURELES'),
(374, 'ISLA MACIEL'),
(375, 'ISLA MARTIN GARCIA'),
(376, 'J. J. ALMEYRA'),
(377, 'JAUREGUI'),
(378, 'JEPPENNER'),
(379, 'JOAQUIN GORINA'),
(380, 'JOSE B. CASA'),
(381, 'JOSE HERNANDEZ'),
(382, 'JOSE INGENIEROS'),
(383, 'JOSE LEON SUAREZ'),
(384, 'JUAN A. DE LA PENA'),
(385, 'JUAN A. PRADERE'),
(386, 'JUAN B. ALBERDI'),
(387, 'JUAN BLAQUIER'),
(388, 'JUAN E. BARRA'),
(389, 'JUAN JOSE PASO'),
(390, 'JUAN M. GUTIERREZ'),
(391, 'JUAN N. FERNANDEZ'),
(392, 'LA ANGELITA'),
(393, 'LA AZUCENA'),
(394, 'LA BEBA'),
(395, 'LA CARRETA'),
(396, 'LA CHOZA'),
(397, 'LA COLINA'),
(398, 'LA DULCE'),
(399, 'LA EMILIA'),
(400, 'LA GRANJA'),
(401, 'LA LIMPIA'),
(402, 'LA LONJA'),
(403, 'LA LUCILA'),
(404, 'LA LUCILA DEL MAR'),
(405, 'LA LUISA'),
(406, 'LA PASTORA'),
(407, 'LA REJA'),
(408, 'LA RICA'),
(409, 'LA SALADA'),
(410, 'LA SOFIA'),
(411, 'LA TABLADA'),
(412, 'LA TRINIDAD'),
(413, 'LA VERDE'),
(414, 'LA VIOLETA'),
(415, 'LABARDEN'),
(416, 'LAGO EPECUEN'),
(417, 'LAGUNA ALSINA'),
(418, 'LANUS ESTE'),
(419, 'LANUS OESTE'),
(420, 'LAPLACETTE'),
(421, 'LARTIGAU'),
(422, 'LAS ARMAS'),
(423, 'LAS BAHAMAS'),
(424, 'LAS HERAS'),
(425, 'LAS MARIANAS'),
(426, 'LAS MARTINETAS'),
(427, 'LAS QUINTAS'),
(428, 'LAS TONINAS'),
(429, 'LEUBUCO'),
(430, 'LEZAMA'),
(431, 'LEZICA Y TORREZURI'),
(432, 'LIBANO'),
(433, 'LIBERTAD'),
(434, 'LIC. MATIENZO'),
(435, 'LIMA'),
(436, 'LIN-CALEL'),
(437, 'LISANDRO OLMOS'),
(438, 'LLAVALLOL'),
(439, 'LOMA HERMOSA'),
(440, 'LOMA VERDE'),
(441, 'LOMAS DEL MIRADOR'),
(442, 'LONGCHAMPS'),
(443, 'LOPEZ'),
(444, 'LOPEZ LECUBE'),
(445, 'LOS CARDALES'),
(446, 'LOS HORNOS'),
(447, 'LOS INDIOS'),
(448, 'LOS PINOS'),
(449, 'LOS TALAS'),
(450, 'LOS TOLDOS'),
(451, 'LUIS GUILLON'),
(452, 'MAGDALA'),
(453, 'MALAVER'),
(454, 'MANUEL B GONNET'),
(455, 'MANUEL J. GARCIA'),
(456, 'MANUEL JOSE COBO'),
(457, 'MANUEL OCAMPO'),
(458, 'MANZANARES'),
(459, 'MANZONE'),
(460, 'MAQUINISTA SAVIO'),
(461, 'MAR AZUL'),
(462, 'MAR DE AJO'),
(463, 'MAR DEL SUR'),
(464, 'MAR DEL TUYU'),
(465, 'MARIA IGNACIA'),
(466, 'MARIANO ACOSTA'),
(467, 'MARIANO BENITEZ'),
(468, 'MARMOL'),
(469, 'MARTIN CORONADO'),
(470, 'MARTINEZ'),
(471, 'MASCOTAS'),
(472, 'MATHEU'),
(473, 'MAURICIO HIRSH'),
(474, 'MAXIMO PAZ'),
(475, 'MAYOR BURATOVICH'),
(476, 'MAZA'),
(477, 'MECHITA'),
(478, 'MECHONGUE'),
(479, 'MEDANOS'),
(480, 'MELCHOR ROMERO'),
(481, 'MIGUELETE'),
(482, 'MIRA PAMPA'),
(483, 'MILBERG'),
(484, 'MIRAMAR'),
(485, 'MOCTEZUMA'),
(486, 'MOLL'),
(487, 'MONES CAZON'),
(488, 'MONTE CHINGOLO'),
(489, 'MOQUEHUA'),
(490, 'MOREA'),
(491, 'MORSE'),
(492, 'MU¾IZ'),
(493, 'MUNRO'),
(494, 'NAPALEOFU'),
(495, 'NORUMBEGA'),
(496, 'NUEVA PLATA'),
(497, 'O''HIGGINS'),
(498, 'OLASCOAGA'),
(499, 'OLIVERA'),
(500, 'OLIVOS'),
(501, 'OPEN DOOR'),
(502, 'ORDOQUI'),
(503, 'ORENSE'),
(504, 'ORIENTE'),
(505, 'ORTIZ BASUALDO'),
(506, 'OSTENDE'),
(507, 'PABLO PODESTA'),
(508, 'PARANA MINI'),
(509, 'PARDO'),
(510, 'PARQUE CAMET'),
(511, 'PARQUE LELOIR'),
(512, 'PARQUE SAN MARTIN'),
(513, 'PASMAN'),
(514, 'PASO DEL REY'),
(515, 'PASTEUR'),
(516, 'PATRICIOS'),
(517, 'PAVON'),
(518, 'PEARSON'),
(519, 'PEDRO LURO'),
(520, 'PEHUEN CO'),
(521, 'PEREYRA'),
(522, 'PEREZ MILLAN'),
(523, 'PICHINCHA'),
(524, 'PIEDRITAS'),
(525, 'PIERES'),
(526, 'PIGsE'),
(527, 'PINEYRO'),
(528, 'PIPINAS'),
(529, 'PIROVANO'),
(530, 'PLA'),
(531, 'PLATANOS'),
(532, 'PLOMER'),
(533, 'PONTAUT'),
(534, 'PONTEVEDRA'),
(535, 'PRESIDENTE DERQUI'),
(536, 'PUEBLO SAN JOSE'),
(537, 'PUNTA LARA'),
(538, 'PUNTA MOGOTES'),
(539, 'QUENUMA'),
(540, 'QUEQUEN'),
(541, 'QUILMES OESTE'),
(542, 'R. DE ESCALADA'),
(543, 'RAFAEL CALZADA'),
(544, 'RAFAEL CASTILLO'),
(545, 'RAFAEL OBLIGADO'),
(546, 'RAMON BIAUS'),
(547, 'RAMON SANTAMARINA'),
(548, 'RAMOS MEJIA'),
(549, 'RAMOS OTERO'),
(550, 'RANCAGUA'),
(551, 'RANCHOS'),
(552, 'RANELAGH'),
(553, 'RAWSON'),
(554, 'RECALDE'),
(555, 'RETA'),
(556, 'RICARDO ROJAS'),
(557, 'RINGUELET'),
(558, 'RIO SANTIAGO'),
(559, 'RIO TALA'),
(560, 'RIVAS'),
(561, 'RIVERA'),
(562, 'ROBERTO CANO'),
(563, 'ROOSEVELT'),
(564, 'S.F.DE BELLOCQ'),
(565, 'SAENZ PE¾A'),
(566, 'SAFORCADA'),
(567, 'SALAZAR'),
(568, 'ROBERTS'),
(569, 'SALDUNGARAY'),
(570, 'SALVADOR MARIA'),
(571, 'SAN A. DE PADUA'),
(572, 'SAN AGUSTIN'),
(573, 'SAN ALBERTO'),
(574, 'SAN ANDRES'),
(575, 'SAN BERNARDO'),
(576, 'SAN CARLOS'),
(577, 'SAN CLEMENTE DEL TUYU'),
(578, 'SAN ELADIO'),
(579, 'SAN EMILIO'),
(580, 'SAN FRANCISCO SOLANO'),
(581, 'SAN GERMAN'),
(582, 'SAN JORGE'),
(583, 'SAN MANUEL'),
(584, 'SAN MAURICIO'),
(585, 'SAN MAYOL'),
(586, 'SAN MIGUEL ARCANGEL'),
(587, 'SAN SEBASTIAN'),
(588, 'SANSINENA'),
(589, 'SANTA CLARA DEL MAR'),
(590, 'SANTA COLOMA'),
(591, 'SANTA LUCIA'),
(592, 'SANTA MARIA'),
(593, 'SANTA REGINA'),
(594, 'SANTA TERESITA'),
(595, 'SANTAMARINA'),
(596, 'SANTO DOMINGO'),
(597, 'SANTOS LUGARES'),
(598, 'SANTOS TESEI'),
(599, 'SARANDI'),
(600, 'SEVIGNE'),
(601, 'SIERRA CHICA'),
(602, 'SIERRA DE LA VENTANA'),
(603, 'SIERRA DE LOS PADRES'),
(604, 'SIERRAS BAYAS'),
(605, 'SMITH'),
(606, 'SOLIS'),
(607, 'STROEDER'),
(608, 'SUNDBLAD'),
(609, 'TAMANGUEYU'),
(610, 'TAPIALES'),
(611, 'TEDIN URIBURU'),
(612, 'TEMPERLEY'),
(613, 'TENIENTE ORIGONE'),
(614, 'TIMOTE'),
(615, 'TODD'),
(616, 'TOLOSA'),
(617, 'TOMAS JOFRE'),
(619, 'TORRES'),
(620, 'TORTUGUITAS'),
(621, 'TRES ALGARROBOS'),
(622, 'TRES PICOS'),
(623, 'TRES SARGENTOS'),
(624, 'TRISTAN SUAREZ'),
(625, 'TRUJUI'),
(626, 'TURDERA'),
(627, 'UNION FERROVIARIA'),
(628, 'URDAMPILLETA'),
(629, 'URIBELARREA'),
(630, 'VILLA CIUDAD JARDIN'),
(631, 'VILLA HARDING GREEN'),
(632, 'VILLA J. N. PUEYRREDON'),
(633, 'VILLA CAMPI'),
(634, 'VILLA CANTO'),
(635, 'VILLA ESPERANZA'),
(636, 'VILLA HERMOSA'),
(637, 'VILLA RICCIO'),
(638, 'VALENTIN ALSINA'),
(639, 'VALERIA DEL MAR'),
(640, 'VASQUEZ'),
(641, 'VEINTE DE JUNIO'),
(642, 'VELLOSO'),
(643, 'VERONICA'),
(644, 'VICENTE CASARES'),
(645, 'VICTORIA'),
(646, 'VIEYTES'),
(647, 'VILLA ADELINA'),
(648, 'VILLA ADRIANA'),
(649, 'VILLA ARGUELLO'),
(650, 'VILLA BALLESTER'),
(651, 'VILLA BOSCH'),
(652, 'VILLA BROWN'),
(653, 'VILLA CACIQUE'),
(654, 'VILLA CATELLA'),
(655, 'VILLA CELINA'),
(656, 'VILLA DEL MAR'),
(657, 'VILLA DOLORES'),
(658, 'VILLA DOMINICO'),
(659, 'VILLA ECHENAGUCIA'),
(660, 'VILLA ELISA'),
(661, 'VILLA ELVIRA'),
(662, 'VILLA ESPA¾A'),
(663, 'VILLA ESPIL'),
(664, 'VILLA FLANDRIA'),
(665, 'VILLA FORTABAT'),
(666, 'VILLA FRANCIA'),
(667, 'VILLA GIAMBRUNO'),
(668, 'VILLA GRAL. ARIAS'),
(669, 'VILLA INSUPERABLE'),
(670, 'VILLA IRIS'),
(671, 'VILLA LIA'),
(672, 'VILLA LIBERTAD'),
(673, 'VILLA LUZURIAGA'),
(674, 'VILLA LYNCH'),
(675, 'VILLA MADERO'),
(676, 'VILLA MAIPU'),
(677, 'VILLA MARGARITA'),
(678, 'VILLA MARTELLI'),
(679, 'VILLA MONTORO'),
(680, 'VILLA MOQUEHUA'),
(681, 'VILLA NUMANCIA'),
(682, 'VILLA ORTIZ'),
(683, 'VILLA PORTE¾A'),
(684, 'VILLA RAFFO'),
(685, 'VILLA RAMALLO'),
(686, 'VILLA REBASA'),
(687, 'VILLA RECONDO'),
(688, 'VILLA ROSA'),
(689, 'VILLA RUIZ'),
(690, 'VILLA SABOYA'),
(691, 'VILLA SAN CARLOS'),
(692, 'VILLA SAN LUIS'),
(693, 'VILLA SANTA ROSA'),
(694, 'VILLA SARMIENTO'),
(695, 'VILLA SAUCE'),
(696, 'VILLA VATTEONE'),
(697, 'VILLA ZULA'),
(698, 'VILLALONGA'),
(699, 'VILLANUEVA'),
(700, 'VILLARS'),
(701, 'VIÑA'),
(702, 'VIRREY DEL PINO'),
(703, 'VIRREYES'),
(704, 'VIVORATA'),
(705, 'VUELTA OBLIGADO'),
(706, 'WARNES'),
(707, 'WILDE'),
(708, 'WILLIAM MORRIS'),
(709, 'ZAVALIA'),
(710, 'ZELAYA'),
(711, 'ZENON VIDELA DORNA'),
(712, '11 DE SEPTIEMBRE'),
(713, '30 DE AGOSTO'),
(714, '9 DE ABRIL'),
(715, 'ABASTO'),
(716, 'ABBOTT'),
(717, 'ACASSUSO'),
(718, 'ACEVEDO'),
(719, 'ADELA'),
(720, 'SAN JACINTO'),
(721, 'CASEROS'),
(722, 'LOS POLVORINES'),
(723, 'LA FERRERE'),
(724, 'SOLANO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad-`
--

CREATE TABLE IF NOT EXISTS `localidad-` (
  `localidad_id` int(4) NOT NULL,
  `localidad_nombre` varchar(60) NOT NULL,
  `cpostal` int(4) NOT NULL,
  `provincia_id` smallint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_ingreso`
--

CREATE TABLE IF NOT EXISTS `log_ingreso` (
  `loging_id` int(11) NOT NULL,
  `loging_usua_id` int(11) NOT NULL,
  `loging_app_id` int(11) NOT NULL,
  `loging_fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `material_id` int(11) NOT NULL,
  `material_nombre` varchar(45) NOT NULL,
  `material_descripcion` varchar(200) NOT NULL,
  `material_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `mod_id` int(11) NOT NULL,
  `mod_app_id` int(11) NOT NULL,
  `mod_nombre` varchar(45) NOT NULL,
  `mod_baja` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`mod_id`, `mod_app_id`, `mod_nombre`, `mod_baja`) VALUES
(51, 5, 'Seguridad', 0),
(52, 5, 'Inicio', 0),
(53, 5, 'Listados', 0),
(58, 5, 'Estadisticos', 1),
(60, 5, 'Obra civil', 0),
(61, 5, 'Obra yeserÃ­a', 0),
(62, 5, 'Clientes', 0),
(63, 5, 'Obreros', 0),
(64, 5, 'Configuracion', 0),
(65, 5, 'Proveedor', 0),
(66, 5, 'PaÃ±ol', 0),
(67, 5, 'Presupuesto', 0),
(68, 5, 'Cobro de cuotas', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_paginas`
--

CREATE TABLE IF NOT EXISTS `modulo_paginas` (
  `modpag_id` int(11) NOT NULL,
  `modpag_mod_id` int(11) NOT NULL,
  `modpag_scriptname` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=680 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulo_paginas`
--

INSERT INTO `modulo_paginas` (`modpag_id`, `modpag_mod_id`, `modpag_scriptname`) VALUES
(345, 51, 'aplicaciones/alta_aplicacion.php'),
(346, 51, 'aplicaciones/index.php'),
(347, 51, 'aplicaciones/modificar_aplicacion.php'),
(348, 51, 'aplicaciones/eliminar_aplicacion.php'),
(349, 51, 'areas/alta_area.php'),
(350, 51, 'areas/eliminar_area.php'),
(351, 51, 'areas/index.php'),
(352, 51, 'areas/modificar_area.php'),
(353, 51, 'modulos/alta_modulo.php'),
(354, 51, 'modulos/eliminar_modulo.php'),
(355, 51, 'modulos/index.php'),
(356, 51, 'modulos/modificar_modulo.php'),
(357, 51, 'permisos/eliminar_permiso.php'),
(358, 51, 'permisos/index.php'),
(359, 51, 'roles/alta_rol.php'),
(360, 51, 'roles/eliminar_rol.php'),
(361, 51, 'roles/index.php'),
(362, 51, 'roles/modificar_rol.php'),
(363, 51, 'seguridad/index.php'),
(364, 51, 'tipos_acceso/alta_acceso.php'),
(365, 51, 'tipos_acceso/eliminar_acceso.php'),
(366, 51, 'tipos_acceso/index.php'),
(367, 51, 'tipos_acceso/modificar_acceso.php'),
(368, 51, 'usuarios/alta_usuario.php'),
(369, 51, 'usuarios/cambiar-clave.php'),
(370, 51, 'usuarios/eliminar_usuario.php'),
(371, 51, 'usuarios/index.php'),
(372, 51, 'usuarios/modificar_usuario.php'),
(373, 51, 'usuarios_area/agregar.php'),
(374, 51, 'usuarios_area/eliminar.php'),
(375, 51, 'usuarios_area/index.php'),
(376, 51, 'usuarios_rol/agregar.php'),
(377, 51, 'usuarios_rol/eliminar.php'),
(378, 51, 'usuarios_rol/index.php'),
(379, 52, 'home/denegado.php'),
(380, 52, 'home/edit-clave.php'),
(381, 51, 'paginas/alta_pagina.php'),
(382, 51, 'paginas/eliminar_pagina.php'),
(383, 51, 'paginas/index.php'),
(384, 51, 'paginas/modificar_pagina.php'),
(385, 52, 'home/mantenimiento.php'),
(386, 52, 'home/recuperar-clave.php'),
(387, 52, 'home/resetear-clave.php'),
(608, 52, 'home/home.php'),
(609, 51, 'home/edicion.php'),
(610, 53, 'listados/index.php'),
(611, 53, 'listados/acumulado_concepto.php'),
(628, 58, 'estadistico/index.php'),
(629, 58, 'estadistico/estadistico.config'),
(631, 53, 'listados/empleados.php'),
(633, 58, 'estadistico/chart_prom_bruto_neto.php'),
(634, 58, 'estadistico/chart_ranking.php'),
(635, 53, 'listados/seguimiento_empleado.php'),
(637, 62, 'clientes/index.php'),
(638, 62, 'clientes/alta_cliente.php'),
(639, 62, 'clientes/adjuntos_cliente.php'),
(640, 62, 'clientes/descargar_adjuntos.php'),
(641, 62, 'clientes/modificar_cliente.php'),
(642, 62, 'clientes/subir_adjuntos_cliente.php'),
(643, 62, 'clientes/ver_cliente.php'),
(644, 60, 'obra_civil/alta_obra_civil.php'),
(645, 60, 'obra_civil/eliminar_obra_civil.php'),
(646, 60, 'obra_civil/modificar_obra_civil.php'),
(647, 60, 'obra_civil/index.php'),
(648, 61, 'obra_yeseria/alta_obra_yeseria.php'),
(649, 61, 'obra_yeseria/eliminar_obra_yeseria.php'),
(650, 61, 'obra_yeseria/modificar_obra_yeseria.php'),
(651, 61, 'obra_yeseria/index.php'),
(652, 63, 'obrero/index.php'),
(653, 63, 'obrero/adjuntos_obrero.php'),
(654, 63, 'obrero/alta_obrero.php'),
(655, 63, 'obrero/descargar_adjunto.php'),
(656, 63, 'obrero/modificar_obrero.php'),
(657, 63, 'obrero/ver_obrero.php'),
(658, 63, 'obrero/subir_adjuntos_obrero.php'),
(659, 64, 'configuraciones/index.php'),
(660, 68, 'cobro_cuotas/index.php'),
(661, 66, 'panol/index.php'),
(662, 67, 'presupuesto/index.php'),
(663, 65, 'proveedor/index.php'),
(664, 60, 'unidad_funcional/index.php'),
(665, 60, 'unidad_funcional/alta_unidad_funcional.php'),
(666, 60, 'unidad_funcional/modificar_unidad_funcional.php'),
(667, 60, 'unidad_funcional/eliminar_unidad_funcional.php'),
(668, 64, 'tarea/alta_tarea.php'),
(669, 64, 'tarea/modificar_tarea.php'),
(670, 64, 'tarea/eliminar_tarea.php'),
(671, 64, 'tarea/index.php'),
(672, 64, 'hito/alta_hito.php'),
(673, 64, 'hito/modificar_hito.php'),
(674, 64, 'hito/index.php'),
(675, 64, 'hito/eliminar_hito.php'),
(676, 64, 'hito/hito_tarea.php'),
(677, 64, 'hito/configurar_hito_tarea.php'),
(678, 60, 'obra_civil/finalizar_tarea.php'),
(679, 60, 'obra_civil/configurar_hitos.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_tablas`
--

CREATE TABLE IF NOT EXISTS `modulo_tablas` (
  `modtab_id` int(11) NOT NULL,
  `modtab_ddt_id` int(11) NOT NULL,
  `modtab_mod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE IF NOT EXISTS `movimiento` (
  `movimiento_id` int(11) NOT NULL,
  `material_descripcion` varchar(200) NOT NULL,
  `material_fecha` datetime NOT NULL,
  `material_monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_civil`
--

CREATE TABLE IF NOT EXISTS `obra_civil` (
  `obra_civil_id` int(11) NOT NULL,
  `obra_civil_cantidad_pisos` int(11) NOT NULL,
  `obra_civil_direccion` varchar(45) NOT NULL,
  `obra_civil_fecha_fin` date NOT NULL,
  `obra_civil_fecha_inicio` date NOT NULL,
  `obra_civil_dimensiones_terreno` varchar(45) NOT NULL,
  `obra_civil_valor_compra` float NOT NULL,
  `obra_civil_estado_id` int(11) NOT NULL,
  `obra_civil_localidad_id` int(11) NOT NULL,
  `obra_civil_descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `obra_civil`
--

INSERT INTO `obra_civil` (`obra_civil_id`, `obra_civil_cantidad_pisos`, `obra_civil_direccion`, `obra_civil_fecha_fin`, `obra_civil_fecha_inicio`, `obra_civil_dimensiones_terreno`, `obra_civil_valor_compra`, `obra_civil_estado_id`, `obra_civil_localidad_id`, `obra_civil_descripcion`) VALUES
(1, 40, '2 y 59', '2015-12-16', '2013-02-04', '50', 800000, 1, 303, 'Edificio 2 y 59 - Oficinas'),
(2, 40, '2', '2015-04-29', '2015-04-01', '50x20', 4000000, 1, 307, 'Mejora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_civil_hito`
--

CREATE TABLE IF NOT EXISTS `obra_civil_hito` (
  `obra_civil_hito_id` int(11) NOT NULL,
  `obra_civil_hito_peso` int(5) NOT NULL,
  `obra_civil_hito_obra_civil_id` int(11) NOT NULL,
  `obra_civil_hito_hito_id` int(11) NOT NULL,
  `obra_civil_hito_estado` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `obra_civil_hito`
--

INSERT INTO `obra_civil_hito` (`obra_civil_hito_id`, `obra_civil_hito_peso`, `obra_civil_hito_obra_civil_id`, `obra_civil_hito_hito_id`, `obra_civil_hito_estado`) VALUES
(8, 1, 1, 1, 1),
(9, 2, 1, 2, 1),
(12, 1, 2, 1, 0),
(13, 2, 2, 2, 0),
(15, 12, 1, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_civil_hito_tarea`
--

CREATE TABLE IF NOT EXISTS `obra_civil_hito_tarea` (
  `obra_civil_hito_tarea_id` int(11) NOT NULL,
  `obra_civil_hito_tarea_obra_civil_hito_id` int(11) NOT NULL,
  `obra_civil_hito_tarea_tarea_id` int(11) NOT NULL,
  `obra_civil_hito_tarea_estado` tinyint(1) NOT NULL DEFAULT '0',
  `obra_civil_hito_tarea_fecha_finalizacion` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `obra_civil_hito_tarea`
--

INSERT INTO `obra_civil_hito_tarea` (`obra_civil_hito_tarea_id`, `obra_civil_hito_tarea_obra_civil_hito_id`, `obra_civil_hito_tarea_tarea_id`, `obra_civil_hito_tarea_estado`, `obra_civil_hito_tarea_fecha_finalizacion`) VALUES
(6, 8, 1, 1, '2015-04-30'),
(7, 8, 2, 1, '2015-04-30'),
(8, 8, 4, 1, '2015-05-01'),
(9, 9, 3, 1, '2015-05-01'),
(10, 9, 5, 1, '2015-05-01'),
(11, 12, 1, 0, NULL),
(12, 12, 2, 0, NULL),
(13, 12, 4, 0, NULL),
(14, 13, 3, 0, NULL),
(15, 13, 5, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_yeseria`
--

CREATE TABLE IF NOT EXISTS `obra_yeseria` (
  `obra_yeseria_id` int(11) NOT NULL,
  `obra_yeseria_descripcion` varchar(200) NOT NULL,
  `obra_yeseria_domicilio` varchar(45) NOT NULL,
  `obra_yeseria_fecha_fin` date NOT NULL,
  `obra_yeseria_fecha_inicio` date NOT NULL,
  `obra_yeseria_monto` float NOT NULL,
  `obra_yeseria_estado_id` int(11) NOT NULL,
  `obra_yeseria_localidad_id` int(11) DEFAULT NULL,
  `obra_yeseria_cliente_id` int(11) DEFAULT NULL,
  `obra_yeseria_contrato_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `obra_yeseria`
--

INSERT INTO `obra_yeseria` (`obra_yeseria_id`, `obra_yeseria_descripcion`, `obra_yeseria_domicilio`, `obra_yeseria_fecha_fin`, `obra_yeseria_fecha_inicio`, `obra_yeseria_monto`, `obra_yeseria_estado_id`, `obra_yeseria_localidad_id`, `obra_yeseria_cliente_id`, `obra_yeseria_contrato_id`) VALUES
(1, 'Mejoramiento Teatro Argentino', '51 e/ 9 y 10', '2014-12-04', '2015-05-09', 1000550, 1, 303, 1, 0),
(2, 'Mejoramiento Coliseo', '10 e/ 46 y 47', '2014-12-04', '2015-05-09', 907000, 1, 303, 2, 0),
(3, 'Remodelar comercio 5', '38 e/ 9 y 10', '2014-12-04', '2015-05-09', 300000, 1, 303, 3, 0),
(4, 'Mejoramiento edificio Policia Montada', '1 y 60', '2014-12-04', '2015-05-09', 540640, 1, 303, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obrero`
--

CREATE TABLE IF NOT EXISTS `obrero` (
  `obrero_id` int(11) NOT NULL,
  `obrero_apellido` varchar(255) NOT NULL,
  `obrero_nombre` varchar(255) NOT NULL,
  `obrero_tipo_doc_id` int(11) NOT NULL,
  `obrero_nro_doc` int(11) NOT NULL,
  `obrero_direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `obrero_localidad_id` int(11) NOT NULL,
  `obrero_CP` varchar(255) DEFAULT NULL,
  `obrero_CUIL` varchar(255) DEFAULT NULL,
  `obrero_CBU` varchar(255) DEFAULT NULL,
  `obrero_fecha_inicio` date DEFAULT NULL,
  `obrero_telefono` varchar(255) DEFAULT NULL,
  `obrero_estado` varchar(255) DEFAULT NULL,
  `obrero_fecha_nacimiento` date DEFAULT NULL,
  `obrero_usuario_id` int(11) DEFAULT NULL,
  `obrero_categoria_id` int(11) DEFAULT NULL,
  `obrero_puesto_id` int(11) DEFAULT NULL,
  `obrero_obrero_especialidad_id` int(11) DEFAULT NULL,
  `obrero_estudio_alcanzado_id` int(11) DEFAULT NULL,
  `obrero_sexo_id` int(11) DEFAULT NULL,
  `obrero_estado_civil_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `obrero`
--

INSERT INTO `obrero` (`obrero_id`, `obrero_apellido`, `obrero_nombre`, `obrero_tipo_doc_id`, `obrero_nro_doc`, `obrero_direccion`, `obrero_localidad_id`, `obrero_CP`, `obrero_CUIL`, `obrero_CBU`, `obrero_fecha_inicio`, `obrero_telefono`, `obrero_estado`, `obrero_fecha_nacimiento`, `obrero_usuario_id`, `obrero_categoria_id`, `obrero_puesto_id`, `obrero_obrero_especialidad_id`, `obrero_estudio_alcanzado_id`, `obrero_sexo_id`, `obrero_estado_civil_id`) VALUES
(1, 'Acosta', 'Agustin', 1, 36421777, '2', 355, '1900', '20364217774', '', '2015-04-27', '22', NULL, '1991-06-03', 152, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obrero_obra_yeseria`
--

CREATE TABLE IF NOT EXISTS `obrero_obra_yeseria` (
  `obrero_obra_yeseria_id` int(11) NOT NULL,
  `obrero_obra_yeseria_descripcion` varchar(200) NOT NULL,
  `obrero_obra_yeseria_fecha` date NOT NULL,
  `obrero_obra_yeseria_obrero_id` int(11) NOT NULL,
  `obrero_obra_yeseria_obra_yeseria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE IF NOT EXISTS `orden_compra` (
  `orden_compra_id` int(11) NOT NULL,
  `orden_compra_estado` int(11) NOT NULL,
  `orden_compra_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra_herramienta`
--

CREATE TABLE IF NOT EXISTS `orden_compra_herramienta` (
  `orden_compra_herramienta_id` int(11) NOT NULL,
  `orden_compra_herramienta_herramineta_id` int(11) NOT NULL,
  `orden_compra_herramienta_orden_compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `pedido_id` int(11) NOT NULL,
  `pedido_estado` varchar(45) NOT NULL,
  `pedido_fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_herramienta`
--

CREATE TABLE IF NOT EXISTS `pedido_herramienta` (
  `pedido_herramienta_id` int(11) NOT NULL,
  `pedido_herramienta_cantidad` int(11) NOT NULL,
  `pedido_herramienta_descripcion` varchar(200) NOT NULL,
  `pedido_herramienta_herramienta_id` int(11) NOT NULL,
  `pedido_herramienta_pedido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
  `permiso_id` int(11) NOT NULL,
  `permiso_rol_id` int(11) NOT NULL,
  `permiso_mod_id` int(11) NOT NULL,
  `permiso_tipoacc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7779 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`permiso_id`, `permiso_rol_id`, `permiso_mod_id`, `permiso_tipoacc_id`) VALUES
(7707, 1, 51, 4),
(7708, 1, 51, 1),
(7709, 1, 51, 3),
(7710, 1, 51, 2),
(7711, 1, 52, 4),
(7712, 1, 52, 1),
(7713, 1, 52, 3),
(7714, 1, 52, 2),
(7715, 1, 53, 4),
(7716, 1, 53, 1),
(7717, 1, 53, 3),
(7718, 1, 53, 2),
(7719, 1, 54, 4),
(7720, 1, 54, 1),
(7721, 1, 54, 3),
(7722, 1, 54, 2),
(7723, 1, 56, 4),
(7724, 1, 56, 1),
(7725, 1, 56, 3),
(7726, 1, 56, 2),
(7727, 1, 58, 4),
(7728, 1, 58, 1),
(7729, 1, 58, 3),
(7730, 1, 58, 2),
(7731, 1, 57, 4),
(7732, 1, 57, 1),
(7733, 1, 57, 3),
(7734, 1, 57, 2),
(7735, 1, 55, 4),
(7736, 1, 55, 1),
(7737, 1, 55, 3),
(7738, 1, 55, 2),
(7739, 1, 59, 4),
(7740, 1, 59, 1),
(7741, 1, 59, 3),
(7742, 1, 59, 2),
(7743, 1, 62, 4),
(7744, 1, 62, 1),
(7745, 1, 62, 3),
(7746, 1, 62, 2),
(7747, 1, 60, 4),
(7748, 1, 60, 1),
(7749, 1, 60, 3),
(7750, 1, 60, 2),
(7751, 1, 61, 4),
(7752, 1, 61, 1),
(7753, 1, 61, 3),
(7754, 1, 61, 2),
(7755, 1, 63, 4),
(7756, 1, 63, 1),
(7757, 1, 63, 3),
(7758, 1, 63, 2),
(7759, 1, 64, 4),
(7760, 1, 64, 1),
(7761, 1, 64, 3),
(7762, 1, 64, 2),
(7763, 1, 68, 4),
(7764, 1, 68, 1),
(7765, 1, 68, 3),
(7766, 1, 68, 2),
(7767, 1, 66, 4),
(7768, 1, 66, 1),
(7769, 1, 66, 3),
(7770, 1, 66, 2),
(7771, 1, 67, 4),
(7772, 1, 67, 1),
(7773, 1, 67, 3),
(7774, 1, 67, 2),
(7775, 1, 65, 4),
(7776, 1, 65, 1),
(7777, 1, 65, 3),
(7778, 1, 65, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE IF NOT EXISTS `presupuesto` (
  `presupuesto_id` int(11) NOT NULL,
  `presupuesto_descripcion` varchar(200) NOT NULL,
  `presupuesto_dias_validez` int(11) NOT NULL,
  `presupuesto_fecha` datetime NOT NULL,
  `presupuesto_monto` float NOT NULL,
  `presupuesto_path` varchar(45) NOT NULL,
  `presupuesto_obrero_id` int(11) DEFAULT NULL,
  `presupuesto_obra_yeseria_id` int(11) NOT NULL,
  `presupuesto_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `proveedor_apellido` varchar(255) NOT NULL,
  `proveedor_nombre` varchar(255) NOT NULL,
  `proveedor_nro_doc` int(11) NOT NULL,
  `proveedor_direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `proveedor_localidad_id` int(11) NOT NULL,
  `proveedor_CP` varchar(255) DEFAULT NULL,
  `proveedor_CUIL` varchar(255) DEFAULT NULL,
  `proveedor_cuenta_bancaria` varchar(255) DEFAULT NULL,
  `proveedor_CBU` varchar(255) DEFAULT NULL,
  `proveedor_fecha_inicio` date DEFAULT NULL,
  `proveedor_telefono` varchar(255) DEFAULT NULL,
  `proveedor_tel_fijo_celular` varchar(255) DEFAULT NULL,
  `proveedor_tel_laboral1` varchar(255) DEFAULT NULL,
  `proveedor_tel_laboral2` varchar(255) DEFAULT NULL,
  `proveedor_referido1` varchar(255) DEFAULT NULL,
  `proveedor_referido2` varchar(255) DEFAULT NULL,
  `proveedor_estado_id` varchar(255) NOT NULL,
  `proveedor_fecha_nacimiento` date DEFAULT NULL,
  `proveedor_especialidad_proveedor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE IF NOT EXISTS `puesto` (
  `puesto_id` int(11) NOT NULL,
  `puesto_nombre` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`puesto_id`, `puesto_nombre`) VALUES
(1, '1/2 OFICIAL'),
(2, '1/2 OFICIAL EN GENERAL'),
(3, 'ADM. SEMI SENIOR'),
(4, 'ADMINISTRATIVO JUNIOR'),
(5, 'ADMINISTRATIVO SEMI-SENIOR'),
(6, 'ADMINISTRATIVO SENIOR'),
(7, 'ADMINISTRATIVO SENIOR MULTIPLE'),
(8, 'ADMINISTRATIVO VIA Y OBRAS'),
(9, 'ANALISTA DE CIRCULACION'),
(10, 'ANALISTA RR.HH.'),
(11, 'APRENDIZ'),
(12, 'ASIS.B/PERS.PUESTO FIJO Y FORM'),
(13, 'ASIST.BIENES Y PER.EN PF Y FOR'),
(14, 'ASISTENTE ADMINISTRATIVO'),
(15, 'ASISTENTE TECNICO'),
(16, 'ASPIRANTE A AYUD. COND.'),
(17, 'ASPIRANTE A CONDUCTOR'),
(18, 'AUX. ADMIN. SENIOR MULTIPLE'),
(19, 'AUX. OPERATIVO INTERMEDIA A'),
(20, 'AUX. OPERATIVO INTERMEDIA B'),
(21, 'AUX.ADM.Ssr.BIENES Y PERSONAS'),
(22, 'AUX.MULTIPLE BIENES Y PERSONAS'),
(23, 'AUX.OP.INT."B"(EST.CASEROS)'),
(24, 'AUX.OPER. BIENES Y PERSONAS'),
(25, 'Auxiliar Adm.sem.SR. B y P'),
(26, 'AUXILIAR ADMINISTRATIVO'),
(27, 'AUXILIAR CONTROL PASAJES'),
(28, 'AUXILIAR ENFERMERO'),
(29, 'AUXILIAR FISCALIZACION'),
(30, 'Auxiliar Multiple B y P'),
(31, 'AUXILIAR OPERATIVO 1RA.'),
(32, 'AUXILIAR OPERATIVO 2DA.'),
(33, 'AYUDANTE CONDUCTOR'),
(34, 'AYUDANTE CONDUCTOR HABILITADO'),
(35, 'AYUDANTE DE OFICIAL'),
(36, 'AYUDANTE OPERADOR DE C.C.E.E'),
(37, 'BANDERILLERO'),
(38, 'BOLETERO'),
(39, 'BOLETERO 1er. AÑO'),
(40, 'CAPATAZ CAMBISTA PLAYA RETIRO'),
(41, 'CAPATAZ DE VIA Y OBRAS'),
(42, 'CAPATAZ VIAS'),
(43, 'CHOFER MECANICO'),
(44, 'CONDUCTOR DIESEL'),
(45, 'CONDUCTOR ELECTRICO'),
(46, 'CONTROL DE ACCESO'),
(47, 'CONTROL DE ENERGIA'),
(48, 'CONTROL EN FORMACIONES'),
(49, 'CONTROLADOR'),
(50, 'CONTROLADOR DE MATERIALES'),
(51, 'COORDINADOR PROG.Y MANTEN.'),
(52, 'COORDINADOR PROGRAMADOR M.R.'),
(53, 'ENCARGADO  DE  BOLETERIA'),
(54, 'ENCARGADO DE BOLETERIAS'),
(55, 'ENCARGADO DE LIMPIEZA'),
(56, 'ENCARGADO DE LIMPIEZA (LGR)'),
(57, 'Encargado Limpieza'),
(58, 'ENFERMERO'),
(59, 'ENFERMERO/ A'),
(60, 'GUARDA PASO NIVEL'),
(61, 'GUARDABARRERA'),
(62, 'GUARDATREN'),
(63, 'INICIAL'),
(64, 'INSP. DE SEÑALAMIENTO'),
(65, 'INSPECTOR'),
(66, 'INSPECTOR CON CERTIFICADO'),
(67, 'INSPECTOR DE OBRAS'),
(68, 'INSPECTOR DE VIAS'),
(69, 'INSPECTOR SE?ALAMIENTO'),
(70, 'INSPECTOR VIA'),
(71, 'INSPECTOR/LF'),
(72, 'INSTRUCTOR CONDUCCION'),
(73, 'INSTRUCTOR TECNICO'),
(74, 'JEFE DE ESTACION DE 2DA. CAT.'),
(75, 'JEFE DE ESTACION DE 3RA. CAT.'),
(76, 'JEFE DEPARTAMENTO VIA Y OBRAS'),
(77, 'JEFE PCP'),
(78, 'JEFE RECURSOS HUMANOS'),
(79, 'LIQUIDADOR DE HABERES'),
(80, 'MEDICO'),
(81, 'OF.CAMBISTA P.RETIRO/P.JCPAZ'),
(82, 'OF.ESP.CAM.PLAT./PLAYA JCPAZ'),
(83, 'OFICIAL'),
(84, 'OFICIAL CAMBISTA'),
(85, 'OFICIAL DE CATENARIAS'),
(86, 'OFICIAL ESPECIAL.'),
(87, 'OFICIAL ESPECIALIZADO CAMBISTA'),
(88, 'OFICIAL ESPECIALIZADO EN GRAL.'),
(89, 'OFICIAL ESPECIALIZADO VIA'),
(90, 'OFICIAL SEAL'),
(91, 'OFICIAL TELEFONIA'),
(92, 'OFICIAL VIA'),
(93, 'OPERADOR PCP'),
(94, 'OPERADOR PCT'),
(95, 'OPERADOR PUESTO CONTROL TRENES'),
(96, 'OPERARIO DE CUADRILLA'),
(97, 'PANOLERO'),
(98, 'PATRULLERO DE VIAS'),
(99, 'PEON CAMBISTA'),
(100, 'Peon Desmalezado y Acarreo en'),
(101, 'PEON DESMALEZADO Y ACARREO GRA'),
(102, 'PEON GRAL. TAREAS FERROVIARIAS'),
(103, 'PEON LIMPIEZA;ACARREOyEN GRAL.'),
(104, 'PEON TAR.FERRO. Y DESMALEZADO'),
(105, 'PERSONAL CONTROL PUESTO FIJO'),
(106, 'SECRETARIA/O GERENCIA'),
(107, 'SEÑ. CABINA INTERMEDIA'),
(108, 'SEÑ. CABINA PRINCIPAL'),
(109, 'SEÑ. ENCARGADO CABINA PRINCIPA'),
(110, 'SEÑ. ENCARGADO DE CABINA "U"'),
(111, 'SEÑ. INSPECTOR/INSTRUCTOR'),
(112, 'SEÑALERO'),
(113, 'SEÑALERO ASPIRANTE'),
(114, 'SEÑALERO CABINA INTERMEDIA'),
(115, 'SEÑALERO CABINA PRINCIPAL'),
(116, 'SEÑALERO ENCARGADO CABINA PPAL'),
(117, 'SEÑALERO ENCARGADO DE CABINA U'),
(118, 'SEÑALERO INSPECTOR/ INSTRUCTOR'),
(119, 'SUB CAPATAZ VIA'),
(120, 'SUB. CAPATAZ DESMALEZADO'),
(121, 'SUB.CAPATAZ DE OBRA'),
(122, 'Sub.Capataz Desmalezado'),
(123, 'SUP.PERSONAL BIENES Y PERSONAS'),
(124, 'SUP.S Y T ALMACENES Y C. HERR.'),
(125, 'SUP.SEÑAL.MECANICO'),
(126, 'SUPERV. FISCALIZACION PASAJES'),
(127, 'SUPERV. GRAL. CONTROL CALIDAD'),
(128, 'Superv. Mantent.y Reparaciones'),
(129, 'SUPERV. TECNICO ADMINISTRATIVO'),
(130, 'SUPERVISOR C.C.P.'),
(131, 'SUPERVISOR CONTROL DE CALIDAD'),
(132, 'SUPERVISOR CONTROL DE CALIDDAD'),
(133, 'SUPERVISOR CONTROLADOR'),
(134, 'SUPERVISOR DE TURNO'),
(135, 'SUPERVISOR ELECTROMECANICO'),
(136, 'SUPERVISOR ESTACIONES'),
(137, 'SUPERVISOR FISCALIZAC.PASAJES'),
(138, 'SUPERVISOR INFRAESTRUCTURA'),
(139, 'SUPERVISOR MANT. ELECTRICO'),
(140, 'SUPERVISOR MANT. ELECTRONICO'),
(141, 'SUPERVISOR MANT.Y REPARACIONES'),
(142, 'SUPERVISOR MANTENIMIENTO'),
(143, 'SUPERVISOR MATERIAL RODANTE'),
(144, 'SUPERVISOR MECANICO'),
(145, 'SUPERVISOR OPERATIVO'),
(146, 'SUPERVISOR PCT'),
(147, 'Supervisor persona limpieza'),
(148, 'SUPERVISOR PERSONAL'),
(149, 'Supervisor Personal B Y P'),
(150, 'SUPERVISOR PROGRAM Y ESTADIST.'),
(151, 'SUPERVISOR PROGRAMACION'),
(152, 'SUPERVISOR PROGRAMACION Y EST.'),
(153, 'SUPERVISOR SE?AL. MECANICO'),
(154, 'SUPERVISOR SEÑALAMIENTO'),
(155, 'SUPERVISOR TELECOMUNICACIONES'),
(156, 'SUPERVISOR TURNO AT'),
(157, 'SUPV. MANTENIM. Y REPARAC. TMR'),
(158, 'SUPV. MATERIAL RODANTE DIESEL'),
(159, 'SUPV.CONTROL CALIDAD'),
(160, 'SUPV.MANT.MATL.RODANTE'),
(161, 'SUPV.MANTENIMI. Y REPARACIONES'),
(162, 'SUPV.PROGRAMACION Y ESTADISTIC'),
(163, 'TEC. TALLER LOCOMOTORAS'),
(164, 'TEC.MULTIPLE DE TELECOMUNICAC.'),
(165, 'TEC.MULTIPLE INFRA.EN SENALAM.'),
(166, 'TEC.SUP.DE TELECOMUNICACIONES'),
(167, 'TEC.SUP.TELECOMUNICACIONES'),
(168, 'TEC.TALLER COCHES'),
(169, 'TECNICO'),
(170, 'TECNICO CAMBISTA EST. TAPIALES'),
(171, 'TECNICO DE TALLER COCHES'),
(172, 'TECNICO ELECTRICISTA DE INFRA.'),
(173, 'TECNICO ELECTRONICO'),
(174, 'TECNICO EN GENERAL'),
(175, 'TECNICO EN INFORMATICO'),
(176, 'TECNICO EN TELECOMUNICACIONES'),
(177, 'TECNICO EN TELEFONIA'),
(178, 'TECNICO MANTENIMIENTO'),
(179, 'TECNICO MULTIPLE DE CATENARIAS'),
(180, 'TECNICO MULTIPLE M.RODANTE'),
(181, 'TECNICO MULTIPLE S.y T.,BAL,..'),
(182, 'TECNICO SEAL'),
(183, 'TECNICO TALLER LOCOMOTORAS'),
(184, 'CONDNICTOR DIESEL'),
(185, 'SEï¾‘. CABINA PRINCIPAL'),
(186, 'JEFE PCT'),
(187, 'SUP.SEï¾‘AL.MECANICO'),
(188, 'INSP. DE SEï¾‘ALAMIENTO'),
(189, 'SEï¾‘. ENCARGADO CABINA PRINCIPA'),
(190, 'SEï¾‘. INSPECTOR/INSTRUCTOR'),
(191, 'SEï¾‘. ENCARGADO DE CABINA "U"'),
(192, 'SUPERVISOR SEï¾‘ALAMIENTO'),
(193, 'INSTRUCTOR CONDNICCION'),
(194, 'AYUDANTE CONDNICTOR'),
(195, 'AYUDANTE CONDNICTOR HABILITADO'),
(196, 'SEï¾‘. CABINA INTERMEDIA'),
(197, 'SEï¾‘ALERO ASPIRANTE'),
(198, 'SEï¾‘ALERO CABINA PRINCIPAL'),
(199, 'SEï¾‘ALERO INSPECTOR/ INSTRUCTOR'),
(200, 'SEï¾‘ALERO ENCARGADO CABINA PPAL'),
(201, 'INSPECTOR SEï½¥ALAMIENTO'),
(202, 'SUPERVISOR SEï½¥AL. MECANICO'),
(203, 'SEï¾‘ALERO CABINA INTERMEDIA'),
(204, 'SEï¾‘ALERO ENCARGADO DE CABINA U'),
(205, 'SEï¾‘ALERO'),
(206, 'ANALISTA PLANEAM.ESTRATEGICO'),
(207, 'BOLETERO 1er. Aï¾‘O');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `rol_id` int(11) NOT NULL,
  `rol_nombre` varchar(45) NOT NULL,
  `rol_baja` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `rol_nombre`, `rol_baja`) VALUES
(1, 'Administrador', 0),
(2, 'Test', 0),
(3, 'Intermedio +', 0),
(4, 'Basico', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE IF NOT EXISTS `sexo` (
  `sexo_id` int(11) NOT NULL,
  `sexo_nombre` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`sexo_id`, `sexo_nombre`) VALUES
(1, 'F'),
(2, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE IF NOT EXISTS `tarea` (
  `tarea_id` int(11) NOT NULL,
  `tarea_descripcion` varchar(50) DEFAULT NULL,
  `tarea_peso` int(5) NOT NULL,
  `tarea_baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tarea`
--

INSERT INTO `tarea` (`tarea_id`, `tarea_descripcion`, `tarea_peso`, `tarea_baja`) VALUES
(1, 'Tarea 1', 1, 0),
(2, 'Tarea 2', 2, 0),
(3, 'Tarea 3', 1, 0),
(4, 'Tarea 4', 3, 0),
(5, 'Tarea 5', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea_hito`
--

CREATE TABLE IF NOT EXISTS `tarea_hito` (
  `tarea_hito_id` int(11) NOT NULL,
  `tarea_hito_tarea_id` int(11) NOT NULL,
  `tarea_hito_hito_id` int(11) NOT NULL,
  `tarea_hito_fecha` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tarea_hito`
--

INSERT INTO `tarea_hito` (`tarea_hito_id`, `tarea_hito_tarea_id`, `tarea_hito_hito_id`, `tarea_hito_fecha`) VALUES
(1, 1, 1, '2015-04-24'),
(2, 2, 1, '2015-04-24'),
(3, 4, 1, '2015-04-27'),
(4, 3, 2, '2015-04-26'),
(5, 5, 2, '2015-04-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_acceso`
--

CREATE TABLE IF NOT EXISTS `tipo_acceso` (
  `tipoacc_id` int(11) NOT NULL,
  `tipoacc_nombre` varchar(45) DEFAULT NULL,
  `tipoacc_baja` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_acceso`
--

INSERT INTO `tipo_acceso` (`tipoacc_id`, `tipoacc_nombre`, `tipoacc_baja`) VALUES
(1, 'Alta', 0),
(2, 'Modificacion', 0),
(3, 'Baja', 0),
(4, 'Acceso', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `tipo_documento_id` int(11) NOT NULL,
  `tipo_documento_nombre` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`tipo_documento_id`, `tipo_documento_nombre`) VALUES
(1, 'DNI'),
(2, 'Cedula'),
(3, 'Pasaporte'),
(4, 'LE'),
(5, 'LC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_funcional`
--

CREATE TABLE IF NOT EXISTS `unidad_funcional` (
  `unidad_funcional_id` int(11) NOT NULL,
  `unidad_funcional_obra_civil_id` int(11) NOT NULL,
  `unidad_funcional_cantidad_ambientes` int(11) NOT NULL,
  `unidad_funcional_coeficiente` double(5,2) NOT NULL,
  `unidad_funcional_departamento` varchar(50) NOT NULL,
  `unidad_funcional_estado_uf_id` int(11) NOT NULL,
  `unidad_funcional_dimensiones` varchar(100) NOT NULL,
  `unidad_funcional_monto` double(20,2) NOT NULL,
  `unidad_funcional_observacion` varchar(255) NOT NULL,
  `unidad_funcional_piso` varchar(50) NOT NULL,
  `unidad_funcional_cliente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_funcional`
--

INSERT INTO `unidad_funcional` (`unidad_funcional_id`, `unidad_funcional_obra_civil_id`, `unidad_funcional_cantidad_ambientes`, `unidad_funcional_coeficiente`, `unidad_funcional_departamento`, `unidad_funcional_estado_uf_id`, `unidad_funcional_dimensiones`, `unidad_funcional_monto`, `unidad_funcional_observacion`, `unidad_funcional_piso`, `unidad_funcional_cliente_id`) VALUES
(3, 1, 3, 14.00, 'A', 1, '45x20', 700000.00, 'observación', '1', 16),
(4, 1, 3, 15.00, 'B', 1, '49x15', 700000.00, 'observación', '1', NULL),
(5, 1, 3, 17.00, 'C', 1, '45x21', 800000.00, 'observación', '1', NULL),
(6, 1, 1, 13.00, 'A', 1, '49x16', 550000.00, 'observación', '2', NULL),
(7, 1, 2, 14.50, 'B', 2, '45x22', 600000.00, 'observación', '2', 16),
(8, 1, 2, 14.40, 'C', 1, '49x17', 600000.00, 'observación', '2', 1),
(9, 1, 2, 14.30, 'A', 2, '45x23', 600000.00, 'observación', '3', NULL),
(10, 1, 2, 14.20, 'B', 1, '49x18', 600000.00, 'observación', '3', NULL),
(11, 1, 1, 14.10, 'C', 1, '45x24', 450000.00, 'observación', '3', NULL),
(12, 1, 1, 14.00, 'A', 2, '49x19', 450000.00, 'observación', '4', NULL),
(13, 1, 1, 13.90, 'B', 1, '45x25', 450000.00, 'observación', '4', NULL),
(14, 1, 2, 13.80, 'C', 1, '49x20', 580000.00, 'observación', '4', NULL),
(15, 1, 2, 13.70, 'A', 2, '45x26', 670000.00, 'observación', '5', NULL),
(16, 1, 1, 13.60, 'B', 1, '49x21', 570000.00, 'observación', '5', NULL),
(17, 1, 2, 13.50, 'C', 1, '45x27', 670000.00, 'observación', '5', NULL),
(18, 1, 3, 13.40, 'A', 1, '49x22', 900000.00, 'observación', '6', NULL),
(19, 1, 3, 13.30, 'B', 2, '45x28', 900000.00, 'observación', '6', NULL),
(20, 1, 3, 13.20, 'A', 2, '49x23', 900000.00, 'observación', '7', NULL),
(21, 1, 3, 13.10, 'B', 1, '45x29', 900000.00, 'observación', '7', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `usua_id` int(11) NOT NULL,
  `usua_usrid` varchar(50) NOT NULL,
  `usua_nombre` varchar(100) DEFAULT NULL,
  `usua_pwd` varchar(32) NOT NULL,
  `usua_email` varchar(100) NOT NULL,
  `usua_tel1` varchar(45) DEFAULT NULL,
  `usua_tel2` varchar(45) DEFAULT NULL,
  `usua_baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usua_id`, `usua_usrid`, `usua_nombre`, `usua_pwd`, `usua_email`, `usua_tel1`, `usua_tel2`, `usua_baja`) VALUES
(152, 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@admin.com', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_rol` (
  `usrrol_id` int(11) NOT NULL,
  `usrrol_usua_id` int(11) NOT NULL,
  `usrrol_rol_id` int(11) NOT NULL,
  `usrrol_app_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`usrrol_id`, `usrrol_usua_id`, `usrrol_rol_id`, `usrrol_app_id`) VALUES
(177, 152, 1, 5);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_usuario_login`
--
CREATE TABLE IF NOT EXISTS `view_usuario_login` (
`usrrol_id` int(11)
,`usua_id` int(11)
,`usua_usrid` varchar(50)
,`usua_nombre` varchar(100)
,`usua_pwd` varchar(32)
,`usua_email` varchar(100)
,`rol_nombre` varchar(45)
,`app_id` int(11)
,`app_nombre` varchar(45)
,`permiso_id` int(11)
,`tipoacc_id` int(11)
,`tipoacc_nombre` varchar(45)
,`mod_id` int(11)
,`mod_nombre` varchar(45)
,`modpag_id` int(11)
,`modpag_scriptname` varchar(60)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_usuario_login`
--
DROP TABLE IF EXISTS `view_usuario_login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_usuario_login` AS (select `usuario_rol`.`usrrol_id` AS `usrrol_id`,`usuario`.`usua_id` AS `usua_id`,`usuario`.`usua_usrid` AS `usua_usrid`,`usuario`.`usua_nombre` AS `usua_nombre`,`usuario`.`usua_pwd` AS `usua_pwd`,`usuario`.`usua_email` AS `usua_email`,`rol`.`rol_nombre` AS `rol_nombre`,`aplicacion`.`app_id` AS `app_id`,`aplicacion`.`app_nombre` AS `app_nombre`,`permiso`.`permiso_id` AS `permiso_id`,`tipo_acceso`.`tipoacc_id` AS `tipoacc_id`,`tipo_acceso`.`tipoacc_nombre` AS `tipoacc_nombre`,`modulo`.`mod_id` AS `mod_id`,`modulo`.`mod_nombre` AS `mod_nombre`,`modulo_paginas`.`modpag_id` AS `modpag_id`,`modulo_paginas`.`modpag_scriptname` AS `modpag_scriptname` from ((((((((`usuario_rol` join `usuario` on((`usuario`.`usua_id` = `usuario_rol`.`usrrol_usua_id`))) join `rol` on((`rol`.`rol_id` = `usuario_rol`.`usrrol_rol_id`))) join `aplicacion` on((`usuario_rol`.`usrrol_app_id` = `aplicacion`.`app_id`))) join `permiso` on((`permiso`.`permiso_rol_id` = `usuario_rol`.`usrrol_rol_id`))) join `tipo_acceso` on((`tipo_acceso`.`tipoacc_id` = `permiso`.`permiso_tipoacc_id`))) join `modulo` on(((`modulo`.`mod_id` = `permiso`.`permiso_mod_id`) and (`modulo`.`mod_app_id` = `usuario_rol`.`usrrol_app_id`)))) join `modulo_paginas` on((`modulo_paginas`.`modpag_mod_id` = `modulo`.`mod_id`))) left join `modulo_tablas` on((`modulo_tablas`.`modtab_mod_id` = `modulo`.`mod_id`))) where ((`usuario`.`usua_baja` = 0) and (`aplicacion`.`app_baja` = 0)));

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adjuntos_cliente`
--
ALTER TABLE `adjuntos_cliente`
  ADD PRIMARY KEY (`adjuntos_cliente_id`),
  ADD KEY `fk_adjuntos_cliente_id` (`adjuntos_cliente_cliente_id`);

--
-- Indices de la tabla `ajuste`
--
ALTER TABLE `ajuste`
  ADD PRIMARY KEY (`ajuste_id`),
  ADD KEY `fk_ajuste_obra_civil_id` (`ajuste_obra_civil_id`);

--
-- Indices de la tabla `aplicacion`
--
ALTER TABLE `aplicacion`
  ADD PRIMARY KEY (`app_id`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`asistencia_id`),
  ADD KEY `fk_asistencia_obrero_id` (`asistencia_obrero_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cliente_id`),
  ADD KEY `fk_clientes_tipo_doc_id` (`cliente_tipo_doc_id`),
  ADD KEY `fk_cliente_localidad_id` (`cliente_localidad_id`),
  ADD KEY `fk_cliente_estado_id` (`cliente_estado_id`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`contrato_id`),
  ADD KEY `fk_contrato_cliente_id` (`contrato_cliente_id`);

--
-- Indices de la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD PRIMARY KEY (`cuota_id`),
  ADD KEY `fk_cuota_movimiento_id` (`cuota_movimiento_id`),
  ADD KEY `fk_cuota_unidad_funcional_id` (`cuota_unidad_funcional_id`);

--
-- Indices de la tabla `especialidad_obrero`
--
ALTER TABLE `especialidad_obrero`
  ADD PRIMARY KEY (`especialidad_obrero_id`);

--
-- Indices de la tabla `especialidad_proveedor`
--
ALTER TABLE `especialidad_proveedor`
  ADD PRIMARY KEY (`especialidad_proveedor_id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`estado_id`);

--
-- Indices de la tabla `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`estado_civil_id`);

--
-- Indices de la tabla `estado_cliente`
--
ALTER TABLE `estado_cliente`
  ADD PRIMARY KEY (`estado_id`);

--
-- Indices de la tabla `estado_herramienta`
--
ALTER TABLE `estado_herramienta`
  ADD PRIMARY KEY (`estado_herramienta_id`);

--
-- Indices de la tabla `estado_pedido_compra`
--
ALTER TABLE `estado_pedido_compra`
  ADD PRIMARY KEY (`estado_pedido_compra_id`);

--
-- Indices de la tabla `estado_uf`
--
ALTER TABLE `estado_uf`
  ADD PRIMARY KEY (`estado_uf_id`);

--
-- Indices de la tabla `estudio_alcanzado`
--
ALTER TABLE `estudio_alcanzado`
  ADD PRIMARY KEY (`estudio_id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`factura_id`),
  ADD KEY `fk_factura_cliente1_idx` (`factura_cliente_id`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`factura_detalle_id`),
  ADD KEY `fk_factura_detalle_factura_proveedor1_idx` (`factura_detalle_factura_proveedor_id`),
  ADD KEY `fk_factura_detalle_factura1_idx` (`factura_detalle_factura_id`),
  ADD KEY `fk_factura_detalle_material_id` (`factura_detalle_material_id`),
  ADD KEY `fk_factura_detalle_movimiento_id` (`factura_detalle_movimiento_id`);

--
-- Indices de la tabla `factura_proveedor`
--
ALTER TABLE `factura_proveedor`
  ADD PRIMARY KEY (`factura_proveedor_id`);

--
-- Indices de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD PRIMARY KEY (`herramienta_id`),
  ADD KEY `fk_herramienta_obra_yeseria_id` (`herramienta_obra_yeseria_id`),
  ADD KEY `fk_herramienta_obra_civil_id` (`herramienta_obra_civil_id`),
  ADD KEY `fk_herramienta_estado_herramienta_id` (`herramienta_estado_herramienta_id`);

--
-- Indices de la tabla `hito`
--
ALTER TABLE `hito`
  ADD PRIMARY KEY (`hito_id`),
  ADD KEY `fk_hito_estado1_idx` (`hito_estado`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`licencia_id`),
  ADD KEY `fk_licencia_obrero_id` (`licencia_obrero_id`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`localidad_id`);

--
-- Indices de la tabla `localidad-`
--
ALTER TABLE `localidad-`
  ADD PRIMARY KEY (`localidad_id`),
  ADD KEY `cpostal` (`cpostal`);

--
-- Indices de la tabla `log_ingreso`
--
ALTER TABLE `log_ingreso`
  ADD PRIMARY KEY (`loging_id`),
  ADD KEY `fk_log_ingreso_aplicacion1` (`loging_app_id`),
  ADD KEY `fk_log_ingreso_usuario1` (`loging_usua_id`);

--
-- Indices de la tabla `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`mod_id`),
  ADD KEY `fk_aplicacion_app_id1` (`mod_app_id`) USING BTREE;

--
-- Indices de la tabla `modulo_paginas`
--
ALTER TABLE `modulo_paginas`
  ADD PRIMARY KEY (`modpag_id`),
  ADD KEY `fk_modulo_modpag_mod_id1` (`modpag_mod_id`) USING BTREE;

--
-- Indices de la tabla `modulo_tablas`
--
ALTER TABLE `modulo_tablas`
  ADD PRIMARY KEY (`modtab_id`),
  ADD KEY `fk_modulo_modtab_mod_id1` (`modtab_mod_id`) USING BTREE,
  ADD KEY `fk_diccionario_datos_tablas_modtab_ddt_id1` (`modtab_ddt_id`) USING BTREE;

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`movimiento_id`);

--
-- Indices de la tabla `obra_civil`
--
ALTER TABLE `obra_civil`
  ADD PRIMARY KEY (`obra_civil_id`),
  ADD KEY `fk_obra_civil_estado1_idx` (`obra_civil_estado_id`),
  ADD KEY `fk_obra_civil_localidad_id` (`obra_civil_localidad_id`);

--
-- Indices de la tabla `obra_civil_hito`
--
ALTER TABLE `obra_civil_hito`
  ADD PRIMARY KEY (`obra_civil_hito_id`),
  ADD KEY `fk_obra_civil_hito_obra_civil_id` (`obra_civil_hito_obra_civil_id`),
  ADD KEY `fk_obra_civil_hito_hito_id` (`obra_civil_hito_hito_id`);

--
-- Indices de la tabla `obra_civil_hito_tarea`
--
ALTER TABLE `obra_civil_hito_tarea`
  ADD PRIMARY KEY (`obra_civil_hito_tarea_id`),
  ADD KEY `fk_obra_civil_hito_tarea_obra_civil_hito_id` (`obra_civil_hito_tarea_obra_civil_hito_id`),
  ADD KEY `fk_obra_civil_hito_tarea_tarea_id` (`obra_civil_hito_tarea_tarea_id`);

--
-- Indices de la tabla `obra_yeseria`
--
ALTER TABLE `obra_yeseria`
  ADD PRIMARY KEY (`obra_yeseria_id`),
  ADD KEY `fk_obra_yeseria_estado1_idx` (`obra_yeseria_estado_id`),
  ADD KEY `fk_obra_yeseria_localidad_id` (`obra_yeseria_localidad_id`),
  ADD KEY `fk_obra_yeseria_cliente_id` (`obra_yeseria_cliente_id`);

--
-- Indices de la tabla `obrero`
--
ALTER TABLE `obrero`
  ADD PRIMARY KEY (`obrero_id`),
  ADD KEY `fk_obrero_puesto_id` (`obrero_puesto_id`),
  ADD KEY `fk_obrero_obrero_especialidad_id` (`obrero_obrero_especialidad_id`),
  ADD KEY `fk_obrero_categoria_id` (`obrero_categoria_id`),
  ADD KEY `fk_obrero_usuario_id` (`obrero_usuario_id`),
  ADD KEY `fk_obrero_tipo_doc_id` (`obrero_tipo_doc_id`),
  ADD KEY `fk_obrero_estudio_alcanzado_id` (`obrero_estudio_alcanzado_id`),
  ADD KEY `fk_obrero_sexo_id` (`obrero_sexo_id`),
  ADD KEY `fk_obrero_estado_civil_id` (`obrero_estado_civil_id`),
  ADD KEY `fk_obrero_localidad_id` (`obrero_localidad_id`);

--
-- Indices de la tabla `obrero_obra_yeseria`
--
ALTER TABLE `obrero_obra_yeseria`
  ADD PRIMARY KEY (`obrero_obra_yeseria_id`),
  ADD KEY `fk_obrero_obra_yeseria_obra_yeseria1_idx` (`obrero_obra_yeseria_obra_yeseria_id`),
  ADD KEY `fk_obrero_obra_yeseria_obrero_id` (`obrero_obra_yeseria_obrero_id`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`orden_compra_id`),
  ADD KEY `fk_orden_compra_usuario_id` (`orden_compra_usuario_id`),
  ADD KEY `fk_orden_compra_estado` (`orden_compra_estado`);

--
-- Indices de la tabla `orden_compra_herramienta`
--
ALTER TABLE `orden_compra_herramienta`
  ADD PRIMARY KEY (`orden_compra_herramienta_id`),
  ADD KEY `fk_orden_compra_herramienta_herramienta1_idx` (`orden_compra_herramienta_herramineta_id`),
  ADD KEY `fk_orden_compra_idx` (`orden_compra_herramienta_orden_compra_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`);

--
-- Indices de la tabla `pedido_herramienta`
--
ALTER TABLE `pedido_herramienta`
  ADD PRIMARY KEY (`pedido_herramienta_id`),
  ADD KEY `fk_pedido_herramienta_herramienta1_idx` (`pedido_herramienta_herramienta_id`),
  ADD KEY `fk_pedido_herramienta_pedido1_idx` (`pedido_herramienta_pedido_id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`permiso_id`),
  ADD KEY `fk_rol_has_modulo_modulo1` (`permiso_mod_id`) USING BTREE,
  ADD KEY `fk_rol_has_modulo_rol1` (`permiso_rol_id`) USING BTREE,
  ADD KEY `fk_permiso_tipo_acceso1` (`permiso_tipoacc_id`) USING BTREE;

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD PRIMARY KEY (`presupuesto_id`),
  ADD KEY `fk_presupuesto_obra_yeseria1_idx` (`presupuesto_obra_yeseria_id`),
  ADD KEY `fk_presupuesto_obrero_id` (`presupuesto_obrero_id`),
  ADD KEY `fk_presupuesto_cliente_id` (`presupuesto_cliente_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_id`),
  ADD KEY `fk_proveedor_localidad_id` (`proveedor_localidad_id`),
  ADD KEY `fk_proveedor_especialidad_proveedor_id` (`proveedor_especialidad_proveedor_id`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`puesto_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`sexo_id`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`tarea_id`);

--
-- Indices de la tabla `tarea_hito`
--
ALTER TABLE `tarea_hito`
  ADD PRIMARY KEY (`tarea_hito_id`),
  ADD KEY `fk_tarea_hito_tarea_id` (`tarea_hito_tarea_id`),
  ADD KEY `fk_tarea_hito_hito_id` (`tarea_hito_hito_id`);

--
-- Indices de la tabla `tipo_acceso`
--
ALTER TABLE `tipo_acceso`
  ADD PRIMARY KEY (`tipoacc_id`),
  ADD UNIQUE KEY `tipoacc_nombre_UNIQUE` (`tipoacc_nombre`) USING BTREE;

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`tipo_documento_id`);

--
-- Indices de la tabla `unidad_funcional`
--
ALTER TABLE `unidad_funcional`
  ADD PRIMARY KEY (`unidad_funcional_id`),
  ADD KEY `fk_unidad_funcional_obra_civil_id` (`unidad_funcional_obra_civil_id`),
  ADD KEY `fk_unidad_funcional_cliente_id` (`unidad_funcional_cliente_id`),
  ADD KEY `fk_unidad_funcional_estado_uf_id` (`unidad_funcional_estado_uf_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usua_id`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`usrrol_id`),
  ADD KEY `fk_usuario_has_rol_rol1` (`usrrol_rol_id`) USING BTREE,
  ADD KEY `fk_usuario_has_rol_usuario1` (`usrrol_usua_id`) USING BTREE,
  ADD KEY `fk_usuario_rol_aplicacion1` (`usrrol_app_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adjuntos_cliente`
--
ALTER TABLE `adjuntos_cliente`
  MODIFY `adjuntos_cliente_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ajuste`
--
ALTER TABLE `ajuste`
  MODIFY `ajuste_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `aplicacion`
--
ALTER TABLE `aplicacion`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `asistencia_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `contrato_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cuota`
--
ALTER TABLE `cuota`
  MODIFY `cuota_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `especialidad_obrero`
--
ALTER TABLE `especialidad_obrero`
  MODIFY `especialidad_obrero_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `especialidad_proveedor`
--
ALTER TABLE `especialidad_proveedor`
  MODIFY `especialidad_proveedor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `estado_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `estado_civil_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `estado_cliente`
--
ALTER TABLE `estado_cliente`
  MODIFY `estado_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `estado_herramienta`
--
ALTER TABLE `estado_herramienta`
  MODIFY `estado_herramienta_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado_pedido_compra`
--
ALTER TABLE `estado_pedido_compra`
  MODIFY `estado_pedido_compra_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estudio_alcanzado`
--
ALTER TABLE `estudio_alcanzado`
  MODIFY `estudio_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `factura_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `factura_detalle_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `factura_proveedor`
--
ALTER TABLE `factura_proveedor`
  MODIFY `factura_proveedor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  MODIFY `herramienta_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `hito`
--
ALTER TABLE `hito`
  MODIFY `hito_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `licencia_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `log_ingreso`
--
ALTER TABLE `log_ingreso`
  MODIFY `loging_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `material`
--
ALTER TABLE `material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT de la tabla `modulo_paginas`
--
ALTER TABLE `modulo_paginas`
  MODIFY `modpag_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=680;
--
-- AUTO_INCREMENT de la tabla `modulo_tablas`
--
ALTER TABLE `modulo_tablas`
  MODIFY `modtab_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `movimiento_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `obra_civil`
--
ALTER TABLE `obra_civil`
  MODIFY `obra_civil_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `obra_civil_hito`
--
ALTER TABLE `obra_civil_hito`
  MODIFY `obra_civil_hito_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `obra_civil_hito_tarea`
--
ALTER TABLE `obra_civil_hito_tarea`
  MODIFY `obra_civil_hito_tarea_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `obra_yeseria`
--
ALTER TABLE `obra_yeseria`
  MODIFY `obra_yeseria_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `obrero`
--
ALTER TABLE `obrero`
  MODIFY `obrero_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `obrero_obra_yeseria`
--
ALTER TABLE `obrero_obra_yeseria`
  MODIFY `obrero_obra_yeseria_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `orden_compra_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_compra_herramienta`
--
ALTER TABLE `orden_compra_herramienta`
  MODIFY `orden_compra_herramienta_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido_herramienta`
--
ALTER TABLE `pedido_herramienta`
  MODIFY `pedido_herramienta_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `permiso_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7779;
--
-- AUTO_INCREMENT de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  MODIFY `presupuesto_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `puesto_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=208;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `sexo_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `tarea_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tarea_hito`
--
ALTER TABLE `tarea_hito`
  MODIFY `tarea_hito_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tipo_acceso`
--
ALTER TABLE `tipo_acceso`
  MODIFY `tipoacc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `tipo_documento_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `unidad_funcional`
--
ALTER TABLE `unidad_funcional`
  MODIFY `unidad_funcional_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usua_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=153;
--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `usrrol_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=178;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adjuntos_cliente`
--
ALTER TABLE `adjuntos_cliente`
  ADD CONSTRAINT `fk_adjuntos_cliente_id` FOREIGN KEY (`adjuntos_cliente_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ajuste`
--
ALTER TABLE `ajuste`
  ADD CONSTRAINT `fk_ajuste_obra_civil_id` FOREIGN KEY (`ajuste_obra_civil_id`) REFERENCES `obra_civil` (`obra_civil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `fk_asistencia_obrero_id` FOREIGN KEY (`asistencia_obrero_id`) REFERENCES `obrero` (`obrero_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_cliente_estado_id` FOREIGN KEY (`cliente_estado_id`) REFERENCES `estado_cliente` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_localidad_id` FOREIGN KEY (`cliente_localidad_id`) REFERENCES `localidad-` (`localidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_clientes_tipo_doc_id` FOREIGN KEY (`cliente_tipo_doc_id`) REFERENCES `tipo_documento` (`tipo_documento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `fk_contrato_cliente_id` FOREIGN KEY (`contrato_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD CONSTRAINT `fk_cuota_movimiento_id` FOREIGN KEY (`cuota_movimiento_id`) REFERENCES `movimiento` (`movimiento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cuota_unidad_funcional_id` FOREIGN KEY (`cuota_unidad_funcional_id`) REFERENCES `unidad_funcional` (`unidad_funcional_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_cliente_id` FOREIGN KEY (`factura_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD CONSTRAINT `fk_factura_detalle_factura_id` FOREIGN KEY (`factura_detalle_factura_id`) REFERENCES `factura` (`factura_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_detalle_factura_proveedor_id` FOREIGN KEY (`factura_detalle_factura_proveedor_id`) REFERENCES `factura_proveedor` (`factura_proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_detalle_material_id` FOREIGN KEY (`factura_detalle_material_id`) REFERENCES `material` (`material_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_detalle_movimiento_id` FOREIGN KEY (`factura_detalle_movimiento_id`) REFERENCES `movimiento` (`movimiento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD CONSTRAINT `fk_herramienta_estado_herramienta_id` FOREIGN KEY (`herramienta_estado_herramienta_id`) REFERENCES `estado_herramienta` (`estado_herramienta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_herramienta_obra_civil_id` FOREIGN KEY (`herramienta_obra_civil_id`) REFERENCES `obra_civil` (`obra_civil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_herramienta_obra_yeseria_id` FOREIGN KEY (`herramienta_obra_yeseria_id`) REFERENCES `obra_yeseria` (`obra_yeseria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `fk_licencia_obrero_id` FOREIGN KEY (`licencia_obrero_id`) REFERENCES `obrero` (`obrero_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_ingreso`
--
ALTER TABLE `log_ingreso`
  ADD CONSTRAINT `fk_loging_app_id` FOREIGN KEY (`loging_app_id`) REFERENCES `aplicacion` (`app_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_loging_usua_id` FOREIGN KEY (`loging_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_mod_app_id` FOREIGN KEY (`mod_app_id`) REFERENCES `aplicacion` (`app_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulo_paginas`
--
ALTER TABLE `modulo_paginas`
  ADD CONSTRAINT `fk_modpag_mod_id` FOREIGN KEY (`modpag_mod_id`) REFERENCES `modulo` (`mod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulo_tablas`
--
ALTER TABLE `modulo_tablas`
  ADD CONSTRAINT `fk_modtab_mod_id` FOREIGN KEY (`modtab_mod_id`) REFERENCES `modulo` (`mod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `obra_civil`
--
ALTER TABLE `obra_civil`
  ADD CONSTRAINT `fk_obra_civil_estado_id` FOREIGN KEY (`obra_civil_estado_id`) REFERENCES `estado` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obra_civil_localidad_id` FOREIGN KEY (`obra_civil_localidad_id`) REFERENCES `localidad` (`localidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `obra_civil_hito`
--
ALTER TABLE `obra_civil_hito`
  ADD CONSTRAINT `fk_obra_civil_hito_hito_id` FOREIGN KEY (`obra_civil_hito_hito_id`) REFERENCES `hito` (`hito_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obra_civil_hito_obra_civil_id` FOREIGN KEY (`obra_civil_hito_obra_civil_id`) REFERENCES `obra_civil` (`obra_civil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `obra_civil_hito_tarea`
--
ALTER TABLE `obra_civil_hito_tarea`
  ADD CONSTRAINT `fk_obra_civil_hito_tarea_obra_civil_hito_id` FOREIGN KEY (`obra_civil_hito_tarea_obra_civil_hito_id`) REFERENCES `obra_civil_hito` (`obra_civil_hito_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obra_civil_hito_tarea_tarea_id` FOREIGN KEY (`obra_civil_hito_tarea_tarea_id`) REFERENCES `tarea` (`tarea_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `obra_yeseria`
--
ALTER TABLE `obra_yeseria`
  ADD CONSTRAINT `fk_obra_yeseria_cliente_id` FOREIGN KEY (`obra_yeseria_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obra_yeseria_estado_id` FOREIGN KEY (`obra_yeseria_estado_id`) REFERENCES `estado` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obra_yeseria_localidad_id` FOREIGN KEY (`obra_yeseria_localidad_id`) REFERENCES `localidad-` (`localidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `obrero`
--
ALTER TABLE `obrero`
  ADD CONSTRAINT `fk_obrero_categoria_id` FOREIGN KEY (`obrero_categoria_id`) REFERENCES `categoria` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_estado_civil_id` FOREIGN KEY (`obrero_estado_civil_id`) REFERENCES `estado_civil` (`estado_civil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_estudio_alcanzado_id` FOREIGN KEY (`obrero_estudio_alcanzado_id`) REFERENCES `estudio_alcanzado` (`estudio_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_localidad_id` FOREIGN KEY (`obrero_localidad_id`) REFERENCES `localidad` (`localidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_obrero_especialidad_id` FOREIGN KEY (`obrero_obrero_especialidad_id`) REFERENCES `especialidad_obrero` (`especialidad_obrero_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_puesto_id` FOREIGN KEY (`obrero_puesto_id`) REFERENCES `puesto` (`puesto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_sexo_id` FOREIGN KEY (`obrero_sexo_id`) REFERENCES `sexo` (`sexo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_tipo_doc_id` FOREIGN KEY (`obrero_tipo_doc_id`) REFERENCES `tipo_documento` (`tipo_documento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_usuario_id` FOREIGN KEY (`obrero_usuario_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `obrero_obra_yeseria`
--
ALTER TABLE `obrero_obra_yeseria`
  ADD CONSTRAINT `fk_obrero_obra_yeseria_obra_yeseria_id` FOREIGN KEY (`obrero_obra_yeseria_obra_yeseria_id`) REFERENCES `obra_yeseria` (`obra_yeseria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obrero_obra_yeseria_obrero_id` FOREIGN KEY (`obrero_obra_yeseria_obrero_id`) REFERENCES `obrero` (`obrero_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `fk_orden_compra_estado` FOREIGN KEY (`orden_compra_estado`) REFERENCES `estado_pedido_compra` (`estado_pedido_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_compra_usuario_id` FOREIGN KEY (`orden_compra_usuario_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_compra_herramienta`
--
ALTER TABLE `orden_compra_herramienta`
  ADD CONSTRAINT `fk_orden_compra_herramienta_herramineta_id` FOREIGN KEY (`orden_compra_herramienta_herramineta_id`) REFERENCES `herramienta` (`herramienta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_compra_herramienta_orden_compra_id` FOREIGN KEY (`orden_compra_herramienta_orden_compra_id`) REFERENCES `orden_compra` (`orden_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_herramienta`
--
ALTER TABLE `pedido_herramienta`
  ADD CONSTRAINT `fk_pedido_herramienta_herramienta_id` FOREIGN KEY (`pedido_herramienta_herramienta_id`) REFERENCES `herramienta` (`herramienta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_herramienta_pedido_id` FOREIGN KEY (`pedido_herramienta_pedido_id`) REFERENCES `pedido` (`pedido_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `fk_permiso_rol_id` FOREIGN KEY (`permiso_rol_id`) REFERENCES `rol` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permiso_tipoacc_id` FOREIGN KEY (`permiso_tipoacc_id`) REFERENCES `tipo_acceso` (`tipoacc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD CONSTRAINT `fk_presupuesto_cliente_id` FOREIGN KEY (`presupuesto_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_presupuesto_obra_yeseria_id` FOREIGN KEY (`presupuesto_obra_yeseria_id`) REFERENCES `obra_yeseria` (`obra_yeseria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_presupuesto_obrero_id` FOREIGN KEY (`presupuesto_obrero_id`) REFERENCES `obrero` (`obrero_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_especialidad_proveedor_id` FOREIGN KEY (`proveedor_especialidad_proveedor_id`) REFERENCES `especialidad_proveedor` (`especialidad_proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedor_localidad_id` FOREIGN KEY (`proveedor_localidad_id`) REFERENCES `localidad-` (`localidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarea_hito`
--
ALTER TABLE `tarea_hito`
  ADD CONSTRAINT `fk_tarea_hito_hito_id` FOREIGN KEY (`tarea_hito_hito_id`) REFERENCES `hito` (`hito_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tarea_hito_tarea_id` FOREIGN KEY (`tarea_hito_tarea_id`) REFERENCES `tarea` (`tarea_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `unidad_funcional`
--
ALTER TABLE `unidad_funcional`
  ADD CONSTRAINT `fk_unidad_funcional_cliente_id` FOREIGN KEY (`unidad_funcional_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_unidad_funcional_estado_uf_id` FOREIGN KEY (`unidad_funcional_estado_uf_id`) REFERENCES `estado_uf` (`estado_uf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_unidad_funcional_obra_civil_id` FOREIGN KEY (`unidad_funcional_obra_civil_id`) REFERENCES `obra_civil` (`obra_civil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `fk_usrrol_app_id` FOREIGN KEY (`usrrol_app_id`) REFERENCES `aplicacion` (`app_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrrol_rol_id` FOREIGN KEY (`usrrol_rol_id`) REFERENCES `rol` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrrol_usua_id` FOREIGN KEY (`usrrol_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
