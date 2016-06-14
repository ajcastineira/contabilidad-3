-- --------------------------------------------------------
-- Host:                         qqf261.qualidad.info
-- Versión del servidor:         5.1.73 - Source distribution
-- SO del servidor:              redhat-linux-gnu
-- HeidiSQL Versión:             9.3.0.5051
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla qqf261.registrosmedia
CREATE TABLE IF NOT EXISTS `registrosmedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.registrosmedia: ~12 rows (aproximadamente)
DELETE FROM `registrosmedia`;
/*!40000 ALTER TABLE `registrosmedia` DISABLE KEYS */;
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(1, 'Movil Roberto windows phone', './media/WP_20160205_001.jpg');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(4, 'mi movil', './media/1454677459263-763701701.jpg');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(7, 'Prueba sonido', './media/record20160205191150.3gpp');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(8, 'Foto paco', './media/14546995380981249317654.jpg');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(9, 'VÃ­deo paco', './media/VID_20160205_201416.3gp');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(10, 'foto movil roberto', './media/WP_20160206_001.jpg');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(11, 'video movil roberto', './media/WP_20160206_002.mp4');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(12, 'GrabaciÃ³n desde han Roberto con mi movil', './media/record20160206161225.3gpp');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(13, '', './media/1454920204340-2037968869.jpg');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(14, 'h', './media/1454920204340-2037968869.jpg');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(15, 'h', './media/Voz 002.m4a');
INSERT INTO `registrosmedia` (`id`, `descripcion`, `url`) VALUES
	(16, 'Tablet toÃ±i', './media/1455651259530-1863314563.jpg');
/*!40000 ALTER TABLE `registrosmedia` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbasignacion_bbdd
CREATE TABLE IF NOT EXISTS `tbasignacion_bbdd` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `servidor` varchar(50) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `fichero` varchar(30) DEFAULT NULL,
  `IdEmpresa` int(11) DEFAULT NULL,
  `libre_ocupado` varchar(10) DEFAULT 'Libre' COMMENT '''Libre'' u ''Ocupado''',
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fichero` (`fichero`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbasignacion_bbdd: ~19 rows (aproximadamente)
DELETE FROM `tbasignacion_bbdd`;
/*!40000 ALTER TABLE `tbasignacion_bbdd` DISABLE KEYS */;
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(1, 'qrx896.qualidad.info', 'qrx896', 'Jose4011', 'conexionEmpresaNueva.php\r\n', 3, 'Ocupado', '2014-08-07 12:36:07', '2014-08-07 12:36:07');
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(2, 'qqr776.qualidad.info', 'qqr776', 'Az0ch82\r\n', 'conexion3.php\r\n', 1, 'Ocupado', '2014-08-07 12:46:45', '2014-08-07 12:46:45');
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(3, 'qqi384.qualidad.info', 'qqi384', 'dbS4l1r\r\n', 'conexion2.php', 2, 'Ocupado', '2014-08-07 12:48:13', '2014-08-07 12:48:13');
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(4, 'qsg982.qualidad.info\r\n', 'qsg982\r\n', 'cdHg56fOi78\r\n', 'conexion4.php', 4, 'Ocupado', '2014-08-07 12:48:13', '2014-09-16 09:43:24');
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(5, 'qsg984.qualidad.info\r\n', 'qsg984\r\n', 'as6yhJJ76g5\r\n', 'conexion5.php', 5, 'Ocupado', '2014-08-07 12:48:13', '2015-06-03 10:29:08');
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(6, 'qsg985.qualidad.info', 'qsg985\r\n', 'dc89UhH78rE\r\n', 'conexion6.php', NULL, 'Libre', '2014-08-07 12:48:13', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(7, 'qsl289.qualidad.info', 'qsl289', 'dse56Asder9', 'conexion7.php', NULL, 'Libre', '2014-09-17 13:11:24', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(8, 'qsl292.qualidad.info', 'qsl292', 'yhYYt675rTRe', 'conexion8.php', NULL, 'Libre', '2014-09-17 13:16:31', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(9, 'qsl295.qualidad.info', 'qsl295', 'ujLLop09oiI9', 'conexion9.php', NULL, 'Libre', '2014-09-17 13:19:43', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(10, 'qsl297.qualidad.info', 'qsl297', 'Lliou675trEw', 'conexion10.php', NULL, 'Libre', '2014-09-17 13:24:55', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(11, 'qsl300.qualidad.info', 'qsl300', 'edreU54Ret5', 'conexion11.php', NULL, 'Libre', '2014-09-17 13:28:21', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(12, 'qua696.qualidad.info', 'qua696', 'asd526jKKl', 'conexion12.php', NULL, 'Libre', '2015-09-10 12:47:42', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(13, 'qua700.qualidad.info', 'qua700', '41aAhgT401', 'conexion13.php', NULL, 'Libre', '2015-09-10 12:48:49', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(14, 'qua701.qualidad.info', 'qua701', 'Aqew54sSd5', 'conexion14.php', NULL, 'Libre', '2015-09-10 12:50:05', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(15, 'qua702.qualidad.info', 'qua702', 'Aqew54sSd5', 'conexion15.php', NULL, 'Libre', '2015-09-10 12:55:52', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(16, 'qua703.qualidad.info', 'qua703', 'zZAa4566rrt', 'conexion16.php', NULL, 'Libre', '2015-09-10 12:57:38', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(17, 'qua705.qualidad.info', 'qua705', '601AsdeRT5', 'conexion17.php', NULL, 'Libre', '2015-09-10 12:59:18', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(18, 'qua707.qualidad.info', 'qua707', 'zS635ghTY5k', 'conexion18.php', NULL, 'Libre', '2015-09-10 12:59:58', NULL);
INSERT INTO `tbasignacion_bbdd` (`id`, `servidor`, `usuario`, `password`, `fichero`, `IdEmpresa`, `libre_ocupado`, `fecha_alta`, `fecha_asignacion`) VALUES
	(19, 'quc550.qualidad.info', 'quc550', 'zS635ghTY5k', 'conexionDemo.php', 6, 'Ocupado', '2015-09-28 10:04:02', '2015-09-28 13:21:44');
/*!40000 ALTER TABLE `tbasignacion_bbdd` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbcargos
CREATE TABLE IF NOT EXISTS `tbcargos` (
  `lngId` int(11) NOT NULL DEFAULT '0',
  `strCargo` varchar(50) NOT NULL,
  `strPermisos` text,
  PRIMARY KEY (`lngId`),
  KEY `lngId` (`lngId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbcargos: ~24 rows (aproximadamente)
DELETE FROM `tbcargos`;
/*!40000 ALTER TABLE `tbcargos` DISABLE KEYS */;
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(-99, 'Sin Permisos Asignados', NULL);
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(0, 'Administrador', ', 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 75, 76, 77,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(1, 'Director Business Travel', ', , 10, 11, 12, 13, 10, , 10, 11, 12, 13, 10, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 73, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 74, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 58, 59, 60, 61, 62, 65, 71, 75,,,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(2, 'Directora de Calidad', ', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 12, 13, 10, 14, 14, 15, 16, 17, 73, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 28, 29, 30, 31, 32, 33, 34, 34, 35, 36, 37, 38, 39, 40, 41, 74, 42, 43, 44, 45, 46, 47, 80, 81, 82, 83, 48, 48, 49, 49, 50, 51, 52, 52, 53, 53, 54, 55, 56, 58, 57, 58, 59, 62, 60, 61, 62, 65, 71, 75,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(3, 'Responsable de Departamento', ', 4, 5, 7, 8, 9, 10, 12, 13, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 52, 53, 55, 56, 58, 59, 60, 62, 65,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(4, 'Empleado', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(5, 'Comercial', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(6, 'Secretaria Dir. Regional', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(7, 'Director Regional', ', 4, 5, 7, 8, 9, 10, 12, 13, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 52, 53, 55, 56, 58, 59, 60, 62, 65,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(8, 'Coordinador Operativo BT', ', , 14, 14, 14, 15, 16, 16, 16, , 1, 2, 3, 4, 5, 6, 7, 8, 9, 4, 5, 7, 8, 9, 10, 12, 13, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 52, 53, 55, 56, 58, 59, 60, 62, 65,,,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(9, 'Director BTC', ', 4, 5, 7, 8, 9, 10, 12, 13, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 52, 53, 55, 56, 58, 59, 60, 62, 65,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(10, 'Director Implant', ', 4, 5, 7, 8, 9, 10, 12, 13, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 52, 53, 55, 56, 58, 59, 60, 62, 65,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(11, 'Jefe Comercial', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(12, 'Jefe de Isla', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(13, 'Jefe de Back', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(14, 'Operador de Front', ', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 12, 13, 10, 14, 14, 15, 16, 17, 73, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 28, 29, 30, 31, 32, 33, 34, 34, 35, 36, 37, 38, 39, 40, 41, 74, 42, 43, 44, 45, 46, 47, 80, 81, 82, 83, 48, 48, 49, 49, 50, 51, 52, 52, 53, 53, 54, 55, 56, 58, 57, 58, 59, 62, 60, 61, 62, 65, 71, 75,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(15, 'Operador de Back', ', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 12, 13, 10, 14, 14, 15, 16, 17, 73, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 28, 29, 30, 31, 32, 33, 34, 34, 35, 36, 37, 38, 39, 40, 41, 74, 42, 43, 44, 45, 46, 47, 80, 81, 82, 83, 48, 48, 49, 49, 50, 51, 52, 52, 53, 53, 54, 55, 56, 58, 57, 58, 59, 62, 60, 61, 62, 65, 71, 75,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(16, 'Coordiandor de Mensajero', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(17, 'Mensajero', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(18, 'Telefonista ', ', 4, 5, 12, 18, 23, 24, 25, 28, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 48, 51, 52, 55, 56, 58, 62,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(19, 'Coordinador Operativo', ', 4, 5, 7, 8, 9, 10, 12, 13, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 52, 53, 55, 56, 58, 59, 60, 62, 65,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(20, 'Auxiliar de Calidad', ', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 65, 71, 74, 75, 77,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(21, 'Auditor', ', 4, 5, 8, 12, 18, 21, 22, 25, 27, 30, 31, 36, 38, 39, 40, 42, 44, 45, 47, 51, 55, 58, 62, 63, 65,');
INSERT INTO `tbcargos` (`lngId`, `strCargo`, `strPermisos`) VALUES
	(22, 'Cliente Supervisor', ', , 59, 62, 60, 60, 61, 62, 48, 51, 55, 58, 62,,');
/*!40000 ALTER TABLE `tbcargos` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbcliprov
CREATE TABLE IF NOT EXISTS `tbcliprov` (
  `IdCliProv` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(50) DEFAULT NULL,
  `CIF` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `municipio` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `CP` int(11) DEFAULT '0',
  `Telefono1` int(11) DEFAULT '0',
  `Telefono2` int(11) DEFAULT '0',
  `Fax` int(11) DEFAULT '0',
  `Correo` varchar(50) DEFAULT NULL,
  `Actividad` varchar(50) DEFAULT NULL,
  `CNAE` int(11) DEFAULT '0',
  `NumSS` int(11) DEFAULT '0',
  `Borrado` int(11) DEFAULT NULL,
  `CliProv` int(11) DEFAULT '0' COMMENT '0-Clientes 1-Proveedor',
  PRIMARY KEY (`IdCliProv`),
  KEY `IdCliProv` (`IdCliProv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbcliprov: ~105 rows (aproximadamente)
DELETE FROM `tbcliprov`;
/*!40000 ALTER TABLE `tbcliprov` DISABLE KEYS */;
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(1, 'Institut Dental ILERDENT, S.L.', 'B25321514', 'Sant Antoni, 2', 'LLEIDA', 'LLEIDA', 25002, 0, 0, 0, 'Dani@ilerdent.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(2, 'Barclays Bank, S.A.', 'A47001946', 'Colón, 1', 'MADRID', 'MADRID', 28046, NULL, NULL, NULL, 'nacho.martin@barclays.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(3, 'Unión de Gestión Hipotecaria, S.L.', 'B50919604', 'Hermanos Garcia Noblejas, 41-3º', 'MADRID', 'MADRID', 28037, NULL, NULL, NULL, 'jmlahera@ugh.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(4, 'MDC Montaje y Diseño de Cableado,SL', 'B60546348', 'Ptincipal - Pol. Ind. Can Clapers, 43', 'SENTMENAT', 'BARCELONA', 8181, NULL, NULL, NULL, 'admin@cableados-mdc.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(5, 'AC NET, SV, S.A.U.', 'A82968249', 'de la Castellana, 89', 'MADRID', 'MADRID', 28046, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(6, 'Nagibe Mokbell Llata', '01937089Y', 'Cáceres, 48 -2E', 'MADRID', 'MADRID', 28045, 0, 0, 0, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(7, 'Titulización de Activos SGFT, S.A.', 'A80352750', 'Orense  - Edif. Eurobuilding, 69-2º', 'MADRID', 'MADRID', 28080, NULL, NULL, NULL, 'duboisjl@tda-sgft.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(8, 'JDSU Spain, S.A.', 'A78431483', 'Manoteras, 44 - 6ºB', 'MADRID', 'MADRID', 28050, 913836027, NULL, NULL, 'soledad.gonzalez@jdsu.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(9, 'Realtel Sistemas de Comunicación, SL', 'B82573031', 'Tellez, 52 - Local B', 'MADRID', 'MADRID', 28007, 0, 0, 0, 'nmunicio@realtel.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(10, 'CERO Mediterraneo, SAU.', 'A46642054', 'Conde de los Gaitanes, 81', 'MADRID', 'MADRID', 28109, NULL, NULL, NULL, 'oscar@cero.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(11, 'Isoexpertise, S.L.', 'B84387166', 'Maiquez, 21', 'MADRID', 'MADRID', 28009, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(12, 'IM Goya Hipotecario I. FTA.', 'G85241024', 'Plaza Pablo Ruiz Picasso, s/n - 22º', 'MADRID', 'MADRID', 28020, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(13, 'Grupo Regatas Hispania, S.L.', 'B06519243', 'San Juan, 21-A', 'MERIDA', 'BADAJOZ', 6800, NULL, NULL, NULL, 'gerencia@gruporegatashispania.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(14, 'SKN Consulting Informático, S.L.', 'B83036962', 'del Pinar, 29', 'ALCORCON', 'MADRID', 28925, 0, 0, 0, 'info@skn.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(15, 'BCTS Spain, S.L.', 'B84276278', 'Quimicas, 2', 'ALCORCON', 'MADRID', 28923, 0, 0, 0, 'wburga@bctspain.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(16, 'Davanti Limpieza en Seco, S.L.', 'B83932574', 'Santo Domingo de  Silos, 8', 'MADRID', 'MADRID', 28036, 0, 0, 0, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(17, 'Daim Tintorerias, S.L.', 'B84548890', 'Concha Espina, 1', 'MADRID', 'MADRID', 28036, 0, 0, 0, 'davidpsegarra@wanadoo.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(18, 'Ingenico Services Iberia, S.A.', 'A78425774', 'Partenón, 16 - 18 - 4ª planta', 'MADRID', 'MADRID', 28042, NULL, NULL, NULL, 'juancarlos.yusta@si.ingenico.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(19, 'S A T, S.L.U.', 'B28857860', 'Toledo, 168', 'MADRID', 'MADRID', 28005, NULL, NULL, NULL, 'mfernandez@satferroli.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(20, 'GEBEMA Construcciones y Reformas, SL', 'B13450382', 'Estación, 27', 'ALMODOVAR DEL CAMPO', 'CIUDAD REAL', 13580, NULL, NULL, NULL, 'angeltorrijos@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(21, 'Mudanzas Zarza, S.A.', 'A28617983', 'Villaamil, 76', 'MADRID', 'MADRID', 28039, NULL, NULL, NULL, 'info@mudanzaszarza.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(22, 'Repessa Sistemas, S.A.', 'A28641686', 'General Martínez Campos, 20', 'MADRID', 'MADRID', 28010, NULL, NULL, NULL, 'adelarosa@repessa.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(23, 'Logisat  Sistemas, S.L.', 'B83850776', 'Maria Tubau, 8 - 3º B', 'MADRID', 'MADRID', 28050, NULL, NULL, NULL, 'adelarosa@repessa.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(24, 'Carpintería Ballesteros S.L.U.', 'B84313295', 'Eraso, 31', 'MADRID', 'MADRID', 28028, 0, 0, 0, 'ebanisteriaballesteros@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(25, 'Maria del Carmen Lopez Carmona Pint', '5620968K ', 'Garcia de Paredes, 3', 'MADRID', 'MADRID', 28010, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(27, 'Ventureta, S.L.', 'B83106484', 'Ventura de la Vega, 10', 'MADRID', 'MADRID', 28014, NULL, NULL, NULL, 'patfer00@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(28, 'Germanischer Lloyd Certificación SER', 'B83701334', 'Pedro Teixeira, 8 - 6º E', 'MADRID', 'MADRID', 28020, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(29, 'Info Public Consulting, S.L.', 'B82501347', 'Velazquez, 121', 'MADRID', 'MADRID', 28006, NULL, NULL, NULL, 'amruiz@infoayudas.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(30, 'Química Farmacéutica BAYER, S.A.', 'A28049582', 'Calabria, 268', 'BARCELONA', 'BARCELONA', 8029, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(31, 'Restaurante de Las Cortes, S.L.', 'B81781189', 'Ventura de la Vega, 10', 'MADRID', 'MADRID', 28014, NULL, NULL, NULL, 'lacabanaargentina@telefonica.net', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(32, 'Viajes Iberia, S.A.', 'A07001415', 'C/ Rita Levi, s/n', 'PALMA DE MALLORCA', 'ILLES BALEARS', 7121, NULL, NULL, NULL, 'vanessa.ramos@viajesiberia.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(33, 'Ahorro y Titulización S.G.F.T.,S.A.', 'A80732142', 'de la Castellana, 143-7º', 'MADRID', 'MADRID', 28046, NULL, NULL, NULL, 'aillanes@ceca.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(34, 'Formar y Seleccionar, S.L.', 'B83873133', 'Rafael Salgado, 11 - 3º', 'MADRID', 'MADRID', 28036, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(35, 'Frutas AZ, S.L.', 'B80372220', 'Mercamadrid, Nave A - Pto.37 Ctra. Villa', 'MADRID', 'MADRID', 28053, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(36, 'David Raymundo Mejía', '05323488T', 'Iriarte, 26', 'MADRID', 'MADRID', 28028, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(37, 'Moti Petrisor', 'X6907240H', 'Iriarte, 26', 'MADRID', 'MADRID', 28028, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(38, 'Pelegrina Blasco, S.C.P.', 'G63613434', 'Agricultura, 25-27', 'MOLLET DEL VALLES', 'BARCELONA', 8100, NULL, NULL, NULL, 'jmpelegrina@ecodi.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(39, 'Blau Calor Energy, S.L.', 'B63897128', 'Nuria, 22', 'PRAT DE LLOBREGAT, EL', 'BARCELONA', 8820, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(40, 'Institut Geriatric Torras, S.L. ', 'B17391061', 'Josep Irla, 7', 'SALT', 'GIRONA', 17190, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(41, 'Proexma D\'Anoia, S.L.', 'B61234167', 'Dinamarca, 1', 'IGUALADA', 'BARCELONA', 8700, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(42, 'Construcciones Ferlavila, S.L.', 'B63622708', 'Algarrobo, 15', 'VILADECANS', 'BARCELONA', 8840, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(43, 'Repamagri,.S.L.', 'B38494662', 'General El Socorro, 191', 'TEGUESTE', 'STA CRUZ DE TENERIFE', 38280, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(44, 'Instalconfort Rubi, S.C.P.', 'G63056121', 'Federico García Lorca, 35', 'RUBI', 'BARCELONA', 8191, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(45, 'Residencia Geriátrica Genesis II', 'B60646486', 'Moncada, 121', 'TERRASSA', 'BARCELONA', 8221, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(46, 'Joan García Martínez', '39833367N', 'Pol. Ind. Llicoristes, s/n', 'VALLS', 'TARRAGONA', 43800, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(47, 'Envans Pluvials Puig, S.L.', 'B63586366', 'Marie Curie, nave 8', 'TERRASSA', 'BARCELONA', 8223, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(48, 'Trenchsalvic, S.L.', 'B60742202', 'Reverent Antoni Solanas, 69', 'SANT BOI DE LLOBREGAT', 'BARCELONA', 8830, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(49, 'Pavianca 2003, S.L.', 'B83729020', 'Camino de Santiago, 1 - 5º B', 'ALCALA DE HENARES', 'MADRID', 28806, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(50, 'Estructuras Pecofris, S.L.', 'B63039606', 'Villamaría, 86-88', 'BARCELONA', 'BARCELONA', 8015, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(51, 'Interclean Services, S.L.', 'B62598578', 'Llull - local, 252-254', 'BARCELONA', 'BARCELONA', 8005, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(52, 'UTE Tinsa-Qualidad', 'G84944982', 'Jose Echegaray, 9', 'LAS ROZAS', 'MADRID', 28230, NULL, NULL, NULL, 'cgm@tinsa.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(53, 'Ayamaka, S.L.', 'B80070139', 'José Ortega y Gasset, 22-24', 'MADRID', 'MADRID', 28006, NULL, NULL, NULL, 'jm.ortega@qualidad.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(54, 'Europair Broker, S.A.', 'A07663354', 'Cristobal Bordiú, 22-E', 'MADRID', 'MADRID', 28003, NULL, NULL, NULL, 'administracion@europair.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(55, 'Divecreus, S.L.', 'B-17477829', 'Caritat Serinyana, 17', 'CADAQUES', 'Girona', 17488, 972258876, NULL, 972258876, 'sotamar@telefonica.net', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(56, 'Servicios Eléctricos Pelegrina y Blasco S.L.', 'B64798192', 'Agricultura, 25', 'Mollet del Vallés', 'Barcelona', 8100, 935931684, NULL, 935445047, 'jmpelegrina@ecodi.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(57, 'Limpiezas Hermarlim, S.L.', 'B80829146', 'Sisones, 2 Nave 42 (Pol. Ind. El Cascajal)', 'PINTO', 'Madrid', 28320, 916912897, NULL, 916924658, 'isabel_hermarlim@yahoo.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(58, 'Análisis y Control, S.A.', 'A28615607', 'Av. de la Democracia, 7', 'MADRID', 'Madrid', 28031, 913313850, NULL, NULL, 'a.perez@analisisycontrol.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(59, 'Faustino García Yebra e Hijos, S.L.', 'B-78531324', 'Camino de la Isabela, 37', 'Los Hueros-Villalbilla', 'Madrid', 28810, 918898754, NULL, 918793743, 'faustinogarciayebraehijos@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(60, 'Investigación y Programas, S.A.', 'A28905123', 'José Bardasano Baos, 9 (Edif. Gorbea 3ª)', 'Madrid', 'Madrid', 28016, 0, 0, 915159200, 'astu@ipsa.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(63, 'Venturini España, S.A.U.', 'A78289006', 'de la Industria, 17', 'Tres Cantos', 'Madrid', 28760, 918060620, 0, 0, 'jcjuarez@vesadirect.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(64, 'MARTIN ARTS GRÁFIQUES, S.L.', 'B08783664', 'Abad Odó, nº 81-83', 'Barcelona', 'Barcelona', 8030, 933451000, 0, 933459443, 'antoni@martinagsl.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(67, 'Tourline Express Mensajería SLU', 'B-63238455', 'La Selva, 12', 'EL PRAT DE LLOBREGAT', 'Barcelona', 8820, 916732513, 0, 0, 'tourline7@tourlineexpress.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(69, 'Talleres Clar, S.L.', 'B85591824', 'Torres Miranda, 17', 'Madrid', 'Madrid', 28045, 914735768, NULL, 914735768, 'talleresclar@yahoo.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(70, 'Viajes Halcón, S.A.U.', 'A10005510', 'Arenal-Llucmajor, Km. 21,5', 'Palma de Mallorca', 'Baleares', 7620, 915406048, 629784886, 915595669, 'miriam.alonso@globalia-corp.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(71, 'Fotocopias Universidad, S.A.', 'A78948999', 'Europa, 5', 'Pozuelo de Alarcón', 'Madrid', 28224, 913523114, 609141542, 913517430, 'fcembranos@powerprint.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(72, 'Restobar Argentino, S.L.', 'B-85559375', 'Echegaray, 5', 'Madrid', 'Madrid', 28014, 0, 0, 0, 'lacabanaargentina@telefonica.net', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(73, 'Venturini, S.A.', 'A-78531196', 'Av. de los Artesanos, 31-33', 'ALAQUAS', 'Valencia', 46970, 0, 0, 0, 'jcjuarez@vesadirect.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(75, 'Datacard Ibérica, S.L.U.', 'B81188047', 'Po Club Deportivo, 1 - blq. 3 bajo', 'Pozuelo de Alarcón', 'Madrid', 28223, 0, 0, 0, 'marina_gaztelumendi@datacard.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(76, 'Dibupel Servicios Globales, S.L.', 'B70277678', 'Villa de Noia, 84-86 4B', 'Carballo', 'La Coruña', 15100, 935172845, 672210156, 0, 'montse@unmardetentaciones.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(77, 'Gema Servicios de Restauración, S.L.', 'B70285010', 'Villa de Noia, 84 -4B', 'Carballo', 'La Coruña', 15100, 0, 0, 0, 'montse@unmardetentaciones.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(78, 'Nieves López López', '33802640T', 'Canillas, 62 - 1º C', 'Madrid', 'Madrid', 28023, 0, 0, 0, 'elena.calo@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(79, 'JF INFORMATICA', 'B80658032', 'Guadarrama, nº 13', 'San Sebatián de Los Reyes', 'Madrid', 28700, 916637120, NULL, NULL, 'david@jfinformatica.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(80, 'Agencia Estatal Administración Tributaria', 'Q2826000H', 'Lérida, 32-34', 'Madrid', 'Madrid', 28020, 0, 0, 0, 'mcarmen.guerrero@correo.aeat.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(81, 'Key, S.A.', 'A28328458', 'Manufactura, 11', 'Mairena del Aljarafe', 'Sevilla', 41927, 918060620, NULL, NULL, 'jcjuarez@servinform.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(82, 'Mecanizados Pelegrina y Rubio SCP', 'J62364146', 'Pasaje Comte D\'Urgell,  11', 'Mollet del Vallés', 'Barcelona', 8100, 935931684, 0, 0, 'jmpelegrina@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(83, 'Iberworld Airlines, S.A.', 'A07788318', 'Rita Levi, s/n', 'Parc Bit', 'Palma de Mallorca', 7121, 0, 0, 0, 'joseluis.cardona@orbest.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(84, 'Orizonia Destination Management S.L.', 'B57581076', 'Rita Levi, s/n', 'Parc Bit', 'Palma de Mallorca', 7121, 971076161, 0, 0, 'elena.pozo@orizonia.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(85, 'Alfa Cargo & Logistics Services, S.L.', 'B86436052', 'Embajadores, 296 - 5º', 'Madrid', 'Madrid', 28045, 0, 654433356, 0, 'clariviello@alfalogistics.net', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(86, 'XP SERVEIS EL PLA, S.L.U', 'B25560418', 'POU NOU, 12', 'EL PALAU D\'ANGLESOLA', 'LLEIDA', 25243, 973710540, 0, 973711028, 'albert@xpserveiselpla.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(87, 'Ingenico Iberia S.L.U.', 'B82241506', 'Partenon, 16-18', 'Madrid', 'Madrid', 28042, 918375000, 0, 0, 'marisol.cerrada@ingenico.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(89, 'Impermeabilizaciones Trassierra, SCP', 'J64594369', 'Port de la Bonaigua, 15', 'Vallirana', 'BARCELONA', 8759, 936834203, 667747561, NULL, 'trassiv@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(90, 'Residencia Royal Llar, S.L.', 'B62309760', 'Gran Via de Les Corts Catalanes,695 principal 1ª', 'Barcelona', 'Barcelona', 8013, 932311118, NULL, NULL, 'royalllar@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(91, 'Fachadas Zaren, S.L.', 'B64801962', 'Hospitalet, 11 Local', 'Sant Feliu de Llobregat', 'Barcelona', 8980, 934770214, NULL, NULL, 'fachadaszaren@fachadaszaren.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(92, 'Pintores Radiant, SCCL', 'F62491873', 'Laureá Miró, 353', 'Esplugues de Llobregat', 'Barcelona', 8950, NULL, 692898817, NULL, 'pintoresradiant@yahoo.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(93, 'Geriátric Emily, S.L', 'B62258298', 'Sant Elies, 9 Torre', 'Barcelona', 'Barcelona', 8006, 934144001, NULL, 932019002, 'pverdaguer33@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(94, 'Mecanitzats Mecane, S.L.', 'B65010670', 'Industrial del Mig, 62-64, Carrer B Nau 8A', 'Cabrera de Mar', 'Barcelona', 8349, 931500068, NULL, NULL, 'mecane@mecane.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(95, 'Restauraciones Talan, S.L.', 'B75014357', 'Erramun Astibia, 1 3º B', 'Renteria', 'Guipuzcoa', 20100, NULL, 659045888, NULL, 'info@pinturastalan.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(96, 'Universal Embaladora, S.L.', 'B58992207', 'Ind. Can Humet de Dalt-Camí Can Vinyals,Naves 2A-2', 'Polinyá', 'Barcelona', 8213, 937133161, 0, 937133189, 'embalajes@uembal.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(97, 'Infomallorca, S.L.', 'B-07894215', 'Valldemosa, Km. 7,400', 'PARC BIT', 'Palma de Mallorca', 7121, 0, 0, 0, 'miquel.terrasa@viboviajes.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(98, 'Doves Informática, S.L.', 'B86559036', 'Mercado, 3', 'GALAPAGAR', 'Madrid', 28260, 912862524, 605364790, 0, 'angelesespinar@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(99, 'Técnicos en Tasación, S.A.', 'A78116324', 'Europa, 26-5-2ª', 'POZUELO DE ALARCON', 'Madrid', 28224, 917823820, NULL, NULL, 'mherrero@tecnitasa.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(100, 'JOMABER, S.L', 'B59305169', 'Pintor sert, nave 34 Poligono SUR ESTE', 'POLINYÀ', 'BARCELONA', 8213, 937133095, NULL, NULL, '"', NULL, 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(101, 'TOT HIDRAULIC, S.L', 'B25285487', 'Partida la Mariola, 27', 'Lleida', 'Lleida', 25192, 973221838, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(102, 'ARIZONA 2001, S.L', 'B62532072', 'VALLALTA, 14', 'SANT ANTONI DE VILAMAJOR', 'BARCELONA', 8459, NULL, 629651785, NULL, 'PABLOANDA@HOTMAIL.COM', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(103, 'AUTOMATISMOS Y TÉCNICAS EN CUADROS, S.L', 'B65764284', 'PROGRÈS, 228', 'BADALONA', 'BARCELONA', 8918, NULL, NULL, NULL, 'j.bonet.bonet@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(104, 'Sidrería El Tigre, S.L.', 'B86594595', 'Hortaleza, 26', 'MADRID', 'MADRID', 28004, 915320072, 636450477, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(105, 'Globalia Servicios Corporativos, SAU', 'B07948979', 'Ctra. Arenal Llucmajor Km. 21,5', 'Llucmajor', 'Islas Baleares', 7620, NULL, NULL, NULL, 'virginia.santos@globalia.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(106, 'Red Quavitor, S.L.P.', 'B85644292', 'Peña Vargas, nº 9', 'MADRID', 'MADRID', 28031, NULL, NULL, NULL, 'angeltorrijos@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(107, 'Instituto Español Funerario, S.L', 'B66085291', 'Doctor Marañon, 11', 'MALGRAT DE MAR', 'BARCELONA', 8380, NULL, NULL, NULL, 'joseplluismulero@peritojudicial.pro', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(109, 'Zertia Telecomunicaciones, S.L.', 'B84458140', 'Avda. de la Industria, 32', 'Alcobendas', 'MADRID', 28108, 902995567, NULL, NULL, 'Ana.gabriel@zertia.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(111, 'ALEXIS MARTÍNEZ MUÑIZ', '47331800P', 'Joan Brosa, 15', 'Tiana', 'BARCELONA', 8391, 935799842, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(112, 'Asociación Equitación como Terapia', 'G86055019', 'de Yeserías, 33', 'Madrid', 'Madrid', 28005, 0, 616251200, 0, 'equitacionterapia@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(114, 'Tigre del Norte, S.L.', 'B86901816', 'Infantas, 30', 'Madrid', 'Madrid', 28004, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(116, 'Vaz Lorenco, S.L.', 'B85417020', 'San Bartolomé, 7', 'Madrid', 'Madrid', 28004, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(117, 'ETNA & CHRIS, S.L.', 'B86941911', 'Enrique Granados, 6', 'POZUELO DE ALARCON', 'Madrid', 28224, NULL, NULL, NULL, 'miriam.alonso@globalia-corp.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(118, 'Area10', 'B06148811', 'Pza. de España, 16', 'Badajoz', 'Badajoz', 6002, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(119, 'Angel Torrijos Fuensalida', '50967331K', 'Piedra Buena, 53', 'Ciudad Real', 'Ciudad Real', 13005, NULL, NULL, NULL, 'angeltorrijos@hotmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(120, 'Juan y Mauricio, S.C.', 'J87027538', 'Pla de San Joan, nº 11', 'Ciutadella de Menorca', 'Islas Baleares', 7760, NULL, NULL, NULL, 'coboamores@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(121, 'Ibermutuamur', 'G81939217', '', '', '', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(122, 'VIAJES BARCELO, S.L.', 'B07012107', 'José Rover Motta, 27', 'Palma de Mallorca', 'ISLAS BALEARES', 7006, NULL, NULL, NULL, 'c.delrio@bcdtravel.es', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(123, 'CRITHERIA GROUP FORMATION', 'B06637730', 'Canarias, 23-B', 'BADAJOZ', 'Badajoz', 6007, NULL, NULL, NULL, 'administracion@critheria.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(124, 'Cuadros,Traceados e Instalaciones Eléctricas, S.L.', 'B66415555', 'Progreso, 228', 'Barcelona', 'Barcelona', 8918, NULL, NULL, NULL, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(125, 'Comidas Lucia', 'B4125368', 'Calle Polvoranca 8', 'Al', 'Madrid', 0, 0, 0, 0, 'jm.ortega@qualidad.com', 'Comidas', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(126, 'Ebanisteria Juan Moreras', 'v526398', 'Calle Diego de León 69 4H', 'Móstoles', 'Madrid', 0, 0, 0, 0, '', 'Ebanisteria', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(127, 'Cerrajeria Bienbe', 'R5236987', 'Calle Libertad 22', 'Algete', 'Madrid', 0, 0, 0, 0, '', 'Cerrajeria', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(128, 'Juan Alarcón', 'Y10253698', 'Plaza Legazpi 2', 'Madrid', 'Madrid', 0, 0, 0, 0, '', 'Ferralla', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(129, 'Mim cliente', 'g41255877', 'Plaza Legazpi 2', 'Madrid', 'Madrid', 0, 0, 0, 0, '', 'Delineacion', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(130, 'Lucas Moura', 'g5253654788', 'Calle Libertad 22', 'Algete', 'Madrid', 0, 0, 0, 0, NULL, NULL, 0, 0, NULL, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(131, 'Nuevo Paco', 'Z5698795644', 'Calle de la Morte 19', 'Fuenlabrada', 'Madrid', 28444, 914445566, 0, 0, 'qualidadinformatica@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(132, 'Cliente Prueba', 'B1111111111', 'Calle', 'Municipio', 'Provincia', 0, 0, 0, 0, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(133, 'Proveedor Prueba', 'B2222222', 'Calle', 'Municipio', 'Provincia', 0, 0, 0, 0, '', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(134, 'dasda asdasd', 'G38995114', '', '555', 'asd', 5454, 5445, 0, 0, 'a@gmail.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(135, 'Contacto', '542542', '', '', '', 0, 0, 0, 0, 'soporte@qualidad.com', '', 0, 0, 0, 0);
INSERT INTO `tbcliprov` (`IdCliProv`, `nombre`, `CIF`, `direccion`, `municipio`, `provincia`, `CP`, `Telefono1`, `Telefono2`, `Fax`, `Correo`, `Actividad`, `CNAE`, `NumSS`, `Borrado`, `CliProv`) VALUES
	(136, 'Amisaday  Rodríguez García', '78613189V', 'C/Uruguay', 'Los Realejos', 'Santa Cruz de Tenerife', 38410, 0, 699377623, 0, 'a.rg03211@gmail.com', '', 0, 0, 0, 0);
/*!40000 ALTER TABLE `tbcliprov` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbconsulta_pregunta
CREATE TABLE IF NOT EXISTS `tbconsulta_pregunta` (
  `lngIdPregunta` int(10) DEFAULT NULL,
  `lngIdUsuario` int(10) DEFAULT NULL,
  `strPregunta` longtext CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `strClasificacion` varchar(20) DEFAULT NULL,
  `strEstado` varchar(20) DEFAULT NULL,
  `strDoc` varchar(100) DEFAULT NULL,
  `lngStatus` int(2) DEFAULT NULL,
  `datFechaStatus` datetime DEFAULT NULL,
  `leido` int(2) NOT NULL COMMENT '0= NO 1= SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbconsulta_pregunta: ~67 rows (aproximadamente)
DELETE FROM `tbconsulta_pregunta`;
/*!40000 ALTER TABLE `tbconsulta_pregunta` DISABLE KEYS */;
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(1, 2, 'Pregunta para AMARTIN, SBAQUERO y BAR', 'Mercantil', 'En Curso', '', 1, '2014-09-04 11:54:00', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(2, 17, 'Pregunta de AMARTIN', '', 'Cerrada', '', 1, '2014-09-04 11:56:50', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(3, 17, 'Pregunta n2 AMARTIN', '', 'Cerrada', '', 1, '2014-09-04 11:57:05', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(4, 182, 'Pregunta de BAR', '', 'Abierto', '', 1, '2014-09-04 11:58:20', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(5, 17, 'Pregunta de SBAQUERO', 'Laboral', 'Cerrada', '', 1, '2014-09-04 11:59:31', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(6, 195, 'Pregunta de Paco Parralejo', '', 'Abierto', '', 1, '2014-09-04 12:05:59', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(7, 182, 'Pregunta n2 de BAR', '', 'Abierto', '', 1, '2014-09-04 12:07:48', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(8, 0, 'Pregunta a Paco Parralejo, Barbara, Angel Martin y Santiago Baquero', '', 'Cerrada', '', 1, '2014-09-04 12:10:47', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(9, 17, 'Pregunta JM', '', 'Cerrada', '', 1, '2014-09-04 13:01:26', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(10, 0, 'Comunicado del ASESOR  MORLACAL', '', 'Abierto', '', 1, '2014-09-04 13:19:06', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(11, 17, 'Paco. A ver si terminas la aplicación que hay que venderla.', '', 'Abierto', '', 1, '2014-09-04 14:00:18', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(12, 2, 'Pregunta desde ARSYS', '', 'Abierto', '', 1, '2014-09-08 10:32:40', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(13, 2, 'A Benzema le ha durado un año la tranquilidad. Hoy, cuando se incorpore a los entrenamientos con el Real Madrid, se encontrará en el vestuario de Valdebebas con otro delantero: Chicharito.\r\n32 goles llegó a firmar Benzema en la segunda temporada de Mourinho\r\nKarim se marchó el pasado lunes con la selección siendo el único nueve del conjunto blanco. A su regreso a Madrid una semana después, se encontrará con un competidor directo por su puesto.\r\nEl Madrid se entrena hoy por la tarde para poder contar con los internacionales que jugaron ayer. Benzema es uno de ellos —junto a Varane, Kroos, James, Pepe y Coentrao—. Por tanto, será la primera vez que Chicharito y él se vean las caras tras el fichaje in extremis del exjugador del Manchester United. Se saludarán y, desde ese momento, arrancará la batalla del nueve en el Real Madrid.\r\nLa llegada de Chicharito no pone en peligro la condición de titularísimo de Benzema. Al menos, a corto plazo. Ancelotti confía ciegamente en el francés, al que considera vital en el engranaje de la BBC. Con Cristiano Ronaldo y Bale, más que un goleador, el técnico italiano necesita un buen socio para ellos. Y Karim eso lo hace de lujo.\r\n', '', 'Abierto', '', 1, '2014-09-08 10:38:08', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(14, 2, 'Pregunta de prueba con totos los correos que tengo 187', '', 'Abierto', '', 1, '2014-09-08 11:12:05', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(15, 2, 'Pregunta 2 desde ARSYS', '', 'Abierto', '', 1, '2014-09-08 13:09:36', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(16, 2, 'qqqq qqq qq qqqq qq q qq', '', 'Abierto', '', 1, '2014-09-08 13:27:39', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(17, 2, 'Pregunta n3 ARSYS', '', 'Abierto', '', 1, '2014-09-08 13:30:46', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(18, 2, 'Pregunta n4 ARSYS', '', 'Abierto', '', 1, '2014-09-08 13:32:08', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(19, 2, 'Pregunta a fparralejo@hotmail.com desde ARSYS', '', 'Abierto', '', 1, '2014-09-08 13:36:32', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(20, 2, 'Pregunta n2 a fparralejo@hotmail.com desde ARSYS', '', 'En Curso', '', 1, '2014-09-08 13:37:48', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(21, 2, 'regunta n4 ARSYS', '', 'Cerrada', '', 1, '2014-09-09 09:16:12', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(22, 0, 'Ya se han activado las claves de acceso', '', 'Abierto', '', 1, '2014-09-25 09:52:47', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(23, 17, 'Nueva Pregunta dia 15/10/2014', '', 'Cerrada', '', 1, '2014-10-15 18:39:11', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(24, 17, 'pruebo comentario nuevo', '', 'Abierto', '', 1, '2014-11-25 20:24:42', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(25, 17, 'nueva pregunta', '', 'Abierto', '../doc/doc-qq/1720141201195209.pdf', 1, '2014-12-01 19:52:09', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(26, 17, 'Pregunta desde el movil', '', 'Abierto', '../doc/doc-qq/1720141201200943.pdf', 1, '2014-12-01 20:09:43', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(27, 182, 'Nueva pregunta desde movil', '', 'Cerrada', '', 1, '2014-12-02 10:56:55', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(28, 17, 'prueba desde emulador de IE', '', 'Cerrada', '', 1, '2014-12-02 11:11:03', 0);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(29, 0, 'Futuro ygkjg idea ble fo yéndose ', '', 'Abierto', '', 1, '2014-12-03 20:20:50', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(30, 2, 'Fofo Ubuntu ignífugo individual ', '', 'En Curso', '../doc/doc-qq/220141203221424.pdf', 1, '2014-12-03 22:14:25', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(31, 2, 'Pregunta 1', '', 'Abierto', '', 1, '2014-12-04 10:00:05', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(32, 2, 'Pregunta 2', '', 'Abierto', '', 1, '2014-12-04 10:05:54', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(33, 2, 'pregunta 3', '', 'En Curso', '', 1, '2014-12-04 10:12:15', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(34, 2, 'Pregunta listado 10', '', 'Abierto', '', 1, '2014-12-04 10:15:49', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(35, 2, 'Digital viguetas ', '', 'Abierto', '', 1, '2014-12-04 10:47:23', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(36, 2, 'Desde el bus', '', 'En Curso', '../doc/doc-qq/220141204144818.pdf', 1, '2014-12-04 14:48:18', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(37, 2, 'Pregunta Windows phone Roberto', 'Laboral', 'En Curso', '', 1, '2014-12-04 16:54:22', 9);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(38, 17, 'Pregunta Oscar ', '', 'Cerrada', '', 1, '2014-12-16 19:02:50', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(39, 17, 'Nnnnnnnnueva ttttttttablet', '', 'Abierto', '', 1, '2014-12-17 18:22:19', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(40, 17, 'Te envío el DNI escaneado', '', 'Cerrada', '../doc/doc-qq/1720141218111423.pdf', 1, '2014-12-18 11:14:24', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(41, 182, 'te do el DNI', '', 'Cerrada', '../doc/doc-Solar/18220141218112527.pdf', 1, '2014-12-18 11:25:27', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(42, 182, 'te envío el DNI', '', 'Abierto', '../doc/doc-Solar/18220141218124648.pdf', 1, '2014-12-18 12:46:48', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(43, 17, 'hola me llamo lola y me gusta las pastillas juanolas', '', 'Cerrada', '../doc/doc-qq/1720141218130535.pdf', 1, '2014-12-18 13:05:35', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(44, 17, 'comentario desde chrome', '', 'Cerrada', '', 1, '2014-12-18 13:20:06', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(45, 17, 'El horario de trabajo será por turnos.', '', 'Cerrada', '', 1, '2015-01-08 19:40:05', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(46, 17, 'Necesito los papeles del camion', '', 'Abierto', '../doc/doc-qq/1720150114181219.pdf', 1, '2015-01-14 18:12:19', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(47, 17, 'Contrato en practicas', '', 'Abierto', '', 1, '2015-01-15 10:57:27', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(48, 17, 'contrato de formacion en un hotel', '', 'Abierto', '../doc/doc-qq/1720150115110057.pdf', 1, '2015-01-15 11:00:57', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(49, 17, 'Si no hay bonificacion mejor darle de alta con un contrato temporal. Mañana enviaré la copia del DNI', '', 'Cerrada', '', 1, '2015-01-21 20:49:09', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(50, 17, 'P1 26/01/2015', '', 'En Curso', '', 1, '2015-01-26 10:07:18', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(51, 17, 'alta empleado ha sido correcta', '', 'En Curso', '', 1, '2015-01-27 11:58:45', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(52, 17, 'alta empleado ha sido correcta', '', 'Abierto', '', 1, '2015-01-27 11:59:46', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(53, 17, 'alta empleado ha sido correcta', '', 'Abierto', '', 1, '2015-01-27 11:59:57', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(54, 17, 'alta empleado ha sido correcta', '', 'Abierto', '', 1, '2015-01-27 12:00:10', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(55, 17, 'Se ha dado de alta correctamente el empleado en la base de datos', '', 'Abierto', '', 1, '2015-01-27 12:02:13', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(56, 17, 'Se ha dado de alta correctamente el empleado en la base de datos', '', 'Abierto', '', 1, '2015-02-02 09:20:15', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(57, 17, 'Se ha dado de alta correctamente el empleado en la base de datos', '', 'Abierto', '', 1, '2015-02-05 10:41:39', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(58, 17, 'Prueba hecha desde la apk en el metro', '', 'Abierto', '', 1, '2015-08-21 08:22:01', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(59, 17, 'pregunta irene', '', 'Cerrada', '', 1, '2015-09-02 12:28:02', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(60, 2, '<u>Descripción de la Incidencia:</u>\r\nerror no veo resultados\r\n\r\n<u>Pagina: </u>resultados.php', 'Técnico', 'Cerrada', '', 1, '2015-09-03 10:20:27', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(61, 17, 'Informar si se puede conseguir bonificación', '', 'Abierto', '', 1, '2015-09-27 19:23:39', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(62, 202, 'Primera consulta hecha desde el el móvil', '', 'Abierto', '', 1, '2015-09-30 18:38:36', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(63, 201, 'Tenemos que mirar la posibilidad de añadir un campo a la BBDD para un segundo email del cliente', '', 'Abierto', '', 1, '2016-02-02 11:05:52', 0);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(64, 201, 'Habría que ordenar alfabéticamente la selección de clientes en Pedidos y Facturas', '', 'Cerrada', '../doc/doc-qualidad/20120160202111116.pdf', 1, '2016-02-02 11:11:16', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(65, 17, 'Incluir en la version del movil el guardar una foto de las facturas\r\n\r\nEn google drive tengo la solucion', '', 'Abierto', '', 1, '2016-02-04 21:00:43', 0);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(66, 17, 'poner en la tabla de los pedidos un campo llamado "referencia" (varchar) y poner en el formulario de alta-edicion este campo encima de la fecha (tb en el PDFde pedidos)\r\n\r\nEste dato tendra que aparecer en las facturas, tb encima de la fecha (tanto en el formulario como en el PDF)\r\n', '', 'Cerrada', '', 1, '2016-02-05 10:56:37', 1);
INSERT INTO `tbconsulta_pregunta` (`lngIdPregunta`, `lngIdUsuario`, `strPregunta`, `strClasificacion`, `strEstado`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(67, 17, 'Poner un segundo email en la app y que salga en CC en los envios de presupuestos, pedidos y facturas', '', 'Abierto', '', 1, '2016-02-05 10:59:59', 0);
/*!40000 ALTER TABLE `tbconsulta_pregunta` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbconsulta_pregunta_asesor
CREATE TABLE IF NOT EXISTS `tbconsulta_pregunta_asesor` (
  `id` int(10) NOT NULL,
  `lngIdPregunta` int(10) DEFAULT NULL,
  `lngIdEmpleado` int(10) DEFAULT NULL,
  `Leido` int(10) DEFAULT '0' COMMENT '0= NO 1= SI ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbconsulta_pregunta_asesor: ~1.285 rows (aproximadamente)
DELETE FROM `tbconsulta_pregunta_asesor`;
/*!40000 ALTER TABLE `tbconsulta_pregunta_asesor` DISABLE KEYS */;
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1, 1, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(2, 1, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(3, 1, 54, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(4, 8, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(5, 8, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(6, 8, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(7, 8, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(8, 10, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(9, 10, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(10, 10, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(11, 10, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(12, 12, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(13, 12, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(14, 12, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(15, 12, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(16, 12, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(17, 12, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(18, 13, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(19, 13, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(20, 13, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(21, 13, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(22, 13, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(23, 13, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(24, 14, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(25, 14, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(26, 14, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(27, 14, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(28, 14, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(29, 14, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(30, 14, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(31, 14, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(32, 14, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(33, 14, 159, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(34, 14, 94, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(35, 14, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(36, 14, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(37, 14, 152, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(38, 14, 15, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(39, 14, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(40, 14, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(41, 14, 68, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(42, 14, 145, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(43, 14, 37, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(44, 14, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(45, 14, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(46, 14, 74, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(47, 14, 34, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(48, 14, 85, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(49, 14, 93, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(50, 14, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(51, 14, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(52, 14, 151, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(53, 14, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(54, 14, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(55, 14, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(56, 14, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(57, 14, 44, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(58, 14, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(59, 14, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(60, 14, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(61, 14, 36, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(62, 14, 144, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(63, 14, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(64, 14, 50, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(65, 14, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(66, 14, 142, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(67, 14, 83, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(68, 14, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(69, 14, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(70, 14, 26, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(71, 14, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(72, 14, 39, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(73, 14, 81, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(74, 14, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(75, 14, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(76, 14, 40, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(77, 14, 56, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(78, 14, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(79, 14, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(80, 14, 59, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(81, 14, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(82, 14, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(83, 14, 84, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(84, 14, 48, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(85, 14, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(86, 14, 25, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(87, 14, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(88, 14, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(89, 14, 60, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(90, 14, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(91, 14, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(92, 14, 51, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(93, 14, 31, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(94, 14, 30, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(95, 14, 47, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(96, 14, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(97, 14, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(98, 14, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(99, 14, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(100, 14, 58, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(101, 14, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(102, 14, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(103, 14, 46, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(104, 14, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(105, 14, 33, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(106, 14, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(107, 14, 29, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(108, 14, 28, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(109, 14, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(110, 14, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(111, 14, 67, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(112, 14, 43, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(113, 14, 139, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(114, 14, 143, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(115, 14, 73, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(116, 14, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(117, 14, 154, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(118, 14, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(119, 14, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(120, 14, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(121, 14, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(122, 14, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(123, 14, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(124, 14, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(125, 14, 35, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(126, 14, 147, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(127, 14, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(128, 14, 148, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(129, 14, 91, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(130, 14, 32, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(131, 14, 27, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(132, 14, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(133, 14, 55, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(134, 14, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(135, 14, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(136, 14, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(137, 14, 53, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(138, 14, 90, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(139, 14, 61, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(140, 14, 75, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(141, 14, 149, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(142, 14, 42, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(143, 14, 49, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(144, 14, 87, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(145, 14, 64, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(146, 14, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(147, 14, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(148, 14, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(149, 14, 89, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(150, 14, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(151, 14, 65, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(152, 14, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(153, 14, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(154, 14, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(155, 14, 80, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(156, 14, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(157, 14, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(158, 14, 79, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(159, 14, 45, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(160, 14, 140, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(161, 14, 82, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(162, 14, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(163, 14, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(164, 14, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(165, 14, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(166, 14, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(167, 14, 150, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(168, 14, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(169, 14, 88, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(170, 14, 153, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(171, 14, 38, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(172, 14, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(173, 14, 86, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(174, 14, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(175, 14, 72, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(176, 14, 71, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(177, 14, 57, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(178, 14, 62, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(179, 14, 92, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(180, 14, 77, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(181, 14, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(182, 14, 146, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(183, 14, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(184, 14, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(185, 14, 52, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(186, 14, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(187, 14, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(188, 14, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(189, 14, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(190, 14, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(191, 14, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(192, 14, 66, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(193, 14, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(194, 14, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(195, 14, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(196, 14, 41, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(197, 14, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(198, 14, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(199, 14, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(200, 14, 63, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(201, 14, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(202, 14, 70, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(203, 14, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(204, 14, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(205, 14, 69, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(206, 14, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(207, 14, 76, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(208, 14, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(209, 14, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(210, 14, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(211, 15, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(212, 15, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(213, 15, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(214, 16, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(215, 16, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(216, 16, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(217, 16, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(218, 16, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(219, 16, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(220, 16, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(221, 16, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(222, 16, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(223, 16, 159, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(224, 16, 94, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(225, 16, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(226, 16, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(227, 16, 152, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(228, 16, 15, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(229, 16, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(230, 16, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(231, 16, 68, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(232, 16, 145, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(233, 16, 37, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(234, 16, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(235, 16, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(236, 16, 74, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(237, 16, 34, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(238, 16, 85, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(239, 16, 93, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(240, 16, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(241, 16, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(242, 16, 151, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(243, 16, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(244, 16, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(245, 16, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(246, 16, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(247, 16, 44, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(248, 16, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(249, 16, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(250, 16, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(251, 16, 36, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(252, 16, 144, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(253, 16, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(254, 16, 50, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(255, 16, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(256, 16, 142, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(257, 16, 83, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(258, 16, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(259, 16, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(260, 16, 26, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(261, 16, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(262, 16, 39, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(263, 16, 81, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(264, 16, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(265, 16, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(266, 16, 40, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(267, 16, 56, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(268, 16, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(269, 16, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(270, 16, 59, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(271, 16, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(272, 16, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(273, 16, 84, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(274, 16, 48, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(275, 16, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(276, 16, 25, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(277, 16, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(278, 16, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(279, 16, 60, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(280, 16, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(281, 16, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(282, 16, 51, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(283, 16, 31, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(284, 16, 30, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(285, 16, 47, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(286, 16, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(287, 16, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(288, 16, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(289, 16, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(290, 16, 58, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(291, 16, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(292, 16, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(293, 16, 46, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(294, 16, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(295, 16, 33, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(296, 16, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(297, 16, 29, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(298, 16, 28, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(299, 16, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(300, 16, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(301, 16, 67, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(302, 16, 43, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(303, 16, 139, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(304, 16, 143, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(305, 16, 73, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(306, 16, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(307, 16, 154, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(308, 16, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(309, 16, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(310, 16, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(311, 16, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(312, 16, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(313, 16, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(314, 16, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(315, 16, 35, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(316, 16, 147, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(317, 16, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(318, 16, 148, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(319, 16, 91, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(320, 16, 32, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(321, 16, 27, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(322, 16, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(323, 16, 55, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(324, 16, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(325, 16, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(326, 16, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(327, 16, 53, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(328, 16, 90, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(329, 16, 61, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(330, 16, 75, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(331, 16, 149, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(332, 16, 42, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(333, 16, 49, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(334, 16, 87, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(335, 16, 64, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(336, 16, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(337, 16, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(338, 16, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(339, 16, 89, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(340, 16, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(341, 16, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(342, 16, 65, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(343, 16, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(344, 16, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(345, 16, 80, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(346, 16, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(347, 16, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(348, 16, 79, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(349, 16, 45, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(350, 16, 140, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(351, 16, 82, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(352, 16, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(353, 16, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(354, 16, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(355, 16, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(356, 16, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(357, 16, 150, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(358, 16, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(359, 16, 88, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(360, 16, 153, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(361, 16, 38, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(362, 16, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(363, 16, 86, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(364, 16, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(365, 16, 72, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(366, 16, 71, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(367, 16, 57, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(368, 16, 62, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(369, 16, 92, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(370, 16, 77, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(371, 16, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(372, 16, 146, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(373, 16, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(374, 16, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(375, 16, 52, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(376, 16, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(377, 16, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(378, 16, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(379, 16, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(380, 16, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(381, 16, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(382, 16, 66, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(383, 16, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(384, 16, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(385, 16, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(386, 16, 41, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(387, 16, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(388, 16, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(389, 16, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(390, 16, 63, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(391, 16, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(392, 16, 70, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(393, 16, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(394, 16, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(395, 16, 69, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(396, 16, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(397, 16, 76, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(398, 16, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(399, 16, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(400, 16, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(401, 17, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(402, 17, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(403, 17, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(404, 17, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(405, 17, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(406, 17, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(407, 17, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(408, 17, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(409, 17, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(410, 17, 159, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(411, 17, 94, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(412, 17, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(413, 17, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(414, 17, 152, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(415, 17, 15, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(416, 17, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(417, 17, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(418, 17, 68, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(419, 17, 145, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(420, 17, 37, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(421, 17, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(422, 17, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(423, 17, 74, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(424, 17, 34, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(425, 17, 85, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(426, 17, 93, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(427, 17, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(428, 17, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(429, 17, 151, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(430, 17, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(431, 17, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(432, 17, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(433, 17, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(434, 17, 44, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(435, 17, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(436, 17, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(437, 17, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(438, 17, 36, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(439, 17, 144, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(440, 17, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(441, 17, 50, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(442, 17, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(443, 17, 142, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(444, 17, 83, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(445, 17, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(446, 17, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(447, 17, 26, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(448, 17, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(449, 17, 39, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(450, 17, 81, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(451, 17, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(452, 17, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(453, 17, 40, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(454, 17, 56, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(455, 17, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(456, 17, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(457, 17, 59, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(458, 17, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(459, 17, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(460, 17, 84, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(461, 17, 48, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(462, 17, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(463, 17, 25, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(464, 17, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(465, 17, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(466, 17, 60, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(467, 17, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(468, 17, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(469, 17, 51, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(470, 17, 31, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(471, 17, 30, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(472, 17, 47, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(473, 17, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(474, 17, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(475, 17, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(476, 17, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(477, 17, 58, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(478, 17, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(479, 17, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(480, 17, 46, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(481, 17, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(482, 17, 33, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(483, 17, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(484, 17, 29, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(485, 17, 28, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(486, 17, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(487, 17, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(488, 17, 67, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(489, 17, 43, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(490, 17, 139, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(491, 17, 143, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(492, 17, 73, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(493, 17, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(494, 17, 154, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(495, 17, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(496, 17, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(497, 17, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(498, 17, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(499, 17, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(500, 17, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(501, 17, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(502, 17, 35, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(503, 17, 147, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(504, 17, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(505, 17, 148, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(506, 17, 91, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(507, 17, 32, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(508, 17, 27, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(509, 17, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(510, 17, 55, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(511, 17, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(512, 17, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(513, 17, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(514, 17, 53, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(515, 17, 90, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(516, 17, 61, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(517, 17, 75, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(518, 17, 149, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(519, 17, 42, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(520, 17, 49, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(521, 17, 87, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(522, 17, 64, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(523, 17, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(524, 17, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(525, 17, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(526, 17, 89, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(527, 17, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(528, 17, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(529, 17, 65, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(530, 17, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(531, 17, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(532, 17, 80, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(533, 17, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(534, 17, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(535, 17, 79, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(536, 17, 45, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(537, 17, 140, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(538, 17, 82, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(539, 17, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(540, 17, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(541, 17, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(542, 17, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(543, 17, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(544, 17, 150, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(545, 17, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(546, 17, 88, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(547, 17, 153, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(548, 17, 38, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(549, 17, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(550, 17, 86, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(551, 17, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(552, 17, 72, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(553, 17, 71, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(554, 17, 57, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(555, 17, 62, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(556, 17, 92, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(557, 17, 77, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(558, 17, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(559, 17, 146, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(560, 17, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(561, 17, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(562, 17, 52, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(563, 17, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(564, 17, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(565, 17, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(566, 17, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(567, 17, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(568, 17, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(569, 17, 66, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(570, 17, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(571, 17, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(572, 17, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(573, 17, 41, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(574, 17, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(575, 17, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(576, 17, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(577, 17, 63, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(578, 17, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(579, 17, 70, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(580, 17, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(581, 17, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(582, 17, 69, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(583, 17, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(584, 17, 76, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(585, 17, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(586, 17, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(587, 17, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(588, 18, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(589, 18, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(590, 18, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(591, 18, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(592, 18, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(593, 18, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(594, 19, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(595, 19, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(596, 19, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(597, 19, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(598, 19, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(599, 19, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(600, 19, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(601, 19, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(602, 19, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(603, 19, 159, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(604, 19, 94, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(605, 19, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(606, 19, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(607, 19, 152, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(608, 19, 15, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(609, 19, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(610, 19, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(611, 19, 68, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(612, 19, 145, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(613, 19, 37, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(614, 19, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(615, 19, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(616, 19, 74, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(617, 19, 34, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(618, 19, 85, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(619, 19, 93, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(620, 19, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(621, 19, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(622, 19, 151, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(623, 19, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(624, 19, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(625, 19, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(626, 19, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(627, 19, 44, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(628, 19, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(629, 19, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(630, 19, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(631, 19, 36, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(632, 19, 144, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(633, 19, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(634, 19, 50, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(635, 19, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(636, 19, 142, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(637, 19, 83, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(638, 19, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(639, 19, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(640, 19, 26, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(641, 19, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(642, 19, 39, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(643, 19, 81, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(644, 19, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(645, 19, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(646, 19, 40, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(647, 19, 56, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(648, 19, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(649, 19, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(650, 19, 59, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(651, 19, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(652, 19, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(653, 19, 84, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(654, 19, 48, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(655, 19, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(656, 19, 25, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(657, 19, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(658, 19, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(659, 19, 60, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(660, 19, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(661, 19, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(662, 19, 51, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(663, 19, 31, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(664, 19, 30, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(665, 19, 47, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(666, 19, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(667, 19, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(668, 19, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(669, 19, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(670, 19, 58, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(671, 19, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(672, 19, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(673, 19, 46, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(674, 19, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(675, 19, 33, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(676, 19, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(677, 19, 29, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(678, 19, 28, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(679, 19, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(680, 19, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(681, 19, 67, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(682, 19, 43, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(683, 19, 139, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(684, 19, 143, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(685, 19, 73, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(686, 19, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(687, 19, 154, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(688, 19, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(689, 19, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(690, 19, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(691, 19, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(692, 19, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(693, 19, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(694, 19, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(695, 19, 35, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(696, 19, 147, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(697, 19, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(698, 19, 148, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(699, 19, 91, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(700, 19, 32, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(701, 19, 27, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(702, 19, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(703, 19, 55, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(704, 19, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(705, 19, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(706, 19, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(707, 19, 53, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(708, 19, 90, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(709, 19, 61, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(710, 19, 75, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(711, 19, 149, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(712, 19, 42, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(713, 19, 49, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(714, 19, 87, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(715, 19, 64, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(716, 19, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(717, 19, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(718, 19, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(719, 19, 89, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(720, 19, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(721, 19, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(722, 19, 65, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(723, 19, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(724, 19, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(725, 19, 80, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(726, 19, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(727, 19, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(728, 19, 79, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(729, 19, 45, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(730, 19, 140, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(731, 19, 82, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(732, 19, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(733, 19, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(734, 19, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(735, 19, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(736, 19, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(737, 19, 150, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(738, 19, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(739, 19, 88, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(740, 19, 153, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(741, 19, 38, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(742, 19, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(743, 19, 86, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(744, 19, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(745, 19, 72, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(746, 19, 71, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(747, 19, 57, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(748, 19, 62, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(749, 19, 92, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(750, 19, 77, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(751, 19, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(752, 19, 146, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(753, 19, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(754, 19, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(755, 19, 52, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(756, 19, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(757, 19, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(758, 19, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(759, 19, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(760, 19, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(761, 19, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(762, 19, 66, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(763, 19, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(764, 19, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(765, 19, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(766, 19, 41, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(767, 19, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(768, 19, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(769, 19, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(770, 19, 63, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(771, 19, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(772, 19, 70, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(773, 19, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(774, 19, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(775, 19, 69, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(776, 19, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(777, 19, 76, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(778, 19, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(779, 19, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(780, 19, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(781, 20, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(782, 20, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(783, 20, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(784, 20, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(785, 20, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(786, 20, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(787, 20, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(788, 20, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(789, 20, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(790, 20, 159, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(791, 20, 94, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(792, 20, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(793, 20, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(794, 20, 152, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(795, 20, 15, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(796, 20, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(797, 20, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(798, 20, 68, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(799, 20, 145, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(800, 20, 37, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(801, 20, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(802, 20, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(803, 20, 74, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(804, 20, 34, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(805, 20, 85, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(806, 20, 93, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(807, 20, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(808, 20, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(809, 20, 151, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(810, 20, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(811, 20, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(812, 20, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(813, 20, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(814, 20, 44, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(815, 20, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(816, 20, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(817, 20, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(818, 20, 36, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(819, 20, 144, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(820, 20, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(821, 20, 50, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(822, 20, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(823, 20, 142, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(824, 20, 83, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(825, 20, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(826, 20, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(827, 20, 26, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(828, 20, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(829, 20, 39, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(830, 20, 81, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(831, 20, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(832, 20, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(833, 20, 40, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(834, 20, 56, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(835, 20, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(836, 20, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(837, 20, 59, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(838, 20, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(839, 20, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(840, 20, 84, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(841, 20, 48, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(842, 20, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(843, 20, 25, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(844, 20, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(845, 20, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(846, 20, 60, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(847, 20, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(848, 20, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(849, 20, 51, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(850, 20, 31, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(851, 20, 30, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(852, 20, 47, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(853, 20, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(854, 20, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(855, 20, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(856, 20, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(857, 20, 58, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(858, 20, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(859, 20, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(860, 20, 46, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(861, 20, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(862, 20, 33, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(863, 20, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(864, 20, 29, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(865, 20, 28, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(866, 20, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(867, 20, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(868, 20, 67, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(869, 20, 43, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(870, 20, 139, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(871, 20, 143, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(872, 20, 73, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(873, 20, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(874, 20, 154, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(875, 20, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(876, 20, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(877, 20, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(878, 20, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(879, 20, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(880, 20, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(881, 20, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(882, 20, 35, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(883, 20, 147, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(884, 20, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(885, 20, 148, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(886, 20, 91, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(887, 20, 32, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(888, 20, 27, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(889, 20, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(890, 20, 55, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(891, 20, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(892, 20, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(893, 20, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(894, 20, 53, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(895, 20, 90, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(896, 20, 61, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(897, 20, 75, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(898, 20, 149, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(899, 20, 42, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(900, 20, 49, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(901, 20, 87, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(902, 20, 64, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(903, 20, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(904, 20, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(905, 20, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(906, 20, 89, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(907, 20, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(908, 20, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(909, 20, 65, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(910, 20, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(911, 20, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(912, 20, 80, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(913, 20, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(914, 20, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(915, 20, 79, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(916, 20, 45, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(917, 20, 140, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(918, 20, 82, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(919, 20, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(920, 20, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(921, 20, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(922, 20, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(923, 20, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(924, 20, 150, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(925, 20, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(926, 20, 88, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(927, 20, 153, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(928, 20, 38, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(929, 20, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(930, 20, 86, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(931, 20, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(932, 20, 72, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(933, 20, 71, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(934, 20, 57, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(935, 20, 62, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(936, 20, 92, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(937, 20, 77, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(938, 20, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(939, 20, 146, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(940, 20, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(941, 20, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(942, 20, 52, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(943, 20, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(944, 20, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(945, 20, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(946, 20, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(947, 20, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(948, 20, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(949, 20, 66, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(950, 20, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(951, 20, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(952, 20, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(953, 20, 41, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(954, 20, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(955, 20, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(956, 20, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(957, 20, 63, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(958, 20, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(959, 20, 70, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(960, 20, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(961, 20, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(962, 20, 69, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(963, 20, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(964, 20, 76, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(965, 20, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(966, 20, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(967, 20, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(968, 21, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(969, 21, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(970, 21, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(971, 21, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(972, 21, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(973, 21, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(974, 21, 195, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(975, 21, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(976, 21, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(977, 21, 159, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(978, 21, 94, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(979, 21, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(980, 21, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(981, 21, 152, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(982, 21, 15, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(983, 21, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(984, 21, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(985, 21, 68, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(986, 21, 145, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(987, 21, 37, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(988, 21, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(989, 21, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(990, 21, 74, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(991, 21, 34, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(992, 21, 85, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(993, 21, 93, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(994, 21, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(995, 21, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(996, 21, 151, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(997, 21, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(998, 21, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(999, 21, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1000, 21, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1001, 21, 44, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1002, 21, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1003, 21, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1004, 21, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1005, 21, 36, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1006, 21, 144, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1007, 21, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1008, 21, 50, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1009, 21, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1010, 21, 142, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1011, 21, 83, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1012, 21, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1013, 21, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1014, 21, 26, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1015, 21, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1016, 21, 39, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1017, 21, 81, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1018, 21, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1019, 21, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1020, 21, 40, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1021, 21, 56, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1022, 21, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1023, 21, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1024, 21, 59, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1025, 21, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1026, 21, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1027, 21, 84, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1028, 21, 48, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1029, 21, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1030, 21, 25, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1031, 21, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1032, 21, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1033, 21, 60, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1034, 21, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1035, 21, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1036, 21, 51, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1037, 21, 31, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1038, 21, 30, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1039, 21, 47, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1040, 21, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1041, 21, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1042, 21, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1043, 21, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1044, 21, 58, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1045, 21, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1046, 21, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1047, 21, 46, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1048, 21, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1049, 21, 33, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1050, 21, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1051, 21, 29, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1052, 21, 28, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1053, 21, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1054, 21, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1055, 21, 67, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1056, 21, 43, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1057, 21, 139, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1058, 21, 143, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1059, 21, 73, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1060, 21, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1061, 21, 154, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1062, 21, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1063, 21, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1064, 21, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1065, 21, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1066, 21, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1067, 21, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1068, 21, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1069, 21, 35, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1070, 21, 147, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1071, 21, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1072, 21, 148, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1073, 21, 91, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1074, 21, 32, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1075, 21, 27, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1076, 21, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1077, 21, 55, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1078, 21, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1079, 21, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1080, 21, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1081, 21, 53, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1082, 21, 90, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1083, 21, 61, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1084, 21, 75, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1085, 21, 149, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1086, 21, 42, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1087, 21, 49, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1088, 21, 87, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1089, 21, 64, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1090, 21, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1091, 21, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1092, 21, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1093, 21, 89, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1094, 21, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1095, 21, 65, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1096, 21, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1097, 21, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1098, 21, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1099, 21, 80, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1100, 21, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1101, 21, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1102, 21, 79, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1103, 21, 45, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1104, 21, 140, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1105, 21, 82, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1106, 21, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1107, 21, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1108, 21, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1109, 21, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1110, 21, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1111, 21, 150, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1112, 21, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1113, 21, 88, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1114, 21, 153, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1115, 21, 38, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1116, 21, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1117, 21, 86, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1118, 21, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1119, 21, 72, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1120, 21, 71, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1121, 21, 57, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1122, 21, 62, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1123, 21, 92, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1124, 21, 77, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1125, 21, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1126, 21, 146, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1127, 21, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1128, 21, 54, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1129, 21, 52, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1130, 21, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1131, 21, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1132, 21, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1133, 21, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1134, 21, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1135, 21, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1136, 21, 66, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1137, 21, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1138, 21, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1139, 21, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1140, 21, 41, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1141, 21, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1142, 21, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1143, 21, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1144, 21, 63, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1145, 21, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1146, 21, 70, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1147, 21, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1148, 21, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1149, 21, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1150, 21, 69, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1151, 21, 76, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1152, 21, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1153, 21, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1154, 21, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1155, 22, 197, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1156, 22, 180, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1157, 29, 141, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1158, 29, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1159, 30, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1160, 30, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1161, 31, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1162, 31, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1163, 31, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1164, 31, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1165, 31, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1166, 31, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1167, 32, 197, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1168, 32, 180, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1169, 32, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1170, 32, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1171, 32, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1172, 32, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1173, 32, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1174, 32, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1175, 32, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1176, 32, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1177, 32, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1178, 32, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1179, 32, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1180, 32, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1181, 32, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1182, 32, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1183, 32, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1184, 32, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1185, 32, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1186, 32, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1187, 32, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1188, 32, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1189, 32, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1190, 32, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1191, 32, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1192, 32, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1193, 32, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1194, 32, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1195, 32, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1196, 32, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1197, 32, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1198, 32, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1199, 32, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1200, 32, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1201, 32, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1202, 32, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1203, 32, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1204, 32, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1205, 32, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1206, 32, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1207, 32, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1208, 32, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1209, 32, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1210, 32, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1211, 32, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1212, 32, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1213, 32, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1214, 32, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1215, 32, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1216, 32, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1217, 32, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1218, 32, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1219, 32, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1220, 32, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1221, 32, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1222, 32, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1223, 32, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1224, 32, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1225, 32, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1226, 32, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1227, 32, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1228, 32, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1229, 32, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1230, 32, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1231, 32, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1232, 32, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1233, 32, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1234, 32, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1235, 32, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1236, 32, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1237, 32, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1238, 32, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1239, 32, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1240, 32, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1241, 32, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1242, 32, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1243, 32, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1244, 32, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1245, 32, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1246, 32, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1247, 32, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1248, 32, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1249, 32, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1250, 32, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1251, 32, 174, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1252, 32, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1253, 32, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1254, 32, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1255, 32, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1256, 32, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1257, 32, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1258, 32, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1259, 32, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1260, 32, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1261, 32, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1262, 32, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1263, 32, 200, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1264, 32, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1265, 32, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1266, 32, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1267, 32, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1268, 32, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1269, 32, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1270, 33, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1271, 33, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1272, 33, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1273, 33, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1274, 33, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1275, 33, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1276, 33, 195, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1277, 33, 200, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1278, 33, 163, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1279, 33, 162, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1280, 33, 196, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1281, 33, 185, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1282, 33, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1283, 33, 168, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1284, 33, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1285, 33, 187, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1286, 33, 165, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1287, 33, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1288, 33, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1289, 33, 172, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1290, 33, 135, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1291, 33, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1292, 33, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1293, 33, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1294, 33, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1295, 33, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1296, 33, 167, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1297, 33, 113, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1298, 33, 125, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1299, 33, 156, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1300, 33, 6, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1301, 33, 106, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1302, 33, 133, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1303, 33, 170, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1304, 33, 130, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1305, 33, 191, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1306, 33, 98, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1307, 33, 8, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1308, 33, 20, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1309, 33, 11, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1310, 33, 158, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1311, 33, 109, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1312, 33, 4, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1313, 33, 5, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1314, 33, 189, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1315, 33, 104, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1316, 33, 102, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1317, 33, 121, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1318, 33, 184, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1319, 33, 131, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1320, 33, 100, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1321, 33, 95, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1322, 33, 18, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1323, 33, 7, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1324, 33, 13, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1325, 33, 122, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1326, 33, 16, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1327, 33, 12, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1328, 33, 188, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1329, 33, 97, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1330, 33, 108, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1331, 33, 127, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1332, 33, 19, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1333, 33, 116, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1334, 33, 137, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1335, 33, 110, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1336, 33, 10, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1337, 33, 119, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1338, 33, 155, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1339, 33, 103, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1340, 33, 9, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1341, 33, 192, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1342, 33, 114, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1343, 33, 107, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1344, 33, 169, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1345, 33, 160, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1346, 33, 171, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1347, 33, 22, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1348, 33, 101, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1349, 33, 117, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1350, 33, 120, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1351, 33, 24, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1352, 33, 123, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1353, 33, 161, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1354, 33, 178, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1355, 33, 177, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1356, 33, 134, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1357, 33, 78, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1358, 33, 129, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1359, 33, 115, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1360, 33, 174, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1361, 33, 173, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1362, 33, 126, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1363, 33, 138, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1364, 33, 112, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1365, 33, 111, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1366, 33, 176, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1367, 33, 118, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1368, 33, 166, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1369, 33, 14, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1370, 33, 175, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1371, 33, 197, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1372, 33, 180, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1373, 34, 180, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1374, 34, 190, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1375, 34, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1376, 34, 164, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1377, 34, 179, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1378, 34, 96, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1379, 34, 105, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1380, 34, 136, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1381, 34, 124, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1382, 34, 186, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1383, 35, 194, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1384, 35, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1385, 35, 23, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1386, 35, 21, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1387, 35, 183, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1388, 35, 193, 0);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1389, 36, 182, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1390, 37, 17, 1);
INSERT INTO `tbconsulta_pregunta_asesor` (`id`, `lngIdPregunta`, `lngIdEmpleado`, `Leido`) VALUES
	(1391, 37, 182, 1);
/*!40000 ALTER TABLE `tbconsulta_pregunta_asesor` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbconsulta_respuestas
CREATE TABLE IF NOT EXISTS `tbconsulta_respuestas` (
  `lngIdRespuesta` int(10) DEFAULT NULL,
  `lngIdPregunta` int(10) DEFAULT NULL,
  `lngIdUsuario` int(10) DEFAULT NULL,
  `strRespuesta` longtext,
  `strDoc` varchar(100) DEFAULT NULL,
  `lngStatus` int(2) DEFAULT NULL,
  `datFechaStatus` datetime DEFAULT NULL,
  `leido` int(11) NOT NULL DEFAULT '0' COMMENT '0= NO, 1= SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbconsulta_respuestas: ~77 rows (aproximadamente)
DELETE FROM `tbconsulta_respuestas`;
/*!40000 ALTER TABLE `tbconsulta_respuestas` DISABLE KEYS */;
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(1, 1, 0, 'Comentario añadido por el asesor JMOP', '', 1, '2014-09-04 11:54:44', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(2, 1, 182, 'Respuesta de BAR', '', 1, '2014-09-04 11:58:42', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(3, 3, 0, 'Respuesta de JMOP', '', 1, '2014-09-04 12:02:17', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(4, 2, 2, 'Respuesta de MORLACAL', '', 1, '2014-09-04 12:06:54', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(5, 1, 54, 'Respuesta de SBAQUERO', '', 1, '2014-09-04 12:08:43', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(6, 8, 182, 'Respuesta de BAR', '', 1, '2014-09-04 12:33:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(7, 9, 2, 'Respuesta del ASESOR MORLACAL', '', 1, '2014-09-04 13:05:50', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(8, 9, 17, 'NO me gusta lo que me has dicho', '', 1, '2014-09-04 13:08:08', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(9, 23, 2, 'Respuesta de morlacal 15/10/2014', '', 1, '2014-10-15 18:40:17', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(10, 20, 17, 'respuesta de Angel Martin con adjunto', '../doc/doc-qq/172020141125121259.pdf', 1, '2014-11-25 12:13:00', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(11, 23, 2, 'Debe liquidarse en trimestre', '', 1, '2014-11-27 12:34:41', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(12, 21, 17, 'Respuesta a la pregunta n4 ARSYS', '', 1, '2014-11-27 23:00:26', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(13, 21, 2, 'n4 ARSYS sigo la traza', '', 1, '2014-11-27 23:02:37', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(14, 1, 17, 'nueva respuesta', '../doc/doc-qq/17120141201195120.pdf', 1, '2014-12-01 19:51:21', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(15, 5, 2, 'respuesta de Rosa Morales', '../doc/generales/Articulo.pdf', 1, '2014-12-02 10:55:38', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(16, 27, 2, 'Respuesta desde el móvil ', '../doc/generales/Articulo.pdf', 1, '2014-12-02 11:01:39', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(17, 8, 0, 'Respuesta desde el móvil ', 'http://book.cakephp.org/2.0/_downloads/es/CakePHPCookbook.pdf', 1, '2014-12-02 11:56:23', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(18, 9, 0, 'Vudú texto urgen ucranianos ', '../doc/generales/Articulo.pdf', 1, '2014-12-02 11:57:58', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(19, 28, 2, 'Furibundo tejeduría ', '../doc/generales/Articulo.pdf', 1, '2014-12-02 13:40:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(20, 30, 182, 'Urbes une uso teocracia ', '', 1, '2014-12-03 22:18:02', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(21, 36, 182, 'Desde el bus', '', 1, '2014-12-04 14:51:32', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(22, 33, 182, 'Respuesta a pregunta 3', '', 1, '2014-12-04 16:36:20', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(23, 37, 182, 'Respuesta Windows phone', '', 1, '2014-12-04 17:00:40', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(24, 37, 2, 'Respuesta Windows Phone ', '../doc/generales/jsp-No view-20140417191947.pdf', 1, '2014-12-04 17:06:02', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(25, 37, 17, 'Respuesta Windows Phone 2', '', 1, '2014-12-04 17:11:07', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(26, 38, 2, 'Respuesta paco', '', 1, '2014-12-16 19:05:21', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(27, 40, 0, 'Necesito que me des información adicional del empleado', '../doc/generales/Articulo.pdf', 1, '2014-12-18 11:16:11', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(28, 41, 182, 'necesito mas informacion IE', '', 1, '2014-12-18 11:28:13', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(29, 41, 0, 'respuesta en Firefox', 'http://book.cakephp.org/2.0/_downloads/es/CakePHPCookbook.pdf', 1, '2014-12-18 13:17:36', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(30, 40, 17, 'rescrito desde chrome', '../doc/generales/jsp-No view-20140417191947.pdf', 1, '2014-12-18 13:18:43', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(31, 44, 2, 'en sevilla la lluvia es una maravilla', '../doc/generales/Contrato indefinido.pdf', 1, '2014-12-18 13:23:42', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(32, 43, 2, 'Los avisos del asesor se ordenan de forma rara cuando entras en la página principal con morlacal', '', 1, '2015-01-08 19:43:04', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(33, 45, 17, 'Lo he cambiado de soltero a casado desde la tablet pequeña\r\n', '', 1, '2015-01-08 21:41:04', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(34, 49, 17, 'Se me olvidaba comentar que está inscrito en el desempleo desde hace un mes', '', 1, '2015-01-21 20:52:23', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(35, 49, 2, 'A la primera le pone 7 y a la otra 10 . Las he puesto seguidas???? Yo respondo la 7\r\nen el listado de empleados se puede poner un vb verde si el asesor responde que ha dado el alta o lo grabamos de alguna forma. ComenTar', '', 1, '2015-01-21 21:01:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(36, 49, 17, 'Ahora que ya ha respondido el asesor le envío un documento.\r\ndesde la tablet solo me da un listado. Tendremos que investigar', '../doc/generales/04-20130823111105.pdf', 1, '2015-01-21 21:06:23', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(37, 50, 17, 'R1 a P1 26/01/2015', '', 1, '2015-01-26 10:07:52', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(38, 55, 2, 'Se a tramitado correctamente', '', 1, '2015-01-27 12:03:57', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(39, 52, 2, 'Se a tramitado correctamente', '', 1, '2015-01-27 12:05:58', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(40, 56, 17, '- Incidencia del dia 02/02/2015, de tipo enfermedad y de Observaciones Esta con un resfriado muy severo<br/><br/>', '', 1, '2015-02-02 09:55:24', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(41, 56, 2, 'Se a tramitado correctamente', '', 1, '2015-02-02 10:00:58', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(42, 56, 2, 'La incidencia del dia 02/02/2015, de tipo enfermedad y de Observaciones Esta con un resfriado muy severo, ha sido cerrada por el asesor', '', 1, '2015-02-02 10:03:07', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(43, 51, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 14/01/2015, de tipo enfermedad y de Observaciones Esta con gripe aviar<br/><br/>- Incidencia del dia 22/01/2015, de tipo maternidad y de Observaciones Maternidad de la mujer de este hombre<br/><br/>', '', 1, '2015-02-02 10:07:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(44, 46, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 05/01/2015, de tipo ausencia y de Observaciones Asuntos Propios<br/><br/>- Incidencia del dia 14/01/2015, de tipo ausencia y de Observaciones ausencia sin justificar al trabajo<br/><br/>- Incidencia del dia 22/01/2015, de tipo maternidad y de Observaciones Maternidad de la mujer de este hombre<br/><br/>', '', 1, '2015-02-02 10:07:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(45, 47, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 01/01/2015, de tipo ausencia y de Observaciones Estan en un curso<br/><br/>', '', 1, '2015-02-02 10:10:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(46, 48, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 01/01/2015, de tipo ausencia y de Observaciones Estan en un curso<br/><br/>', '', 1, '2015-02-02 10:10:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(47, 52, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 01/01/2015, de tipo ausencia y de Observaciones Estan en un curso<br/><br/>', '', 1, '2015-02-02 10:10:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(48, 53, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 01/01/2015, de tipo ausencia y de Observaciones Estan en un curso<br/><br/>', '', 1, '2015-02-02 10:10:45', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(49, 51, 17, 'respuesta desde PC  y  chrome', '../doc/doc-qq/175120150205103455.pdf', 1, '2015-02-05 10:34:55', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(50, 57, 2, 'Se a tramitado correctamente', '', 1, '2015-02-05 10:43:21', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(51, 56, 2, 'La incidencia del dia 02/02/2015, de tipo enfermedad y de Observaciones Esta con un resfriado muy severo, ha sido abierta por el asesor', '', 1, '2015-02-06 21:10:11', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(52, 51, 17, '- Incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés <br/><br/>', '', 1, '2015-02-06 21:51:34', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(53, 46, 17, '- Incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés <br/><br/>- Incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés <br/><br/>', '', 1, '2015-02-06 21:51:34', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(54, 51, 2, 'La incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés Editado, ha sido cerrada por el asesor', '', 1, '2015-02-06 21:57:44', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(55, 46, 2, 'La incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés Editado, ha sido cerrada por el asesor', '', 1, '2015-02-06 21:57:44', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(56, 54, 2, '- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>', '', 1, '2015-02-06 21:59:08', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(57, 55, 2, '- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>', '', 1, '2015-02-06 21:59:08', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(58, 57, 2, '- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>', '', 1, '2015-02-06 21:59:08', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(59, 54, 2, '- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones le duele la espalda<br/><br/>', '', 1, '2015-02-06 22:50:30', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(60, 51, 2, '- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-06 22:52:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(61, 47, 2, '- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-06 22:52:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(62, 48, 2, '- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-06 22:52:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(63, 54, 2, '- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-06 22:52:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(64, 57, 2, '- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-06 22:52:22', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(65, 51, 2, 'La incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés Editado, ha sido abierta por el asesor', '', 1, '2015-02-09 10:55:33', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(66, 46, 2, 'La incidencia del dia 02/02/2015, de tipo ausencia y de Observaciones Esta haciendo un curso de formación en inglés Editado, ha sido abierta por el asesor', '', 1, '2015-02-09 10:55:33', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(67, 51, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 06/02/2015, de tipo ausencia y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-09 11:02:23', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(68, 57, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>- Incidencia del dia 06/02/2015, de tipo ausencia y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-09 11:02:23', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(69, 47, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 06/02/2015, de tipo ausencia y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-09 11:02:23', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(70, 48, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 06/02/2015, de tipo ausencia y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-09 11:02:24', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(71, 54, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>- Incidencia del dia 06/02/2015, de tipo enfermedad y de Observaciones le duele la espalda<br/><br/>- Incidencia del dia 06/02/2015, de tipo ausencia y de Observaciones reunión de pastores oveja muerta <br/><br/>', '', 1, '2015-02-09 11:02:24', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(72, 55, 2, 'La(s) incidencia(s) está(n) cerrada(s) son las siguientes:<br/><br/>- Incidencia del dia 06/02/2015, de tipo accidente y de Observaciones han tenido un accidente con el camión<br/><br/>', '', 1, '2015-02-09 11:02:24', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(73, 50, 17, 'prueba desde opera en ssl', '', 1, '2015-05-04 20:58:34', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(74, 59, 2, 'hola esta contestada', '', 1, '2015-09-02 12:29:36', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(75, 59, 17, 'no me convenze tu respuesta', '', 1, '2015-09-02 12:30:52', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(76, 64, 2, 'Ya esta implementado este select que salen los clientes en presupuestos, pedidos y facturas', '', 1, '2016-02-04 09:57:41', 1);
INSERT INTO `tbconsulta_respuestas` (`lngIdRespuesta`, `lngIdPregunta`, `lngIdUsuario`, `strRespuesta`, `strDoc`, `lngStatus`, `datFechaStatus`, `leido`) VALUES
	(77, 66, 2, 'Ya esta terminado y subido este cambio, he incluido tanto en pedidos como en facturas', '', 1, '2016-02-16 12:00:58', 1);
/*!40000 ALTER TABLE `tbconsulta_respuestas` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbcontrollinglog
CREATE TABLE IF NOT EXISTS `tbcontrollinglog` (
  `lngId` int(11) NOT NULL AUTO_INCREMENT,
  `strTipo` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`lngId`),
  KEY `lngId` (`lngId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbcontrollinglog: ~4 rows (aproximadamente)
DELETE FROM `tbcontrollinglog`;
/*!40000 ALTER TABLE `tbcontrollinglog` DISABLE KEYS */;
INSERT INTO `tbcontrollinglog` (`lngId`, `strTipo`, `status`) VALUES
	(1, 'Info', 1);
INSERT INTO `tbcontrollinglog` (`lngId`, `strTipo`, `status`) VALUES
	(2, 'Warning', 0);
INSERT INTO `tbcontrollinglog` (`lngId`, `strTipo`, `status`) VALUES
	(3, 'ERROR', 1);
INSERT INTO `tbcontrollinglog` (`lngId`, `strTipo`, `status`) VALUES
	(4, 'TRAZADEVELOPER', 1);
/*!40000 ALTER TABLE `tbcontrollinglog` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbcuentas
CREATE TABLE IF NOT EXISTS `tbcuentas` (
  `IdCuenta` int(11) NOT NULL DEFAULT '0',
  `NumCuenta` varchar(50) DEFAULT NULL,
  `Grupo` int(11) DEFAULT NULL,
  `SubGrupo2` int(11) DEFAULT NULL,
  `SubGrupo4` int(11) DEFAULT '0',
  `Nombre` varchar(50) DEFAULT NULL,
  `Borrado` int(11) DEFAULT '0',
  PRIMARY KEY (`IdCuenta`),
  KEY `Grupo` (`Grupo`),
  KEY `IdCuenta` (`IdCuenta`),
  KEY `NumCuenta` (`NumCuenta`),
  KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbcuentas: ~165 rows (aproximadamente)
DELETE FROM `tbcuentas`;
/*!40000 ALTER TABLE `tbcuentas` DISABLE KEYS */;
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(1, '477000000', 4, 47, 4770, 'I.V.A. Repercutido', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(2, '472000000', 4, 47, 4720, 'IVA soportado', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(3, '100000000', 1, 10, 1000, 'Capital Social', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(4, '103000000', 1, 10, 1030, 'Accionistas desembolsos no exigidos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(5, '112000000', 1, 11, 1120, 'Reserva legal', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(6, '113000000', 1, 11, 1130, 'Reservas voluntarias', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(7, '113400000', 1, 11, 1134, 'Gastos de constitución', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(8, '113500000', 1, 11, 1135, 'Gastos de primer establecimiento', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(9, '113600000', 1, 11, 1136, 'Gastos de ampliación de capital', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(10, '114000000', 1, 11, 1140, 'Reservas especiales', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(11, '118000000', 1, 11, 1180, 'Aportacion.socios compen.pérdidas ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(12, '120000000', 1, 12, 1200, 'Remanente', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(13, '121000000', 1, 12, 1210, 'Resultados negativos de ejer.anter.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(14, '129000000', 1, 12, 1290, 'Pérdidas y ganancias', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(15, '131000000', 1, 13, 1310, 'Subvenciones de capital', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(16, '140000000', 1, 14, 1400, 'Provisión para pensiones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(17, '141000000', 1, 14, 1410, 'Provisión para impuestos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(18, '142000000', 1, 14, 1420, 'Provisión para responsabilidades', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(19, '146000000', 1, 14, 1460, 'Provisión para grandes reparaciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(20, '160300000', 1, 16, 1603, 'Deudas l.p. entidades crédito grupo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(21, '171000000', 1, 17, 1710, 'Deudas a largo plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(22, '180000000', 1, 18, 1800, 'Fianzas recibidas a largo plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(23, '205000000', 2, 20, 2050, 'Derechos de traspaso', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(24, '206000000', 2, 20, 2060, 'Aplicaciones informáticas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(25, '210000000', 2, 21, 2100, 'Terrenos y bienes naturales', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(26, '211000000', 2, 21, 2110, 'Construcciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(27, '212000000', 2, 21, 2120, 'Instalaciones técnicas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(28, '213000000', 2, 21, 2130, 'Maquinaria', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(29, '214000000', 2, 21, 2140, 'Utillaje', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(30, '215000000', 2, 21, 2150, 'Otras instalaciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(31, '216000000', 2, 21, 2160, 'Mobiliario', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(32, '216100000', 2, 21, 2161, 'Máquinas de Oficina', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(33, '217000000', 2, 21, 2170, 'Equipos para proces.información', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(34, '218000000', 2, 21, 2180, 'Elementos de transporte', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(35, '219000000', 2, 21, 2190, 'Otro inmovilizado material', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(36, '252000000', 2, 25, 2520, 'Créditos a largo plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(37, '260000000', 2, 26, 2600, 'Fianzas constituidas a largo plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(38, '280500000', 2, 28, 2805, 'Amort.acumul.derechos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(39, '280600000', 2, 28, 2806, 'Amort.acumul.aplicaciones inform.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(40, '281100000', 2, 28, 2811, 'Amort.acumul.de construcciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(41, '281200000', 2, 28, 2812, 'Amort.acumul. instal.técnicas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(42, '281300000', 2, 28, 2813, 'Amort.acumul. de maquinaria', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(43, '281400000', 2, 28, 2814, 'Amort.acumul. de utillaje', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(44, '281500000', 2, 28, 2815, 'Amort. acumul. otras instalaciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(45, '281600000', 2, 28, 2816, 'Amort. acumul.de mobiliario', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(46, '281600001', 2, 28, 2816, 'Amort.Acum.maquinas oficina', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(47, '281700000', 2, 28, 2817, 'Amort.acumul.equip.proces.inform.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(48, '281800000', 2, 28, 2818, 'Amort.acumul.element.transporte', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(49, '281900000', 2, 28, 2819, 'Amort.acumul.otro inmov.mater.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(50, '290000000', 2, 29, 2900, 'Provisión deprec.inmov.inmat.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(51, '291000000', 2, 29, 2910, 'Provisión deprec.inmov.mater.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(52, '298000000', 2, 29, 2980, 'Prov.insolv.créditos a l.p.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(53, '300000000', 3, 30, 3000, 'Mercaderías ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(54, '310000000', 3, 31, 3100, 'Materias primas ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(55, '321000000', 3, 32, 3210, 'Combustibles', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(56, '322000000', 3, 32, 3220, 'Repuestos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(57, '325000000', 3, 32, 3250, 'Materiales diversos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(58, '326000000', 3, 32, 3260, 'Embalajes', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(59, '327000000', 3, 32, 3270, 'Envases', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(60, '350000000', 3, 35, 3500, 'Productos terminados', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(61, '365000000', 3, 36, 3650, 'Residuos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(62, '390000000', 3, 39, 3900, 'Provisión depreciación mercaderías', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(63, '391000000', 3, 39, 3910, 'Provisión deprec.materias primas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(64, '392000000', 3, 39, 3920, 'Provisión deprec.otros aprovis.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(65, '400000000', 4, 40, 4000, 'Proveedor ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(66, '400900000', 4, 40, 4009, 'Proveedor, fras.pend.recibir ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(67, '401000000', 4, 40, 4010, 'Proveedor, efectos comer.a pagar', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(68, '407000000', 4, 40, 4070, 'Anticipos a proveedores', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(69, '410000000', 4, 41, 4100, 'Acreedores ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(70, '430000000', 4, 43, 4300, 'Clientes ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(71, '431000000', 4, 43, 4310, 'Efectos comerciales en cartera', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(72, '431500000', 4, 43, 4315, 'Efectos comerciales impagados', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(73, '436000000', 4, 43, 4360, 'Clientes de dudoso cobro', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(74, '438000000', 4, 43, 4380, 'Anticipos de clientes', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(75, '440000000', 4, 44, 4400, 'Deudores ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(76, '460000000', 4, 46, 4600, 'Anticipos de remuneración', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(77, '465000000', 4, 46, 4650, 'Remuneraciones pendientes de pago ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(78, '470000000', 4, 47, 4700, 'Hac.Pública, deudor por IVA', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(79, '470700000', 4, 47, 4707, 'Hac.Pública, deudor por IGIC', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(80, '470800000', 4, 47, 4708, 'Hac.Pública,deudor por subv.conced.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(81, '470900000', 4, 47, 4709, 'Hac.Pública,deudor por devol.imp.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(82, '471000000', 4, 47, 4710, 'Organismo Seguridad Social,deudores', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(83, '472700000', 4, 47, 4727, 'IGIC soportado', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(84, '473000000', 4, 47, 4730, 'Hac.Pública,retenc.y pagos a cta.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(85, '474000000', 4, 47, 4740, 'Impuesto s/beneficios anticipados', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(86, '474500000', 4, 47, 4745, 'Crédito por perd.a comp.ejer.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(87, '475000000', 4, 47, 4750, 'Hacienda Pública, acreedor por IVA', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(88, '475100000', 4, 47, 4751, 'H. Pública Retención', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(89, '475200000', 4, 47, 4752, 'Hac.Pública,acreedor imp.s/socied.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(90, '475700000', 4, 47, 4757, 'Hac.Pública ,acreedor por IGIC', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(91, '475800000', 4, 47, 4758, 'Hac.Pública, acreedor subv.a reint.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(92, '476000000', 4, 47, 4760, 'Organismos  Seg.Social, acreedor', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(93, '477700000', 4, 47, 4777, 'IGIC repercutido', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(94, '480000000', 4, 48, 4800, 'Gastos anticipados', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(95, '485000000', 4, 48, 4850, 'Ingresos anticipados', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(96, '490000000', 4, 49, 4900, 'Provisión insolvencias de tráfico', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(97, '520100000', 5, 52, 5201, 'Deudas c.p. por crédito dispuesto', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(98, '520200000', 5, 52, 5202, 'Tarjetas de Crédito Corporativas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(99, '521000000', 5, 52, 5210, 'Deudas a corto plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(100, '525000000', 5, 52, 5250, 'Efectos a pagar a corto plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(101, '540900000', 5, 54, 5409, 'Otras invers.finac.temp.en capital', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(102, '542000000', 5, 54, 5420, 'Créditos a corto plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(103, '550000000', 5, 55, 5500, 'Titular de la explotación', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(104, '551000000', 5, 55, 5510, 'Cuentas corrientes con soc.y admin.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(105, '555000000', 5, 55, 5550, 'Partidas pendientes de aplicación', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(106, '561000000', 5, 56, 5610, 'Depósitos recibidos a corto plazo', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(107, '570000000', 5, 57, 5700, 'Caja Euros', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(108, '572000000', 5, 57, 5720, 'Bancos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(109, '600000000', 6, 60, 6000, 'Compras ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(110, '608000000', 6, 60, 6080, 'Devolución compras de mercaderías', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(111, '608100000', 6, 60, 6081, 'Devolución compras materias primas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(112, '608200000', 6, 60, 6082, 'Devolución compras otros aprovis.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(113, '609000000', 6, 60, 6090, '"Rappels" por compras mercaderías', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(114, '610000000', 6, 61, 6100, 'Variación existencias mercaderías', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(115, '621000000', 6, 62, 6210, 'Arrendamientos locales', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(116, '622000000', 6, 62, 6220, 'Reparaciones y conservación', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(117, '623000000', 6, 62, 6230, 'Asesorías', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(118, '623100000', 6, 62, 6231, 'Juridicos y Notariales', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(119, '623500000', 6, 62, 6235, 'Asociaciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(120, '624000000', 6, 62, 6240, 'Transportes', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(121, '624100000', 6, 62, 6241, 'Locomoción', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(122, '625000000', 6, 62, 6250, 'Primas de seguros', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(123, '626000000', 6, 62, 6260, 'Gastos cuentas corrientes', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(124, '627000000', 6, 62, 6270, 'Relaciones Públicas y Gestión', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(125, '627100000', 6, 62, 6271, 'Publicidad y Propaganda', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(126, '627200000', 6, 62, 6272, 'Suscripciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(127, '628000000', 6, 62, 6280, 'Electricidad', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(128, '628200000', 6, 62, 6282, 'Gas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(129, '628600000', 6, 62, 6286, 'Agua', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(130, '628800000', 6, 62, 6288, 'Material de Oficina', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(131, '629100000', 6, 62, 6291, 'Teléfonos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(132, '629200000', 6, 62, 6292, 'Gastos de viaje', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(133, '629300000', 6, 62, 6293, 'Correos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(134, '629800000', 6, 62, 6298, 'Otros gastos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(135, '630000000', 6, 63, 6300, 'Impuesto sobre beneficios', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(136, '631000000', 6, 63, 6310, 'Otros tributos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(137, '640000000', 6, 64, 6400, 'Sueldos y salarios', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(138, '640100000', 6, 64, 6401, 'Retribución Administradores', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(139, '640300000', 6, 64, 6403, 'Dietas', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(140, '641000000', 6, 64, 6410, 'Indemnizaciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(141, '642000000', 6, 64, 6420, 'Seg.Social a cargo de la empresa', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(142, '649100000', 6, 64, 6491, 'Otros gastos sociales', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(143, '650000000', 6, 65, 6500, 'Pérdidas de créditos comerc.incobr.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(144, '669000000', 6, 66, 6690, 'Otros gastos financieros', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(145, '670000000', 6, 67, 6700, 'Pérdidas proced.inmov.inmat.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(146, '671000000', 6, 67, 6710, 'Pérdidas proced.inmov.mater.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(147, '678000000', 6, 67, 6780, 'Gastos extraordinarios', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(148, '680000000', 6, 68, 6800, 'Amortización del inmovil.inmater.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(149, '680500000', 6, 68, 6805, 'Amortizac. Aplicaciones Informát.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(150, '681000000', 6, 68, 6810, 'Amortización del inmovil.material', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(151, '681100000', 6, 68, 6811, 'Amortizac. Construcciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(152, '681400000', 6, 68, 6814, 'Amortizac. Utillaje', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(153, '681500000', 6, 68, 6815, 'Amortizac. Instalaciones', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(154, '681600000', 6, 68, 6816, 'Amortizac. Mobiliario', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(155, '681600001', 6, 68, 6816, 'Amortizac. Máquinas Oficina', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(156, '681700000', 6, 68, 6817, 'Amortizac. Equipo proceso Inform.', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(157, '681800000', 6, 68, 6818, 'Amortizac. Elementos Transporte', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(158, '681900000', 6, 68, 6819, 'Amortizac. Otro Inmovil. Material', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(159, '700000000', 7, 70, 7000, 'Ventas ', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(160, '708000000', 7, 70, 7080, 'Devolución ventas mercaderías', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(161, '712000000', 7, 71, 7120, 'Variación exist.prod. terminados', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(162, '747000000', 7, 74, 7470, 'Otras subvenciones a la explotación', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(163, '752000000', 7, 75, 7520, 'Ingresos por arrendamientos', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(164, '769000000', 7, 76, 7690, 'Otros ingresos financieros', 0);
INSERT INTO `tbcuentas` (`IdCuenta`, `NumCuenta`, `Grupo`, `SubGrupo2`, `SubGrupo4`, `Nombre`, `Borrado`) VALUES
	(165, '778000000', 7, 77, 7780, 'Ingresos extraordinarios', 0);
/*!40000 ALTER TABLE `tbcuentas` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbdepartamentos
CREATE TABLE IF NOT EXISTS `tbdepartamentos` (
  `lngId` int(11) NOT NULL,
  `strDescripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`lngId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbdepartamentos: ~25 rows (aproximadamente)
DELETE FROM `tbdepartamentos`;
/*!40000 ALTER TABLE `tbdepartamentos` DISABLE KEYS */;
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(0, '111111111111111111111');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(1, 'Calidad');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(2, 'Regionales MAD');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(3, 'Regionales BIO');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(4, 'Regionales VLC');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(5, 'Regionales BCN');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(6, 'Operativo Nacional BT');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(7, 'BTC oficina 310');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(8, 'BTC oficina 290');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(9, 'BTC oficina 344');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(10, 'Implant oficina 890');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(11, 'BTC oficina 280');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(12, 'BTC oficina 500');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(13, 'Implant oficina 539');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(14, 'Departamento 1');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(15, '123456789012345');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(16, '555');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(17, 'Departamentonu ');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(18, 'rrrewqqqqqqqqqqqqqqqqqqqqqqqqqq');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(19, 'wwwwwwwwwwwwwwwwwwwwwww');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(20, 'ewrwr');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(21, 'werererewrwwwweeerewrweerewqweewrw');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(22, '123456789011111111111111');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(23, 'dep-prueba');
INSERT INTO `tbdepartamentos` (`lngId`, `strDescripcion`) VALUES
	(24, 'Administración');
/*!40000 ALTER TABLE `tbdepartamentos` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbdocumentos
CREATE TABLE IF NOT EXISTS `tbdocumentos` (
  `IdDocumento` int(11) NOT NULL DEFAULT '0',
  `IdVersion` int(11) NOT NULL DEFAULT '0',
  `lngTipo` int(11) DEFAULT '0',
  `lngTipo2` varchar(20) DEFAULT NULL,
  `strDocumento` varchar(10) NOT NULL,
  `strNombre` varchar(100) DEFAULT NULL,
  `Categoria` varchar(30) DEFAULT NULL,
  `datFecha` datetime DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `strDescripcion` text,
  `lngIdResponsable` int(11) DEFAULT NULL,
  `lngIdDepartamento` int(11) DEFAULT '0',
  `lngEstado` int(11) DEFAULT '0',
  `lngIdRespRevisado` int(11) DEFAULT NULL,
  `lngIdRespAprobado` int(11) DEFAULT NULL,
  `lngOrden` int(11) DEFAULT '0',
  `lngStatus` int(2) DEFAULT NULL,
  `datFechaStatus` datetime DEFAULT NULL,
  `lngIdEmpleadoStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDocumento`,`IdVersion`),
  UNIQUE KEY `IdDocumento` (`IdDocumento`),
  KEY `IdVersion` (`IdVersion`),
  KEY `strDocumento` (`strDocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbdocumentos: ~7 rows (aproximadamente)
DELETE FROM `tbdocumentos`;
/*!40000 ALTER TABLE `tbdocumentos` DISABLE KEYS */;
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(1, 1, 0, 'Publica', 'MC-01-01', 'Articulo.pdf', 'Calidad', '2013-08-23 10:54:51', '', 'MC-01-01 Edicion 1 Dia 23/8/2013 10:54', 2, 0, 2, 0, 0, 1, 1, '2013-08-23 10:54:51', 2);
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(2, 2, 0, 'Publica', 'MC-01-01', 'Contrato indefinido.pdf', 'Calidad', '2013-08-23 10:57:54', '', 'MC-01-01 Edicion 2 Dia 23/8/2013 10:57', 2, 0, 2, 0, 0, 1, 1, '2013-08-23 10:57:54', 2);
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(3, 3, 0, 'Publica', 'MC-01-01', 'LOPD-20130823110316.pdf', 'Calidad', '2013-08-23 11:03:16', '', 'MC-01-01 Eicion 3 dia 23/8/2013 11:03', 2, 0, 2, 0, 0, 1, 1, '2013-08-23 11:03:16', 2);
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(4, 1, 0, 'Publica', 'IT-03', '04-20130823111105.pdf', 'Calidad', '2013-08-23 11:11:05', '', 'IT-03 Edicion 1', 2, 0, 2, 0, 0, 3, 1, '2013-08-23 11:11:05', 2);
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(5, 2013, 1, 'Publica', 'Cake PHP', '', 'Calidad', '2013-08-23 13:25:53', 'http://book.cakephp.org/2.0/_downloads/es/CakePHPCookbook.pdf', 'Documento de explicacion del framework Cake PHP', 2, 0, 2, 0, 0, 8, 1, '2013-08-23 13:25:53', 2);
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(6, 1, 0, 'Publica', 'MC-10-10', 'jsp-No view-20140417191947.pdf', 'Calidad', '2014-04-17 19:19:47', '', 'Documento prueba 17/4/2014', 2, 0, 2, 0, 0, 1, 1, '2014-04-17 19:19:47', 2);
INSERT INTO `tbdocumentos` (`IdDocumento`, `IdVersion`, `lngTipo`, `lngTipo2`, `strDocumento`, `strNombre`, `Categoria`, `datFecha`, `link`, `strDescripcion`, `lngIdResponsable`, `lngIdDepartamento`, `lngEstado`, `lngIdRespRevisado`, `lngIdRespAprobado`, `lngOrden`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(7, 1, 0, 'Publica', 'dsfd', 'tbReclamaciones1-20151027134635.pdf', 'Calidad', '2015-10-27 13:46:43', '', 'adsffa asdfasdf ', 2, 0, 2, 0, 0, 8, 1, '2015-10-27 13:46:43', 2);
/*!40000 ALTER TABLE `tbdocumentos` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbempleados
CREATE TABLE IF NOT EXISTS `tbempleados` (
  `lngIdEmpleado` int(11) NOT NULL,
  `IdEmpresa` int(11) DEFAULT NULL,
  `strNombre` varchar(15) NOT NULL,
  `strApellidos` varchar(30) NOT NULL,
  `lngIdResponsable` int(11) NOT NULL,
  `lngIdDepartamento` int(11) NOT NULL,
  `strCorreo` varchar(50) DEFAULT NULL,
  `lngIdOficina` int(11) DEFAULT '1',
  `lngTelefono` int(11) DEFAULT '0',
  `lngMovil` int(11) DEFAULT '0',
  `lngStatus` int(2) DEFAULT NULL,
  `datFechaStatus` datetime DEFAULT NULL,
  `lngIdEmpleadoStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`lngIdEmpleado`),
  KEY `IdEmpresa` (`IdEmpresa`),
  KEY `lngIdResponsable` (`lngIdResponsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbempleados: ~121 rows (aproximadamente)
DELETE FROM `tbempleados`;
/*!40000 ALTER TABLE `tbempleados` DISABLE KEYS */;
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(0, 1, 'Administrador', 'Administrador', 0, 0, 'soporte@qualidad.com', 1, 0, 915654477, 1, '2014-08-11 21:42:00', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(1, 2, 'Jose Miguel', 'Ortega ASES', 1, 0, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(2, 2, 'Rosa', 'Morales', 4, 1, 'soporte@qualidad.com', 1, 933442310, 5522, 1, '2013-06-28 19:50:29', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(3, 1, 'Rosó', 'Morlá', 4, 6, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(4, 1, 'Jordi', 'Laviga', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(5, 1, 'Jordi', 'Murall Anduig', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(6, 1, 'Esther', 'Antón', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(7, 1, 'Manel', 'Marquez Martinez', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(8, 1, 'Gloria', 'Garcia Martinez', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(9, 1, 'Oscar', 'Guiu Asensio', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(10, 1, 'Natalia', 'Perez', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(11, 1, 'Javier', 'Longarte Cifrián', 0, 2, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(12, 1, 'Marcos', 'Espada Martinez', 0, 7, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(13, 1, 'Manuel', 'Perez Roblas', 0, 9, 'soporte@qualidad.com', 3, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(14, 1, 'Yolanda', 'Abajo Arroyo', 0, 2, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(16, 1, 'Marcos', 'Barroso García', 0, 2, 'soporte@qualidad.com', 3, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(17, 1, 'Angel', 'Martín', 0, 3, 'soporte@qualidad.com', 6, 946050002, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(18, 1, 'Maje', 'Morcillo Villanueva', 0, 12, 'soporte@qualidad.com', 6, 946050002, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(19, 1, 'Mayte', 'Fernandez Puente', 0, 3, 'soporte@qualidad.com', 6, 946050002, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(20, 1, 'Idoia', 'Zabala Loroño', 0, 3, 'soporte@qualidad.com', 6, 946050002, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(21, 2, 'Carlos', 'Moreno', 0, 4, 'soporte@qualidad.com', 5, 963356322, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(22, 1, 'Rafael', 'Valero Roca', 0, 11, 'soporte@qualidad.com', 5, 963356322, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(23, 2, 'Belén', 'Cervera', 0, 4, 'soporte@qualidad.com', 5, 963356322, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(24, 1, 'Santiago', 'Baeza Vilana', 0, 4, 'soporte@qualidad.com', 5, 963356322, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(54, 1, 'Santiago', 'Barquero', 0, 0, 'soporte@qualidad.com', 1, 0, 0, 1, '2015-02-06 11:40:52', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(78, 1, 'Silvia', 'Martín Santiago', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(95, 1, 'Maite', 'Gentil Lopez', 0, 9, 'soporte@qualidad.com', 3, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(96, 1, 'Beatriz', 'Gallardo', 0, 7, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(97, 1, 'Mario', 'Asenjo', 0, 7, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(98, 1, 'Gemma', 'Viñes Verge', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(99, 1, 'Virginia', 'Alonso Alonso', 0, 12, 'soporte@qualidad.com', 6, 946050000, 0, 0, '2013-05-14 09:13:00', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(100, 1, 'Liliana', 'Jimenez', 0, 7, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(101, 1, 'Raquel', 'Montellano', 0, 7, 'soporte@qualidad.com', 2, 915320685, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(102, 1, 'Jose Miguel', 'Ortega Pardos', 0, 1, 'soporte@qualidad.com', 1, 913095500, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(103, 1, 'Norma', 'Pla - Giribert Enrich', 0, 1, 'soporte@qualidad.com', 1, 932292929, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(104, 1, 'Jose Luis', 'Arcos Granados', 0, 1, 'soporte@qualidad.com', 1, 932292929, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(105, 1, 'Carlos', 'Bordana García', 0, 7, 'soporte@qualidad.com', 2, 912961545, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(106, 1, 'Esther', 'Moya', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(107, 1, 'Pilar', 'Yañez', 0, 5, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(108, 1, 'Marta', 'Jover', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(109, 1, 'Jordi', 'Canals Menal', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(110, 1, 'Mª José', 'Segura del Monte', 0, 2, 'soporte@qualidad.com', 2, 912961545, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(111, 1, 'Susana', 'Sánchez Rizo', 0, 7, 'soporte@qualidad.com', 2, 912961545, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(112, 1, 'Sonia', 'Jiménez Vilanova', 0, 8, 'soporte@qualidad.com', 1, 933442310, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(113, 1, 'Elena', 'González Martínez', 0, 7, 'soporte@qualidad.com', 2, 912961545, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(114, 1, 'Pilar', 'Soto Infantes', 0, 9, 'soporte@qualidad.com', 3, 912961545, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(115, 1, 'Silvia', 'Rodriguez Fernández', 0, 12, 'soporte@qualidad.com', 6, 946050002, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(116, 1, 'Mª Eugenia', 'Cases Lechuga', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(117, 1, 'Rita', 'Pamplona Erencia', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(118, 1, 'Vanessa', 'Fauquier Pascual', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(119, 1, 'Nelly', 'Soria Yagüe', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(120, 1, 'Rosa', 'Salinas Torrecillas', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(121, 1, 'Josep Antón', 'Badía Moreno', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(122, 1, 'Maravillas', 'Sánchez Ibarra', 0, 8, 'soporte@qualidad.com', 1, 933442302, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(123, 1, 'Sara', 'García Maté', 0, 8, 'soporte@qualidad.com', 1, 933442301, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(124, 1, 'Carolina', 'Sánchez Rodrigo', 0, 8, 'soporte@qualidad.com', 1, 933442303, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(125, 1, 'Eliane de los', 'Ríos Céspedes', 0, 8, 'soporte@qualidad.com', 1, 933442304, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(126, 1, 'Sonia', 'Codinarch Luján', 0, 8, 'soporte@qualidad.com', 1, 933442304, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(127, 1, 'Marta', 'Masip Rodrigo', 0, 13, 'soporte@qualidad.com', 7, 934047348, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(128, 1, 'Silvia', 'Rodríguez Fernández', 0, 13, 'soporte@qualidad.com', 1, 946050000, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(129, 1, 'Silvia', 'Rodríguez Fernández', 0, 12, 'soporte@qualidad.com', 1, 946050000, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(130, 1, 'Félix ', 'Cortés', 0, 12, 'soporte@qualidad.com', 6, 946050000, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(131, 1, 'JUan Vicente', 'Ramiro Nicolás', 0, 11, 'soporte@qualidad.com', 5, 963356322, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(132, 1, 'Esther', 'Moya Moya', 0, 13, 'soporte@qualidad.com', 1, 934047348, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(133, 1, 'Esther', 'Moya Moya', 0, 13, 'soporte@qualidad.com', 7, 934047348, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(134, 1, 'Silvia', 'Fita Torres', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(135, 1, 'Bárbara', 'García Guillén', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(136, 1, 'Carme', 'García Osuna', 0, 13, 'soporte@qualidad.com', 7, 934046262, 934900668, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(137, 1, 'Mª José', 'Gil', 0, 4, 'soporte@qualidad.com', 5, 963356322, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(138, 1, 'Sonia', 'Esteban Hernández', 0, 7, 'soporte@qualidad.com', 2, 915328137, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(155, 1, 'noelia', 'lopez arias', 0, 3, 'soporte@qualidad.com', 1, 913410056, 20, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(156, 1, 'erewr', 'hjkhj', 0, 4, 'soporte@qualidad.com', 1, 8989, 9898, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(157, 1, 'erewr', 'hjkhj', 0, 4, 'soporte@qualidad.com', 1, 8989, 9898, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(158, 1, 'jhjhjkh', 'llkjlkjlj', 0, 2, 'soporte@qualidad.com', 1, 888, 8888, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(159, 1, 'aaa', 'Cccc', 0, 1, 'soporte@qualidad.com', 2, 965231458, 123, 0, '2014-09-29 13:13:02', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(160, 1, 'Prueba', 'Manu', 0, 2, 'soporte@qualidad.com', 1, 4564, 54, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(161, 1, 'sdf', 'asdfasd', 0, 0, 'soporte@qualidad.com', 1, 0, 32, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(162, 1, '3213213312', 'wqrwe', 0, 7, 'soporte@qualidad.com', 1, 23232, 3231, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(163, 1, '23123', '123123', 0, 6, 'soporte@qualidad.com', 1, 1312, 12312, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(164, 1, 'asfas', 'we342', 0, 9, 'soporte@qualidad.com', 1, 8787, 8787, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(165, 1, 'asdf', 'asdfas', 0, 0, 'soporte@qualidad.com', 1, 324, 23423, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(166, 1, 'ww', 'ww', 0, 0, 'soporte@qualidad.com', 1, 0, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(167, 1, 'de', 'de', 0, 8, 'soporte@qualidad.com', 1, 0, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(168, 1, 'Ana', 'Nuñez-Seco', 0, 1, 'soporte@qualidad.com', 1, 123456789, 6789, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(169, 1, 'pp', 'pp', 0, 0, 'soporte@qualidad.com', 1, 2323, 123, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(170, 1, 'ewrwe', 'erw', 0, 0, 'soporte@qualidad.com', 1, 12, 12, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(171, 1, 'pruuuu', 'gcvgcvgh', 0, 0, 'soporte@qualidad.com', 1, 5454, 154564, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(172, 1, 'babssss', 'gfvglv ', 0, 0, 'soporte@qualidad.com', 1, 56412, 5412, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(173, 1, 'sofff', 'gfvglv ', 0, 0, 'soporte@qualidad.com', 1, 56412, 5412, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(174, 1, 'sisisisis', 'gfdgtcg', 0, 0, 'soporte@qualidad.com', 1, 57454, 7424, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(175, 1, 'yugh', 'gtyhg', 0, 23, 'soporte@qualidad.com', 1, 7435141, 54154, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(176, 1, 'tdft', 'gg', 0, 20, 'soporte@qualidad.com', 1, 5654, 8748, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(177, 1, 'septiembre', 'jhjub', 0, 23, 'soporte@qualidad.com', 1, 545415418, 8754, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(178, 1, 'sept', 'sept', 0, 0, 'soporte@qualidad.com', 1, 215454541, 815454541, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(179, 1, 'babs', 'babs', 0, 0, 'soporte@qualidad.com', 1, 234857485, 544241542, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(180, 4, 'teo', 'teo', 0, 23, 'soporte@qualidad.com', 1, 5874541, 87451541, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(182, 2, 'Barbara', 'Barbero', 0, 0, 'soporte@qualidad.com', 1, 3526424, 56412541, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(183, 2, 'conchi2', 'conchi', 0, 0, 'soporte@qualidad.com', 1, 5454, 5474, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(184, 1, 'Juan', 'Palomo', 0, 11, 'soporte@qualidad.com', 1, 916564789, 0, 1, NULL, NULL);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(185, 1, 'Alberto', 'Manera Bassa', 0, 6, 'soporte@qualidad.com', 1, 915654477, 2356, 1, '2013-05-13 11:43:03', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(186, 1, 'Conchita', 'Puig', 0, 7, 'soporte@qualidad.com', 1, 935645577, 5632, 1, '2013-05-13 11:49:03', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(187, 1, 'Arturo', 'Valls', 0, 1, 'soporte@qualidad.com', 1, 915467897, 123, 1, '2013-05-14 09:15:44', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(188, 1, 'Maria', 'Del Monte', 0, 18, 'soporte@qualidad.com', 1, 915647799, 212, 1, '2013-05-14 09:59:26', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(189, 1, 'Jose', 'Lopez', 0, 9, 'soporte@qualidad.com', 1, 5646464, 0, 1, '2013-05-14 10:52:30', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(190, 1, 'Alvaro', 'Losada', 0, 7, 'soporte@qualidad.com', 1, 564654, 0, 1, '2013-05-14 10:56:31', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(191, 1, 'Francisco', 'Parralejo', 0, 8, 'soporte@qualidad.com', 1, 6546464, 0, 1, '2013-05-14 11:08:23', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(192, 1, 'Paco', 'Parralejo', 0, 11, 'soporte@qualidad.com', 1, 915654477, 0, 1, '2013-05-14 12:34:18', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(193, 2, 'Juan', 'Aller', 0, 1, 'soporte@qualidad.com', 1, 915654477, 0, 1, '2013-06-29 11:38:03', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(194, 2, 'Alfonso', 'Gloria', 0, 11, 'soporte@qualidad.com', 1, 9156478, 0, 1, '2013-08-05 10:53:37', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(195, 3, 'Paco', 'Parralejo', 0, 24, 'soporte@qualidad.com', 1, 671108309, 0, 1, '2014-09-29 22:38:43', 195);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(196, 1, 'Alberto', 'Fernandez', 0, 0, 'soporte@qualidad.com', 1, 915654477, 952364477, 1, '2014-08-11 20:03:57', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(197, 4, 'Aurelio', 'Moñino Ruiz', 0, 0, 'soporte@qualidad.com', 1, 91, 639728500, 1, '2014-09-16 09:43:24', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(198, 2, 'aaaaaaa', 'bbbbbbbb', 0, 0, 'soporte@qualidad.com', 1, 962541, 4145877, 0, '2014-09-29 12:45:57', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(199, 1, 'Aaaaaaa', 'Ssssssddd', 0, 0, 'soporte@qualidad.com', 1, 914563654, 69545632, 0, '2014-09-29 13:29:29', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(200, 3, 'Usuario', 'Sisha', 0, 0, 'soporte@qualidad.com', 1, 0, 0, 1, '2014-10-10 11:01:57', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(201, 5, 'Conchi', 'González', 0, 0, 'c.gonzalez@qualidad.com', 1, 913095500, 616424847, 1, '2015-06-03 10:29:08', 0);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(202, 6, 'Usuario', 'Pruebas', 0, 0, 'soporte@qualidad.com', 1, 0, 0, 1, '2015-09-28 13:25:04', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(203, 1, 'Francisco', 'Parralejo', 0, 0, 'soporte@qualidad.com', 1, 913095500, 0, 1, '2015-09-29 10:16:11', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(204, 1, 'Conchi', 'Gonzalez', 0, 0, 'soporte@qualidad.com', 1, 913095500, 0, 1, '2015-09-29 10:29:10', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(205, 1, 'Irene', 'Merino', 0, 0, 'soporte@qualidad.com', 1, 913095500, 0, 1, '2015-09-29 10:29:49', 2);
INSERT INTO `tbempleados` (`lngIdEmpleado`, `IdEmpresa`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngMovil`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	(206, 1, 'Jose Miguel', 'Ortega Pardos', 0, 0, 'soporte@qualidad.com', 1, 913095500, 0, 1, '2015-09-29 10:30:32', 2);
/*!40000 ALTER TABLE `tbempleados` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbempleadosok
CREATE TABLE IF NOT EXISTS `tbempleadosok` (
  `lngIdEmpleado` int(11) NOT NULL,
  `strNombre` varchar(15) NOT NULL,
  `strApellidos` varchar(30) NOT NULL,
  `lngIdResponsable` int(11) NOT NULL,
  `lngIdDepartamento` int(11) NOT NULL,
  `strCorreo` varchar(50) DEFAULT NULL,
  `lngIdOficina` int(11) DEFAULT '1',
  `lngTelefono` int(11) DEFAULT '0',
  `lngExtension` int(11) DEFAULT '0',
  PRIMARY KEY (`lngIdEmpleado`),
  KEY `lngIdResponsable` (`lngIdResponsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbempleadosok: ~174 rows (aproximadamente)
DELETE FROM `tbempleadosok`;
/*!40000 ALTER TABLE `tbempleadosok` DISABLE KEYS */;
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(0, 'Administrador', 'Administrador', 0, 0, 'sgcalidad@qualidad.com', 1, 0, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(1, 'Carlos', 'Codina', 1, 0, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(2, 'Rosa', 'Morales', 4, 1, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(3, 'Rosó', 'Morlá', 4, 6, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(4, 'Jordi', 'Laviga', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(5, 'Jordi', 'Murall Anduig', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(6, 'Esther', 'Antón', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(7, 'Manel', 'Marquez Martinez', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(8, 'Gloria', 'Garcia Martinez', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(9, 'Oscar', 'Guiu Asensio', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(10, 'Natalia', 'Perez', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(11, 'Javier', 'Longarte Cifrián', 0, 2, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(12, 'Marcos', 'Espada Martinez', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(13, 'Manuel', 'Perez Roblas', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(14, 'Yolanda', 'Abajo Arroyo', 0, 2, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(15, 'Alvaro', 'Bernabeu Merlo', 0, 2, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(16, 'Marcos', 'Barroso García', 0, 2, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(17, 'Angel', 'Martín', 0, 3, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(18, 'Maje', 'Morcillo Villanueva', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(19, 'Mayte', 'Fernandez Puente', 0, 3, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(20, 'Idoia', 'Zabala Loroño', 0, 3, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(21, 'Carlos', 'Moreno', 0, 4, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(22, 'Rafael', 'Valero Roca', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(23, 'Belén', 'Cervera', 0, 4, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(24, 'Santiago', 'Baeza Vilana', 0, 4, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(25, 'Gemma', 'Montanchez Rosselló', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(26, 'Elena', 'Piqué', 0, 10, 'jm.ortega@qualidad.com', 4, 0, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(27, 'María', 'Turbica', 0, 2, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(28, 'Juan Manuel', 'Fernandez Rubio', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(29, 'Juan Antonio', 'Barroso Velasco', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(30, 'Jesús', 'Alonso Espinar', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(31, 'Jerónimo', 'Serrano Perez', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(32, 'María Luisa', 'Gentil Lopez', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(33, 'José Ramón', 'Cuesta Fernandez', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(34, 'Antonio', 'Ortiz Perez', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(35, 'Mari Paz', 'Vaquero García', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(36, 'Carmen', 'Moreno Soriano', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(37, 'Ana María', 'Rodriguez García', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(38, 'Raquel', 'Delgado Cordero', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(39, 'Emilio', 'Soriano Perez', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(40, 'Esther', 'Lopez Matas', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(41, 'Socorro', 'Relea Herrero', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(42, 'Mercedes', 'Lopez de la Cruz', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(43, 'Julia', 'Cabanillas Carvajal', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(44, 'Beatriz', 'Alonso Serrano', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(45, 'Pedro Antonio', 'Moreno Herrero', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(46, 'José Luís', 'Dorrego Arroyo', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(47, 'Jesús', 'Moreno Herrero', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(48, 'Francisco', 'Liñan Orguín', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(49, 'Mercedes', 'Lopez Palomar', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(50, 'Celia', 'Hernandez Porras', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(51, 'Jenifer', 'Garoz Arroyo', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(52, 'Sara', 'Gago Cao', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(53, 'Mayte', 'García Verdasco', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(54, 'Santiago', 'Baquero Gusano', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(55, 'Marisol', 'Gordillo Llorente', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(56, 'Esther', 'Martinez Bueno', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(57, 'Rocio', 'Galán Cano', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(58, 'José', 'Alvarez Perez', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(59, 'Eugenia', 'Arranz Viana', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(60, 'Guiseppe', 'de Leonardis', 0, 2, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(61, 'Mercé', 'Gonzalez Juanes', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(62, 'Rosa', 'Camacho Alvarez', 0, 8, 'jm.ortega@qualidad.com', 1, 934422301, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(63, 'Sonia', 'Fernandez Romero', 0, 8, 'jm.ortega@qualidad.com', 1, 934422301, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(64, 'Monserrat', 'Pallarés Doig', 0, 8, 'jm.ortega@qualidad.com', 1, 934422301, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(65, 'Nelly', 'Soria Yagüe', 0, 8, 'jm.ortega@qualidad.com', 1, 934422301, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(66, 'Silvia', 'Nuñez Ventura', 0, 8, 'jm.ortega@qualidad.com', 1, 934422302, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(67, 'Judith', 'Moreno Lopez', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(68, 'Ana', 'Carmona Piña', 0, 8, 'jm.ortega@qualidad.com', 1, 934422302, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(69, 'Vanessa', 'Fauquier Pascual', 0, 8, 'jm.ortega@qualidad.com', 1, 934422302, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(70, 'Sonia', 'Torcal Alamo', 0, 8, 'jm.ortega@qualidad.com', 1, 934422303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(71, 'Rocio', 'Andujar Hernandez', 0, 8, 'jm.ortega@qualidad.com', 1, 934422303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(72, 'Rita', 'Pamplona Erencia', 0, 8, 'jm.ortega@qualidad.com', 1, 934422303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(73, 'Laura', 'Casulleras Martinez', 0, 8, 'jm.ortega@qualidad.com', 1, 934422303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(74, 'Angels', 'Wanguemert Serrano', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(75, 'Mercé', 'Puig Munne', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(76, 'Veronica', 'Vilá Lucea', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(77, 'Rosa', 'Salinas Torrecillas', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(78, 'Silvia', 'Martín Santiago', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(79, 'Paqui', 'Quiñonero Madrid', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(80, 'Oscar', 'Concejo Gomez', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(81, 'Encarna', 'Iniesta Jimenez', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(82, 'Pilar', 'Serradilla Macias', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(83, 'David', 'Lapeña Ferrer', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(84, 'Fermín', 'Donet Bellver', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(85, 'Arantxa', 'Martinez Bellido', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(86, 'Reyes', 'Trenor Larraz', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(87, 'Mireia', 'Navarro Griño', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(88, 'Raimon', 'Cano Esparza', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(89, 'Nagore', 'Barcenilla Larrianaga', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(90, 'Mayte', 'Ruiz Fernandez', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(91, 'María José', 'Planillo Fernandez', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(92, 'Rosa María', 'Acebes Cachafeiro', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(93, 'Aranzazu', 'Arrospide Gutierrez', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(94, 'Adriá', 'Flor', 0, 1, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(95, 'Maite', 'Gentil Lopez', 0, 9, 'jm.ortega@qualidad.com', 3, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(96, 'Beatriz', 'Gallardo', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(97, 'Mario', 'Asenjo', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(98, 'Gemma', 'Viñes Verge', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(99, 'Virginia', 'Alonso Alonso', 0, 12, 'jm.ortega@qualidad.com', 6, 946050000, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(100, 'Liliana', 'Jimenez', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(101, 'Raquel', 'Montellano', 0, 7, 'jm.ortega@qualidad.com', 2, 915320685, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(102, 'Jose Miguel', 'Ortega Pardos', 0, 1, 'jm.ortega@qualidad.com', 1, 913095500, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(103, 'Norma', 'Pla - Giribert Enrich', 0, 1, 'jm.ortega@qualidad.com', 1, 932292929, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(104, 'Jose Luis', 'Arcos Granados', 0, 1, 'jm.ortega@qualidad.com', 1, 932292929, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(105, 'Carlos', 'Bordana García', 0, 7, 'jm.ortega@qualidad.com', 2, 912961545, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(106, 'Esther', 'Moya', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(107, 'Pilar', 'Yañez', 0, 5, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(108, 'Marta', 'Jover', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(109, 'Jordi', 'Canals Menal', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(110, 'Mª José', 'Segura del Monte', 0, 2, 'jm.ortega@qualidad.com', 2, 912961545, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(111, 'Susana', 'Sánchez Rizo', 0, 7, 'jm.ortega@qualidad.com', 2, 912961545, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(112, 'Sonia', 'Jiménez Vilanova', 0, 8, 'jm.ortega@qualidad.com', 1, 933442310, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(113, 'Elena', 'González Martínez', 0, 7, 'jm.ortega@qualidad.com', 2, 912961545, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(114, 'Pilar', 'Soto Infantes', 0, 9, 'jm.ortega@qualidad.com', 3, 912961545, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(115, 'Silvia', 'Rodriguez Fernández', 0, 12, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(116, 'Mª Eugenia', 'Cases Lechuga', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(117, 'Rita', 'Pamplona Erencia', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(118, 'Vanessa', 'Fauquier Pascual', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(119, 'Nelly', 'Soria Yagüe', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(120, 'Rosa', 'Salinas Torrecillas', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(121, 'Josep Antón', 'Badía Moreno', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(122, 'Maravillas', 'Sánchez Ibarra', 0, 8, 'jm.ortega@qualidad.com', 1, 933442302, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(123, 'Sara', 'García Maté', 0, 8, 'jm.ortega@qualidad.com', 1, 933442301, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(124, 'Carolina', 'Sánchez Rodrigo', 0, 8, 'jm.ortega@qualidad.com', 1, 933442303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(125, 'Eliane de los', 'Ríos Céspedes', 0, 8, 'jm.ortega@qualidad.com', 1, 933442304, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(126, 'Sonia', 'Codinarch Luján', 0, 8, 'jm.ortega@qualidad.com', 1, 933442304, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(127, 'Marta', 'Masip Rodrigo', 0, 13, 'jm.ortega@qualidad.com', 7, 934047348, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(128, 'Silvia', 'Rodríguez Fernández', 0, 13, 'jm.ortega@qualidad.com', 1, 946050000, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(129, 'Silvia', 'Rodríguez Fernández', 0, 12, 'jm.ortega@qualidad.com', 1, 946050000, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(130, 'Félix ', 'Cortés', 0, 12, 'jm.ortega@qualidad.com', 6, 946050000, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(131, 'JUan Vicente', 'Ramiro Nicolás', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(132, 'Esther', 'Moya Moya', 0, 13, 'jm.ortega@qualidad.com', 1, 934047348, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(133, 'Esther', 'Moya Moya', 0, 13, 'jm.ortega@qualidad.com', 7, 934047348, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(134, 'Silvia', 'Fita Torres', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(135, 'Bárbara', 'García Guillén', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(136, 'Carme', 'García Osuna', 0, 13, 'jm.ortega@qualidad.com', 7, 934046262, 934900668);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(137, 'Mª José', 'Gil', 0, 4, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(138, 'Sonia', 'Esteban Hernández', 0, 7, 'jm.ortega@qualidad.com', 2, 915328137, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(139, 'Koldo', 'Haro', 0, 3, 'jm.ortega@qualidad.com', 6, 946050002, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(140, 'Pilar', 'Ballester', 0, 0, 'jm.ortega@qualidad.com', 5, 963356323, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(141, 'Amparo', 'Abanda', 0, 11, 'jm.ortega@qualidad.com', 5, 963356323, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(142, 'Daniel', 'Jiménez', 0, 0, 'jm.ortega@qualidad.com', 5, 963356323, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(143, 'Laura', 'Castro Ávarez', 0, 7, 'jm.ortega@qualidad.com', 2, 915243903, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(144, 'Carol', 'Loren', 0, 8, 'jm.ortega@qualidad.com', 1, 933442303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(145, 'Ana', 'Carmona Piña', 0, 11, 'jm.ortega@qualidad.com', 5, 963356322, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(146, 'Sandra', 'Vázquez Otero', 0, 8, 'jm.ortega@qualidad.com', 1, 933442303, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(147, 'María ', 'Aguilar Barbadillo', 0, 9, 'jm.ortega@qualidad.com', 3, 917819960, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(148, 'María Gregoria', 'Rodríguez Ramiro', 0, 9, 'jm.ortega@qualidad.com', 3, 912963723, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(149, 'Merce', 'Rovira', 0, 1, 'jm.ortega@qualidad.com', 1, 9, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(150, 'P_manuel', 'Lozano', 0, 0, 'dfasdsad', 1, 223, 12);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(151, 'asdfsad', 'asdfasdf', 0, 1, '', 1, 0, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(152, '43543', '435', 0, 0, '312312', 1, 32, 212);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(153, 'Raquel', 'Cebrecos Tobes', 0, 8, 'trescantos.poniente16business@viajesiberia.com', 1, 0, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(154, 'luisa', 'arias lopez', 0, 1, 'luisa@hotmail.com', 1, 913410056, 20);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(155, 'noelia', 'lopez arias', 0, 3, 'noelia@hotmail.com', 1, 913410056, 20);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(156, 'erewr', 'hjkhj', 0, 4, 'kjh lkhjj', 1, 8989, 9898);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(157, 'erewr', 'hjkhj', 0, 4, 'kjh lkhjj', 1, 8989, 9898);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(158, 'jhjhjkh', 'llkjlkjlj', 0, 2, '9llkjlkj', 1, 888, 8888);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(159, 'aaa', 'aaa', 0, 1, 'aaa', 2, 123, 123);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(160, 'Prueba', 'Manu', 0, 2, 'asdfasdf@afads,.es', 1, 4564, 54);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(161, 'sdf', 'asdfasd', 0, 0, '', 1, 0, 32);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(162, '3213213312', 'wqrwe', 0, 7, '21313', 1, 23232, 3231);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(163, '23123', '123123', 0, 6, '21312', 1, 1312, 12312);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(164, 'asfas', 'we342', 0, 9, '09808', 1, 8787, 8787);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(165, 'asdf', 'asdfas', 0, 0, 'rqwer', 1, 324, 23423);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(166, 'ww', 'ww', 0, 0, 'ww', 1, 0, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(167, 'de', 'de', 0, 8, 'jm.ortega@qualidad.com', 1, 0, 0);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(168, 'Ana', 'Nuñez-Seco', 0, 1, 'qualidad@qualidad.com', 1, 123456789, 6789);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(169, 'pp', 'pp', 0, 0, 'edfdf', 1, 2323, 123);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(170, 'ewrwe', 'erw', 0, 0, '12', 1, 12, 12);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(171, 'pruuuu', 'gcvgcvgh', 0, 0, 'vcfc gbv ', 1, 5454, 154564);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(172, 'babssss', 'gfvglv ', 0, 0, 'gcdgkbvkhv', 1, 56412, 5412);
INSERT INTO `tbempleadosok` (`lngIdEmpleado`, `strNombre`, `strApellidos`, `lngIdResponsable`, `lngIdDepartamento`, `strCorreo`, `lngIdOficina`, `lngTelefono`, `lngExtension`) VALUES
	(173, 'sofff', 'gfvglv ', 0, 0, 'gcdgkbvkhv', 1, 56412, 5412);
/*!40000 ALTER TABLE `tbempleadosok` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbempresas
CREATE TABLE IF NOT EXISTS `tbempresas` (
  `IdEmpresa` int(11) NOT NULL DEFAULT '0',
  `strPassword` varchar(10) DEFAULT NULL,
  `strNombre` varchar(10) DEFAULT NULL,
  `strSesion` varchar(50) DEFAULT NULL,
  `strBD` varchar(15) DEFAULT NULL,
  `strCIF` varchar(50) DEFAULT NULL,
  `fechaAlta` datetime DEFAULT NULL,
  `fechaVencimiento` datetime DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `municipio` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `email1` varchar(50) DEFAULT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `Version` int(11) DEFAULT '0',
  `numApuntes` int(11) DEFAULT '100',
  `borrado` int(11) DEFAULT '0' COMMENT '0=Valido, 1=Borrado',
  `strMapeo` varchar(50) DEFAULT NULL,
  `lngAsesor` int(11) DEFAULT NULL,
  `claseEmpresa` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`),
  KEY `IdEmpresa` (`IdEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbempresas: ~6 rows (aproximadamente)
DELETE FROM `tbempresas`;
/*!40000 ALTER TABLE `tbempresas` DISABLE KEYS */;
INSERT INTO `tbempresas` (`IdEmpresa`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `direccion`, `municipio`, `provincia`, `CP`, `telefono`, `email1`, `email2`, `Version`, `numApuntes`, `borrado`, `strMapeo`, `lngAsesor`, `claseEmpresa`) VALUES
	(1, 'qq', 'qq', 'Qualidad SL Pruebas', 'qq', 'A001', '2013-01-01 00:00:00', '2020-12-31 00:00:00', 'Calle Diego de Leon 69, 4H', 'Móstoles', 'Madrid', 28125, 915602233, 'soporte@qualidad.com', 'soporte@qualidad.com', 12, 100, 0, 'conexion3.php', 1, 'Autonomo');
INSERT INTO `tbempresas` (`IdEmpresa`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `direccion`, `municipio`, `provincia`, `CP`, `telefono`, `email1`, `email2`, `Version`, `numApuntes`, `borrado`, `strMapeo`, `lngAsesor`, `claseEmpresa`) VALUES
	(2, 'ss', 'ss', 'Solar', 'Solar', 'A002', '2013-01-10 00:00:00', '2020-12-31 00:00:00', 'Plaza de la Independencia 1', 'Leganes', 'Madrid', 28556, 915447788, 'solar@solar.es', '', 2, 100, 0, 'conexion2.php', 1, 'Sociedades');
INSERT INTO `tbempresas` (`IdEmpresa`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `direccion`, `municipio`, `provincia`, `CP`, `telefono`, `email1`, `email2`, `Version`, `numApuntes`, `borrado`, `strMapeo`, `lngAsesor`, `claseEmpresa`) VALUES
	(3, 'sisha', 'sisha', 'Sisha Restarurante', 'Sisha', 'A003', '2014-04-15 00:00:00', '2020-12-30 00:00:00', 'Calle Mayor 23', 'Calvia', 'Mallorca', 0, 0, 'jm.ortega@qualidad.com', 'soporte@qualidad.com', 1, 100, 0, 'conexionEmpresaNueva.php', 1, 'Autonomo');
INSERT INTO `tbempresas` (`IdEmpresa`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `direccion`, `municipio`, `provincia`, `CP`, `telefono`, `email1`, `email2`, `Version`, `numApuntes`, `borrado`, `strMapeo`, `lngAsesor`, `claseEmpresa`) VALUES
	(4, 'amruiz', 'infopublic', 'Infopublic Consulting S.L.', 'infopublic', 'B82501347', '2014-09-16 00:00:00', '2020-12-31 00:00:00', 'Velázquez, 121', 'Madrid', 'Madrid', 28006, 91, 'jm.ortega@qualidad.com', '', 1, 100, 0, 'conexion4.php', 2, 'Sociedades');
INSERT INTO `tbempresas` (`IdEmpresa`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `direccion`, `municipio`, `provincia`, `CP`, `telefono`, `email1`, `email2`, `Version`, `numApuntes`, `borrado`, `strMapeo`, `lngAsesor`, `claseEmpresa`) VALUES
	(5, '2003', 'qualidad', 'Qualidad Consulting de Sistemas, S.L.', 'qualidad', 'B83520148', '2015-06-01 00:00:00', '2020-06-18 00:00:00', 'Diego de León, 69 4H', 'Madrid', 'Madrid', 28006, 913095500, 'jm.ortega@qualidad.com', 'c.gonzalez@qualidad.com', 1, 1000, 0, 'conexion5.php', 1, 'Sociedades');
INSERT INTO `tbempresas` (`IdEmpresa`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `direccion`, `municipio`, `provincia`, `CP`, `telefono`, `email1`, `email2`, `Version`, `numApuntes`, `borrado`, `strMapeo`, `lngAsesor`, `claseEmpresa`) VALUES
	(6, '1234', 'Demo', 'Demo', 'Demo', 'B000000000000', '2015-09-28 00:00:00', '2020-10-13 00:00:00', 'Calle Diego de Leon 69, 4H', 'Madrid', 'Madrid', 28006, 913095500, 'soporte@qualidad.om', '', 1, 100, 0, 'conexionDemo.php', 0, 'Sociedades');
/*!40000 ALTER TABLE `tbempresas` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbempresasokk
CREATE TABLE IF NOT EXISTS `tbempresasokk` (
  `lngId` int(11) NOT NULL AUTO_INCREMENT,
  `strPassword` varchar(10) DEFAULT NULL,
  `strNombre` varchar(10) DEFAULT NULL,
  `strSesion` varchar(50) DEFAULT NULL,
  `strBD` varchar(15) DEFAULT NULL,
  `strCIF` varchar(50) DEFAULT NULL,
  `fechaAlta` datetime DEFAULT NULL,
  `fechaVencimiento` datetime DEFAULT NULL,
  `codVersion` varchar(50) DEFAULT NULL,
  `numEmpleados` int(11) DEFAULT '100',
  PRIMARY KEY (`lngId`),
  KEY `lngId` (`lngId`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbempresasokk: ~40 rows (aproximadamente)
DELETE FROM `tbempresasokk`;
/*!40000 ALTER TABLE `tbempresasokk` DISABLE KEYS */;
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(1, 'qq', 'qq', 'Qualidad Consulting de Sistemas S.L.', 'Qualidad', 'A001', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(2, 'prueba', 'infopublic', 'Infopublic', 'Infopublic', 'A002', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(3, 'ayamaka', 'ayamaka', 'Ayamaka, S.L.', 'Ayamaka', 'B80070139', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(4, 'bt620', 'iberia', 'Viajes Iberia División Business Travel', 'VIBusiness', 'A07001415', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(5, 'demo', 'demo', 'Empresa de demostración', 'Demo', 'A003', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(6, 'pinar29', 'SKN', 'Sistemas Kabel Netz S.L', 'SKN', 'A004', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(7, '28039', 'Zarza', 'Mudanzas Zarza S.L.', 'Zarza', 'A005', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(8, '25002', 'Ilerdent', 'Institut Dental Ilerdent, S.L.', 'Ilerdent', 'B25321514', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(9, '28010', 'Repessa', 'Repro Escritura S.A.', 'Repessa', 'A28641686', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(10, '28050', 'Logisat', 'Logisat Sistemas S.L.', 'Logisat', 'B83850776', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(11, '08181', 'MDC', 'Montaje y Diseño del Cableado S.L.', 'MDC', 'B60546348', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(12, '08820', 'Blau', 'Blau Calor Energy, S.L.', 'Blau', 'B63897128', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(13, '08100', 'Pelegrina', 'Pelegrina Blasco, S.C.P', 'Pelegrina', 'G63613434', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(14, '17190', 'Torras', 'Institut Geriàtric Torras, S.L.', 'Torras', 'B17391061', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(15, '08840', 'Ferlavila', 'Construcciones Ferlavila, S.L.', 'Ferlavila', 'B63622708', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(16, '38280', 'Repamagri', 'Repamagri, S.L.', 'Repamagri', 'B38494662', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(17, '08191', 'Rubi', 'Instalconfort Rubí S.C.P.', 'Rubi', 'G63056121', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(18, '9999', 'Genesis', 'Residencia Geriàtrica Génesis II', 'Genesis', 'B60646486', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(19, 'bt620', 'Incentivos', 'Viajes Iberia Incentivos y Convenciones', 'Incentivos', 'A07001415', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(20, '08223', 'Puig', 'Envans Pluvials Puig, S.L.', 'Puig', 'B63586366', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(21, '08830', 'Trench', 'Trenchsalvic, S.L.', 'Trenchsalvic', 'B60742202', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(22, '28806', 'Pavianca', 'Pavianca 2003, S.L.', 'Pavianca', 'B83729020', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(23, '08015', 'Pecofris', 'Estructuras Pecofris, S.L.', 'Pecofris', 'B63039606', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(24, '08005', 'Interclean', 'Interclean Services, S.L.', 'Interclean', 'B62598578', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(25, '9294', 'wqo', 'WQO Organización Mundial de la Calidad', 'Wqo', 'G62081344', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(26, '28036', 'ipsa', 'Investigación y Programas, S.A. (IPSA)', 'Ipsa', 'A006', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(27, '28014', 'ugh', 'Unión de Gestión Hipotecaria, S.L.', 'Ugh', 'B50919604', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(28, '431', 'Formarse', 'Formar y Seleccionar, S.L.', 'Formarse', 'B83873133', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(29, '28005', 'Sat', 'S A T, S.L.', 'Sat', 'B', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(30, '28031', 'ayc', 'Análisis y Control, S.A.', 'ayc', 'A28615607', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(31, '28923', 'bcts', 'BCTS Spain, S.L.', 'bcts', 'B', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(32, '06800', 'Regatas', 'Grupo Regatas Hispania', 'Regatas', 'B-06519243', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(33, '28003', 'Europair', 'Europair Broker', 'Europair', 'A-07663354', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(34, '28050', 'JDSU', 'JDSU Spain, S.A.', 'JDSU', 'A78431483', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(35, '3322', 'Tourline', 'Tourline Express, S.A.', 'Tourline', 'a', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(36, '28760', 'Vesa', 'Vesa Direct', 'Vesa', 'q', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(37, '08030', 'Martin', 'Martín Arts Gràfiques, S.L.', 'Martin', 'B-08783664', NULL, '2009-12-31 00:00:00', NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(38, '90611', 'Halcon', 'Halcon, S.L.', 'Halcon', NULL, NULL, NULL, NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(39, 'gg', 'gg', 'prueba', 'prueba', NULL, NULL, NULL, NULL, 100);
INSERT INTO `tbempresasokk` (`lngId`, `strPassword`, `strNombre`, `strSesion`, `strBD`, `strCIF`, `fechaAlta`, `fechaVencimiento`, `codVersion`, `numEmpleados`) VALUES
	(40, 'ss', 'ss', 'prueba', 'prueba', NULL, NULL, NULL, NULL, 100);
/*!40000 ALTER TABLE `tbempresasokk` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbempresas_joomla_control
CREATE TABLE IF NOT EXISTS `tbempresas_joomla_control` (
  `id` int(10) NOT NULL,
  `id_joomla` int(10) NOT NULL,
  `fecha_alta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbempresas_joomla_control: ~2 rows (aproximadamente)
DELETE FROM `tbempresas_joomla_control`;
/*!40000 ALTER TABLE `tbempresas_joomla_control` DISABLE KEYS */;
INSERT INTO `tbempresas_joomla_control` (`id`, `id_joomla`, `fecha_alta`) VALUES
	(1, 8, '2014-09-16 09:43:24');
INSERT INTO `tbempresas_joomla_control` (`id`, `id_joomla`, `fecha_alta`) VALUES
	(2, 11, '2015-06-03 10:29:08');
/*!40000 ALTER TABLE `tbempresas_joomla_control` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbgrupos
CREATE TABLE IF NOT EXISTS `tbgrupos` (
  `IdGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IdGrupo`),
  KEY `IdGrupo` (`IdGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbgrupos: ~0 rows (aproximadamente)
DELETE FROM `tbgrupos`;
/*!40000 ALTER TABLE `tbgrupos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbgrupos` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbmenu
CREATE TABLE IF NOT EXISTS `tbmenu` (
  `idx` varchar(8) NOT NULL,
  `lng_nivel` int(4) NOT NULL,
  `lng_posicion` int(4) NOT NULL,
  `lng_anterior` varchar(8) NOT NULL,
  `str_texto` varchar(150) NOT NULL,
  `lng_standard` int(4) NOT NULL,
  `lng_profesional` int(4) NOT NULL,
  `lng_premiun` int(4) NOT NULL,
  `str_destino` varchar(100) NOT NULL,
  `textoSuperior` varchar(100) DEFAULT NULL,
  `textoPrincipal` varchar(100) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `idx` (`idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbmenu: ~110 rows (aproximadamente)
DELETE FROM `tbmenu`;
/*!40000 ALTER TABLE `tbmenu` DISABLE KEYS */;
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('01', 1, 1, '0', 'Configuración', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0101', 2, 1, '01', 'Mis Usuarios', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010101', 3, 1, '0101', 'Alta', 1, 1, 1, 'altaempleado.php', 'Opción Seleccionada:', 'Alta Empleado', 'Puedes dar de alta un nuevo empleado');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010102', 3, 2, '0101', 'Baja', 1, 1, 1, 'usuborra.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010103', 3, 3, '0101', 'Consulta/Modificación', 1, 1, 1, 'usumodiflist.php', 'Opción Seleccionada:', 'Editar Empleado', 'Puedes editar los datos del empleado');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010104', 3, 4, '0101', 'Consulta', 1, 1, 1, 'usulist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010105', 3, 5, '0101', 'Alta Empresa', 1, 1, 1, 'altaempresa.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0102', 2, 2, '01', 'Mis Clientes', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010201', 3, 1, '0102', 'Alta', 1, 1, 1, 'altacliprov.php', 'Opción Seleccionada:', 'Nuevo Cliente', 'Recuerda que puedes convertir un CONTACTO a CLIENTE. Ir a <a href="../vista/contactolist.php">Mis contactos</a>');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010202', 3, 2, '0102', 'Consulta/Modificación', 1, 1, 1, 'cliprovlist.php', 'Opción Seleccionada:', 'Editar Cliente', 'Puedes editar los datos del cliente');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010203', 3, 3, '0102', 'Modificación', 1, 1, 1, 'clilist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010204', 3, 4, '0102', 'Consulta', 1, 1, 1, 'clilist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0103', 2, 3, '01', 'Mis Proveedores', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010301', 3, 1, '0103', 'Alta', 1, 1, 1, 'altacliprov.php', 'Opción Seleccionada:', 'Nuevo Proveedor', 'Recuerda que puedes convertir un PROVEEDOR a CLIENTE. Ir a <a href="../vista/contactolist.php">Mis contactos</a>');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010302', 3, 2, '0103', 'Consulta/Modificación', 1, 1, 1, 'cliprovlist.php', 'Opción Seleccionada:', 'Editar Proveedor', 'Puedes editar los datos del Proveedor');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010303', 3, 3, '0103', 'Modificación', 1, 1, 1, 'provborra.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010304', 3, 4, '0103', 'Consulta', 1, 1, 1, 'provlist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0104', 2, 4, '01', 'Mis Cuentas', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010401', 3, 1, '0104', 'Alta', 1, 1, 1, 'altacuentas.php', 'Opción Seleccionada:', 'Nueva Cuenta', 'Puedes dar de alta una nueva cuenta');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010402', 3, 2, '0104', 'Consulta/Modificación', 1, 1, 1, 'cuentaslist.php', 'Opción Seleccionada:', 'Editar Cuenta', 'Puedes edita una cuenta');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010403', 3, 3, '0104', 'Modificación', 1, 1, 1, 'cuentaslist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010404', 3, 4, '0104', 'Consulta', 1, 1, 1, 'cuentaslist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0105', 2, 5, '01', 'Mis Contactos', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010501', 3, 1, '0105', 'Alta', 1, 1, 1, 'altacontacto.php', 'Opción Seleccionada:', 'Nuevo Contacto', 'Puedes enviar presupuestos a tus clientes potenciales');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010502', 3, 2, '0105', 'Consulta/Modificación', 1, 1, 1, 'contactolist.php', 'Opción Seleccionada:', 'Editar Contacto', 'Puedes modificar los datos de los clientes potenciales');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0106', 2, 1, '01', 'Mi Empresa', 1, 1, 1, 'configuracion_empresa.php', 'Área Privada:', 'Configurar Mi Empresa', 'Introduzca los datos de configurarciones de su empresa');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0107', 2, 1, '01', 'Mis Artículos', 1, 1, 1, 'misArticulos.php', 'Opción Seleccionada:', 'Mis Artículos', 'Se puede dar de ata o modificar un Artículo');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010701', 3, 2, '0107', 'Alta', 1, 1, 1, 'altaArticulo.php', 'Opción Seleccionada:', 'Alta de Artículo', 'Se puede dar el alta de un artículo');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('010702', 3, 2, '0107', 'Consulta/Modificación', 1, 1, 1, 'articulo_list.php', 'Opción Seleccionada:', 'Editar Artículo', 'Puedes modificar los datos de un artículo');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('02', 1, 2, '0', 'Contabilidad', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0201', 2, 1, '02', 'Contabilizar Facturas', 1, 1, 1, 'contabilizar_facturas.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0202', 2, 2, '02', 'Mis Ingresos', 1, 1, 1, 'ingresos_entrada.php', 'Opción Seleccionada:', 'Contabilizar Ingresos', 'Se van a añadir asientos de ingresos a la contabilidad');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020201', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Ingresos', 'Sin Factura', 'Puede dar de alta un asiento sin IVA');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020202', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Ingresos', 'Con Factura  + 1 IVA', 'Puede dar de alta un asiento con IVA');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020203', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Ingresos', 'Con Factura + Varios IVA\'s', 'Puede dar de alta un asiento con varios IVA\'s');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020204', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Ingresos', 'Con Factura  + 1 IVA + IRPF', 'Puede dar de alta un asiento con 1 IVA + IRPF');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020205', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Ingresos', 'Con Factura + Varios IVA\'s + IRPF', 'Puede dar de alta un asiento con varios IVA\'s + IRPF');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0203', 2, 3, '02', 'Compras y Gastos', 1, 1, 1, 'gastos_entrada.php', 'Opción Seleccionada:', 'Contabilizar Compras y Gastos', 'Se van a añadir asientos de gastos a la contabilidad');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020301', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Compras y Gastos', 'Sin Factura', 'Puede dar de alta un asiento sin IVA');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020302', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Compras y Gastos', 'Con Factura  + 1 IVA', 'Puede dar de alta un asiento con IVA');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020303', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Compras y Gastos', 'Con Factura + Varios IVA\'s', 'Puede dar de alta un asiento con varios IVA\'s');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020304', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Compras y Gastos', 'Con Factura  + 1 IVA + IRPF', 'Puede dar de alta un asiento con 1 IVA + IRPF');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('020305', 0, 0, '', '', 1, 1, 1, '', 'Contabilizar Compras y Gastos', 'Con Factura + Varios IVA\'s + IRPF', 'Puede dar de alta un asiento con varios IVA\'s + IRPF');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0204', 2, 4, '02', 'Mis Movimientos', 1, 1, 1, 'ingresos_gastos.php', 'Opción Seleccionada:', 'Nuevo Asiento', 'Puede dar de alta un asiento');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0204e', 0, 0, '', '', 1, 1, 1, '', 'Opción Seleccionada:', 'Editar Asiento', 'Puede editar los datos del asiento');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0204n', 0, 0, '', '', 1, 1, 1, '', 'Opción Seleccionada:', 'Nuevo Asiento', 'Puede dar de alta un asiento nuevo');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0205', 2, 5, '02', 'Modificar Asiento', 1, 1, 1, 'listado_asientos.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0206', 2, 3, '02', 'Cobrar mis Facturas', 1, 1, 1, 'cobrar_facturas.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('03', 1, 3, '0', 'Consultas', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0301', 2, 1, '03', 'I.V.A.', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('030101', 3, 1, '0301', 'Cálculo de Liquidaciones', 1, 1, 1, 'presentar_iva.php', 'Opción Seleccionada:', 'Autoliquidación del IVA', 'Puedes preparar el impuesto del IVA');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('030102', 3, 2, '0301', 'Liquidaciones Presentadas', 1, 1, 1, 'consultar_iva.php', 'Opción Seleccionada:', 'Autoliquidación.<br/> Impuesto sobre el Valor Añadido', 'Puedes revisar el impuesto del IVA');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0302', 2, 2, '03', 'IRPF', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('030201', 3, 1, '0302', 'Cálculo de Liquidaciones', 1, 1, 1, 'presentar_irpf.php', 'Opción Seleccionada:', 'Autoliquidación<br/>Iimpuesto Retención Personas Físicas', 'Puedes preparar el impuesto IRPF');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('030202', 3, 2, '0302', 'Liquidaciones Presentadas', 1, 1, 1, 'consultar_irpf.php', 'Opción Seleccionada:', 'Autoliquidación<br/>Iimpuesto Retención Personas Físicas', 'Puedes revisar el impuesto IRPF');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0303a', 2, 3, '03', 'Pagos a Cuenta', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0303a01', 3, 1, '0303a', 'Calculados', 1, 1, 1, 'presentar_autonomo130.php', 'Opción Seleccionada:', 'Autoliquidación. Pagos a Cuenta', 'Puedes presentar el impuesto de pago a cuenta 130');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0303a02', 3, 2, '0303a', 'Presentados', 1, 1, 1, 'consultar_autonomo130.php', 'Opción Seleccionada:', 'Autoliquidación. Pagos a Cuenta', 'Puedes revisar el impuesto de pago a cuenta 130');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0303e', 2, 3, '03', 'Sociedades', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0304', 2, 4, '03', 'Balance', 1, 1, 1, 'balance.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0305', 2, 5, '03', 'Cuentas', 1, 1, 1, 'listado.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0306', 2, 6, '03', 'Sumas y Saldos', 1, 1, 1, 'movagrulist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0307', 2, 7, '03', 'Resultados', 1, 1, 1, 'resultados.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('04', 1, 4, '0', 'Comunicaciones', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0402', 2, 2, '04', 'Consultas al Asesor', 1, 1, 1, 'consulta_asesor_cliente.php', 'Opción Seleccionada:', 'Consultas al Asesor', 'Puede preguntar al asesor sobre cualquier duda');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0402b', 2, 2, '04', 'Consultas del Asesor', 1, 1, 1, 'consulta_del_asesor.php', 'Opción Seleccionada:', 'Consultas del Asesor', 'El asesor puede realizar las comunicaciones a los usuarios');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0403', 2, 3, '04', 'Transmitir Apuntes', 1, 1, 1, 'transmitir_apuntes.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('05', 1, 5, '0', 'Mis Presupuestos', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0501', 2, 1, '05', 'Alta', 1, 1, 1, 'altapresupuesto.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0502', 2, 2, '05', 'Modificación/Duplicar/Baja', 1, 1, 1, 'presupuestolist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0503', 2, 3, '05', 'Facturar Presupuesto', 1, 1, 1, 'facturar_presupuesto.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0504', 2, 4, '05', 'Generar Pedido', 1, 1, 1, 'presupuestoConvertirList.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('06', 1, 6, '0', 'Mis Facturas', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0601', 2, 1, '06', 'Alta', 1, 1, 1, 'altafactura.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0602', 2, 2, '06', 'Modificación/Duplicar/Baja', 1, 1, 1, 'facturalist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0603', 2, 3, '06', 'Facturar Presupuesto', 1, 1, 1, 'facturar_presupuesto.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0603b', 2, 4, '06', 'Facturar Pedidos', 1, 1, 1, 'facturar_pedido.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0604', 2, 5, '06', 'Contabilizar Facturas', 1, 1, 1, 'contabilizar_facturas.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('07', 1, 1, '0', 'Fiscal', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('08', 1, 1, '0', 'Laboral', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0801', 2, 1, '08', 'Empleados', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('080101', 3, 1, '0801', 'Alta', 1, 1, 1, 'empleados.php', 'Opción Seleccionada:', 'Nuevo Empleado', 'Puede dar de alta un empleado nuevo');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('080102', 3, 2, '0801', 'Modificación/Baja', 1, 1, 1, 'empleados_list.php', 'Opción Seleccionada:', 'Editar Empleado', 'Puede editar los datos del empleado');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0802', 2, 2, '08', 'Incidencias Nómina', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('080201', 3, 1, '0802', 'Alta', 1, 1, 1, 'incNomina.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('080202', 3, 2, '0802', 'Consulta', 1, 1, 1, 'incNomina_listIncidencias.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0802a', 2, 2, '08', 'Incidencias Nómina', 1, 1, 1, 'incNominaEmpleadoIncidencia.php', 'Opción Seleccionada:', 'Alta de Incidencia', 'Puede dar de alta una nueva incidencia de un empleado');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0803', 2, 3, '08', 'Nóminas', 1, 1, 1, 'nominas.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('0804', 2, 4, '08', 'Plantilla Actual', 1, 1, 1, 'plantActual.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('09', 1, 1, '0', 'Salir', 1, 1, 1, 'salir.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('10', 1, 1, '0', 'Mis Pedidos', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('1001', 2, 1, '1', 'Alta', 1, 1, 1, 'altapedido.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('1002', 2, 2, '1', 'Modificación/Duplicar/Baja', 1, 1, 1, 'pedidolist.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('1003', 2, 3, '1', 'Generar Facturas', 1, 1, 1, 'facturar_pedido.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a01', 1, 1, '0', 'www.qualidad.es', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0101a', 2, 1, '01', 'Alta Empresa', 1, 1, 1, 'altaempresa.php', 'Opción Seleccionada:', 'Se puede dar de alta una empresa', NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0101b', 2, 1, '01', 'Alta Empresa', 1, 1, 1, 'joomla_list_empresa.php', 'Opción Seleccionada:', 'Alta Empresa desde www.qualidad.es', 'Se puede dar de alta una empresa importando los datos de la web');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a02', 1, 2, '0', 'Documentacion', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0201', 2, 1, '02', 'Alta Documento', 1, 1, 1, 'alta_documento.php', 'Opción Seleccionada:', 'Alta de Documento', 'Se puede dar de alta un documento y subirlo al servidor');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0202', 2, 2, '02', 'Listado Documento', 1, 1, 1, 'listado_documento.php', 'Opción Seleccionada:', NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a03', 1, 3, '0', 'Incidencias', 1, 1, 1, '0', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0301', 2, 1, '03', 'Alta Incidencia', 1, 1, 1, 'incidencias.php', 'Opción Seleccionada:', 'Alta de Incidencia', 'Se puede dar de alta la incidencia');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0302', 2, 2, '03', 'Listado Incidencias', 1, 1, 1, 'consulta_list_preguntas.php', 'Opción Seleccionada:', NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a04', 1, 4, '0', 'www.qualidad-asesores.es', 1, 1, 1, '', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0401', 2, 1, '04', 'Alta Empresa', 1, 1, 1, 'innovae_listado.php', 'Opción Seleccionada:', 'Alta Empresa desde www.qualidad-asesores.es', 'Se puede dar de alta una empresa importando los datos de la web');
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a05', 1, 5, '0', 'Ventas', 1, 1, 1, '', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0501', 2, 1, '05', 'Bancos', 1, 1, 1, 'ventas_bancos.php', 'Opción Seleccionada:', 'Entrada de Ventas', NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0502', 2, 2, '05', 'Tarjetas', 1, 1, 1, 'ventas_tarjetas.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('a0503', 2, 3, '05', 'Listado General', 1, 1, 1, 'ventas_listado.php', NULL, NULL, NULL);
INSERT INTO `tbmenu` (`idx`, `lng_nivel`, `lng_posicion`, `lng_anterior`, `str_texto`, `lng_standard`, `lng_profesional`, `lng_premiun`, `str_destino`, `textoSuperior`, `textoPrincipal`, `descripcion`) VALUES
	('incidenc', 0, 0, '0', 'Incidencias', 1, 1, 1, 'incidencias.php', 'Opción Seleccionada:', 'Envío de Incidencias', 'Se puede dar de alta la incidencia');
/*!40000 ALTER TABLE `tbmenu` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbmovimientos
CREATE TABLE IF NOT EXISTS `tbmovimientos` (
  `IdMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) DEFAULT '0',
  `asiento` int(11) DEFAULT '0',
  `orden` int(11) DEFAULT '0',
  `idCuenta` int(11) DEFAULT '0',
  `D/H` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `periodo` int(11) DEFAULT '0',
  `ejercicio` int(11) DEFAULT '0',
  PRIMARY KEY (`IdMovimiento`),
  KEY `asiento` (`asiento`),
  KEY `idCuenta` (`idCuenta`),
  KEY `idEmpresa` (`idEmpresa`),
  KEY `IdMovimiento` (`IdMovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbmovimientos: ~0 rows (aproximadamente)
DELETE FROM `tbmovimientos`;
/*!40000 ALTER TABLE `tbmovimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbmovimientos` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tboficinas
CREATE TABLE IF NOT EXISTS `tboficinas` (
  `lngId` int(11) NOT NULL DEFAULT '0',
  `strNombre` varchar(70) DEFAULT NULL,
  `strPoblacion` varchar(70) NOT NULL,
  `strProvincia` varchar(50) NOT NULL,
  `lngCP` int(11) NOT NULL DEFAULT '0',
  `strDireccion` varchar(70) NOT NULL,
  `strCodigo` varchar(20) NOT NULL,
  `lngTelefono` int(11) DEFAULT NULL,
  `lngFax` int(11) DEFAULT '0',
  PRIMARY KEY (`lngId`),
  KEY `lngId` (`lngId`),
  KEY `strCodigo` (`strCodigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tboficinas: ~12 rows (aproximadamente)
DELETE FROM `tboficinas`;
/*!40000 ALTER TABLE `tboficinas` DISABLE KEYS */;
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(0, 'Todas las Oficinas', 'Población', 'Provincia', 0, 'Dirección', '000', 0, 0);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(1, 'Gran Via', 'Barcelona', 'Barcelona', 8007, 'Gran Via, 613 - 4', '290', 933442310, 933442311);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(2, 'San Bernardo 1', 'Madrid', 'Madrid', 28015, 'San Bernardo 20 - 6', '310', 915328137, 915223418);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(3, 'San Bernardo 2', 'Madrid', 'Madrid', 28015, 'San Bernardo 20 - 6', '344', 914449500, 912963730);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(4, 'Nutrexpa', 'Barcelona', 'Barcelona', 8025, 'Lepanto 410 - 414', '890', 932900290, 932900337);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(5, 'Pintor Sorolla', 'Valencia', 'Valencia', 46004, 'Pintor Sorolla 5 1A', '280', 963356323, 963951537);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(6, 'Mazarredo', 'Bilbao', 'Vizcaya', 48009, 'Alameda Mazarredo, 18', '500', 946050000, 946050001);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(7, 'La Caixa', 'Barcelona', 'Barcelona', 8028, 'Gran Vía, 621-629', '539', 934046262, 934900668);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(8, 'Ofi-prueba', 'e', 'e', 1, 'e', '1212', 0, 0);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(9, 'Oficina Principal', 'Madrid', 'Madrid', 28008, 'C/Rosa, 9', '001', 123456789, 987456321);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(10, '', 'Toledo', 'Toledo', 45001, 'C/Moros, 5', '002', 0, 0);
INSERT INTO `tboficinas` (`lngId`, `strNombre`, `strPoblacion`, `strProvincia`, `lngCP`, `strDireccion`, `strCodigo`, `lngTelefono`, `lngFax`) VALUES
	(11, 'diego de leon', 'fgsdfh', 'dbsdgh', 99999, 'dfhhtr', '1', 999999999, 999999999);
/*!40000 ALTER TABLE `tboficinas` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbpermisoscargos
CREATE TABLE IF NOT EXISTS `tbpermisoscargos` (
  `lngId` int(11) NOT NULL AUTO_INCREMENT,
  `strPagina` varchar(50) NOT NULL,
  `strDesc` varchar(50) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  `Asesor` int(1) NOT NULL DEFAULT '1',
  `Asesor2` int(1) NOT NULL DEFAULT '1',
  `Asesor3` int(1) NOT NULL DEFAULT '1',
  `Asesor4` int(1) NOT NULL DEFAULT '1',
  `Asesor5` int(1) NOT NULL DEFAULT '1',
  `Usuario` int(1) NOT NULL DEFAULT '1',
  `Usuario2` int(1) NOT NULL DEFAULT '1',
  `Usuario3` int(1) NOT NULL DEFAULT '1',
  `Usuario4` int(1) NOT NULL DEFAULT '1',
  `Usuario5` int(1) NOT NULL DEFAULT '1',
  `Invitado` int(1) NOT NULL DEFAULT '1',
  `SinPermisosAsignados` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`lngId`),
  KEY `lngId` (`lngId`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbpermisoscargos: ~144 rows (aproximadamente)
DELETE FROM `tbpermisoscargos`;
/*!40000 ALTER TABLE `tbpermisoscargos` DISABLE KEYS */;
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(1, 'alta_documento.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(2, 'altacliprov.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(3, 'altacuentas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(4, 'altaempleado.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(5, 'altaempresa.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(6, 'asientoBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(7, 'autonomo130_datosVer.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(8, 'autonomo_130.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(9, 'aviso.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(10, 'balance.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(11, 'cabecera2.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(12, 'cabecera2Asesor.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(13, 'cabeceraForm.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(14, 'cabeceraFormAsesor.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(15, 'cliprovBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(16, 'cliprovlist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(17, 'consulta_asesor.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(18, 'consulta_asesor_cliente.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(19, 'consulta_list_preguntas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(20, 'consultacliprov.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(21, 'consultacuentas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(22, 'consultar_autonomo130.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(23, 'consultar_irpf.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(24, 'consultar_iva.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(25, 'cuentaBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(26, 'cuentaslist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(27, 'default2.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(28, 'defaultAsesor.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(29, 'empleadoBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(30, 'empleados.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(31, 'empleados_list.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(32, 'error.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(33, 'exito.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(34, 'gastos_CFIVA1CIRPF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(35, 'gastos_CFIVA1SIRPF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(36, 'gastos_CFIVAV.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(37, 'gastos_editar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(38, 'gastos_entrada.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(39, 'gastos_exito.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(40, 'gastos_SF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(41, 'IndicacionIncidencia.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(42, 'ingresos_CFIVA1CIRPF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(43, 'ingresos_CFIVA1SIRPF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(44, 'ingresos_CFIVAV.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(45, 'ingresos_entrada.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(46, 'ingresos_exito.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(47, 'ingresos_gastos.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(48, 'ingresos_SF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(49, 'irpf_datosPresentar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(50, 'irpf_datosVer.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(51, 'iva_303.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(52, 'iva_303_ver.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(53, 'listado_asientos2.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(54, 'listado_asientos.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(55, 'listado_documento.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(56, 'login.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(57, 'movagrulist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(58, 'movimientos.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(59, 'movlist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(60, 'presentar_autonomo130.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(61, 'presentar_irpf.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(62, 'presentar_iva.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(63, 'resultados.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(64, 'tree_resp.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(65, 'usuarioBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(66, 'usulist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(67, 'usumodif.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(68, 'usumodiflist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(69, 'listado.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(70, 'listado_cuenta.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(71, 'altacontacto.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(72, 'contactolist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(73, 'altapresupuesto.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(74, 'presupuestolist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(75, 'altafactura.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(76, 'facturalist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(77, 'contactoBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(78, 'presupuestoBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(79, 'presupuestoImprimir.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(80, 'exitoInsertado.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(81, 'configuracion_empresa.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(82, 'cliprov_exito.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(83, 'incidencias.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(84, 'facturar_presupuesto.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(85, 'factura_presup_parcial.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(86, 'exitoInsertado_factura.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(87, 'facturaBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(88, 'facturaImprimir1.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(89, 'factura_presup_total.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(90, 'factura_presup_diferencia.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(91, 'contabilizar_facturas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(92, 'contabilizar_facturas_proceso.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(93, 'ingresos_CFIVAVCIRPF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(94, 'gastos_CFIVAVCIRPF.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(95, 'transmitir_apuntes.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(96, 'transmitir_apuntes_exportar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(97, 'transmitir_apuntes_importar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(98, 'consulta_del_asesor.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(99, 'consulta_del_asesor_proceso.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(100, 'joomla_list_empresa.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(101, 'joomla_alta_empresa.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(102, 'altapresupuestoLineas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(103, 'altapresupuestoLineaEditar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(104, 'altapresupuestoFinal.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(105, 'altafacturaLineas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(106, 'altafacturaLineaEditar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(107, 'facturar_presupuesto_detalle.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(108, 'gastos_entrada2.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(109, 'incNomina.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(110, 'incNominaEmpleado.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(111, 'incNominaEmpleadoIncidencia.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(112, 'incNomina_nueva.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(113, 'incNomina_listIncidencias.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(114, 'nominas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(115, 'plantActual.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(116, 'default2m.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(117, 'defaultFacturas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(118, 'defaultOperaciones.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(119, 'defaultLaboral.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(120, 'defaultComunicaciones.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(121, 'defaultPresupuestos.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(122, 'cobrar_facturas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(123, 'cobrar_facturas_proceso.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(124, 'verVideo.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(125, 'misArticulos.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(126, 'altaArticulo.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(127, 'articuloBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(128, 'altaGrupoArticulo.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(129, 'articulosSinGuardar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(130, 'altaArticuloNOGuardar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(131, 'facturaCuentas.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(132, 'ingresos_CFIVA1SIRPFVC.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(133, 'altapedido.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(134, 'pedidolist.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(135, 'facturar_pedido.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(136, 'exitoInsertado_pedido.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(137, 'pedidoImprimir.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(138, 'pedidoBorrar.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(139, 'presupuestoConvertirList.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(140, 'convertir_presup_parcial.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(141, 'convertir_presup_diferencia.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(142, 'convertir_presup_total.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(143, 'facturasPedido.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `tbpermisoscargos` (`lngId`, `strPagina`, `strDesc`, `Status`, `Asesor`, `Asesor2`, `Asesor3`, `Asesor4`, `Asesor5`, `Usuario`, `Usuario2`, `Usuario3`, `Usuario4`, `Usuario5`, `Invitado`, `SinPermisosAsignados`) VALUES
	(144, 'facturaImprimir2.php', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
/*!40000 ALTER TABLE `tbpermisoscargos` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbregistro
CREATE TABLE IF NOT EXISTS `tbregistro` (
  `IdRegistro` int(11) NOT NULL DEFAULT '0',
  `FechaRegistro` datetime DEFAULT NULL,
  `strNombreUsu` varchar(255) DEFAULT NULL,
  `strNombreEmp` varchar(255) DEFAULT NULL,
  `strTel1` varchar(12) DEFAULT NULL,
  `strTel2` varchar(50) DEFAULT NULL,
  `strmail` varchar(255) DEFAULT NULL,
  `strWeb` varchar(255) DEFAULT NULL,
  `lngAux` int(11) DEFAULT NULL,
  `strAux` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdRegistro`),
  KEY `strNombreUsu` (`strNombreUsu`(191)),
  KEY `IdRegistro` (`IdRegistro`),
  KEY `FechaRegistro` (`FechaRegistro`),
  KEY `strTel2` (`strTel2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbregistro: ~66 rows (aproximadamente)
DELETE FROM `tbregistro`;
/*!40000 ALTER TABLE `tbregistro` DISABLE KEYS */;
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(0, '2010-12-08 00:00:00', 'qwewq', 'l', 'we', '23', '23', '23', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(1, '2010-12-08 00:00:00', 'qwewq', 'l', 'we', '23', '23', '23', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(2, '2010-12-08 00:00:00', 'jose MAH', 'MAH', '626', '688', 'jm.ortega@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(3, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(4, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(5, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(6, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(7, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(8, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(9, '2010-12-11 00:00:00', 'mm', 'mm', '87766', '88766', 'mkmk@kji,es', 'saddsaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(10, '2010-12-11 00:00:00', 'mm', 'mm', '12121', '1212', 'masfsadf@safdsafe.es', 'dsafas', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(11, '2010-12-11 00:00:00', '87', '87', '87', '87', '1jhasd', 'kj', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(12, '2010-12-11 00:00:00', '87', '87', '87', '87', '1jhasd', 'kj', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(13, '2010-12-11 00:00:00', '99', '99', '99', '99', 'jh@mmams.es', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(14, '2010-12-11 00:00:00', '99', '99', '99', '99', 'jh@mmams.es', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(15, '2010-12-11 00:00:00', '99', '99', '99', '99', 'jh@mmams.es', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(16, '2010-12-11 00:00:00', '99', '99', '99', '99', 'jh@mmams.es', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(17, '2010-12-11 00:00:00', '99', '99', '99', '99', 'jh@mmams.es', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(18, '2010-12-11 00:00:00', '99', '99', '99', '99', 'jh@mmams.es', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(19, '2010-12-15 00:00:00', 'jjjjjjjose', 'sss', '55', '55', 'jm.ortega@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(20, '2010-12-15 00:00:00', 'jjjjjjjose', 'sss', '55', '55', 'jm.ortega@qualidad.com', 'www.qualidad.com', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(21, '2010-12-16 00:00:00', 'barabara', 'qualiadad', '69874554', '74854656', 'soporte@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(22, '2010-12-16 00:00:00', 'barabara', 'qualiadad', '69874554', '74854656', 'soporte@qualidad.com', 'www.qualidad.com', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(23, '2010-12-16 00:00:00', 'conchi', 'qualidad', '21541154216', '54564151', 'soporte@qualidad.com', 'www.qualidad.com', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(24, '2010-12-16 00:00:00', 'qua', 'qua', '877454545745', '8745745874', 'soporte@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(25, '2010-12-17 00:00:00', 'antonio', 'qualidad', '9214362175', '7454657454', 'soporte@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(26, '2010-12-17 00:00:00', 'prueba', 'qualidad', '7887', '8785787', 'soporte@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(27, '2010-12-18 00:00:00', 'jose', 'qqqq', '639728500', '55', 'jm.ortega@qualida.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(28, '2010-12-18 00:00:00', 'mwerwqerw', 'uiy', '787', '878', 'mamdamdf@fsdsa.es', 'ajhfjdksh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(29, '2010-12-18 00:00:00', 'mwerwqerw', 'uiy', '787', '878', 'mamdamdf@fsdsa.es', 'ajhfjdksh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(30, '2010-12-18 00:00:00', 'mwerwqerw', 'uiy', '787', '878', 'mamdamdf@fsdsa.es', 'ajhfjdksh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(31, '2010-12-18 00:00:00', 'qwe', 'jkhjkh', '7676', '7676', 'kjshdfsdaf@afasd.es', 'sadfsdaf', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(32, '2010-12-18 00:00:00', 'hjghjg', 'oijjh', '767', '8767', 'welkjhfsdf@asfsd.es', 'odfsd', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(33, '2010-12-18 00:00:00', 'hjghjg', 'oijjh', '767', '8767', 'welkjhfsdf@asfsd.es', 'odfsd', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(34, '2010-12-19 00:00:00', 'ANTPNIO RIVERA GARCIA', 'RIVERA Y NAVAJAS, S.L.', '914856206', '630978625', 'rivera@telefonica.net', 'no', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(35, '2010-12-19 00:00:00', 'jose prueba Manuel', 'Solar', '9155', '6', 'jm.ortega@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(36, '2010-12-19 00:00:00', 'Nuevologo', 'nuevolo', '8', '8', 'jm.ortega@qualidad.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(37, '2010-12-19 00:00:00', 'mlv', 'mm', '9898', '98989', 'manuel.lozano.velasco@gmail.com', 'i', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(38, '2010-12-19 00:00:00', 'mlv', 'mm', '9898', '98989', 'manuel.lozano.velasco@gmail.com', 'i', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(39, '2010-12-19 00:00:00', 'mlv', 'kjk', '989', '9898', 'manuel.lozano.velasco@gmail.com', 'oiou', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(40, '2010-12-19 00:00:00', 'mlv', 'kjk', '989', '9898', 'manuel.lozano.velasco@gmail.com', 'oiou', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(41, '2010-12-19 00:00:00', 'mlv', 'kjk', '989', '9898', 'manuel.lozano.velasco@gmail.com', 'oiou', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(42, '2010-12-19 00:00:00', 'asdf', 'kmlsdjf', '9899', '90898', 'manuel.lozano.velasco@gmail.com', 'kjkj', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(43, '2010-12-19 00:00:00', 'añlfkds', 'lakfda', '045349', '393904', 'manuel.lozano.velasco@gmai.com', 'jdhsfjdh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(44, '2010-12-19 00:00:00', 'añlfkds', 'lakfda', '045349', '393904', 'manuel.lozano.velasco@gmail.com', 'jdhsfjdh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(45, '2010-12-19 00:00:00', 'sfjasdjfadsk', 'asjfasdjf', '3827483274', '3204812390', 'manuel.lozano.velasco@gmail.com', 'KOJJK', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(46, '2010-12-19 00:00:00', 'sfjasdjfadsk', 'asjfasdjf', '3827483274', '3204812390', 'MLOZANO@gmail.com', 'KOJJK', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(47, '2010-12-19 00:00:00', 'sfjasdjfadsk', 'asjfasdjf', '3827483274', '3204812390', 'SOPORTE@QUALIDAD.com', 'KOJJK', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(48, '2010-12-19 00:00:00', 'KJ', 'JK', '89', '89', 'manuel.lozano.velasco@gmail.com', 'jdhsfjdh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(49, '2010-12-19 00:00:00', 'KJ232', '232323', '34324', '34343', 'manuel.lozano.velasco@gmail.com', 'jdhsfjdh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(50, '2010-12-19 00:00:00', 'KJ232', '232323', '34324', '34343', 'manuel.lozano.velasco@gmail.com', 'jdhsfjdh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(51, '2010-12-19 00:00:00', 'KJ232', '232323', '34324', '34343', 'manuel.lozano.velasco@gmail.com', 'jdhsfjdh', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(52, '2010-12-19 00:00:00', 'JFAKSD', 'EWKRJI', '30948394', '3493849', 'MANUEL.LOZANO.VELASCO@GMAIL.COM', '34234', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(53, '2010-12-19 00:00:00', 'RE', 'Q', '899', '9898', 'manuel.lozano.velasco@gmail.com', 'kdsfdj', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(54, '2010-12-19 00:00:00', 'iu', 'oiu', '878', '87', 'manuel.lozano.velasco@gmail.com', 'jkui', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(55, '2010-12-19 00:00:00', 'af', 'LJ', '878', '878', 'MANUEL.LOZANO.VELASCO@GMAIL.COM', 'JKHJ', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(56, '2010-12-19 00:00:00', 'QR', 'WER', '23434', '987', 'manuel.lozano.velasco@gmail.com', 'kj', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(57, '2010-12-19 00:00:00', 'kj', 'kjh', '87', '87', 'manuel.lodfas@gamil.com', '', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(58, '2010-12-19 00:00:00', 'mlv', 'jkhj', '897989', '7878', 'manuel.lozano.velasco@gmail.com', 'kjk', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(59, '2010-12-19 00:00:00', 'mlv', 'jkhj', '897989', '7878', 'manuel.lozano.velasco@gmail.com', 'kjk', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(60, '2010-12-19 00:00:00', 'kljk', 'jhkjh', '8979', '98', 'manuel.lozano.velasco@gmail.com', 'po', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(61, '2010-12-19 00:00:00', 'kljk', 'jhkjh', '8979', '98', 'manuel.lozano.velasco@gmail.com', 'po', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(62, '2010-12-19 00:00:00', 'kljk', 'jhkjh', '8979', '98', 'manuel.lozano.velasco@gmail.com', 'po', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(63, '2010-12-19 00:00:00', 'kljk', 'jhkjh', '8979', '98', 'manuel.lozano.velasco@gmail.com', 'po', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(64, '2010-12-19 00:00:00', 'kljk', 'jhkjh', '8979', '98', 'manuel.lozano.velasco@gmail.com', 'po', 0, ' web');
INSERT INTO `tbregistro` (`IdRegistro`, `FechaRegistro`, `strNombreUsu`, `strNombreEmp`, `strTel1`, `strTel2`, `strmail`, `strWeb`, `lngAux`, `strAux`) VALUES
	(65, '2010-12-19 00:00:00', 'kljk', 'jhkjh', '8979', '98', 'manuel.lozano.velasco@gmail.com', 'po', 0, ' web');
/*!40000 ALTER TABLE `tbregistro` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbrelacioncliprov
CREATE TABLE IF NOT EXISTS `tbrelacioncliprov` (
  `IdRelacionCliProv` int(11) NOT NULL DEFAULT '0',
  `IdEmpresa` int(11) DEFAULT '0',
  `codigo` varchar(11) DEFAULT '0',
  `IdCliProv` int(11) DEFAULT '0',
  `Borrado` varchar(50) DEFAULT NULL COMMENT '0=Valido 1=Borrado',
  `CliProv` int(11) DEFAULT '0' COMMENT '0=4300, 1=4000 y 2=4100',
  `CC_Recibos` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`IdRelacionCliProv`),
  KEY `IdCliProv` (`IdCliProv`),
  KEY `codigo` (`codigo`),
  KEY `IdRelacionCliProv` (`IdRelacionCliProv`),
  KEY `IdEmpresa` (`IdEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbrelacioncliprov: ~248 rows (aproximadamente)
DELETE FROM `tbrelacioncliprov`;
/*!40000 ALTER TABLE `tbrelacioncliprov` DISABLE KEYS */;
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(1, 2, '400000001', 1, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(2, 2, '400000002', 2, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(3, 2, '400000003', 3, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(4, 2, '400000004', 4, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(5, 2, '400000005', 5, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(6, 2, '400000006', 6, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(7, 2, '400000007', 7, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(8, 2, '400000008', 8, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(9, 2, '400000009', 9, '0', 1, 'ES55555555555555555555');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(10, 2, '400000010', 10, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(11, 2, '400000011', 11, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(12, 2, '400000012', 12, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(13, 2, '400000013', 13, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(14, 1, '400000001', 14, '0', 1, 'ES33333333333311111111');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(15, 1, '400000002', 15, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(16, 1, '400000003', 16, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(17, 1, '400000004', 9, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(18, 1, '430000001', 6, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(19, 1, '430000002', 17, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(21, 2, '400000019', 19, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(22, 2, '400000014', 20, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(23, 2, '400000015', 21, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(24, 2, '430000001', 22, '0', 0, 'ES000000000000000000000');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(25, 1, '400000005', 23, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(26, 1, '400000006', 24, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(27, 1, '400000005', 1, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(28, 2, '430000002', 25, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(29, 2, '430000003', 26, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(30, 2, '430000004', 27, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(31, 2, '430000005', 28, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(32, 2, '430000006', 29, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(33, 2, '430000007', 30, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(34, 2, '430000008', 31, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(35, 2, '430000009', 32, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(36, 2, '430000010', 33, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(37, 2, '430000002', 34, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(38, 2, '430000011', 35, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(39, 2, '430000012', 36, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(40, 2, '430000013', 37, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(41, 2, '430000014', 38, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(42, 2, '430000015', 39, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(43, 2, '430000016', 40, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(44, 2, '430000017', 41, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(45, 2, '430000018', 42, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(46, 2, '430000019', 43, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(47, 2, '430000020', 44, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(48, 2, '430000021', 45, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(49, 2, '430000022', 46, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(50, 2, '430000023', 47, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(51, 2, '430000024', 48, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(52, 2, '430000025', 49, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(53, 2, '430000026', 50, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(54, 2, '430000027', 51, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(55, 2, '430000028', 52, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(56, 2, '430000029', 53, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(57, 2, '430000030', 54, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(58, 2, '430000031', 0, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(59, 2, '430000032', 0, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(60, 2, '430000032', 55, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(61, 2, '430000031', 56, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(62, 2, '430000100', 22, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(63, 1, '430000003', 14, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(64, 1, '430000003', 14, '0', 0, 'ES11111111111111111333');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(65, 2, '430000033', 57, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(66, 2, '400000034', 58, '0', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(67, 2, '430000034', 59, '0', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(68, 1, '430000004', 60, '0', 0, 'ES47488693211478856932258');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(69, 1, '430000005', 61, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(70, 1, '430000006', 2, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(71, 1, '430012355', 62, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(72, 1, '430000006', 63, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(73, 1, '430000007', 64, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(74, 1, '430000010', 65, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(75, 1, '430000011', 66, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(76, 1, '430000008', 67, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(77, 1, '430000009', 68, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(78, 1, '400000014', 69, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(79, 1, '400000001', 70, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(80, 1, '400000020', 71, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(81, 1, '400000002', 72, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(82, 1, '400000000', 73, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(83, 1, '400000005', 74, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(84, 1, '400000001', 75, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(85, 1, '400000002', 76, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(86, 3, '400000005', 69, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(87, 1, '430000025', 70, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(88, 1, '430000038', 71, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(89, 1, '400073224', 72, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(90, 1, '430003522', 73, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(91, 1, '430000380', 74, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(92, 1, '430000012', 75, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(93, 1, '430000013', 76, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(94, 1, '430000014', 77, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(95, 1, '400000016', 78, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(96, 1, '430000016', 79, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(97, 1, '400000044', 80, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(98, 1, '400000015', 81, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(99, 1, '430000015', 82, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(100, 1, '430000017', 83, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(101, 1, '400000005', 84, '0', 0, 'ES4444444444444444444');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(102, 1, '400000007', 85, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(103, 1, '430000109', 86, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(104, 1, '430000018', 87, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(105, 1, '400000011', 88, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(106, 3, '400000007', 89, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(107, 3, '430000001', 14, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(108, 3, '430000002', 90, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(109, 3, '400000001', 14, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(110, 3, '430000003', 2, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(111, 3, '400000006', 1, '1', 1, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(112, 3, '430000008', 91, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(113, 1, '400000020', 1, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(114, 3, '400000004', 92, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(115, 3, '430000010', 93, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(116, 3, '430000004', 94, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(117, 3, '430000005', 95, '1', 0, NULL);
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(118, 1, '430000019', 96, '0', 0, 'ES00000000000000');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(119, 1, '430000020', 97, '0', 0, 'ES3333333333333333333333');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(120, 1, '400000008', 98, '0', 0, 'ES777777777777777777777777893');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(121, 3, '430000001', 9, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(122, 3, '430000002', 15, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(123, 3, '430000003', 24, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(124, 3, '430000004', 61, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(125, 3, '400000001', 61, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(126, 3, '400000002', 60, '0', 1, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(127, 5, '430000045', 1, '0', 0, '0075 0108 30 0500290906');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(128, 5, '430000046', 2, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(129, 5, '430000047', 3, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(130, 5, '430000048', 4, '0', 0, '0128 0526 18 0502030971');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(131, 5, '430000049', 5, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(132, 5, '430000100', 6, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(133, 5, '430000051', 7, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(134, 5, '430000052', 8, '0', 0, '1474 0000 14 0011969003');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(135, 5, '430000053', 9, '1', 0, '2100 2138 17 0200249849');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(136, 5, '430000054', 10, '0', 0, '0081 5503 68 0001002811');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(137, 5, '430000055', 11, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(138, 5, '430000056', 12, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(139, 5, '430000057', 13, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(140, 5, '430000062', 14, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(141, 5, '430000064', 15, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(142, 5, '430000074', 16, '0', 0, '0030 1517 63 0298018273');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(143, 5, '430000075', 17, '0', 0, '0030 1517 65 0298042273');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(144, 5, '430000077', 18, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(145, 5, '430000080', 19, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(146, 5, '430000082', 20, '0', 0, '2105 2060 84 1290013259');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(147, 5, '430000083', 21, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(148, 5, '430000086', 22, '0', 0, '0072 0517 85 0000102899');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(149, 5, '430000087', 23, '0', 0, '2038 1723 24 6000203423');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(150, 5, '430000095', 24, '0', 0, '0030 1426 53 0297506273');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(151, 5, '430000099', 25, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(152, 5, '430000084', 27, '0', 0, '2038 1985 24 6000129506');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(153, 5, '430000103', 28, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(154, 5, '430000101', 29, '0', 0, '0081 0108 50 0001205726');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(155, 5, '430000105', 30, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(156, 5, '430000089', 31, '0', 0, '0182 4000 64 0201656994');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(157, 5, '430000107', 32, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(158, 5, '430000108', 33, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(159, 5, '430000133', 34, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(160, 5, '430000220', 35, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(161, 5, '430000488', 36, '0', 0, '2038 1037 21 3002410295');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(162, 5, '430000489', 37, '0', 0, '2100 2146 13 2001027798');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(163, 5, '430000534', 38, '0', 0, '2059 0570 83 8000100069');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(164, 5, '430000546', 39, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(165, 5, '430000547', 40, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(166, 5, '430000549', 41, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(167, 5, '430000550', 42, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(168, 5, '430000551', 43, '0', 0, '2100 4358 71 0200011541');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(169, 5, '430000552', 44, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(170, 5, '430000553', 45, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(171, 5, '430000554', 46, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(172, 5, '430000555', 47, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(173, 5, '430000556', 48, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(174, 5, '430000557', 49, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(175, 5, '430000558', 50, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(176, 5, '430000559', 51, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(177, 5, '430000982', 52, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(178, 5, '430000050', 53, '0', 0, '2038 1093 81 6000854714');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(179, 5, '430000060', 54, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(180, 5, '430000560', 55, '0', 0, '0182 2832 21 0101500811');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(181, 5, '430000634', 56, '0', 0, '2059 0570 80 8000113071');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(182, 5, '430000501', 57, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(183, 5, '430000067', 58, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(184, 5, '430000324', 59, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(185, 5, '430000123', 60, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(186, 5, '430000058', 63, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(187, 5, '430000635', 64, '0', 0, '2100 0722 53 0200060047');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(188, 5, '430000098', 67, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(189, 5, '430000096', 69, '0', 0, '2038 1859 51 6003813646');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(190, 5, '430000127', 70, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(191, 5, '430000116', 71, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(192, 5, '430000085', 72, '0', 0, '0182 4000 62 0201669116');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(193, 5, '430000059', 73, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(194, 5, '430000124', 75, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(195, 5, '430000701', 76, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(196, 5, '430000702', 77, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(197, 5, '430000703', 78, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(198, 5, '430000140', 79, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(199, 5, '430000362', 80, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(200, 5, '430000061', 81, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(201, 5, '430000535', 82, '0', 0, '2059 0570 89 8000078468');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(202, 5, '430000150', 83, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(203, 5, '430000151', 84, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(204, 5, '430000092', 85, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(205, 5, '430000561', 86, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(206, 5, '430000078', 87, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(207, 5, '430000562', 89, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(208, 5, '430000563', 90, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(209, 5, '430000564', 91, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(210, 5, '430000565', 92, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(211, 5, '430000566', 93, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(212, 5, '430000567', 94, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(213, 5, '430000568', 95, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(214, 5, '430000569', 96, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(215, 5, '430000104', 97, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(216, 5, '430000076', 98, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(217, 5, '430000044', 99, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(218, 5, '430000570', 100, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(219, 5, '430000573', 101, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(220, 5, '430000571', 102, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(221, 5, '430000572', 103, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(222, 5, '430000090', 104, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(223, 5, '430000128', 105, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(224, 5, '430000093', 106, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(225, 5, '430000574', 107, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(226, 5, '430000141', 109, '0', 0, '2100 5846 04 0200025105');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(227, 5, '430000575', 111, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(228, 5, '430000142', 112, '0', 0, '2100 4938 49 2200071048');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(229, 5, '430000091', 114, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(230, 5, '430000094', 116, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(231, 5, '430000801', 117, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(232, 5, '430000983', 118, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(233, 5, '430000201', 119, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(234, 5, '430000802', 120, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(235, 5, '430000650', 121, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(236, 5, '430000079', 122, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(237, 5, '430000984', 123, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(238, 5, '430000576', 124, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(239, 1, '430000005', 125, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(240, 1, '430000009', 126, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(241, 1, '430000010', 127, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(242, 1, '430000011', 128, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(243, 1, '430012355', 129, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(244, 1, '430000016', 131, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(245, 6, '430000001', 132, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(246, 6, '400000001', 133, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(247, 6, '430002015', 134, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(248, 6, '430002016', 135, '0', 0, '');
INSERT INTO `tbrelacioncliprov` (`IdRelacionCliProv`, `IdEmpresa`, `codigo`, `IdCliProv`, `Borrado`, `CliProv`, `CC_Recibos`) VALUES
	(249, 6, '430070000', 136, '0', 0, '');
/*!40000 ALTER TABLE `tbrelacioncliprov` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbtipofactura
CREATE TABLE IF NOT EXISTS `tbtipofactura` (
  `IdTipo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(40) NOT NULL,
  `Fichero` varchar(100) NOT NULL,
  PRIMARY KEY (`IdTipo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbtipofactura: ~2 rows (aproximadamente)
DELETE FROM `tbtipofactura`;
/*!40000 ALTER TABLE `tbtipofactura` DISABLE KEYS */;
INSERT INTO `tbtipofactura` (`IdTipo`, `Nombre`, `Fichero`) VALUES
	(1, 'Tipo 1', 'factura_tipo1.jpg');
INSERT INTO `tbtipofactura` (`IdTipo`, `Nombre`, `Fichero`) VALUES
	(2, 'Tipo 2', 'factura_tipo2.jpg');
/*!40000 ALTER TABLE `tbtipofactura` ENABLE KEYS */;

-- Volcando estructura para tabla qqf261.tbusuarios
CREATE TABLE IF NOT EXISTS `tbusuarios` (
  `strUsuario` varchar(12) NOT NULL,
  `strPassword` varchar(12) NOT NULL,
  `lngIdEmpleado` int(11) NOT NULL,
  `lngPermiso` int(11) DEFAULT '-99',
  `strOpcMenu` varchar(50) DEFAULT NULL,
  `strPuesto` varchar(50) DEFAULT NULL,
  `lngStatus` int(2) DEFAULT NULL,
  `datFechaStatus` datetime DEFAULT NULL,
  `lngIdEmpleadoStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`lngIdEmpleado`),
  UNIQUE KEY `lngIdEmpleado` (`lngIdEmpleado`),
  UNIQUE KEY `strUsuario` (`strUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla qqf261.tbusuarios: ~203 rows (aproximadamente)
DELETE FROM `tbusuarios`;
/*!40000 ALTER TABLE `tbusuarios` DISABLE KEYS */;
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jmop', 'jmop', 0, 0, NULL, 'Asesor', 1, '2014-08-11 21:42:00', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('joseases', '7658', 1, 1, NULL, 'Asesor', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('morlacal', '3260', 2, 2, 'a', 'Asesor', 1, '2013-06-28 19:50:29', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('morlaop', '3261', 3, 8, NULL, 'Asesor', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jlaviga', '4011', 4, 7, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jmurall', '1662', 5, 19, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('eanton', '1038', 6, 6, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mmarquez', '8636', 7, 11, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ggarcia', '3689', 8, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('oguiu', '5312', 9, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('nperez', '6420', 10, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jlongarte', '5417', 11, 7, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mespada', '4107', 12, 19, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mperez', '2415', 13, 9, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('yabajo', '2208', 14, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('abernabeu', '1405', 15, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mbarroso', '9999', 16, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('amartin', '9624', 17, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mmorcillo', '1000', 18, 9, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mfernandez', '7721', 19, 6, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('izabala', '9999', 20, 11, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cmoreno', '6518', 21, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rvalero', '3173', 22, 19, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('bcervera', '5714', 23, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sbaeza', '2643', 24, 11, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('montanchez', '1000', 25, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('epique', '6059', 26, 10, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mturbica', '7612', 27, 6, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jfernandez', '9999', 28, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jbarroso', '9999', 29, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jalonso', '2341', 30, 14, NULL, 'Usuario', 1, '2014-08-11 20:17:02', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jserrano', '2513', 31, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mgentil', '2512', 32, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jcuesta', '0202', 33, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aortiz', '3862', 34, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mvaquero', '4371', 35, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('camoreno', '4682', 36, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('arodriguez', '6228', 37, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rdelgado', '6572', 38, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('esoriano', '5569', 39, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('elopez', '7526', 40, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('srelea', '3690', 41, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mcruz', '8590', 42, 13, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jcabanill', '7312', 43, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('balonso', '9463', 44, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pmoreno', '1532', 45, 17, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jdorrego', '3256', 46, 17, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jmoreno', '2781', 47, 17, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('fliñan', '2695', 48, 17, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mpalomar', '1212', 49, 9, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('chernandez', '3522', 50, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jgaroz', '3111', 51, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sgago', '8120', 52, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mgarcia', '7583', 53, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sbaquero', '9162', 54, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mgordillo', '9017', 55, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('emartinez', '9672', 56, 13, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rgalan', '5977', 57, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jalvarez', '5044', 58, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('earranz', '5405', 59, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('gleonardis', '7011', 60, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mgonzalez', '1589', 61, 9, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rcamacho', '6916', 62, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sfernandez', '4371', 63, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mpallares', '4143', 64, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('nsoria', '1000', 65, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('snuñez', '5042', 66, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jumoreno', '1000', 67, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('acarmona', '1000', 68, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('vfauquier', '1000', 69, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('storcal', '1164', 70, 12, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('randujar', '8538', 71, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rpamplona', '1000', 72, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('lcasull', '3321', 73, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('awanguem', '7142', 74, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mpuig', '3771', 75, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('vvila', '7473', 76, 13, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rsalinas', '1000', 77, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('smartin', '6049', 78, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pquiñonero', '1199', 79, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('oconcejo', '5106', 80, 9, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('einiesta', '3804', 81, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pserrad', '6640', 82, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('dlapeña', '3072', 83, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('fconet', '7281', 84, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('amartinez', '6946', 85, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rtrenor', '8806', 86, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mnavarro', '2160', 87, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rcano', '4180', 88, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('nbarcen', '1430', 89, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mruiz', '8209', 90, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mplanillo', '9026', 91, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('racebes', '3051', 92, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aarrospide', '5036', 93, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aflor', '4040', 94, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mglopez', '5678', 95, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('bgallardo', '8459', 96, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('masenjo', '6478', 97, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('gviñes', '2154', 98, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('valonso', '3565', 99, 14, NULL, 'Usuario', 0, '2013-05-14 09:12:59', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ljimenez', '1431', 100, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rmontellan', '9027', 101, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jose', '4444', 102, 21, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('Norma', '999', 103, 21, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jluis', '888', 104, 21, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cbordana', '1248', 105, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('emoya', '1000', 106, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pyañez', '9999', 107, 18, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mjover', '1257', 108, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jcanals', '1288', 109, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jsegura', '1219', 110, 18, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ssanchez', '1275', 111, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sjimenez', '5500', 112, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('egonzalez', '5501', 113, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('psoto', '5505', 114, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('srodriguez', '2004', 115, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cases', '1876', 116, 10, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pamplona', '2815', 117, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('fauquier', '2107', 118, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('soria', '4265', 119, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('salinas', '4284', 120, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('badia', '1122', 121, 22, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('msanchez', '1562', 122, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sgarcia', '1957', 123, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('csanchez', '1960', 124, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('erios', '2241', 125, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('codinarch', '2476', 126, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mmasip', '5273', 127, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('silviarodr', '1000', 129, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('fcortes', '6815', 130, 9, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jramiro', '7816', 131, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('esmoya', '5816', 133, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sfita', '5391', 134, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('bguillen', '6682', 135, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cosuna', '4626', 136, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mjgil', '3653', 137, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sesteban', '4272', 138, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('kharo', '7359', 139, 5, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pballester', '7896', 140, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aabanda', '1415', 141, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('djimenez', '5172', 142, 15, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('lcastro', '3603', 143, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cloren', '2303', 144, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('anacarm', '7594', 145, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('svazquez', '8315', 146, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('maguilar', '9999', 147, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('gramiro', '6394', 148, 14, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mrovira', '3260', 149, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('pman', '8888', 150, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('vvv', 'ccc', 151, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('manuelil', '8877', 152, 20, NULL, 'Usuario', 1, '2013-05-14 10:25:22', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('rcebrecos', '3333', 153, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('luisa', '2020', 154, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('noelia', '5656', 155, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('22uuu', '3333', 156, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('98999', '0099', 158, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aaa', 'aaa', 159, 6, NULL, 'Usuario', 0, '2014-09-29 13:13:02', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('kkpp', '4455', 160, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ddffg', '5567', 161, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ppbb', '0077', 162, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ppoo', '9999', 163, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('kkjj', '9976', 164, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('qwer', '7777', 165, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ww', 'ww', 166, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('de', 'de', 167, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('Ana', '1234', 168, 4, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('kkvvkk', '6234', 169, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('uyyuy', '7765', 170, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ll', 'll', 171, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('bb', 'bb', 172, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('hh', 'hh', 173, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('ff', 'ff', 174, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('fifif', 'ii', 175, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('eeeee', 'dd', 176, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('si', '9999', 177, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sept', 'sept', 178, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('babs', 'babs', 179, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('teo', 'teo', 180, 6, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('barsof', 'barsof', 181, 6, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('bar', 'bar', 182, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jpali', '1234', 184, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('amaba', '2345', 185, 20, NULL, 'Usuario', 1, NULL, NULL);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cpuig', '9624', 186, 20, NULL, 'Usuario', 1, '2013-05-13 11:49:03', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('avalls', '2222', 187, 20, NULL, 'Usuario', 1, '2013-05-14 09:15:44', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('mmonte', '9966', 188, 20, NULL, 'Usuario', 1, '2013-05-14 09:59:26', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jlopez', '1111', 189, 20, NULL, 'Usuario', 1, '2013-05-14 10:52:30', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('alosada', '2222', 190, 20, NULL, 'Usuario', 1, '2013-05-14 10:56:31', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('paco', '4444', 191, 20, NULL, 'Usuario', 1, '2013-05-14 11:08:23', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('parra', '2222', 192, 20, NULL, 'Usuario', 1, '2013-05-14 12:34:18', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jaller', '5555', 193, 20, NULL, 'Usuario', 1, '2013-06-29 11:38:03', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('agloria', '4444', 194, 20, NULL, 'Usuario', 1, '2013-08-05 10:53:37', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sisha', 'sisha', 195, 20, NULL, 'Usuario', 1, '2014-09-29 22:38:43', 195);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('afernandez', '0000', 196, 20, NULL, 'Usuario', 1, '2014-08-11 20:03:57', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aurelio', 'amr', 197, 20, NULL, 'Usuario', 1, '2014-09-16 09:43:24', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('aaaa', '000', 198, 20, NULL, 'Usuario', 0, '2014-09-29 12:45:57', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('Aa', 'aa', 199, 20, NULL, 'Usuario', 0, '2014-09-29 13:29:29', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('sis', 'sis', 200, 20, NULL, 'Usuario', 1, '2014-10-10 11:01:57', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('Conchi', 'q8', 201, 20, NULL, 'Usuario', 1, '2015-06-03 10:29:08', 0);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('usuario1', '1234', 202, 20, NULL, 'Usuario', 1, '2015-09-28 13:25:04', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('fpp', '3260', 203, 20, NULL, 'Asesor', 1, '2015-09-29 10:16:11', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('cgf', '0208', 204, 20, NULL, 'Asesor', 1, '2015-09-29 10:29:10', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('img', '3260', 205, 20, NULL, 'Asesor', 1, '2015-09-29 10:29:49', 2);
INSERT INTO `tbusuarios` (`strUsuario`, `strPassword`, `lngIdEmpleado`, `lngPermiso`, `strOpcMenu`, `strPuesto`, `lngStatus`, `datFechaStatus`, `lngIdEmpleadoStatus`) VALUES
	('jmo', '1212', 206, 20, NULL, 'Asesor', 1, '2015-09-29 10:30:32', 2);
/*!40000 ALTER TABLE `tbusuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
