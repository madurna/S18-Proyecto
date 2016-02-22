/*
MySQL Data Transfer
Source Host: localhost
Source Database: eco_reciclar
Target Host: localhost
Target Database: eco_reciclar
Date: 22/02/2016 05:52:06 p.m.
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for adjuntos_cliente
-- ----------------------------
DROP TABLE IF EXISTS `adjuntos_cliente`;
CREATE TABLE `adjuntos_cliente` (
  `adjuntos_cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `adjuntos_cliente_tipo_adjunto_id` int(11) NOT NULL,
  `adjuntos_cliente_cliente_id` int(11) NOT NULL,
  `adjuntos_cliente_direccion` varchar(300) NOT NULL,
  `adjuntos_cliente_descripcion` varchar(300) NOT NULL,
  `adjuntos_cliente_nombre` varchar(300) NOT NULL,
  PRIMARY KEY (`adjuntos_cliente_id`),
  KEY `fk_adjuntos_cliente_id` (`adjuntos_cliente_cliente_id`),
  CONSTRAINT `fk_adjuntos_cliente_id` FOREIGN KEY (`adjuntos_cliente_cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for adjuntos_empleado
-- ----------------------------
DROP TABLE IF EXISTS `adjuntos_empleado`;
CREATE TABLE `adjuntos_empleado` (
  `adjuntos_empleado_id` int(11) NOT NULL AUTO_INCREMENT,
  `adjuntos_empleado_tipo_adjunto_id` int(11) DEFAULT NULL,
  `adjuntos_empleado_empleado_id` int(11) DEFAULT NULL,
  `adjuntos_empleado_direccion` varchar(300) DEFAULT NULL,
  `adjuntos_empleado_descripcion` varchar(300) DEFAULT NULL,
  `adjuntos_empleado_nombre` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`adjuntos_empleado_id`),
  KEY `fk_adjuntos_empleado_id` (`adjuntos_empleado_empleado_id`),
  CONSTRAINT `fk_adjuntos_empleado_id` FOREIGN KEY (`adjuntos_empleado_empleado_id`) REFERENCES `empleado` (`empleado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ajuste
-- ----------------------------
DROP TABLE IF EXISTS `ajuste`;
CREATE TABLE `ajuste` (
  `ajuste_id` int(11) NOT NULL AUTO_INCREMENT,
  `ajuste_descripcion` varchar(200) NOT NULL,
  `ajuste_porcentaje` float NOT NULL,
  `ajuste_fecha` date NOT NULL,
  `ajuste_monto` double(20,2) NOT NULL,
  `ajuste_obra_civil_id` int(11) NOT NULL,
  PRIMARY KEY (`ajuste_id`),
  KEY `fk_ajuste_obra_civil_id` (`ajuste_obra_civil_id`),
  CONSTRAINT `fk_ajuste_obra_civil_id` FOREIGN KEY (`ajuste_obra_civil_id`) REFERENCES `obra_civil` (`obra_civil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for aplicacion
-- ----------------------------
DROP TABLE IF EXISTS `aplicacion`;
CREATE TABLE `aplicacion` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_nombre` varchar(45) NOT NULL,
  `app_baja` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for asistencia
-- ----------------------------
DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE `asistencia` (
  `asistencia_id` int(11) NOT NULL AUTO_INCREMENT,
  `asistencia_estado` char(1) NOT NULL,
  `asistencia_fecha` date NOT NULL,
  `asistencia_obrero_id` int(11) NOT NULL,
  PRIMARY KEY (`asistencia_id`),
  KEY `fk_asistencia_obrero_id` (`asistencia_obrero_id`),
  CONSTRAINT `fk_asistencia_obrero_id` FOREIGN KEY (`asistencia_obrero_id`) REFERENCES `obrero` (`obrero_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for categoria
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_descripcion` varchar(200) NOT NULL,
  `categoria_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cinta_transportadora
-- ----------------------------
DROP TABLE IF EXISTS `cinta_transportadora`;
CREATE TABLE `cinta_transportadora` (
  `cinta_transportadora_id` int(11) NOT NULL AUTO_INCREMENT,
  `cinta_transportadora_largo` float DEFAULT NULL,
  `cinta_transportadora_motor` char(45) DEFAULT NULL,
  `cinta_transportadora_ancho` float DEFAULT NULL,
  `cinta_transportadora_material` char(45) DEFAULT NULL,
  `cinta_transportadora_tipo_cinta` char(45) DEFAULT NULL,
  `id_planta` int(11) NOT NULL,
  `cinta_transportadora_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`cinta_transportadora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_apellido` varchar(255) NOT NULL,
  `cliente_nombre` varchar(255) NOT NULL,
  `cliente_tipo_doc_id` int(11) NOT NULL,
  `cliente_nro_doc` int(11) NOT NULL,
  `cliente_direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cliente_localidad_id` int(11) DEFAULT NULL,
  `cliente_fecha_inicio` date DEFAULT NULL,
  `cliente_telefono` varchar(255) DEFAULT NULL,
  `cliente_estado_id` int(11) DEFAULT NULL,
  `cliente_fecha_nacimiento` date DEFAULT NULL,
  `cliente_razon_social` varchar(45) DEFAULT NULL,
  `cliente_observacion` varchar(255) DEFAULT NULL,
  `cliente_cuenta_corriente` int(45) DEFAULT NULL,
  `nro_contrato_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`),
  KEY `fk_clientes_tipo_doc_id` (`cliente_tipo_doc_id`),
  KEY `fk_cliente_localidad_id` (`cliente_localidad_id`),
  KEY `fk_cliente_estado_id` (`cliente_estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contrato
-- ----------------------------
DROP TABLE IF EXISTS `contrato`;
CREATE TABLE `contrato` (
  `contrato_id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_bibliorato` varchar(50) NOT NULL,
  `contrato_caja_numero` varchar(50) NOT NULL,
  `contrato_cliente_id` int(11) NOT NULL,
  `contrato_fecha` date NOT NULL,
  `contrato_monto` double(20,2) NOT NULL,
  `contrato_path` varchar(100) DEFAULT NULL,
  `contrato_descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contrato_id`),
  KEY `fk_contrato_cliente_id` (`contrato_cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cuota
-- ----------------------------
DROP TABLE IF EXISTS `cuota`;
CREATE TABLE `cuota` (
  `cuota_id` int(11) NOT NULL AUTO_INCREMENT,
  `cuota_descripcion` varchar(200) NOT NULL,
  `cuota_fecha_vencimiento` datetime NOT NULL,
  `cuota_monto` float NOT NULL,
  `cuota_numero` int(11) NOT NULL,
  `cuota_porcentaje_recargo` float NOT NULL,
  `cuota_unidad_funcional_id` int(11) NOT NULL,
  `cuota_movimiento_id` int(11) NOT NULL,
  PRIMARY KEY (`cuota_id`),
  KEY `fk_cuota_movimiento_id` (`cuota_movimiento_id`),
  KEY `fk_cuota_unidad_funcional_id` (`cuota_unidad_funcional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for empleado
-- ----------------------------
DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `empleado_id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado_apellido` varchar(255) NOT NULL,
  `empleado_nombre` varchar(255) NOT NULL,
  `empleado_tipo_doc_id` int(11) NOT NULL,
  `empleado_nro_doc` int(11) NOT NULL,
  `empleado_direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `empleado_localidad_id` int(11) NOT NULL,
  `empleado_CP` varchar(255) DEFAULT NULL,
  `empleado_CUIL` varchar(255) DEFAULT NULL,
  `empleado_CBU` varchar(255) DEFAULT NULL,
  `empleado_fecha_inicio` date DEFAULT NULL,
  `empleado_telefono` varchar(255) DEFAULT NULL,
  `empleado_estado` varchar(255) DEFAULT NULL,
  `empleado_fecha_nacimiento` date DEFAULT NULL,
  `empleado_sector_id` int(11) DEFAULT NULL,
  `empleado_tarea_id` int(11) DEFAULT NULL,
  `empleado_capacitacion` varchar(45) DEFAULT NULL,
  `empleado_sexo_id` int(11) DEFAULT NULL,
  `empleado_estado_civil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`empleado_id`),
  KEY `fk_obrero_puesto_id` (`empleado_capacitacion`),
  KEY `fk_obrero_categoria_id` (`empleado_tarea_id`),
  KEY `fk_obrero_usuario_id` (`empleado_sector_id`),
  KEY `fk_obrero_tipo_doc_id` (`empleado_tipo_doc_id`),
  KEY `fk_obrero_sexo_id` (`empleado_sexo_id`),
  KEY `fk_obrero_estado_civil_id` (`empleado_estado_civil_id`),
  KEY `fk_obrero_localidad_id` (`empleado_localidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for especialidad_obrero
-- ----------------------------
DROP TABLE IF EXISTS `especialidad_obrero`;
CREATE TABLE `especialidad_obrero` (
  `especialidad_obrero_id` int(11) NOT NULL AUTO_INCREMENT,
  `especialidad_obrero_descripcion` varchar(200) NOT NULL,
  `especialidad_obrero_nombre` varchar(45) NOT NULL,
  `especialidad_obrero_sueldo_basico` float NOT NULL,
  PRIMARY KEY (`especialidad_obrero_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for especialidad_proveedor
-- ----------------------------
DROP TABLE IF EXISTS `especialidad_proveedor`;
CREATE TABLE `especialidad_proveedor` (
  `especialidad_proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
  `especialidad_proveedor_descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`especialidad_proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado
-- ----------------------------
DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `estado_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_descripcion` varchar(200) NOT NULL,
  `estado_baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_civil
-- ----------------------------
DROP TABLE IF EXISTS `estado_civil`;
CREATE TABLE `estado_civil` (
  `estado_civil_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_civil_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`estado_civil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_cliente
-- ----------------------------
DROP TABLE IF EXISTS `estado_cliente`;
CREATE TABLE `estado_cliente` (
  `estado_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_descripcion` varchar(200) NOT NULL,
  `estado_baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_herramienta
-- ----------------------------
DROP TABLE IF EXISTS `estado_herramienta`;
CREATE TABLE `estado_herramienta` (
  `estado_herramienta_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_herramienta_descripcion` varchar(200) NOT NULL,
  `estado_herramienta_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`estado_herramienta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_pedido_compra
-- ----------------------------
DROP TABLE IF EXISTS `estado_pedido_compra`;
CREATE TABLE `estado_pedido_compra` (
  `estado_pedido_compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_pedido_compra_descripcion` varchar(50) NOT NULL,
  `estado_pedido_compra_baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`estado_pedido_compra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_uf
-- ----------------------------
DROP TABLE IF EXISTS `estado_uf`;
CREATE TABLE `estado_uf` (
  `estado_uf_id` int(11) NOT NULL,
  `estado_uf_descripcion` varchar(50) NOT NULL,
  `estado_uf_baja` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`estado_uf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estudio_alcanzado
-- ----------------------------
DROP TABLE IF EXISTS `estudio_alcanzado`;
CREATE TABLE `estudio_alcanzado` (
  `estudio_id` int(11) NOT NULL AUTO_INCREMENT,
  `estudio_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`estudio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for factura
-- ----------------------------
DROP TABLE IF EXISTS `factura`;
CREATE TABLE `factura` (
  `factura_id` int(11) NOT NULL AUTO_INCREMENT,
  `factura_fecha_generacion` date NOT NULL,
  `factura_fecha_vencimiento` date NOT NULL,
  `factura_numero` int(11) NOT NULL,
  `factura_cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`factura_id`),
  KEY `fk_factura_cliente1_idx` (`factura_cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for factura_detalle
-- ----------------------------
DROP TABLE IF EXISTS `factura_detalle`;
CREATE TABLE `factura_detalle` (
  `factura_detalle_id` int(11) NOT NULL AUTO_INCREMENT,
  `factura_detalle_cantidad` int(11) NOT NULL,
  `factura_detalle_monto` float NOT NULL,
  `factura_detalle_material_id` int(11) NOT NULL,
  `factura_detalle_factura_id` int(11) NOT NULL,
  `factura_detalle_factura_proveedor_id` int(11) NOT NULL,
  `factura_detalle_movimiento_id` int(11) NOT NULL,
  PRIMARY KEY (`factura_detalle_id`),
  KEY `fk_factura_detalle_factura_proveedor1_idx` (`factura_detalle_factura_proveedor_id`),
  KEY `fk_factura_detalle_factura1_idx` (`factura_detalle_factura_id`),
  KEY `fk_factura_detalle_material_id` (`factura_detalle_material_id`),
  KEY `fk_factura_detalle_movimiento_id` (`factura_detalle_movimiento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for factura_proveedor
-- ----------------------------
DROP TABLE IF EXISTS `factura_proveedor`;
CREATE TABLE `factura_proveedor` (
  `factura_proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
  `factura_proveedor_fecha` datetime NOT NULL,
  `factura_proveedor_numero` int(11) NOT NULL,
  `factura_proveedor_proveedor_id` int(11) NOT NULL,
  PRIMARY KEY (`factura_proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for herramienta
-- ----------------------------
DROP TABLE IF EXISTS `herramienta`;
CREATE TABLE `herramienta` (
  `herramienta_id` int(11) NOT NULL AUTO_INCREMENT,
  `herramienta_descripcion` varchar(200) NOT NULL,
  `herramienta_nombre` varchar(45) NOT NULL,
  `herramienta_estado_herramienta_id` int(11) NOT NULL,
  `herramienta_obra_yeseria_id` int(11) DEFAULT NULL,
  `herramienta_obra_civil_id` int(11) DEFAULT NULL,
  `herramienta_fecha_compra` date NOT NULL,
  `herramienta_fecha_ultima_reparacion` date NOT NULL,
  `herramienta_codigo` varchar(30) NOT NULL,
  PRIMARY KEY (`herramienta_id`),
  KEY `fk_herramienta_obra_yeseria_id` (`herramienta_obra_yeseria_id`),
  KEY `fk_herramienta_obra_civil_id` (`herramienta_obra_civil_id`),
  KEY `fk_herramienta_estado_herramienta_id` (`herramienta_estado_herramienta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for hito
-- ----------------------------
DROP TABLE IF EXISTS `hito`;
CREATE TABLE `hito` (
  `hito_id` int(11) NOT NULL AUTO_INCREMENT,
  `hito_nombre` varchar(45) NOT NULL,
  `hito_plazo_estimado_dias` int(11) NOT NULL,
  `hito_estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`hito_id`),
  KEY `fk_hito_estado1_idx` (`hito_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for licencia
-- ----------------------------
DROP TABLE IF EXISTS `licencia`;
CREATE TABLE `licencia` (
  `licencia_id` int(11) NOT NULL AUTO_INCREMENT,
  `licencia_fecha_comienzo` datetime NOT NULL,
  `licencia_fecha_fin` datetime NOT NULL,
  `licencia_nota` varchar(200) NOT NULL,
  `licencia_path_certificado` varchar(45) NOT NULL,
  `licencia_tipo_licencia` int(11) NOT NULL,
  `licencia_obrero_id` int(11) NOT NULL,
  PRIMARY KEY (`licencia_id`),
  KEY `fk_licencia_obrero_id` (`licencia_obrero_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for localidad
-- ----------------------------
DROP TABLE IF EXISTS `localidad`;
CREATE TABLE `localidad` (
  `localidad_id` int(11) NOT NULL,
  `localidad_nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`localidad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for localidad-
-- ----------------------------
DROP TABLE IF EXISTS `localidad-`;
CREATE TABLE `localidad-` (
  `localidad_id` int(4) NOT NULL,
  `localidad_nombre` varchar(60) NOT NULL,
  `cpostal` int(4) NOT NULL,
  `provincia_id` smallint(2) NOT NULL,
  PRIMARY KEY (`localidad_id`),
  KEY `cpostal` (`cpostal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for log_ingreso
-- ----------------------------
DROP TABLE IF EXISTS `log_ingreso`;
CREATE TABLE `log_ingreso` (
  `loging_id` int(11) NOT NULL AUTO_INCREMENT,
  `loging_usua_id` int(11) NOT NULL,
  `loging_app_id` int(11) NOT NULL,
  `loging_fecha` datetime NOT NULL,
  PRIMARY KEY (`loging_id`),
  KEY `fk_log_ingreso_aplicacion1` (`loging_app_id`),
  KEY `fk_log_ingreso_usuario1` (`loging_usua_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for material
-- ----------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_nombre` varchar(45) NOT NULL,
  `material_descripcion` varchar(200) NOT NULL,
  `material_codigo` int(11) NOT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modulo
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_app_id` int(11) NOT NULL,
  `mod_nombre` varchar(45) NOT NULL,
  `mod_baja` tinyint(4) NOT NULL,
  PRIMARY KEY (`mod_id`),
  KEY `fk_aplicacion_app_id1` (`mod_app_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for modulo_paginas
-- ----------------------------
DROP TABLE IF EXISTS `modulo_paginas`;
CREATE TABLE `modulo_paginas` (
  `modpag_id` int(11) NOT NULL AUTO_INCREMENT,
  `modpag_mod_id` int(11) NOT NULL,
  `modpag_scriptname` varchar(60) NOT NULL,
  PRIMARY KEY (`modpag_id`),
  KEY `fk_modulo_modpag_mod_id1` (`modpag_mod_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=699 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for modulo_tablas
-- ----------------------------
DROP TABLE IF EXISTS `modulo_tablas`;
CREATE TABLE `modulo_tablas` (
  `modtab_id` int(11) NOT NULL AUTO_INCREMENT,
  `modtab_ddt_id` int(11) NOT NULL,
  `modtab_mod_id` int(11) NOT NULL,
  PRIMARY KEY (`modtab_id`),
  KEY `fk_modulo_modtab_mod_id1` (`modtab_mod_id`) USING BTREE,
  KEY `fk_diccionario_datos_tablas_modtab_ddt_id1` (`modtab_ddt_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for movimiento
-- ----------------------------
DROP TABLE IF EXISTS `movimiento`;
CREATE TABLE `movimiento` (
  `movimiento_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_descripcion` varchar(200) NOT NULL,
  `material_fecha` datetime NOT NULL,
  `material_monto` float NOT NULL,
  PRIMARY KEY (`movimiento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for obra_civil
-- ----------------------------
DROP TABLE IF EXISTS `obra_civil`;
CREATE TABLE `obra_civil` (
  `obra_civil_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_civil_cantidad_pisos` int(11) NOT NULL,
  `obra_civil_direccion` varchar(45) NOT NULL,
  `obra_civil_fecha_fin` date NOT NULL,
  `obra_civil_fecha_inicio` date NOT NULL,
  `obra_civil_dimensiones_terreno` varchar(45) NOT NULL,
  `obra_civil_valor_compra` float NOT NULL,
  `obra_civil_estado_id` int(11) NOT NULL,
  `obra_civil_localidad_id` int(11) NOT NULL,
  `obra_civil_descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`obra_civil_id`),
  KEY `fk_obra_civil_estado1_idx` (`obra_civil_estado_id`),
  KEY `fk_obra_civil_localidad_id` (`obra_civil_localidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for obra_civil_hito
-- ----------------------------
DROP TABLE IF EXISTS `obra_civil_hito`;
CREATE TABLE `obra_civil_hito` (
  `obra_civil_hito_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_civil_hito_peso` int(5) NOT NULL,
  `obra_civil_hito_obra_civil_id` int(11) NOT NULL,
  `obra_civil_hito_hito_id` int(11) NOT NULL,
  `obra_civil_hito_estado` tinyint(4) NOT NULL,
  PRIMARY KEY (`obra_civil_hito_id`),
  KEY `fk_obra_civil_hito_obra_civil_id` (`obra_civil_hito_obra_civil_id`),
  KEY `fk_obra_civil_hito_hito_id` (`obra_civil_hito_hito_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for obra_civil_hito_tarea
-- ----------------------------
DROP TABLE IF EXISTS `obra_civil_hito_tarea`;
CREATE TABLE `obra_civil_hito_tarea` (
  `obra_civil_hito_tarea_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_civil_hito_tarea_obra_civil_hito_id` int(11) NOT NULL,
  `obra_civil_hito_tarea_tarea_id` int(11) NOT NULL,
  `obra_civil_hito_tarea_estado` tinyint(1) NOT NULL DEFAULT '0',
  `obra_civil_hito_tarea_fecha_finalizacion` date DEFAULT NULL,
  PRIMARY KEY (`obra_civil_hito_tarea_id`),
  KEY `fk_obra_civil_hito_tarea_obra_civil_hito_id` (`obra_civil_hito_tarea_obra_civil_hito_id`),
  KEY `fk_obra_civil_hito_tarea_tarea_id` (`obra_civil_hito_tarea_tarea_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for obra_yeseria
-- ----------------------------
DROP TABLE IF EXISTS `obra_yeseria`;
CREATE TABLE `obra_yeseria` (
  `obra_yeseria_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_yeseria_descripcion` varchar(200) NOT NULL,
  `obra_yeseria_domicilio` varchar(45) NOT NULL,
  `obra_yeseria_fecha_fin` date NOT NULL,
  `obra_yeseria_fecha_inicio` date NOT NULL,
  `obra_yeseria_monto` float NOT NULL,
  `obra_yeseria_estado_id` int(11) NOT NULL,
  `obra_yeseria_localidad_id` int(11) DEFAULT NULL,
  `obra_yeseria_cliente_id` int(11) DEFAULT NULL,
  `obra_yeseria_contrato_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`obra_yeseria_id`),
  KEY `fk_obra_yeseria_estado1_idx` (`obra_yeseria_estado_id`),
  KEY `fk_obra_yeseria_localidad_id` (`obra_yeseria_localidad_id`),
  KEY `fk_obra_yeseria_cliente_id` (`obra_yeseria_cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for obrero
-- ----------------------------
DROP TABLE IF EXISTS `obrero`;
CREATE TABLE `obrero` (
  `obrero_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `obrero_estado_civil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`obrero_id`),
  KEY `fk_obrero_puesto_id` (`obrero_puesto_id`),
  KEY `fk_obrero_obrero_especialidad_id` (`obrero_obrero_especialidad_id`),
  KEY `fk_obrero_categoria_id` (`obrero_categoria_id`),
  KEY `fk_obrero_usuario_id` (`obrero_usuario_id`),
  KEY `fk_obrero_tipo_doc_id` (`obrero_tipo_doc_id`),
  KEY `fk_obrero_estudio_alcanzado_id` (`obrero_estudio_alcanzado_id`),
  KEY `fk_obrero_sexo_id` (`obrero_sexo_id`),
  KEY `fk_obrero_estado_civil_id` (`obrero_estado_civil_id`),
  KEY `fk_obrero_localidad_id` (`obrero_localidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for obrero_obra_yeseria
-- ----------------------------
DROP TABLE IF EXISTS `obrero_obra_yeseria`;
CREATE TABLE `obrero_obra_yeseria` (
  `obrero_obra_yeseria_id` int(11) NOT NULL AUTO_INCREMENT,
  `obrero_obra_yeseria_descripcion` varchar(200) NOT NULL,
  `obrero_obra_yeseria_fecha` date NOT NULL,
  `obrero_obra_yeseria_obrero_id` int(11) NOT NULL,
  `obrero_obra_yeseria_obra_yeseria_id` int(11) NOT NULL,
  PRIMARY KEY (`obrero_obra_yeseria_id`),
  KEY `fk_obrero_obra_yeseria_obra_yeseria1_idx` (`obrero_obra_yeseria_obra_yeseria_id`),
  KEY `fk_obrero_obra_yeseria_obrero_id` (`obrero_obra_yeseria_obrero_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for orden_compra
-- ----------------------------
DROP TABLE IF EXISTS `orden_compra`;
CREATE TABLE `orden_compra` (
  `orden_compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `orden_compra_estado` int(11) NOT NULL,
  `orden_compra_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`orden_compra_id`),
  KEY `fk_orden_compra_usuario_id` (`orden_compra_usuario_id`),
  KEY `fk_orden_compra_estado` (`orden_compra_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for orden_compra_herramienta
-- ----------------------------
DROP TABLE IF EXISTS `orden_compra_herramienta`;
CREATE TABLE `orden_compra_herramienta` (
  `orden_compra_herramienta_id` int(11) NOT NULL AUTO_INCREMENT,
  `orden_compra_herramienta_herramineta_id` int(11) NOT NULL,
  `orden_compra_herramienta_orden_compra_id` int(11) NOT NULL,
  PRIMARY KEY (`orden_compra_herramienta_id`),
  KEY `fk_orden_compra_herramienta_herramienta1_idx` (`orden_compra_herramienta_herramineta_id`),
  KEY `fk_orden_compra_idx` (`orden_compra_herramienta_orden_compra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pedido
-- ----------------------------
DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `pedido_id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_estado` varchar(45) NOT NULL,
  `pedido_fecha` datetime NOT NULL,
  PRIMARY KEY (`pedido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pedido_herramienta
-- ----------------------------
DROP TABLE IF EXISTS `pedido_herramienta`;
CREATE TABLE `pedido_herramienta` (
  `pedido_herramienta_id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_herramienta_cantidad` int(11) NOT NULL,
  `pedido_herramienta_descripcion` varchar(200) NOT NULL,
  `pedido_herramienta_herramienta_id` int(11) NOT NULL,
  `pedido_herramienta_pedido_id` int(11) NOT NULL,
  PRIMARY KEY (`pedido_herramienta_id`),
  KEY `fk_pedido_herramienta_herramienta1_idx` (`pedido_herramienta_herramienta_id`),
  KEY `fk_pedido_herramienta_pedido1_idx` (`pedido_herramienta_pedido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for permiso
-- ----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `permiso_id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso_rol_id` int(11) NOT NULL,
  `permiso_mod_id` int(11) NOT NULL,
  `permiso_tipoacc_id` int(11) NOT NULL,
  PRIMARY KEY (`permiso_id`),
  KEY `fk_rol_has_modulo_modulo1` (`permiso_mod_id`) USING BTREE,
  KEY `fk_rol_has_modulo_rol1` (`permiso_rol_id`) USING BTREE,
  KEY `fk_permiso_tipo_acceso1` (`permiso_tipoacc_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7803 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for planta
-- ----------------------------
DROP TABLE IF EXISTS `planta`;
CREATE TABLE `planta` (
  `planta_id` int(11) NOT NULL AUTO_INCREMENT,
  `planta_color` varchar(45) DEFAULT NULL,
  `planta_direccion` varchar(45) NOT NULL,
  `planta_fecha_fin` date NOT NULL,
  `planta_fecha_inicio` date NOT NULL,
  `planta_precio_estimado` float NOT NULL,
  `planta_estado_id` int(11) NOT NULL,
  `planta_localidad_id` int(11) NOT NULL,
  `planta_descripcion` varchar(200) DEFAULT NULL,
  `planta_contrato_id` int(11) DEFAULT NULL,
  `planta_cliente_id` int(11) DEFAULT NULL,
  `planta_fecha_alta` date NOT NULL,
  PRIMARY KEY (`planta_id`),
  KEY `fk_planta_estado1_idx` (`planta_estado_id`),
  KEY `fk_planta_localidad_id` (`planta_localidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for prensa
-- ----------------------------
DROP TABLE IF EXISTS `prensa`;
CREATE TABLE `prensa` (
  `prensa_id` int(11) NOT NULL AUTO_INCREMENT,
  `prensa_motor` char(45) DEFAULT NULL,
  `prensa_plano` char(45) DEFAULT NULL,
  `prensa_alto` float DEFAULT NULL,
  `prensa_ancho` float DEFAULT NULL,
  `prensa_bomba` char(45) DEFAULT NULL,
  `prensa_cilindro` char(45) DEFAULT NULL,
  `prensa_comando` char(45) DEFAULT NULL,
  `prensa_fondo` int(11) DEFAULT NULL,
  `prensa_kilajeMax` int(11) DEFAULT NULL,
  `id_planta` int(11) NOT NULL,
  `prensa_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`prensa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for presupuesto
-- ----------------------------
DROP TABLE IF EXISTS `presupuesto`;
CREATE TABLE `presupuesto` (
  `presupuesto_id` int(11) NOT NULL AUTO_INCREMENT,
  `presupuesto_descripcion` varchar(200) NOT NULL,
  `presupuesto_dias_validez` int(11) NOT NULL,
  `presupuesto_fecha` datetime NOT NULL,
  `presupuesto_monto` float NOT NULL,
  `presupuesto_path` varchar(45) NOT NULL,
  `presupuesto_obrero_id` int(11) DEFAULT NULL,
  `presupuesto_obra_yeseria_id` int(11) NOT NULL,
  `presupuesto_cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`presupuesto_id`),
  KEY `fk_presupuesto_obra_yeseria1_idx` (`presupuesto_obra_yeseria_id`),
  KEY `fk_presupuesto_obrero_id` (`presupuesto_obrero_id`),
  KEY `fk_presupuesto_cliente_id` (`presupuesto_cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for proveedor
-- ----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `proveedor_especialidad_proveedor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`proveedor_id`),
  KEY `fk_proveedor_localidad_id` (`proveedor_localidad_id`),
  KEY `fk_proveedor_especialidad_proveedor_id` (`proveedor_especialidad_proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for puesto
-- ----------------------------
DROP TABLE IF EXISTS `puesto`;
CREATE TABLE `puesto` (
  `puesto_id` int(11) NOT NULL AUTO_INCREMENT,
  `puesto_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`puesto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(45) NOT NULL,
  `rol_baja` tinyint(4) NOT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for sexo
-- ----------------------------
DROP TABLE IF EXISTS `sexo`;
CREATE TABLE `sexo` (
  `sexo_id` int(11) NOT NULL AUTO_INCREMENT,
  `sexo_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`sexo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tarea
-- ----------------------------
DROP TABLE IF EXISTS `tarea`;
CREATE TABLE `tarea` (
  `tarea_id` int(11) NOT NULL AUTO_INCREMENT,
  `tarea_descripcion` varchar(50) DEFAULT NULL,
  `tarea_peso` int(5) NOT NULL,
  `tarea_baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tarea_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tarea_hito
-- ----------------------------
DROP TABLE IF EXISTS `tarea_hito`;
CREATE TABLE `tarea_hito` (
  `tarea_hito_id` int(11) NOT NULL AUTO_INCREMENT,
  `tarea_hito_tarea_id` int(11) NOT NULL,
  `tarea_hito_hito_id` int(11) NOT NULL,
  `tarea_hito_fecha` date NOT NULL,
  PRIMARY KEY (`tarea_hito_id`),
  KEY `fk_tarea_hito_tarea_id` (`tarea_hito_tarea_id`),
  KEY `fk_tarea_hito_hito_id` (`tarea_hito_hito_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_acceso
-- ----------------------------
DROP TABLE IF EXISTS `tipo_acceso`;
CREATE TABLE `tipo_acceso` (
  `tipoacc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipoacc_nombre` varchar(45) DEFAULT NULL,
  `tipoacc_baja` tinyint(4) NOT NULL,
  PRIMARY KEY (`tipoacc_id`),
  UNIQUE KEY `tipoacc_nombre_UNIQUE` (`tipoacc_nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tipo_adjunto
-- ----------------------------
DROP TABLE IF EXISTS `tipo_adjunto`;
CREATE TABLE `tipo_adjunto` (
  `tipo_adjunto_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_adjunto_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`tipo_adjunto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_documento
-- ----------------------------
DROP TABLE IF EXISTS `tipo_documento`;
CREATE TABLE `tipo_documento` (
  `tipo_documento_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`tipo_documento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for trommel
-- ----------------------------
DROP TABLE IF EXISTS `trommel`;
CREATE TABLE `trommel` (
  `trommel_id` int(11) NOT NULL AUTO_INCREMENT,
  `trommel_diametro` float DEFAULT NULL,
  `trommel_largo` float DEFAULT NULL,
  `trommel_motor` char(45) DEFAULT NULL,
  `trommel_plano` char(45) DEFAULT NULL,
  `trommel_relacion_engranaje` float DEFAULT NULL,
  `id_planta` int(11) NOT NULL,
  `trommel_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`trommel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for unidad_funcional
-- ----------------------------
DROP TABLE IF EXISTS `unidad_funcional`;
CREATE TABLE `unidad_funcional` (
  `unidad_funcional_id` int(11) NOT NULL AUTO_INCREMENT,
  `unidad_funcional_obra_civil_id` int(11) NOT NULL,
  `unidad_funcional_cantidad_ambientes` int(11) NOT NULL,
  `unidad_funcional_coeficiente` double(5,2) NOT NULL,
  `unidad_funcional_departamento` varchar(50) NOT NULL,
  `unidad_funcional_estado_uf_id` int(11) NOT NULL,
  `unidad_funcional_dimensiones` varchar(100) NOT NULL,
  `unidad_funcional_monto` double(20,2) NOT NULL,
  `unidad_funcional_observacion` varchar(255) NOT NULL,
  `unidad_funcional_piso` varchar(50) NOT NULL,
  `unidad_funcional_cliente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`unidad_funcional_id`),
  KEY `fk_unidad_funcional_obra_civil_id` (`unidad_funcional_obra_civil_id`),
  KEY `fk_unidad_funcional_cliente_id` (`unidad_funcional_cliente_id`),
  KEY `fk_unidad_funcional_estado_uf_id` (`unidad_funcional_estado_uf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `usua_id` int(11) NOT NULL AUTO_INCREMENT,
  `usua_usrid` varchar(50) NOT NULL,
  `usua_nombre` varchar(100) DEFAULT NULL,
  `usua_pwd` varchar(32) NOT NULL,
  `usua_email` varchar(100) NOT NULL,
  `usua_tel1` varchar(45) DEFAULT NULL,
  `usua_tel2` varchar(45) DEFAULT NULL,
  `usua_baja` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usua_id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for usuario_rol
-- ----------------------------
DROP TABLE IF EXISTS `usuario_rol`;
CREATE TABLE `usuario_rol` (
  `usrrol_id` int(11) NOT NULL AUTO_INCREMENT,
  `usrrol_usua_id` int(11) NOT NULL,
  `usrrol_rol_id` int(11) NOT NULL,
  `usrrol_app_id` int(11) NOT NULL,
  PRIMARY KEY (`usrrol_id`),
  KEY `fk_usuario_has_rol_rol1` (`usrrol_rol_id`) USING BTREE,
  KEY `fk_usuario_has_rol_usuario1` (`usrrol_usua_id`) USING BTREE,
  KEY `fk_usuario_rol_aplicacion1` (`usrrol_app_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

-- ----------------------------
-- View structure for view_usuario_login
-- ----------------------------
DROP VIEW IF EXISTS `view_usuario_login`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_usuario_login` AS (select `usuario_rol`.`usrrol_id` AS `usrrol_id`,`usuario`.`usua_id` AS `usua_id`,`usuario`.`usua_usrid` AS `usua_usrid`,`usuario`.`usua_nombre` AS `usua_nombre`,`usuario`.`usua_pwd` AS `usua_pwd`,`usuario`.`usua_email` AS `usua_email`,`rol`.`rol_nombre` AS `rol_nombre`,`aplicacion`.`app_id` AS `app_id`,`aplicacion`.`app_nombre` AS `app_nombre`,`permiso`.`permiso_id` AS `permiso_id`,`tipo_acceso`.`tipoacc_id` AS `tipoacc_id`,`tipo_acceso`.`tipoacc_nombre` AS `tipoacc_nombre`,`modulo`.`mod_id` AS `mod_id`,`modulo`.`mod_nombre` AS `mod_nombre`,`modulo_paginas`.`modpag_id` AS `modpag_id`,`modulo_paginas`.`modpag_scriptname` AS `modpag_scriptname` from ((((((((`usuario_rol` join `usuario` on((`usuario`.`usua_id` = `usuario_rol`.`usrrol_usua_id`))) join `rol` on((`rol`.`rol_id` = `usuario_rol`.`usrrol_rol_id`))) join `aplicacion` on((`usuario_rol`.`usrrol_app_id` = `aplicacion`.`app_id`))) join `permiso` on((`permiso`.`permiso_rol_id` = `usuario_rol`.`usrrol_rol_id`))) join `tipo_acceso` on((`tipo_acceso`.`tipoacc_id` = `permiso`.`permiso_tipoacc_id`))) join `modulo` on(((`modulo`.`mod_id` = `permiso`.`permiso_mod_id`) and (`modulo`.`mod_app_id` = `usuario_rol`.`usrrol_app_id`)))) join `modulo_paginas` on((`modulo_paginas`.`modpag_mod_id` = `modulo`.`mod_id`))) left join `modulo_tablas` on((`modulo_tablas`.`modtab_mod_id` = `modulo`.`mod_id`))) where ((`usuario`.`usua_baja` = 0) and (`aplicacion`.`app_baja` = 0)));

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `aplicacion` VALUES ('5', 'ECO-RECICLAR', '0');
INSERT INTO `clientes` VALUES ('1', 'CEPEDA', 'LILIANA INES', '1', '6841180', '41 Nº 736 E/ 8 Y 9', '72', '2010-04-22', '0221-4272409', '3', '1942-01-20', null, null, null, null);
INSERT INTO `clientes` VALUES ('2', 'D´ALESSANDRO', 'MARIA INES', '1', '22669100', '42 Nº 1028 E/ 15 Y 16', '72', '2010-04-22', '0221-4256235', '3', '1972-03-29', null, null, null, null);
INSERT INTO `clientes` VALUES ('3', 'MURA', 'MIRTHA ESTELA', '1', '10317737', '1 Nº 1197 E/ 57 Y 58 1º B', '72', '2010-04-22', '0221-4642577', '2', '1950-12-17', null, null, null, null);
INSERT INTO `clientes` VALUES ('4', 'LOPEZ', 'FERNANDO GABRIEL', '1', '27528244', '17 Nº 2256', '72', '2010-04-23', '0221-4578613', '3', '1979-07-28', null, null, null, null);
INSERT INTO `clientes` VALUES ('5', 'CEPEDA', 'LILIANA INES', '1', '6841180', '41 Nº 576 1/2 E/ 6Y7', '72', '2010-04-29', '0221-4272409', '3', '1942-01-20', null, null, null, null);
INSERT INTO `clientes` VALUES ('6', 'AGUILERA', 'NORMA ESTHER', '1', '18484367', 'PASAJE LA GLORIETA Nº 555', '79', '2010-05-03', '02268-491106', '3', '2005-06-20', null, null, null, null);
INSERT INTO `clientes` VALUES ('7', 'QUIÑONES', 'MARTA OFELIA', '1', '5972836', 'HIPOLITO YRIGOYEN Nº 14', '48', '2010-05-07', '02268-491106', '1', '1949-02-12', null, null, null, null);
INSERT INTO `clientes` VALUES ('8', 'BARRAGUE', 'MARIA CLAUDIA', '1', '18333269', '152 Nº 1878 E/ 70 Y 71', '72', '2010-05-07', '0221-4503417', '1', '1966-03-28', null, null, null, null);
INSERT INTO `clientes` VALUES ('9', 'VALENTI', 'LEONARDO DANIEL', '1', '29403992', '145 Nº 1727 E/ 67 Y 68', '72', '2010-05-10', '0221-4506796', '3', '1982-05-25', null, null, null, null);
INSERT INTO `clientes` VALUES ('10', 'BATH', 'LEONARDO RAFAEL', '1', '26428612', 'MITRE 612 E/ BELGICA Y PJE LAVALLE', '72', '2010-05-11', '0221-4601189', '1', '1978-01-17', null, null, null, null);
INSERT INTO `clientes` VALUES ('11', 'VEGA', 'SILVIA LEANDRA', '1', '24074178', '37 Nº 1911 E/ 133 Y 134', '72', '2010-05-13', '0221-4793847', '3', '1975-01-10', null, null, null, null);
INSERT INTO `clientes` VALUES ('12', 'RODA', 'JULIA NORMA', '1', '18693974', 'GENOVA 132', '72', '2010-05-14', '011-44500874', '3', '1966-11-07', null, null, null, null);
INSERT INTO `clientes` VALUES ('13', 'CIMINO', 'HUGO DOMINGO', '1', '8349233', '603 Nº 512 E/ 5 Y 6', '72', '2010-05-14', '0221-4869680', '1', '1946-08-09', null, null, null, null);
INSERT INTO `clientes` VALUES ('14', 'MARTINEZ ROCCA', 'ANA MARIA', '1', '6216867', '441 S/Nº E/ 136 Y 137', '72', '2010-05-14', '0221-4742822', '1', '1949-10-30', null, null, null, null);
INSERT INTO `clientes` VALUES ('15', 'CITARELLI', 'SILVIA ANAHI', '1', '18212627', '209 S/N E/ 519 Y 519 BIS', '72', '2010-05-17', '0221-4917898', '1', '1967-01-15', null, null, null, null);
INSERT INTO `clientes` VALUES ('16', 'SCUFFI', 'EDGARDO ENRIQUE', '1', '10753506', 'L N ALEM 179', '72', '2010-05-17', '02268-491176/491078', '1', '1953-01-23', null, null, null, null);
INSERT INTO `clientes` VALUES ('18', 'mike', 'mike', '1', '123434', 'dsadad sad 65', '715', '2015-11-02', '1234565', '1', '1980-09-02', 'mike srl', 'sadfas das ds ad ', '2147483647', null);
INSERT INTO `contrato` VALUES ('1', '3', '3', '6', '2016-02-10', '111.00', null, null);
INSERT INTO `contrato` VALUES ('2', '2', '2', '5', '2016-02-05', '222.00', null, null);
INSERT INTO `contrato` VALUES ('3', '2', '4', '6', '2016-02-01', '333.00', null, null);
INSERT INTO `contrato` VALUES ('4', '1', '1', '8', '2016-01-12', '256.00', null, null);
INSERT INTO `empleado` VALUES ('1', 'Perez', 'Juan', '1', '25753684', '2', '355', '1900', '20257536841', '', '0000-00-00', '22', null, '0000-00-00', '152', '0', '', '2', '3');
INSERT INTO `estado` VALUES ('1', 'Activo', '0');
INSERT INTO `estado` VALUES ('2', 'Inactivo', '0');
INSERT INTO `estado` VALUES ('3', 'Ejecutado', '0');
INSERT INTO `estado_civil` VALUES ('1', 'Soltero');
INSERT INTO `estado_civil` VALUES ('2', 'Casado');
INSERT INTO `estado_civil` VALUES ('3', 'Separado');
INSERT INTO `estado_civil` VALUES ('4', 'Divorciado');
INSERT INTO `estado_civil` VALUES ('5', 'Viudo');
INSERT INTO `estado_civil` VALUES ('6', 'Unidad de hecho');
INSERT INTO `estado_civil` VALUES ('7', 'Union Civil');
INSERT INTO `estado_civil` VALUES ('8', 'Otro');
INSERT INTO `estado_cliente` VALUES ('1', 'Activo', '0');
INSERT INTO `estado_cliente` VALUES ('2', 'Inactivo', '0');
INSERT INTO `estado_cliente` VALUES ('3', 'Ejecutado', '0');
INSERT INTO `estado_uf` VALUES ('1', 'Libre', '0');
INSERT INTO `estado_uf` VALUES ('2', 'Ocupado', '0');
INSERT INTO `estudio_alcanzado` VALUES ('1', 'S/E');
INSERT INTO `estudio_alcanzado` VALUES ('2', 'Primario');
INSERT INTO `estudio_alcanzado` VALUES ('3', 'Secundario');
INSERT INTO `estudio_alcanzado` VALUES ('4', 'Terciario');
INSERT INTO `estudio_alcanzado` VALUES ('5', 'Universitario');
INSERT INTO `estudio_alcanzado` VALUES ('6', 'Posgrado');
INSERT INTO `estudio_alcanzado` VALUES ('7', 'Otro');
INSERT INTO `hito` VALUES ('1', 'Hito 1', '13', '1');
INSERT INTO `hito` VALUES ('2', 'Hito 2', '18', '1');
INSERT INTO `hito` VALUES ('3', 'Hito 3', '15', '0');
INSERT INTO `localidad` VALUES ('1', 'ALMIRANTE BROWN');
INSERT INTO `localidad` VALUES ('2', 'ADOLFO ALSINA');
INSERT INTO `localidad` VALUES ('3', 'ALBERTI');
INSERT INTO `localidad` VALUES ('4', 'AVELLANEDA');
INSERT INTO `localidad` VALUES ('5', 'AYACUCHO');
INSERT INTO `localidad` VALUES ('6', 'AZUL');
INSERT INTO `localidad` VALUES ('7', 'BARADERO');
INSERT INTO `localidad` VALUES ('8', 'BAHIA BLANCA');
INSERT INTO `localidad` VALUES ('9', 'BERISSO');
INSERT INTO `localidad` VALUES ('10', 'JUAREZ');
INSERT INTO `localidad` VALUES ('11', 'BALCARCE');
INSERT INTO `localidad` VALUES ('12', 'BOLIVAR');
INSERT INTO `localidad` VALUES ('13', 'BRAGADO');
INSERT INTO `localidad` VALUES ('14', 'ARRECIFES');
INSERT INTO `localidad` VALUES ('15', 'BERAZATEGUI');
INSERT INTO `localidad` VALUES ('16', 'CAMPANA');
INSERT INTO `localidad` VALUES ('17', 'CORONEL BRANDSEN');
INSERT INTO `localidad` VALUES ('18', 'CHACABUCO');
INSERT INTO `localidad` VALUES ('19', 'CORONEL DORREGO');
INSERT INTO `localidad` VALUES ('20', 'CARLOS CASARES');
INSERT INTO `localidad` VALUES ('21', 'CAPITAL FEDERAL');
INSERT INTO `localidad` VALUES ('22', 'CHIVILCOY');
INSERT INTO `localidad` VALUES ('23', 'CARLOS TEJEDOR');
INSERT INTO `localidad` VALUES ('24', 'CORONEL ROSALES');
INSERT INTO `localidad` VALUES ('25', 'CAÑUELAS');
INSERT INTO `localidad` VALUES ('26', 'COLON');
INSERT INTO `localidad` VALUES ('27', 'CORONEL PRINGLES');
INSERT INTO `localidad` VALUES ('28', 'CARMEN DE ARECO');
INSERT INTO `localidad` VALUES ('29', 'CAPITAN SARMIENTO');
INSERT INTO `localidad` VALUES ('30', 'CASTELLI');
INSERT INTO `localidad` VALUES ('31', 'CHASCOMUS');
INSERT INTO `localidad` VALUES ('32', 'CORONEL SUAREZ');
INSERT INTO `localidad` VALUES ('33', 'DAIREAUX');
INSERT INTO `localidad` VALUES ('34', 'DE LA COSTA -SAN CLEMENTE');
INSERT INTO `localidad` VALUES ('35', 'DOLORES');
INSERT INTO `localidad` VALUES ('36', 'ESTEBAN ECHEVERRIA');
INSERT INTO `localidad` VALUES ('37', 'ENSENADA');
INSERT INTO `localidad` VALUES ('38', 'ESCOBAR');
INSERT INTO `localidad` VALUES ('39', 'EXALTACION DE LA CRUZ');
INSERT INTO `localidad` VALUES ('40', 'EZEIZA');
INSERT INTO `localidad` VALUES ('41', 'FLORENTINO AMEGHINO');
INSERT INTO `localidad` VALUES ('42', 'FLORENCIO VARELA');
INSERT INTO `localidad` VALUES ('43', 'GENERAL ALVEAR');
INSERT INTO `localidad` VALUES ('44', 'GENERAL BELGRANO');
INSERT INTO `localidad` VALUES ('45', 'GENERAL LAMADRID');
INSERT INTO `localidad` VALUES ('46', 'GENERAL ALVARADO');
INSERT INTO `localidad` VALUES ('47', 'GREGORIO DE LAFERRERE');
INSERT INTO `localidad` VALUES ('48', 'GENERAL GUIDO');
INSERT INTO `localidad` VALUES ('49', 'GENERAL LAS HERAS');
INSERT INTO `localidad` VALUES ('50', 'GENERAL VILLEGAS');
INSERT INTO `localidad` VALUES ('51', 'GENERAL LAVALLE');
INSERT INTO `localidad` VALUES ('52', 'GENERAL MADARIAGA');
INSERT INTO `localidad` VALUES ('53', 'GENERAL ARENALES');
INSERT INTO `localidad` VALUES ('54', 'GONZALEZ CHAVEZ');
INSERT INTO `localidad` VALUES ('55', 'GENERAL PINTO');
INSERT INTO `localidad` VALUES ('56', 'GENERAL RODRIGUEZ');
INSERT INTO `localidad` VALUES ('57', 'GENERAL SARMIENTO');
INSERT INTO `localidad` VALUES ('58', 'GUAMINI');
INSERT INTO `localidad` VALUES ('59', 'GENERAL VIAMONTE');
INSERT INTO `localidad` VALUES ('60', 'GENERAL PAZ');
INSERT INTO `localidad` VALUES ('61', 'HURLINGHAM');
INSERT INTO `localidad` VALUES ('62', 'HIPOLITO YRIGOYEN-HENDERSON');
INSERT INTO `localidad` VALUES ('63', 'ITUZAINGO');
INSERT INTO `localidad` VALUES ('64', 'JUNIN');
INSERT INTO `localidad` VALUES ('65', 'LANUS');
INSERT INTO `localidad` VALUES ('66', 'LOBERIA');
INSERT INTO `localidad` VALUES ('67', 'LAS FLORES');
INSERT INTO `localidad` VALUES ('68', 'LINCOLN');
INSERT INTO `localidad` VALUES ('69', 'SAN JUSTO');
INSERT INTO `localidad` VALUES ('70', 'LEANDRO N. ALEM');
INSERT INTO `localidad` VALUES ('71', 'LOBOS');
INSERT INTO `localidad` VALUES ('72', 'LA PLATA');
INSERT INTO `localidad` VALUES ('73', 'LAPRIDA');
INSERT INTO `localidad` VALUES ('74', 'LUJAN');
INSERT INTO `localidad` VALUES ('75', 'LOMAS DE ZAMORA');
INSERT INTO `localidad` VALUES ('76', 'MAGDALENA');
INSERT INTO `localidad` VALUES ('77', 'MERCEDES');
INSERT INTO `localidad` VALUES ('78', 'MONTE HERMOSO');
INSERT INTO `localidad` VALUES ('79', 'MAIPU');
INSERT INTO `localidad` VALUES ('80', 'MERLO');
INSERT INTO `localidad` VALUES ('81', 'MONTE');
INSERT INTO `localidad` VALUES ('82', 'MORON');
INSERT INTO `localidad` VALUES ('83', 'MAR DEL PLATA');
INSERT INTO `localidad` VALUES ('84', 'MAR CHIQUITA');
INSERT INTO `localidad` VALUES ('85', 'MORENO');
INSERT INTO `localidad` VALUES ('86', 'MALVINAS ARGENTINAS');
INSERT INTO `localidad` VALUES ('87', 'MARCOS PAZ');
INSERT INTO `localidad` VALUES ('88', 'NAVARRO');
INSERT INTO `localidad` VALUES ('89', 'NECOCHEA');
INSERT INTO `localidad` VALUES ('90', 'NUEVE DE JULIO');
INSERT INTO `localidad` VALUES ('91', 'OLAVARRIA');
INSERT INTO `localidad` VALUES ('92', 'LOCALIDAD DE OTRAS PROVINCIAS');
INSERT INTO `localidad` VALUES ('93', 'CARMEN DE PATAGONES');
INSERT INTO `localidad` VALUES ('94', 'PERGAMINO');
INSERT INTO `localidad` VALUES ('95', 'PELLEGRINI');
INSERT INTO `localidad` VALUES ('96', 'PEHUAJO');
INSERT INTO `localidad` VALUES ('97', 'PILA');
INSERT INTO `localidad` VALUES ('98', 'PILAR');
INSERT INTO `localidad` VALUES ('99', 'PINAMAR');
INSERT INTO `localidad` VALUES ('100', 'PUAN');
INSERT INTO `localidad` VALUES ('101', 'QUILMES');
INSERT INTO `localidad` VALUES ('102', 'RAMALLO');
INSERT INTO `localidad` VALUES ('103', 'RIVADAVIA');
INSERT INTO `localidad` VALUES ('104', 'ROJAS');
INSERT INTO `localidad` VALUES ('105', 'ROQUE PEREZ');
INSERT INTO `localidad` VALUES ('106', 'RAUCH');
INSERT INTO `localidad` VALUES ('107', 'SALADILLO');
INSERT INTO `localidad` VALUES ('108', 'SAAVEDRA');
INSERT INTO `localidad` VALUES ('109', 'SAN CAYETANO');
INSERT INTO `localidad` VALUES ('110', 'SAN FERNANDO');
INSERT INTO `localidad` VALUES ('111', 'SAN ANDRES DE GILES');
INSERT INTO `localidad` VALUES ('112', 'SAN ISIDRO');
INSERT INTO `localidad` VALUES ('113', 'SALTO');
INSERT INTO `localidad` VALUES ('114', 'SAN MARTIN');
INSERT INTO `localidad` VALUES ('115', 'SAN NICOLAS');
INSERT INTO `localidad` VALUES ('116', 'SUIPACHA');
INSERT INTO `localidad` VALUES ('117', 'SALLIQUELO');
INSERT INTO `localidad` VALUES ('118', 'SAN PEDRO');
INSERT INTO `localidad` VALUES ('119', 'SAN ANTONIO DE ARECO');
INSERT INTO `localidad` VALUES ('120', 'SAN MIGUEL');
INSERT INTO `localidad` VALUES ('121', 'SAN VICENTE');
INSERT INTO `localidad` VALUES ('122', 'TAPALQUE');
INSERT INTO `localidad` VALUES ('123', 'TRES DE FEBRERO-CASEROS');
INSERT INTO `localidad` VALUES ('124', 'TIGRE');
INSERT INTO `localidad` VALUES ('125', 'TRENQUE LAUQUEN');
INSERT INTO `localidad` VALUES ('126', 'TANDIL');
INSERT INTO `localidad` VALUES ('127', 'TORDILLO-GENERAL CONESA');
INSERT INTO `localidad` VALUES ('128', 'TORNQUIST');
INSERT INTO `localidad` VALUES ('129', 'TRES LOMAS');
INSERT INTO `localidad` VALUES ('130', 'TRES ARROYOS');
INSERT INTO `localidad` VALUES ('131', 'VEINTICINCO DE MAYO');
INSERT INTO `localidad` VALUES ('132', 'VILLA GESELL');
INSERT INTO `localidad` VALUES ('133', 'VILLARINO');
INSERT INTO `localidad` VALUES ('134', 'VICENTE LOPEZ');
INSERT INTO `localidad` VALUES ('135', 'ZARATE');
INSERT INTO `localidad` VALUES ('136', 'JOSE C. PAZ');
INSERT INTO `localidad` VALUES ('137', 'MONTE GRANDE');
INSERT INTO `localidad` VALUES ('138', 'PRESIDENTE PERON-GUERNICA');
INSERT INTO `localidad` VALUES ('139', 'PUNTA INDIO');
INSERT INTO `localidad` VALUES ('140', 'ISIDRO CASANOVA');
INSERT INTO `localidad` VALUES ('141', 'PUNTA ALTA');
INSERT INTO `localidad` VALUES ('142', 'OTRA LOCALIDAD DE LA PROVINCIA');
INSERT INTO `localidad` VALUES ('143', 'ADROGUE');
INSERT INTO `localidad` VALUES ('144', 'AEROPUERTO EZEIZA');
INSERT INTO `localidad` VALUES ('145', 'AGUSTIN ROCA');
INSERT INTO `localidad` VALUES ('146', 'ALASTUEY');
INSERT INTO `localidad` VALUES ('147', 'ALDO BONZI');
INSERT INTO `localidad` VALUES ('148', 'ALEJANDRO KORN');
INSERT INTO `localidad` VALUES ('149', 'ALFONSO');
INSERT INTO `localidad` VALUES ('150', 'ALGARROBO');
INSERT INTO `localidad` VALUES ('151', 'ALSINA');
INSERT INTO `localidad` VALUES ('152', 'ALVAREZ DE TOLEDO');
INSERT INTO `localidad` VALUES ('153', 'ALVAREZ JONTE');
INSERT INTO `localidad` VALUES ('154', 'AMERICA');
INSERT INTO `localidad` VALUES ('155', 'ANGEL ETCHEVERRY');
INSERT INTO `localidad` VALUES ('156', 'ANTONIO CARBONI');
INSERT INTO `localidad` VALUES ('157', 'ARANA');
INSERT INTO `localidad` VALUES ('158', 'ARBOLEDAS');
INSERT INTO `localidad` VALUES ('159', 'ARENAZA');
INSERT INTO `localidad` VALUES ('160', 'ARGERICH');
INSERT INTO `localidad` VALUES ('161', 'ARIEL');
INSERT INTO `localidad` VALUES ('162', 'ARISTOBULO DEL VALLE');
INSERT INTO `localidad` VALUES ('163', 'ARRIBE¾OS');
INSERT INTO `localidad` VALUES ('164', 'ARROYO CORTO');
INSERT INTO `localidad` VALUES ('165', 'ARROYO DULCE');
INSERT INTO `localidad` VALUES ('166', 'ARROYO VENADO');
INSERT INTO `localidad` VALUES ('167', 'ARTURO SEGUI');
INSERT INTO `localidad` VALUES ('168', 'ASCENSION');
INSERT INTO `localidad` VALUES ('169', 'ATALAYA');
INSERT INTO `localidad` VALUES ('170', 'ATUCHA');
INSERT INTO `localidad` VALUES ('171', 'AZCUENAGA');
INSERT INTO `localidad` VALUES ('172', 'AZOPARDO');
INSERT INTO `localidad` VALUES ('173', 'BAHIA SAN BLAS');
INSERT INTO `localidad` VALUES ('174', 'BAIGORRITA');
INSERT INTO `localidad` VALUES ('175', 'BAJO HONDO');
INSERT INTO `localidad` VALUES ('176', 'BANCALARI');
INSERT INTO `localidad` VALUES ('177', 'BANDERALO');
INSERT INTO `localidad` VALUES ('178', 'BANFIELD');
INSERT INTO `localidad` VALUES ('179', 'BARRIO BCO. PCIA.');
INSERT INTO `localidad` VALUES ('180', 'BARRIO EL CARMEN');
INSERT INTO `localidad` VALUES ('181', 'BARRIO MARITIMO');
INSERT INTO `localidad` VALUES ('182', 'BARRIO TALLERES');
INSERT INTO `localidad` VALUES ('183', 'BARTOLOME BAVIO');
INSERT INTO `localidad` VALUES ('184', 'BATAN');
INSERT INTO `localidad` VALUES ('185', 'BAYAUCA');
INSERT INTO `localidad` VALUES ('186', 'BECCAR');
INSERT INTO `localidad` VALUES ('187', 'BELLA VISTA');
INSERT INTO `localidad` VALUES ('188', 'BELLOCQ');
INSERT INTO `localidad` VALUES ('189', 'BENAVIDEZ');
INSERT INTO `localidad` VALUES ('190', 'BERNAL');
INSERT INTO `localidad` VALUES ('191', 'BERUTTI');
INSERT INTO `localidad` VALUES ('192', 'BILLINGHURST');
INSERT INTO `localidad` VALUES ('193', 'BLAQUIER');
INSERT INTO `localidad` VALUES ('194', 'BO. C. SALLES');
INSERT INTO `localidad` VALUES ('195', 'BO. CASTELLI');
INSERT INTO `localidad` VALUES ('196', 'BO. GRAL. MOSCONI');
INSERT INTO `localidad` VALUES ('197', 'BO. LA FLORIDA');
INSERT INTO `localidad` VALUES ('198', 'BO. LAS MELLIZAS');
INSERT INTO `localidad` VALUES ('199', 'BO. MORENO');
INSERT INTO `localidad` VALUES ('200', 'BO. SAN JORGE');
INSERT INTO `localidad` VALUES ('201', 'BO. SAN MARTIN');
INSERT INTO `localidad` VALUES ('202', 'BO. SANDRINA');
INSERT INTO `localidad` VALUES ('203', 'BO. STA. TERESITA');
INSERT INTO `localidad` VALUES ('204', 'BO. SUIZO');
INSERT INTO `localidad` VALUES ('205', 'BO. YAGUARON');
INSERT INTO `localidad` VALUES ('206', 'BOCAYUVA');
INSERT INTO `localidad` VALUES ('207', 'BORDENAVE');
INSERT INTO `localidad` VALUES ('208', 'BOSQUES');
INSERT INTO `localidad` VALUES ('209', 'BOULOGNE');
INSERT INTO `localidad` VALUES ('210', 'BURZACO');
INSERT INTO `localidad` VALUES ('211', 'CABILDO');
INSERT INTO `localidad` VALUES ('212', 'CACHARI');
INSERT INTO `localidad` VALUES ('213', 'CADRET');
INSERT INTO `localidad` VALUES ('214', 'CANNING');
INSERT INTO `localidad` VALUES ('215', 'CAPILLA DEL SE¾OR');
INSERT INTO `localidad` VALUES ('216', 'CAPITAN CASTRO');
INSERT INTO `localidad` VALUES ('217', 'CARABELAS');
INSERT INTO `localidad` VALUES ('218', 'CARAPACHAY');
INSERT INTO `localidad` VALUES ('219', 'CARDENAL CAGLIERO');
INSERT INTO `localidad` VALUES ('220', 'CARHUE');
INSERT INTO `localidad` VALUES ('221', 'CARILO');
INSERT INTO `localidad` VALUES ('222', 'CARLOS BEGUERIE');
INSERT INTO `localidad` VALUES ('223', 'CARLOS KEEN');
INSERT INTO `localidad` VALUES ('224', 'CARLOS M. NAON');
INSERT INTO `localidad` VALUES ('225', 'CARLOS SALAS');
INSERT INTO `localidad` VALUES ('226', 'CARLOS SPEGAZZINI');
INSERT INTO `localidad` VALUES ('227', 'CARLOS T. SOURIGUES');
INSERT INTO `localidad` VALUES ('228', 'CASBAS');
INSERT INTO `localidad` VALUES ('229', 'CASCADA');
INSERT INTO `localidad` VALUES ('230', 'CASTELAR');
INSERT INTO `localidad` VALUES ('231', 'CAZON');
INSERT INTO `localidad` VALUES ('232', 'CERNADAS');
INSERT INTO `localidad` VALUES ('233', 'CHAPADMALAL');
INSERT INTO `localidad` VALUES ('234', 'CHASICO');
INSERT INTO `localidad` VALUES ('235', 'CHILAVERT');
INSERT INTO `localidad` VALUES ('236', 'CHILLAR');
INSERT INTO `localidad` VALUES ('237', 'CHURRUCA');
INSERT INTO `localidad` VALUES ('238', 'CITY BELL');
INSERT INTO `localidad` VALUES ('239', 'CIUDAD EVITA');
INSERT INTO `localidad` VALUES ('240', 'CIUDADELA');
INSERT INTO `localidad` VALUES ('241', 'CLARAZ');
INSERT INTO `localidad` VALUES ('242', 'CLAROMECO');
INSERT INTO `localidad` VALUES ('243', 'CLAYPOLE');
INSERT INTO `localidad` VALUES ('244', 'COBO');
INSERT INTO `localidad` VALUES ('245', 'COLONIA HINOJO');
INSERT INTO `localidad` VALUES ('246', 'COLONIA LA CAPILLA');
INSERT INTO `localidad` VALUES ('247', 'COLONIA MAURICIO');
INSERT INTO `localidad` VALUES ('248', 'COLONIA NIEVE');
INSERT INTO `localidad` VALUES ('249', 'COLONIA SAN MARTIN');
INSERT INTO `localidad` VALUES ('250', 'COLONIA SAN MIGUEL');
INSERT INTO `localidad` VALUES ('251', 'COLONIA SAN PEDRO');
INSERT INTO `localidad` VALUES ('252', 'COLONIA SERE');
INSERT INTO `localidad` VALUES ('253', 'COMANDANTE OTAMENDI');
INSERT INTO `localidad` VALUES ('254', 'COMODORO PY');
INSERT INTO `localidad` VALUES ('255', 'CONESA');
INSERT INTO `localidad` VALUES ('256', 'COPETONAS');
INSERT INTO `localidad` VALUES ('257', 'CORONEL BOERR');
INSERT INTO `localidad` VALUES ('258', 'CORONEL VIDAL');
INSERT INTO `localidad` VALUES ('259', 'CORTINES');
INSERT INTO `localidad` VALUES ('260', 'COSTA DEL ESTE');
INSERT INTO `localidad` VALUES ('261', 'CROTTO');
INSERT INTO `localidad` VALUES ('262', 'CRUCECITA');
INSERT INTO `localidad` VALUES ('263', 'CUCULLU');
INSERT INTO `localidad` VALUES ('264', 'CURA MALAL');
INSERT INTO `localidad` VALUES ('265', 'CURARU');
INSERT INTO `localidad` VALUES ('266', 'DARREGUEIRA');
INSERT INTO `localidad` VALUES ('267', 'DE BARY');
INSERT INTO `localidad` VALUES ('268', 'DE LA CANAL');
INSERT INTO `localidad` VALUES ('269', 'DE LA GARMA');
INSERT INTO `localidad` VALUES ('270', 'DEL CARRIL');
INSERT INTO `localidad` VALUES ('271', 'DEL VISO');
INSERT INTO `localidad` VALUES ('272', 'DELFIN HUERGO');
INSERT INTO `localidad` VALUES ('273', 'DENNEHY');
INSERT INTO `localidad` VALUES ('274', 'DIECISEIS DE JULIO');
INSERT INTO `localidad` VALUES ('275', 'VILLA DORREGO');
INSERT INTO `localidad` VALUES ('276', 'DIEGO GAYNOR');
INSERT INTO `localidad` VALUES ('277', 'DIQUE LUJAN');
INSERT INTO `localidad` VALUES ('278', 'DOCE DE OCTUBRE');
INSERT INTO `localidad` VALUES ('279', 'DOCK SUD');
INSERT INTO `localidad` VALUES ('280', 'DOMSELAAR');
INSERT INTO `localidad` VALUES ('281', 'DON BOSCO');
INSERT INTO `localidad` VALUES ('282', 'DON TORCUATO');
INSERT INTO `localidad` VALUES ('283', 'DOYLE');
INSERT INTO `localidad` VALUES ('284', 'DUDIGNAC');
INSERT INTO `localidad` VALUES ('285', 'DUFAUR');
INSERT INTO `localidad` VALUES ('286', 'DUGGAN');
INSERT INTO `localidad` VALUES ('287', 'E. S. ZEBALLOS');
INSERT INTO `localidad` VALUES ('288', 'EL CARMEN');
INSERT INTO `localidad` VALUES ('289', 'EL DIQUE');
INSERT INTO `localidad` VALUES ('290', 'EL DIVISORIO');
INSERT INTO `localidad` VALUES ('291', 'EL JAGsEL');
INSERT INTO `localidad` VALUES ('292', 'EL LIBERTADOR');
INSERT INTO `localidad` VALUES ('293', 'EL PALOMAR');
INSERT INTO `localidad` VALUES ('295', 'EL PARAISO');
INSERT INTO `localidad` VALUES ('296', 'EL PATO');
INSERT INTO `localidad` VALUES ('297', 'EL PENSAMIENTO');
INSERT INTO `localidad` VALUES ('298', 'EL PORVENIR');
INSERT INTO `localidad` VALUES ('299', 'EL TALAR DE PACHECO');
INSERT INTO `localidad` VALUES ('300', 'EL TRIGO');
INSERT INTO `localidad` VALUES ('301', 'EL TRIUNFO');
INSERT INTO `localidad` VALUES ('302', 'ELVIRA');
INSERT INTO `localidad` VALUES ('303', 'EMILIO AYARZA');
INSERT INTO `localidad` VALUES ('304', 'EMILIO BUNGE');
INSERT INTO `localidad` VALUES ('305', 'ENERGIA');
INSERT INTO `localidad` VALUES ('306', 'ESPARTILLAR');
INSERT INTO `localidad` VALUES ('307', 'ESQUINA DE CROTTO');
INSERT INTO `localidad` VALUES ('308', 'ESTACION LAZZARINO');
INSERT INTO `localidad` VALUES ('309', 'ESTRUGAMOU');
INSERT INTO `localidad` VALUES ('310', 'EZPELETA');
INSERT INTO `localidad` VALUES ('311', 'FATIMA');
INSERT INTO `localidad` VALUES ('312', 'FELIPE SOLA');
INSERT INTO `localidad` VALUES ('313', 'FERNANDO MARTI');
INSERT INTO `localidad` VALUES ('314', 'FERRE');
INSERT INTO `localidad` VALUES ('315', 'FLORIDA');
INSERT INTO `localidad` VALUES ('316', 'FORTIN ACHA');
INSERT INTO `localidad` VALUES ('317', 'FORTIN OLAVARRIA');
INSERT INTO `localidad` VALUES ('318', 'FORTIN TIBURCIO');
INSERT INTO `localidad` VALUES ('319', 'FRANCISCO ALVAREZ');
INSERT INTO `localidad` VALUES ('320', 'FRANCISCO MAGNANO');
INSERT INTO `localidad` VALUES ('321', 'FRANKLIN');
INSERT INTO `localidad` VALUES ('322', 'FULTON');
INSERT INTO `localidad` VALUES ('323', 'GAHAN');
INSERT INTO `localidad` VALUES ('324', 'GAMBIER');
INSERT INTO `localidad` VALUES ('325', 'GANDARA');
INSERT INTO `localidad` VALUES ('326', 'GARDEY');
INSERT INTO `localidad` VALUES ('327', 'GARIN');
INSERT INTO `localidad` VALUES ('328', 'GARRE');
INSERT INTO `localidad` VALUES ('329', 'GDOR. MONTEVERDE');
INSERT INTO `localidad` VALUES ('330', 'GENERAL CERRI');
INSERT INTO `localidad` VALUES ('331', 'GENERAL HORNOS');
INSERT INTO `localidad` VALUES ('332', 'GENERAL MANSILLA');
INSERT INTO `localidad` VALUES ('333', 'GENERAL O\'BRIEN');
INSERT INTO `localidad` VALUES ('334', 'GENERAL PACHECO');
INSERT INTO `localidad` VALUES ('335', 'GENERAL PIRAN');
INSERT INTO `localidad` VALUES ('336', 'GERLI');
INSERT INTO `localidad` VALUES ('337', 'GERMANIA');
INSERT INTO `localidad` VALUES ('338', 'GIRODIAS');
INSERT INTO `localidad` VALUES ('339', 'GLEW');
INSERT INTO `localidad` VALUES ('340', 'GOBERNADOR CASTRO');
INSERT INTO `localidad` VALUES ('341', 'GOBERNADOR J.COSTA');
INSERT INTO `localidad` VALUES ('342', 'GOBERNADOR UDAONDO');
INSERT INTO `localidad` VALUES ('343', 'GOLDNEY');
INSERT INTO `localidad` VALUES ('344', 'GONZALEZ CATAN');
INSERT INTO `localidad` VALUES ('345', 'GONZALEZ MORENO');
INSERT INTO `localidad` VALUES ('346', 'GOROSTIAGA');
INSERT INTO `localidad` VALUES ('347', 'GOUIN');
INSERT INTO `localidad` VALUES ('348', 'GOWLAND');
INSERT INTO `localidad` VALUES ('349', 'GOYENA');
INSERT INTO `localidad` VALUES ('350', 'GRAND BOURG');
INSERT INTO `localidad` VALUES ('351', 'GRUNBEIN');
INSERT INTO `localidad` VALUES ('352', 'GUERRERO');
INSERT INTO `localidad` VALUES ('353', 'GUERRICO');
INSERT INTO `localidad` VALUES ('354', 'GUILLERMO E HUDSON');
INSERT INTO `localidad` VALUES ('355', 'HAEDO');
INSERT INTO `localidad` VALUES ('356', 'HALE');
INSERT INTO `localidad` VALUES ('357', 'HILARIO ASCASUBI');
INSERT INTO `localidad` VALUES ('358', 'HORTENSIA');
INSERT INTO `localidad` VALUES ('359', 'HUANGUELEN');
INSERT INTO `localidad` VALUES ('360', 'IGNACIO CORREA');
INSERT INTO `localidad` VALUES ('361', 'INDIO RICO');
INSERT INTO `localidad` VALUES ('362', 'INES INDART');
INSERT INTO `localidad` VALUES ('363', 'ING. JUAN ALLAN');
INSERT INTO `localidad` VALUES ('364', 'ING.PABLO NOGUES');
INSERT INTO `localidad` VALUES ('365', 'INGENIERO BUDGE');
INSERT INTO `localidad` VALUES ('366', 'INGENIERO MASCHWITZ');
INSERT INTO `localidad` VALUES ('367', 'INGENIERO MONETA');
INSERT INTO `localidad` VALUES ('368', 'INGENIERO THOMPSON');
INSERT INTO `localidad` VALUES ('369', 'INGENIERO WHITE');
INSERT INTO `localidad` VALUES ('370', 'IRALA');
INSERT INTO `localidad` VALUES ('371', 'IRAOLA');
INSERT INTO `localidad` VALUES ('372', 'IRINEO PORTELA');
INSERT INTO `localidad` VALUES ('373', 'ISLA LOS LAURELES');
INSERT INTO `localidad` VALUES ('374', 'ISLA MACIEL');
INSERT INTO `localidad` VALUES ('375', 'ISLA MARTIN GARCIA');
INSERT INTO `localidad` VALUES ('376', 'J. J. ALMEYRA');
INSERT INTO `localidad` VALUES ('377', 'JAUREGUI');
INSERT INTO `localidad` VALUES ('378', 'JEPPENNER');
INSERT INTO `localidad` VALUES ('379', 'JOAQUIN GORINA');
INSERT INTO `localidad` VALUES ('380', 'JOSE B. CASA');
INSERT INTO `localidad` VALUES ('381', 'JOSE HERNANDEZ');
INSERT INTO `localidad` VALUES ('382', 'JOSE INGENIEROS');
INSERT INTO `localidad` VALUES ('383', 'JOSE LEON SUAREZ');
INSERT INTO `localidad` VALUES ('384', 'JUAN A. DE LA PENA');
INSERT INTO `localidad` VALUES ('385', 'JUAN A. PRADERE');
INSERT INTO `localidad` VALUES ('386', 'JUAN B. ALBERDI');
INSERT INTO `localidad` VALUES ('387', 'JUAN BLAQUIER');
INSERT INTO `localidad` VALUES ('388', 'JUAN E. BARRA');
INSERT INTO `localidad` VALUES ('389', 'JUAN JOSE PASO');
INSERT INTO `localidad` VALUES ('390', 'JUAN M. GUTIERREZ');
INSERT INTO `localidad` VALUES ('391', 'JUAN N. FERNANDEZ');
INSERT INTO `localidad` VALUES ('392', 'LA ANGELITA');
INSERT INTO `localidad` VALUES ('393', 'LA AZUCENA');
INSERT INTO `localidad` VALUES ('394', 'LA BEBA');
INSERT INTO `localidad` VALUES ('395', 'LA CARRETA');
INSERT INTO `localidad` VALUES ('396', 'LA CHOZA');
INSERT INTO `localidad` VALUES ('397', 'LA COLINA');
INSERT INTO `localidad` VALUES ('398', 'LA DULCE');
INSERT INTO `localidad` VALUES ('399', 'LA EMILIA');
INSERT INTO `localidad` VALUES ('400', 'LA GRANJA');
INSERT INTO `localidad` VALUES ('401', 'LA LIMPIA');
INSERT INTO `localidad` VALUES ('402', 'LA LONJA');
INSERT INTO `localidad` VALUES ('403', 'LA LUCILA');
INSERT INTO `localidad` VALUES ('404', 'LA LUCILA DEL MAR');
INSERT INTO `localidad` VALUES ('405', 'LA LUISA');
INSERT INTO `localidad` VALUES ('406', 'LA PASTORA');
INSERT INTO `localidad` VALUES ('407', 'LA REJA');
INSERT INTO `localidad` VALUES ('408', 'LA RICA');
INSERT INTO `localidad` VALUES ('409', 'LA SALADA');
INSERT INTO `localidad` VALUES ('410', 'LA SOFIA');
INSERT INTO `localidad` VALUES ('411', 'LA TABLADA');
INSERT INTO `localidad` VALUES ('412', 'LA TRINIDAD');
INSERT INTO `localidad` VALUES ('413', 'LA VERDE');
INSERT INTO `localidad` VALUES ('414', 'LA VIOLETA');
INSERT INTO `localidad` VALUES ('415', 'LABARDEN');
INSERT INTO `localidad` VALUES ('416', 'LAGO EPECUEN');
INSERT INTO `localidad` VALUES ('417', 'LAGUNA ALSINA');
INSERT INTO `localidad` VALUES ('418', 'LANUS ESTE');
INSERT INTO `localidad` VALUES ('419', 'LANUS OESTE');
INSERT INTO `localidad` VALUES ('420', 'LAPLACETTE');
INSERT INTO `localidad` VALUES ('421', 'LARTIGAU');
INSERT INTO `localidad` VALUES ('422', 'LAS ARMAS');
INSERT INTO `localidad` VALUES ('423', 'LAS BAHAMAS');
INSERT INTO `localidad` VALUES ('424', 'LAS HERAS');
INSERT INTO `localidad` VALUES ('425', 'LAS MARIANAS');
INSERT INTO `localidad` VALUES ('426', 'LAS MARTINETAS');
INSERT INTO `localidad` VALUES ('427', 'LAS QUINTAS');
INSERT INTO `localidad` VALUES ('428', 'LAS TONINAS');
INSERT INTO `localidad` VALUES ('429', 'LEUBUCO');
INSERT INTO `localidad` VALUES ('430', 'LEZAMA');
INSERT INTO `localidad` VALUES ('431', 'LEZICA Y TORREZURI');
INSERT INTO `localidad` VALUES ('432', 'LIBANO');
INSERT INTO `localidad` VALUES ('433', 'LIBERTAD');
INSERT INTO `localidad` VALUES ('434', 'LIC. MATIENZO');
INSERT INTO `localidad` VALUES ('435', 'LIMA');
INSERT INTO `localidad` VALUES ('436', 'LIN-CALEL');
INSERT INTO `localidad` VALUES ('437', 'LISANDRO OLMOS');
INSERT INTO `localidad` VALUES ('438', 'LLAVALLOL');
INSERT INTO `localidad` VALUES ('439', 'LOMA HERMOSA');
INSERT INTO `localidad` VALUES ('440', 'LOMA VERDE');
INSERT INTO `localidad` VALUES ('441', 'LOMAS DEL MIRADOR');
INSERT INTO `localidad` VALUES ('442', 'LONGCHAMPS');
INSERT INTO `localidad` VALUES ('443', 'LOPEZ');
INSERT INTO `localidad` VALUES ('444', 'LOPEZ LECUBE');
INSERT INTO `localidad` VALUES ('445', 'LOS CARDALES');
INSERT INTO `localidad` VALUES ('446', 'LOS HORNOS');
INSERT INTO `localidad` VALUES ('447', 'LOS INDIOS');
INSERT INTO `localidad` VALUES ('448', 'LOS PINOS');
INSERT INTO `localidad` VALUES ('449', 'LOS TALAS');
INSERT INTO `localidad` VALUES ('450', 'LOS TOLDOS');
INSERT INTO `localidad` VALUES ('451', 'LUIS GUILLON');
INSERT INTO `localidad` VALUES ('452', 'MAGDALA');
INSERT INTO `localidad` VALUES ('453', 'MALAVER');
INSERT INTO `localidad` VALUES ('454', 'MANUEL B GONNET');
INSERT INTO `localidad` VALUES ('455', 'MANUEL J. GARCIA');
INSERT INTO `localidad` VALUES ('456', 'MANUEL JOSE COBO');
INSERT INTO `localidad` VALUES ('457', 'MANUEL OCAMPO');
INSERT INTO `localidad` VALUES ('458', 'MANZANARES');
INSERT INTO `localidad` VALUES ('459', 'MANZONE');
INSERT INTO `localidad` VALUES ('460', 'MAQUINISTA SAVIO');
INSERT INTO `localidad` VALUES ('461', 'MAR AZUL');
INSERT INTO `localidad` VALUES ('462', 'MAR DE AJO');
INSERT INTO `localidad` VALUES ('463', 'MAR DEL SUR');
INSERT INTO `localidad` VALUES ('464', 'MAR DEL TUYU');
INSERT INTO `localidad` VALUES ('465', 'MARIA IGNACIA');
INSERT INTO `localidad` VALUES ('466', 'MARIANO ACOSTA');
INSERT INTO `localidad` VALUES ('467', 'MARIANO BENITEZ');
INSERT INTO `localidad` VALUES ('468', 'MARMOL');
INSERT INTO `localidad` VALUES ('469', 'MARTIN CORONADO');
INSERT INTO `localidad` VALUES ('470', 'MARTINEZ');
INSERT INTO `localidad` VALUES ('471', 'MASCOTAS');
INSERT INTO `localidad` VALUES ('472', 'MATHEU');
INSERT INTO `localidad` VALUES ('473', 'MAURICIO HIRSH');
INSERT INTO `localidad` VALUES ('474', 'MAXIMO PAZ');
INSERT INTO `localidad` VALUES ('475', 'MAYOR BURATOVICH');
INSERT INTO `localidad` VALUES ('476', 'MAZA');
INSERT INTO `localidad` VALUES ('477', 'MECHITA');
INSERT INTO `localidad` VALUES ('478', 'MECHONGUE');
INSERT INTO `localidad` VALUES ('479', 'MEDANOS');
INSERT INTO `localidad` VALUES ('480', 'MELCHOR ROMERO');
INSERT INTO `localidad` VALUES ('481', 'MIGUELETE');
INSERT INTO `localidad` VALUES ('482', 'MIRA PAMPA');
INSERT INTO `localidad` VALUES ('483', 'MILBERG');
INSERT INTO `localidad` VALUES ('484', 'MIRAMAR');
INSERT INTO `localidad` VALUES ('485', 'MOCTEZUMA');
INSERT INTO `localidad` VALUES ('486', 'MOLL');
INSERT INTO `localidad` VALUES ('487', 'MONES CAZON');
INSERT INTO `localidad` VALUES ('488', 'MONTE CHINGOLO');
INSERT INTO `localidad` VALUES ('489', 'MOQUEHUA');
INSERT INTO `localidad` VALUES ('490', 'MOREA');
INSERT INTO `localidad` VALUES ('491', 'MORSE');
INSERT INTO `localidad` VALUES ('492', 'MU¾IZ');
INSERT INTO `localidad` VALUES ('493', 'MUNRO');
INSERT INTO `localidad` VALUES ('494', 'NAPALEOFU');
INSERT INTO `localidad` VALUES ('495', 'NORUMBEGA');
INSERT INTO `localidad` VALUES ('496', 'NUEVA PLATA');
INSERT INTO `localidad` VALUES ('497', 'O\'HIGGINS');
INSERT INTO `localidad` VALUES ('498', 'OLASCOAGA');
INSERT INTO `localidad` VALUES ('499', 'OLIVERA');
INSERT INTO `localidad` VALUES ('500', 'OLIVOS');
INSERT INTO `localidad` VALUES ('501', 'OPEN DOOR');
INSERT INTO `localidad` VALUES ('502', 'ORDOQUI');
INSERT INTO `localidad` VALUES ('503', 'ORENSE');
INSERT INTO `localidad` VALUES ('504', 'ORIENTE');
INSERT INTO `localidad` VALUES ('505', 'ORTIZ BASUALDO');
INSERT INTO `localidad` VALUES ('506', 'OSTENDE');
INSERT INTO `localidad` VALUES ('507', 'PABLO PODESTA');
INSERT INTO `localidad` VALUES ('508', 'PARANA MINI');
INSERT INTO `localidad` VALUES ('509', 'PARDO');
INSERT INTO `localidad` VALUES ('510', 'PARQUE CAMET');
INSERT INTO `localidad` VALUES ('511', 'PARQUE LELOIR');
INSERT INTO `localidad` VALUES ('512', 'PARQUE SAN MARTIN');
INSERT INTO `localidad` VALUES ('513', 'PASMAN');
INSERT INTO `localidad` VALUES ('514', 'PASO DEL REY');
INSERT INTO `localidad` VALUES ('515', 'PASTEUR');
INSERT INTO `localidad` VALUES ('516', 'PATRICIOS');
INSERT INTO `localidad` VALUES ('517', 'PAVON');
INSERT INTO `localidad` VALUES ('518', 'PEARSON');
INSERT INTO `localidad` VALUES ('519', 'PEDRO LURO');
INSERT INTO `localidad` VALUES ('520', 'PEHUEN CO');
INSERT INTO `localidad` VALUES ('521', 'PEREYRA');
INSERT INTO `localidad` VALUES ('522', 'PEREZ MILLAN');
INSERT INTO `localidad` VALUES ('523', 'PICHINCHA');
INSERT INTO `localidad` VALUES ('524', 'PIEDRITAS');
INSERT INTO `localidad` VALUES ('525', 'PIERES');
INSERT INTO `localidad` VALUES ('526', 'PIGsE');
INSERT INTO `localidad` VALUES ('527', 'PINEYRO');
INSERT INTO `localidad` VALUES ('528', 'PIPINAS');
INSERT INTO `localidad` VALUES ('529', 'PIROVANO');
INSERT INTO `localidad` VALUES ('530', 'PLA');
INSERT INTO `localidad` VALUES ('531', 'PLATANOS');
INSERT INTO `localidad` VALUES ('532', 'PLOMER');
INSERT INTO `localidad` VALUES ('533', 'PONTAUT');
INSERT INTO `localidad` VALUES ('534', 'PONTEVEDRA');
INSERT INTO `localidad` VALUES ('535', 'PRESIDENTE DERQUI');
INSERT INTO `localidad` VALUES ('536', 'PUEBLO SAN JOSE');
INSERT INTO `localidad` VALUES ('537', 'PUNTA LARA');
INSERT INTO `localidad` VALUES ('538', 'PUNTA MOGOTES');
INSERT INTO `localidad` VALUES ('539', 'QUENUMA');
INSERT INTO `localidad` VALUES ('540', 'QUEQUEN');
INSERT INTO `localidad` VALUES ('541', 'QUILMES OESTE');
INSERT INTO `localidad` VALUES ('542', 'R. DE ESCALADA');
INSERT INTO `localidad` VALUES ('543', 'RAFAEL CALZADA');
INSERT INTO `localidad` VALUES ('544', 'RAFAEL CASTILLO');
INSERT INTO `localidad` VALUES ('545', 'RAFAEL OBLIGADO');
INSERT INTO `localidad` VALUES ('546', 'RAMON BIAUS');
INSERT INTO `localidad` VALUES ('547', 'RAMON SANTAMARINA');
INSERT INTO `localidad` VALUES ('548', 'RAMOS MEJIA');
INSERT INTO `localidad` VALUES ('549', 'RAMOS OTERO');
INSERT INTO `localidad` VALUES ('550', 'RANCAGUA');
INSERT INTO `localidad` VALUES ('551', 'RANCHOS');
INSERT INTO `localidad` VALUES ('552', 'RANELAGH');
INSERT INTO `localidad` VALUES ('553', 'RAWSON');
INSERT INTO `localidad` VALUES ('554', 'RECALDE');
INSERT INTO `localidad` VALUES ('555', 'RETA');
INSERT INTO `localidad` VALUES ('556', 'RICARDO ROJAS');
INSERT INTO `localidad` VALUES ('557', 'RINGUELET');
INSERT INTO `localidad` VALUES ('558', 'RIO SANTIAGO');
INSERT INTO `localidad` VALUES ('559', 'RIO TALA');
INSERT INTO `localidad` VALUES ('560', 'RIVAS');
INSERT INTO `localidad` VALUES ('561', 'RIVERA');
INSERT INTO `localidad` VALUES ('562', 'ROBERTO CANO');
INSERT INTO `localidad` VALUES ('563', 'ROOSEVELT');
INSERT INTO `localidad` VALUES ('564', 'S.F.DE BELLOCQ');
INSERT INTO `localidad` VALUES ('565', 'SAENZ PE¾A');
INSERT INTO `localidad` VALUES ('566', 'SAFORCADA');
INSERT INTO `localidad` VALUES ('567', 'SALAZAR');
INSERT INTO `localidad` VALUES ('568', 'ROBERTS');
INSERT INTO `localidad` VALUES ('569', 'SALDUNGARAY');
INSERT INTO `localidad` VALUES ('570', 'SALVADOR MARIA');
INSERT INTO `localidad` VALUES ('571', 'SAN A. DE PADUA');
INSERT INTO `localidad` VALUES ('572', 'SAN AGUSTIN');
INSERT INTO `localidad` VALUES ('573', 'SAN ALBERTO');
INSERT INTO `localidad` VALUES ('574', 'SAN ANDRES');
INSERT INTO `localidad` VALUES ('575', 'SAN BERNARDO');
INSERT INTO `localidad` VALUES ('576', 'SAN CARLOS');
INSERT INTO `localidad` VALUES ('577', 'SAN CLEMENTE DEL TUYU');
INSERT INTO `localidad` VALUES ('578', 'SAN ELADIO');
INSERT INTO `localidad` VALUES ('579', 'SAN EMILIO');
INSERT INTO `localidad` VALUES ('580', 'SAN FRANCISCO SOLANO');
INSERT INTO `localidad` VALUES ('581', 'SAN GERMAN');
INSERT INTO `localidad` VALUES ('582', 'SAN JORGE');
INSERT INTO `localidad` VALUES ('583', 'SAN MANUEL');
INSERT INTO `localidad` VALUES ('584', 'SAN MAURICIO');
INSERT INTO `localidad` VALUES ('585', 'SAN MAYOL');
INSERT INTO `localidad` VALUES ('586', 'SAN MIGUEL ARCANGEL');
INSERT INTO `localidad` VALUES ('587', 'SAN SEBASTIAN');
INSERT INTO `localidad` VALUES ('588', 'SANSINENA');
INSERT INTO `localidad` VALUES ('589', 'SANTA CLARA DEL MAR');
INSERT INTO `localidad` VALUES ('590', 'SANTA COLOMA');
INSERT INTO `localidad` VALUES ('591', 'SANTA LUCIA');
INSERT INTO `localidad` VALUES ('592', 'SANTA MARIA');
INSERT INTO `localidad` VALUES ('593', 'SANTA REGINA');
INSERT INTO `localidad` VALUES ('594', 'SANTA TERESITA');
INSERT INTO `localidad` VALUES ('595', 'SANTAMARINA');
INSERT INTO `localidad` VALUES ('596', 'SANTO DOMINGO');
INSERT INTO `localidad` VALUES ('597', 'SANTOS LUGARES');
INSERT INTO `localidad` VALUES ('598', 'SANTOS TESEI');
INSERT INTO `localidad` VALUES ('599', 'SARANDI');
INSERT INTO `localidad` VALUES ('600', 'SEVIGNE');
INSERT INTO `localidad` VALUES ('601', 'SIERRA CHICA');
INSERT INTO `localidad` VALUES ('602', 'SIERRA DE LA VENTANA');
INSERT INTO `localidad` VALUES ('603', 'SIERRA DE LOS PADRES');
INSERT INTO `localidad` VALUES ('604', 'SIERRAS BAYAS');
INSERT INTO `localidad` VALUES ('605', 'SMITH');
INSERT INTO `localidad` VALUES ('606', 'SOLIS');
INSERT INTO `localidad` VALUES ('607', 'STROEDER');
INSERT INTO `localidad` VALUES ('608', 'SUNDBLAD');
INSERT INTO `localidad` VALUES ('609', 'TAMANGUEYU');
INSERT INTO `localidad` VALUES ('610', 'TAPIALES');
INSERT INTO `localidad` VALUES ('611', 'TEDIN URIBURU');
INSERT INTO `localidad` VALUES ('612', 'TEMPERLEY');
INSERT INTO `localidad` VALUES ('613', 'TENIENTE ORIGONE');
INSERT INTO `localidad` VALUES ('614', 'TIMOTE');
INSERT INTO `localidad` VALUES ('615', 'TODD');
INSERT INTO `localidad` VALUES ('616', 'TOLOSA');
INSERT INTO `localidad` VALUES ('617', 'TOMAS JOFRE');
INSERT INTO `localidad` VALUES ('619', 'TORRES');
INSERT INTO `localidad` VALUES ('620', 'TORTUGUITAS');
INSERT INTO `localidad` VALUES ('621', 'TRES ALGARROBOS');
INSERT INTO `localidad` VALUES ('622', 'TRES PICOS');
INSERT INTO `localidad` VALUES ('623', 'TRES SARGENTOS');
INSERT INTO `localidad` VALUES ('624', 'TRISTAN SUAREZ');
INSERT INTO `localidad` VALUES ('625', 'TRUJUI');
INSERT INTO `localidad` VALUES ('626', 'TURDERA');
INSERT INTO `localidad` VALUES ('627', 'UNION FERROVIARIA');
INSERT INTO `localidad` VALUES ('628', 'URDAMPILLETA');
INSERT INTO `localidad` VALUES ('629', 'URIBELARREA');
INSERT INTO `localidad` VALUES ('630', 'VILLA CIUDAD JARDIN');
INSERT INTO `localidad` VALUES ('631', 'VILLA HARDING GREEN');
INSERT INTO `localidad` VALUES ('632', 'VILLA J. N. PUEYRREDON');
INSERT INTO `localidad` VALUES ('633', 'VILLA CAMPI');
INSERT INTO `localidad` VALUES ('634', 'VILLA CANTO');
INSERT INTO `localidad` VALUES ('635', 'VILLA ESPERANZA');
INSERT INTO `localidad` VALUES ('636', 'VILLA HERMOSA');
INSERT INTO `localidad` VALUES ('637', 'VILLA RICCIO');
INSERT INTO `localidad` VALUES ('638', 'VALENTIN ALSINA');
INSERT INTO `localidad` VALUES ('639', 'VALERIA DEL MAR');
INSERT INTO `localidad` VALUES ('640', 'VASQUEZ');
INSERT INTO `localidad` VALUES ('641', 'VEINTE DE JUNIO');
INSERT INTO `localidad` VALUES ('642', 'VELLOSO');
INSERT INTO `localidad` VALUES ('643', 'VERONICA');
INSERT INTO `localidad` VALUES ('644', 'VICENTE CASARES');
INSERT INTO `localidad` VALUES ('645', 'VICTORIA');
INSERT INTO `localidad` VALUES ('646', 'VIEYTES');
INSERT INTO `localidad` VALUES ('647', 'VILLA ADELINA');
INSERT INTO `localidad` VALUES ('648', 'VILLA ADRIANA');
INSERT INTO `localidad` VALUES ('649', 'VILLA ARGUELLO');
INSERT INTO `localidad` VALUES ('650', 'VILLA BALLESTER');
INSERT INTO `localidad` VALUES ('651', 'VILLA BOSCH');
INSERT INTO `localidad` VALUES ('652', 'VILLA BROWN');
INSERT INTO `localidad` VALUES ('653', 'VILLA CACIQUE');
INSERT INTO `localidad` VALUES ('654', 'VILLA CATELLA');
INSERT INTO `localidad` VALUES ('655', 'VILLA CELINA');
INSERT INTO `localidad` VALUES ('656', 'VILLA DEL MAR');
INSERT INTO `localidad` VALUES ('657', 'VILLA DOLORES');
INSERT INTO `localidad` VALUES ('658', 'VILLA DOMINICO');
INSERT INTO `localidad` VALUES ('659', 'VILLA ECHENAGUCIA');
INSERT INTO `localidad` VALUES ('660', 'VILLA ELISA');
INSERT INTO `localidad` VALUES ('661', 'VILLA ELVIRA');
INSERT INTO `localidad` VALUES ('662', 'VILLA ESPA¾A');
INSERT INTO `localidad` VALUES ('663', 'VILLA ESPIL');
INSERT INTO `localidad` VALUES ('664', 'VILLA FLANDRIA');
INSERT INTO `localidad` VALUES ('665', 'VILLA FORTABAT');
INSERT INTO `localidad` VALUES ('666', 'VILLA FRANCIA');
INSERT INTO `localidad` VALUES ('667', 'VILLA GIAMBRUNO');
INSERT INTO `localidad` VALUES ('668', 'VILLA GRAL. ARIAS');
INSERT INTO `localidad` VALUES ('669', 'VILLA INSUPERABLE');
INSERT INTO `localidad` VALUES ('670', 'VILLA IRIS');
INSERT INTO `localidad` VALUES ('671', 'VILLA LIA');
INSERT INTO `localidad` VALUES ('672', 'VILLA LIBERTAD');
INSERT INTO `localidad` VALUES ('673', 'VILLA LUZURIAGA');
INSERT INTO `localidad` VALUES ('674', 'VILLA LYNCH');
INSERT INTO `localidad` VALUES ('675', 'VILLA MADERO');
INSERT INTO `localidad` VALUES ('676', 'VILLA MAIPU');
INSERT INTO `localidad` VALUES ('677', 'VILLA MARGARITA');
INSERT INTO `localidad` VALUES ('678', 'VILLA MARTELLI');
INSERT INTO `localidad` VALUES ('679', 'VILLA MONTORO');
INSERT INTO `localidad` VALUES ('680', 'VILLA MOQUEHUA');
INSERT INTO `localidad` VALUES ('681', 'VILLA NUMANCIA');
INSERT INTO `localidad` VALUES ('682', 'VILLA ORTIZ');
INSERT INTO `localidad` VALUES ('683', 'VILLA PORTE¾A');
INSERT INTO `localidad` VALUES ('684', 'VILLA RAFFO');
INSERT INTO `localidad` VALUES ('685', 'VILLA RAMALLO');
INSERT INTO `localidad` VALUES ('686', 'VILLA REBASA');
INSERT INTO `localidad` VALUES ('687', 'VILLA RECONDO');
INSERT INTO `localidad` VALUES ('688', 'VILLA ROSA');
INSERT INTO `localidad` VALUES ('689', 'VILLA RUIZ');
INSERT INTO `localidad` VALUES ('690', 'VILLA SABOYA');
INSERT INTO `localidad` VALUES ('691', 'VILLA SAN CARLOS');
INSERT INTO `localidad` VALUES ('692', 'VILLA SAN LUIS');
INSERT INTO `localidad` VALUES ('693', 'VILLA SANTA ROSA');
INSERT INTO `localidad` VALUES ('694', 'VILLA SARMIENTO');
INSERT INTO `localidad` VALUES ('695', 'VILLA SAUCE');
INSERT INTO `localidad` VALUES ('696', 'VILLA VATTEONE');
INSERT INTO `localidad` VALUES ('697', 'VILLA ZULA');
INSERT INTO `localidad` VALUES ('698', 'VILLALONGA');
INSERT INTO `localidad` VALUES ('699', 'VILLANUEVA');
INSERT INTO `localidad` VALUES ('700', 'VILLARS');
INSERT INTO `localidad` VALUES ('701', 'VIÑA');
INSERT INTO `localidad` VALUES ('702', 'VIRREY DEL PINO');
INSERT INTO `localidad` VALUES ('703', 'VIRREYES');
INSERT INTO `localidad` VALUES ('704', 'VIVORATA');
INSERT INTO `localidad` VALUES ('705', 'VUELTA OBLIGADO');
INSERT INTO `localidad` VALUES ('706', 'WARNES');
INSERT INTO `localidad` VALUES ('707', 'WILDE');
INSERT INTO `localidad` VALUES ('708', 'WILLIAM MORRIS');
INSERT INTO `localidad` VALUES ('709', 'ZAVALIA');
INSERT INTO `localidad` VALUES ('710', 'ZELAYA');
INSERT INTO `localidad` VALUES ('711', 'ZENON VIDELA DORNA');
INSERT INTO `localidad` VALUES ('712', '11 DE SEPTIEMBRE');
INSERT INTO `localidad` VALUES ('713', '30 DE AGOSTO');
INSERT INTO `localidad` VALUES ('714', '9 DE ABRIL');
INSERT INTO `localidad` VALUES ('715', 'ABASTO');
INSERT INTO `localidad` VALUES ('716', 'ABBOTT');
INSERT INTO `localidad` VALUES ('717', 'ACASSUSO');
INSERT INTO `localidad` VALUES ('718', 'ACEVEDO');
INSERT INTO `localidad` VALUES ('719', 'ADELA');
INSERT INTO `localidad` VALUES ('720', 'SAN JACINTO');
INSERT INTO `localidad` VALUES ('721', 'CASEROS');
INSERT INTO `localidad` VALUES ('722', 'LOS POLVORINES');
INSERT INTO `localidad` VALUES ('723', 'LA FERRERE');
INSERT INTO `localidad` VALUES ('724', 'SOLANO');
INSERT INTO `modulo` VALUES ('51', '5', 'Seguridad', '0');
INSERT INTO `modulo` VALUES ('52', '5', 'Inicio', '0');
INSERT INTO `modulo` VALUES ('53', '5', 'Listados', '0');
INSERT INTO `modulo` VALUES ('58', '5', 'Estadisticos', '0');
INSERT INTO `modulo` VALUES ('60', '5', 'Obra civil', '0');
INSERT INTO `modulo` VALUES ('61', '5', 'Obra yeserÃ­a', '0');
INSERT INTO `modulo` VALUES ('62', '5', 'Clientes', '0');
INSERT INTO `modulo` VALUES ('63', '5', 'Obreros', '0');
INSERT INTO `modulo` VALUES ('64', '5', 'Configuracion', '0');
INSERT INTO `modulo` VALUES ('65', '5', 'Proveedor', '0');
INSERT INTO `modulo` VALUES ('66', '5', 'PaÃ±ol', '0');
INSERT INTO `modulo` VALUES ('67', '5', 'Presupuesto', '0');
INSERT INTO `modulo` VALUES ('68', '5', 'Cobro de cuotas', '0');
INSERT INTO `modulo` VALUES ('69', '5', 'Planta', '0');
INSERT INTO `modulo` VALUES ('70', '5', 'Contratos', '0');
INSERT INTO `modulo` VALUES ('71', '5', 'Trommel', '0');
INSERT INTO `modulo` VALUES ('72', '5', 'Prensa', '0');
INSERT INTO `modulo` VALUES ('73', '5', 'Cinta Transportadora', '0');
INSERT INTO `modulo` VALUES ('74', '5', 'Empleado', '0');
INSERT INTO `modulo_paginas` VALUES ('345', '51', 'aplicaciones/alta_aplicacion.php');
INSERT INTO `modulo_paginas` VALUES ('346', '51', 'aplicaciones/index.php');
INSERT INTO `modulo_paginas` VALUES ('347', '51', 'aplicaciones/modificar_aplicacion.php');
INSERT INTO `modulo_paginas` VALUES ('348', '51', 'aplicaciones/eliminar_aplicacion.php');
INSERT INTO `modulo_paginas` VALUES ('349', '51', 'areas/alta_area.php');
INSERT INTO `modulo_paginas` VALUES ('350', '51', 'areas/eliminar_area.php');
INSERT INTO `modulo_paginas` VALUES ('351', '51', 'areas/index.php');
INSERT INTO `modulo_paginas` VALUES ('352', '51', 'areas/modificar_area.php');
INSERT INTO `modulo_paginas` VALUES ('353', '51', 'modulos/alta_modulo.php');
INSERT INTO `modulo_paginas` VALUES ('354', '51', 'modulos/eliminar_modulo.php');
INSERT INTO `modulo_paginas` VALUES ('355', '51', 'modulos/index.php');
INSERT INTO `modulo_paginas` VALUES ('356', '51', 'modulos/modificar_modulo.php');
INSERT INTO `modulo_paginas` VALUES ('357', '51', 'permisos/eliminar_permiso.php');
INSERT INTO `modulo_paginas` VALUES ('358', '51', 'permisos/index.php');
INSERT INTO `modulo_paginas` VALUES ('359', '51', 'roles/alta_rol.php');
INSERT INTO `modulo_paginas` VALUES ('360', '51', 'roles/eliminar_rol.php');
INSERT INTO `modulo_paginas` VALUES ('361', '51', 'roles/index.php');
INSERT INTO `modulo_paginas` VALUES ('362', '51', 'roles/modificar_rol.php');
INSERT INTO `modulo_paginas` VALUES ('363', '51', 'seguridad/index.php');
INSERT INTO `modulo_paginas` VALUES ('364', '51', 'tipos_acceso/alta_acceso.php');
INSERT INTO `modulo_paginas` VALUES ('365', '51', 'tipos_acceso/eliminar_acceso.php');
INSERT INTO `modulo_paginas` VALUES ('366', '51', 'tipos_acceso/index.php');
INSERT INTO `modulo_paginas` VALUES ('367', '51', 'tipos_acceso/modificar_acceso.php');
INSERT INTO `modulo_paginas` VALUES ('368', '51', 'usuarios/alta_usuario.php');
INSERT INTO `modulo_paginas` VALUES ('369', '51', 'usuarios/cambiar-clave.php');
INSERT INTO `modulo_paginas` VALUES ('370', '51', 'usuarios/eliminar_usuario.php');
INSERT INTO `modulo_paginas` VALUES ('371', '51', 'usuarios/index.php');
INSERT INTO `modulo_paginas` VALUES ('372', '51', 'usuarios/modificar_usuario.php');
INSERT INTO `modulo_paginas` VALUES ('373', '51', 'usuarios_area/agregar.php');
INSERT INTO `modulo_paginas` VALUES ('374', '51', 'usuarios_area/eliminar.php');
INSERT INTO `modulo_paginas` VALUES ('375', '51', 'usuarios_area/index.php');
INSERT INTO `modulo_paginas` VALUES ('376', '51', 'usuarios_rol/agregar.php');
INSERT INTO `modulo_paginas` VALUES ('377', '51', 'usuarios_rol/eliminar.php');
INSERT INTO `modulo_paginas` VALUES ('378', '51', 'usuarios_rol/index.php');
INSERT INTO `modulo_paginas` VALUES ('379', '52', 'home/denegado.php');
INSERT INTO `modulo_paginas` VALUES ('380', '52', 'home/edit-clave.php');
INSERT INTO `modulo_paginas` VALUES ('381', '51', 'paginas/alta_pagina.php');
INSERT INTO `modulo_paginas` VALUES ('382', '51', 'paginas/eliminar_pagina.php');
INSERT INTO `modulo_paginas` VALUES ('383', '51', 'paginas/index.php');
INSERT INTO `modulo_paginas` VALUES ('384', '51', 'paginas/modificar_pagina.php');
INSERT INTO `modulo_paginas` VALUES ('385', '52', 'home/mantenimiento.php');
INSERT INTO `modulo_paginas` VALUES ('386', '52', 'home/recuperar-clave.php');
INSERT INTO `modulo_paginas` VALUES ('387', '52', 'home/resetear-clave.php');
INSERT INTO `modulo_paginas` VALUES ('608', '52', 'home/home.php');
INSERT INTO `modulo_paginas` VALUES ('609', '51', 'home/edicion.php');
INSERT INTO `modulo_paginas` VALUES ('610', '53', 'listados/index.php');
INSERT INTO `modulo_paginas` VALUES ('611', '53', 'listados/acumulado_concepto.php');
INSERT INTO `modulo_paginas` VALUES ('628', '58', 'estadistico/index.php');
INSERT INTO `modulo_paginas` VALUES ('629', '58', 'estadistico/estadistico.config');
INSERT INTO `modulo_paginas` VALUES ('631', '53', 'listados/empleados.php');
INSERT INTO `modulo_paginas` VALUES ('633', '58', 'estadistico/chart_prom_bruto_neto.php');
INSERT INTO `modulo_paginas` VALUES ('634', '58', 'estadistico/chart_ranking.php');
INSERT INTO `modulo_paginas` VALUES ('635', '53', 'listados/seguimiento_empleado.php');
INSERT INTO `modulo_paginas` VALUES ('637', '62', 'clientes/index.php');
INSERT INTO `modulo_paginas` VALUES ('638', '62', 'clientes/alta_cliente.php');
INSERT INTO `modulo_paginas` VALUES ('639', '62', 'clientes/adjuntos_cliente.php');
INSERT INTO `modulo_paginas` VALUES ('640', '62', 'clientes/descargar_adjuntos.php');
INSERT INTO `modulo_paginas` VALUES ('641', '62', 'clientes/modificar_cliente.php');
INSERT INTO `modulo_paginas` VALUES ('642', '62', 'clientes/subir_adjuntos_cliente.php');
INSERT INTO `modulo_paginas` VALUES ('643', '62', 'clientes/ver_cliente.php');
INSERT INTO `modulo_paginas` VALUES ('644', '60', 'obra_civil/alta_obra_civil.php');
INSERT INTO `modulo_paginas` VALUES ('645', '60', 'obra_civil/eliminar_obra_civil.php');
INSERT INTO `modulo_paginas` VALUES ('646', '60', 'obra_civil/modificar_obra_civil.php');
INSERT INTO `modulo_paginas` VALUES ('647', '60', 'obra_civil/index.php');
INSERT INTO `modulo_paginas` VALUES ('648', '61', 'obra_yeseria/alta_obra_yeseria.php');
INSERT INTO `modulo_paginas` VALUES ('649', '61', 'obra_yeseria/eliminar_obra_yeseria.php');
INSERT INTO `modulo_paginas` VALUES ('650', '61', 'obra_yeseria/modificar_obra_yeseria.php');
INSERT INTO `modulo_paginas` VALUES ('651', '61', 'obra_yeseria/index.php');
INSERT INTO `modulo_paginas` VALUES ('652', '63', 'obrero/index.php');
INSERT INTO `modulo_paginas` VALUES ('653', '63', 'obrero/adjuntos_obrero.php');
INSERT INTO `modulo_paginas` VALUES ('654', '63', 'obrero/alta_obrero.php');
INSERT INTO `modulo_paginas` VALUES ('655', '63', 'obrero/descargar_adjunto.php');
INSERT INTO `modulo_paginas` VALUES ('656', '63', 'obrero/modificar_obrero.php');
INSERT INTO `modulo_paginas` VALUES ('657', '63', 'obrero/ver_obrero.php');
INSERT INTO `modulo_paginas` VALUES ('658', '63', 'obrero/subir_adjuntos_obrero.php');
INSERT INTO `modulo_paginas` VALUES ('659', '64', 'configuraciones/index.php');
INSERT INTO `modulo_paginas` VALUES ('660', '68', 'cobro_cuotas/index.php');
INSERT INTO `modulo_paginas` VALUES ('661', '66', 'panol/index.php');
INSERT INTO `modulo_paginas` VALUES ('662', '67', 'presupuesto/index.php');
INSERT INTO `modulo_paginas` VALUES ('663', '65', 'proveedor/index.php');
INSERT INTO `modulo_paginas` VALUES ('664', '60', 'unidad_funcional/index.php');
INSERT INTO `modulo_paginas` VALUES ('665', '60', 'unidad_funcional/alta_unidad_funcional.php');
INSERT INTO `modulo_paginas` VALUES ('666', '60', 'unidad_funcional/modificar_unidad_funcional.php');
INSERT INTO `modulo_paginas` VALUES ('667', '60', 'unidad_funcional/eliminar_unidad_funcional.php');
INSERT INTO `modulo_paginas` VALUES ('668', '64', 'tarea/alta_tarea.php');
INSERT INTO `modulo_paginas` VALUES ('669', '64', 'tarea/modificar_tarea.php');
INSERT INTO `modulo_paginas` VALUES ('670', '64', 'tarea/eliminar_tarea.php');
INSERT INTO `modulo_paginas` VALUES ('671', '64', 'tarea/index.php');
INSERT INTO `modulo_paginas` VALUES ('672', '64', 'hito/alta_hito.php');
INSERT INTO `modulo_paginas` VALUES ('673', '64', 'hito/modificar_hito.php');
INSERT INTO `modulo_paginas` VALUES ('674', '64', 'hito/index.php');
INSERT INTO `modulo_paginas` VALUES ('675', '64', 'hito/eliminar_hito.php');
INSERT INTO `modulo_paginas` VALUES ('676', '64', 'hito/hito_tarea.php');
INSERT INTO `modulo_paginas` VALUES ('677', '64', 'hito/configurar_hito_tarea.php');
INSERT INTO `modulo_paginas` VALUES ('678', '60', 'obra_civil/finalizar_tarea.php');
INSERT INTO `modulo_paginas` VALUES ('679', '60', 'obra_civil/configurar_hitos.php');
INSERT INTO `modulo_paginas` VALUES ('680', '69', 'planta/index.php');
INSERT INTO `modulo_paginas` VALUES ('681', '69', 'planta/alta_planta.php');
INSERT INTO `modulo_paginas` VALUES ('683', '62', 'contratos/contrato.php');
INSERT INTO `modulo_paginas` VALUES ('684', '69', 'planta/planta.php');
INSERT INTO `modulo_paginas` VALUES ('685', '70', 'contratos/alta_contrato.php');
INSERT INTO `modulo_paginas` VALUES ('686', '70', 'contratos/subir_contrato_adjunto.php');
INSERT INTO `modulo_paginas` VALUES ('687', '69', 'planta/ver_planta.php');
INSERT INTO `modulo_paginas` VALUES ('688', '71', 'trommel/alta_trommel.php');
INSERT INTO `modulo_paginas` VALUES ('689', '72', 'prensa/alta_prensa.php');
INSERT INTO `modulo_paginas` VALUES ('690', '73', 'cinta_transportadora/alta_cinta_transportadora.php');
INSERT INTO `modulo_paginas` VALUES ('691', '69', 'planta/planta_pieza.php');
INSERT INTO `modulo_paginas` VALUES ('692', '74', 'empleado/alta_empleado.php');
INSERT INTO `modulo_paginas` VALUES ('693', '74', 'empleado/adjuntos_empleado.php');
INSERT INTO `modulo_paginas` VALUES ('694', '74', 'empleado/descargar_adjunto.php');
INSERT INTO `modulo_paginas` VALUES ('695', '74', 'empleado/index.php');
INSERT INTO `modulo_paginas` VALUES ('696', '74', 'empleado/modificar_empleado.php');
INSERT INTO `modulo_paginas` VALUES ('697', '74', 'empleado/subir_adjuntos_empleado.php');
INSERT INTO `modulo_paginas` VALUES ('698', '74', 'empleado/ver_empleado.php');
INSERT INTO `obra_civil` VALUES ('1', '40', '2 y 59', '2015-12-16', '2013-02-04', '50', '800000', '1', '303', 'Edificio 2 y 59 - Oficinas');
INSERT INTO `obra_civil` VALUES ('2', '40', '2', '2015-04-29', '2015-04-01', '50x20', '4000000', '1', '307', 'Mejora');
INSERT INTO `obra_civil_hito` VALUES ('8', '1', '1', '1', '1');
INSERT INTO `obra_civil_hito` VALUES ('9', '2', '1', '2', '1');
INSERT INTO `obra_civil_hito` VALUES ('12', '1', '2', '1', '0');
INSERT INTO `obra_civil_hito` VALUES ('13', '2', '2', '2', '0');
INSERT INTO `obra_civil_hito` VALUES ('15', '12', '1', '3', '0');
INSERT INTO `obra_civil_hito_tarea` VALUES ('6', '8', '1', '1', '2015-04-30');
INSERT INTO `obra_civil_hito_tarea` VALUES ('7', '8', '2', '1', '2015-04-30');
INSERT INTO `obra_civil_hito_tarea` VALUES ('8', '8', '4', '1', '2015-05-01');
INSERT INTO `obra_civil_hito_tarea` VALUES ('9', '9', '3', '1', '2015-05-01');
INSERT INTO `obra_civil_hito_tarea` VALUES ('10', '9', '5', '1', '2015-05-01');
INSERT INTO `obra_civil_hito_tarea` VALUES ('11', '12', '1', '0', null);
INSERT INTO `obra_civil_hito_tarea` VALUES ('12', '12', '2', '0', null);
INSERT INTO `obra_civil_hito_tarea` VALUES ('13', '12', '4', '0', null);
INSERT INTO `obra_civil_hito_tarea` VALUES ('14', '13', '3', '0', null);
INSERT INTO `obra_civil_hito_tarea` VALUES ('15', '13', '5', '0', null);
INSERT INTO `obra_yeseria` VALUES ('1', 'Mejoramiento Teatro Argentino', '51 e/ 9 y 10', '2014-12-04', '2015-05-09', '1000550', '1', '303', '1', '0');
INSERT INTO `obra_yeseria` VALUES ('2', 'Mejoramiento Coliseo', '10 e/ 46 y 47', '2014-12-04', '2015-05-09', '907000', '1', '303', '2', '0');
INSERT INTO `obra_yeseria` VALUES ('3', 'Remodelar comercio 5', '38 e/ 9 y 10', '2014-12-04', '2015-05-09', '300000', '1', '303', '3', '0');
INSERT INTO `obra_yeseria` VALUES ('4', 'Mejoramiento edificio Policia Montada', '1 y 60', '2014-12-04', '2015-05-09', '540640', '1', '303', '4', '0');
INSERT INTO `obrero` VALUES ('1', 'Acosta', 'Agustin', '1', '36421777', '2', '355', '1900', '20364217774', '', '2015-04-27', '22', null, '1991-06-03', '152', null, null, null, null, null, null);
INSERT INTO `permiso` VALUES ('7707', '1', '51', '4');
INSERT INTO `permiso` VALUES ('7708', '1', '51', '1');
INSERT INTO `permiso` VALUES ('7709', '1', '51', '3');
INSERT INTO `permiso` VALUES ('7710', '1', '51', '2');
INSERT INTO `permiso` VALUES ('7711', '1', '52', '4');
INSERT INTO `permiso` VALUES ('7712', '1', '52', '1');
INSERT INTO `permiso` VALUES ('7713', '1', '52', '3');
INSERT INTO `permiso` VALUES ('7714', '1', '52', '2');
INSERT INTO `permiso` VALUES ('7715', '1', '53', '4');
INSERT INTO `permiso` VALUES ('7716', '1', '53', '1');
INSERT INTO `permiso` VALUES ('7717', '1', '53', '3');
INSERT INTO `permiso` VALUES ('7718', '1', '53', '2');
INSERT INTO `permiso` VALUES ('7719', '1', '54', '4');
INSERT INTO `permiso` VALUES ('7720', '1', '54', '1');
INSERT INTO `permiso` VALUES ('7721', '1', '54', '3');
INSERT INTO `permiso` VALUES ('7722', '1', '54', '2');
INSERT INTO `permiso` VALUES ('7723', '1', '56', '4');
INSERT INTO `permiso` VALUES ('7724', '1', '56', '1');
INSERT INTO `permiso` VALUES ('7725', '1', '56', '3');
INSERT INTO `permiso` VALUES ('7726', '1', '56', '2');
INSERT INTO `permiso` VALUES ('7727', '1', '58', '4');
INSERT INTO `permiso` VALUES ('7728', '1', '58', '1');
INSERT INTO `permiso` VALUES ('7729', '1', '58', '3');
INSERT INTO `permiso` VALUES ('7730', '1', '58', '2');
INSERT INTO `permiso` VALUES ('7731', '1', '57', '4');
INSERT INTO `permiso` VALUES ('7732', '1', '57', '1');
INSERT INTO `permiso` VALUES ('7733', '1', '57', '3');
INSERT INTO `permiso` VALUES ('7734', '1', '57', '2');
INSERT INTO `permiso` VALUES ('7735', '1', '55', '4');
INSERT INTO `permiso` VALUES ('7736', '1', '55', '1');
INSERT INTO `permiso` VALUES ('7737', '1', '55', '3');
INSERT INTO `permiso` VALUES ('7738', '1', '55', '2');
INSERT INTO `permiso` VALUES ('7739', '1', '59', '4');
INSERT INTO `permiso` VALUES ('7740', '1', '59', '1');
INSERT INTO `permiso` VALUES ('7741', '1', '59', '3');
INSERT INTO `permiso` VALUES ('7742', '1', '59', '2');
INSERT INTO `permiso` VALUES ('7743', '1', '62', '4');
INSERT INTO `permiso` VALUES ('7744', '1', '62', '1');
INSERT INTO `permiso` VALUES ('7745', '1', '62', '3');
INSERT INTO `permiso` VALUES ('7746', '1', '62', '2');
INSERT INTO `permiso` VALUES ('7747', '1', '60', '4');
INSERT INTO `permiso` VALUES ('7748', '1', '60', '1');
INSERT INTO `permiso` VALUES ('7749', '1', '60', '3');
INSERT INTO `permiso` VALUES ('7750', '1', '60', '2');
INSERT INTO `permiso` VALUES ('7751', '1', '61', '4');
INSERT INTO `permiso` VALUES ('7752', '1', '61', '1');
INSERT INTO `permiso` VALUES ('7753', '1', '61', '3');
INSERT INTO `permiso` VALUES ('7754', '1', '61', '2');
INSERT INTO `permiso` VALUES ('7755', '1', '63', '4');
INSERT INTO `permiso` VALUES ('7756', '1', '63', '1');
INSERT INTO `permiso` VALUES ('7757', '1', '63', '3');
INSERT INTO `permiso` VALUES ('7758', '1', '63', '2');
INSERT INTO `permiso` VALUES ('7759', '1', '64', '4');
INSERT INTO `permiso` VALUES ('7760', '1', '64', '1');
INSERT INTO `permiso` VALUES ('7761', '1', '64', '3');
INSERT INTO `permiso` VALUES ('7762', '1', '64', '2');
INSERT INTO `permiso` VALUES ('7763', '1', '68', '4');
INSERT INTO `permiso` VALUES ('7764', '1', '68', '1');
INSERT INTO `permiso` VALUES ('7765', '1', '68', '3');
INSERT INTO `permiso` VALUES ('7766', '1', '68', '2');
INSERT INTO `permiso` VALUES ('7767', '1', '66', '4');
INSERT INTO `permiso` VALUES ('7768', '1', '66', '1');
INSERT INTO `permiso` VALUES ('7769', '1', '66', '3');
INSERT INTO `permiso` VALUES ('7770', '1', '66', '2');
INSERT INTO `permiso` VALUES ('7771', '1', '67', '4');
INSERT INTO `permiso` VALUES ('7772', '1', '67', '1');
INSERT INTO `permiso` VALUES ('7773', '1', '67', '3');
INSERT INTO `permiso` VALUES ('7774', '1', '67', '2');
INSERT INTO `permiso` VALUES ('7775', '1', '65', '4');
INSERT INTO `permiso` VALUES ('7776', '1', '65', '1');
INSERT INTO `permiso` VALUES ('7777', '1', '65', '3');
INSERT INTO `permiso` VALUES ('7778', '1', '65', '2');
INSERT INTO `permiso` VALUES ('7779', '1', '69', '4');
INSERT INTO `permiso` VALUES ('7780', '1', '69', '1');
INSERT INTO `permiso` VALUES ('7781', '1', '69', '3');
INSERT INTO `permiso` VALUES ('7782', '1', '69', '2');
INSERT INTO `permiso` VALUES ('7783', '1', '70', '4');
INSERT INTO `permiso` VALUES ('7784', '1', '70', '1');
INSERT INTO `permiso` VALUES ('7785', '1', '70', '3');
INSERT INTO `permiso` VALUES ('7786', '1', '70', '2');
INSERT INTO `permiso` VALUES ('7787', '1', '71', '4');
INSERT INTO `permiso` VALUES ('7788', '1', '71', '1');
INSERT INTO `permiso` VALUES ('7789', '1', '71', '3');
INSERT INTO `permiso` VALUES ('7790', '1', '71', '2');
INSERT INTO `permiso` VALUES ('7791', '1', '73', '4');
INSERT INTO `permiso` VALUES ('7792', '1', '73', '1');
INSERT INTO `permiso` VALUES ('7793', '1', '73', '3');
INSERT INTO `permiso` VALUES ('7794', '1', '73', '2');
INSERT INTO `permiso` VALUES ('7795', '1', '72', '4');
INSERT INTO `permiso` VALUES ('7796', '1', '72', '1');
INSERT INTO `permiso` VALUES ('7797', '1', '72', '3');
INSERT INTO `permiso` VALUES ('7798', '1', '72', '2');
INSERT INTO `permiso` VALUES ('7799', '1', '74', '4');
INSERT INTO `permiso` VALUES ('7800', '1', '74', '1');
INSERT INTO `permiso` VALUES ('7801', '1', '74', '3');
INSERT INTO `permiso` VALUES ('7802', '1', '74', '2');
INSERT INTO `planta` VALUES ('1', 'verde', '2 y 59', '2015-12-16', '2013-02-04', '800000', '1', '303', 'Residuos Ayarza', '1', '6', '2016-02-08');
INSERT INTO `planta` VALUES ('2', 'azul', '2', '2015-04-29', '2015-04-01', '4000000', '1', '307', 'Residuos Esq', '2', '5', '2016-02-01');
INSERT INTO `planta` VALUES ('6', 'verde', 'Politecnico', '0000-00-00', '0000-00-00', '123456', '1', '37', 'aca no mas', '3', '6', '0000-00-00');
INSERT INTO `planta` VALUES ('7', 'verde', 'aca', '0000-00-00', '0000-00-00', '111111', '1', '712', 'xzxzz', '3', '6', '0000-00-00');
INSERT INTO `puesto` VALUES ('1', '1/2 OFICIAL');
INSERT INTO `puesto` VALUES ('2', '1/2 OFICIAL EN GENERAL');
INSERT INTO `puesto` VALUES ('3', 'ADM. SEMI SENIOR');
INSERT INTO `puesto` VALUES ('4', 'ADMINISTRATIVO JUNIOR');
INSERT INTO `puesto` VALUES ('5', 'ADMINISTRATIVO SEMI-SENIOR');
INSERT INTO `puesto` VALUES ('6', 'ADMINISTRATIVO SENIOR');
INSERT INTO `puesto` VALUES ('7', 'ADMINISTRATIVO SENIOR MULTIPLE');
INSERT INTO `puesto` VALUES ('8', 'ADMINISTRATIVO VIA Y OBRAS');
INSERT INTO `puesto` VALUES ('9', 'ANALISTA DE CIRCULACION');
INSERT INTO `puesto` VALUES ('10', 'ANALISTA RR.HH.');
INSERT INTO `puesto` VALUES ('11', 'APRENDIZ');
INSERT INTO `puesto` VALUES ('12', 'ASIS.B/PERS.PUESTO FIJO Y FORM');
INSERT INTO `puesto` VALUES ('13', 'ASIST.BIENES Y PER.EN PF Y FOR');
INSERT INTO `puesto` VALUES ('14', 'ASISTENTE ADMINISTRATIVO');
INSERT INTO `puesto` VALUES ('15', 'ASISTENTE TECNICO');
INSERT INTO `puesto` VALUES ('16', 'ASPIRANTE A AYUD. COND.');
INSERT INTO `puesto` VALUES ('17', 'ASPIRANTE A CONDUCTOR');
INSERT INTO `puesto` VALUES ('18', 'AUX. ADMIN. SENIOR MULTIPLE');
INSERT INTO `puesto` VALUES ('19', 'AUX. OPERATIVO INTERMEDIA A');
INSERT INTO `puesto` VALUES ('20', 'AUX. OPERATIVO INTERMEDIA B');
INSERT INTO `puesto` VALUES ('21', 'AUX.ADM.Ssr.BIENES Y PERSONAS');
INSERT INTO `puesto` VALUES ('22', 'AUX.MULTIPLE BIENES Y PERSONAS');
INSERT INTO `puesto` VALUES ('23', 'AUX.OP.INT.\"B\"(EST.CASEROS)');
INSERT INTO `puesto` VALUES ('24', 'AUX.OPER. BIENES Y PERSONAS');
INSERT INTO `puesto` VALUES ('25', 'Auxiliar Adm.sem.SR. B y P');
INSERT INTO `puesto` VALUES ('26', 'AUXILIAR ADMINISTRATIVO');
INSERT INTO `puesto` VALUES ('27', 'AUXILIAR CONTROL PASAJES');
INSERT INTO `puesto` VALUES ('28', 'AUXILIAR ENFERMERO');
INSERT INTO `puesto` VALUES ('29', 'AUXILIAR FISCALIZACION');
INSERT INTO `puesto` VALUES ('30', 'Auxiliar Multiple B y P');
INSERT INTO `puesto` VALUES ('31', 'AUXILIAR OPERATIVO 1RA.');
INSERT INTO `puesto` VALUES ('32', 'AUXILIAR OPERATIVO 2DA.');
INSERT INTO `puesto` VALUES ('33', 'AYUDANTE CONDUCTOR');
INSERT INTO `puesto` VALUES ('34', 'AYUDANTE CONDUCTOR HABILITADO');
INSERT INTO `puesto` VALUES ('35', 'AYUDANTE DE OFICIAL');
INSERT INTO `puesto` VALUES ('36', 'AYUDANTE OPERADOR DE C.C.E.E');
INSERT INTO `puesto` VALUES ('37', 'BANDERILLERO');
INSERT INTO `puesto` VALUES ('38', 'BOLETERO');
INSERT INTO `puesto` VALUES ('39', 'BOLETERO 1er. AÑO');
INSERT INTO `puesto` VALUES ('40', 'CAPATAZ CAMBISTA PLAYA RETIRO');
INSERT INTO `puesto` VALUES ('41', 'CAPATAZ DE VIA Y OBRAS');
INSERT INTO `puesto` VALUES ('42', 'CAPATAZ VIAS');
INSERT INTO `puesto` VALUES ('43', 'CHOFER MECANICO');
INSERT INTO `puesto` VALUES ('44', 'CONDUCTOR DIESEL');
INSERT INTO `puesto` VALUES ('45', 'CONDUCTOR ELECTRICO');
INSERT INTO `puesto` VALUES ('46', 'CONTROL DE ACCESO');
INSERT INTO `puesto` VALUES ('47', 'CONTROL DE ENERGIA');
INSERT INTO `puesto` VALUES ('48', 'CONTROL EN FORMACIONES');
INSERT INTO `puesto` VALUES ('49', 'CONTROLADOR');
INSERT INTO `puesto` VALUES ('50', 'CONTROLADOR DE MATERIALES');
INSERT INTO `puesto` VALUES ('51', 'COORDINADOR PROG.Y MANTEN.');
INSERT INTO `puesto` VALUES ('52', 'COORDINADOR PROGRAMADOR M.R.');
INSERT INTO `puesto` VALUES ('53', 'ENCARGADO  DE  BOLETERIA');
INSERT INTO `puesto` VALUES ('54', 'ENCARGADO DE BOLETERIAS');
INSERT INTO `puesto` VALUES ('55', 'ENCARGADO DE LIMPIEZA');
INSERT INTO `puesto` VALUES ('56', 'ENCARGADO DE LIMPIEZA (LGR)');
INSERT INTO `puesto` VALUES ('57', 'Encargado Limpieza');
INSERT INTO `puesto` VALUES ('58', 'ENFERMERO');
INSERT INTO `puesto` VALUES ('59', 'ENFERMERO/ A');
INSERT INTO `puesto` VALUES ('60', 'GUARDA PASO NIVEL');
INSERT INTO `puesto` VALUES ('61', 'GUARDABARRERA');
INSERT INTO `puesto` VALUES ('62', 'GUARDATREN');
INSERT INTO `puesto` VALUES ('63', 'INICIAL');
INSERT INTO `puesto` VALUES ('64', 'INSP. DE SEÑALAMIENTO');
INSERT INTO `puesto` VALUES ('65', 'INSPECTOR');
INSERT INTO `puesto` VALUES ('66', 'INSPECTOR CON CERTIFICADO');
INSERT INTO `puesto` VALUES ('67', 'INSPECTOR DE OBRAS');
INSERT INTO `puesto` VALUES ('68', 'INSPECTOR DE VIAS');
INSERT INTO `puesto` VALUES ('69', 'INSPECTOR SE?ALAMIENTO');
INSERT INTO `puesto` VALUES ('70', 'INSPECTOR VIA');
INSERT INTO `puesto` VALUES ('71', 'INSPECTOR/LF');
INSERT INTO `puesto` VALUES ('72', 'INSTRUCTOR CONDUCCION');
INSERT INTO `puesto` VALUES ('73', 'INSTRUCTOR TECNICO');
INSERT INTO `puesto` VALUES ('74', 'JEFE DE ESTACION DE 2DA. CAT.');
INSERT INTO `puesto` VALUES ('75', 'JEFE DE ESTACION DE 3RA. CAT.');
INSERT INTO `puesto` VALUES ('76', 'JEFE DEPARTAMENTO VIA Y OBRAS');
INSERT INTO `puesto` VALUES ('77', 'JEFE PCP');
INSERT INTO `puesto` VALUES ('78', 'JEFE RECURSOS HUMANOS');
INSERT INTO `puesto` VALUES ('79', 'LIQUIDADOR DE HABERES');
INSERT INTO `puesto` VALUES ('80', 'MEDICO');
INSERT INTO `puesto` VALUES ('81', 'OF.CAMBISTA P.RETIRO/P.JCPAZ');
INSERT INTO `puesto` VALUES ('82', 'OF.ESP.CAM.PLAT./PLAYA JCPAZ');
INSERT INTO `puesto` VALUES ('83', 'OFICIAL');
INSERT INTO `puesto` VALUES ('84', 'OFICIAL CAMBISTA');
INSERT INTO `puesto` VALUES ('85', 'OFICIAL DE CATENARIAS');
INSERT INTO `puesto` VALUES ('86', 'OFICIAL ESPECIAL.');
INSERT INTO `puesto` VALUES ('87', 'OFICIAL ESPECIALIZADO CAMBISTA');
INSERT INTO `puesto` VALUES ('88', 'OFICIAL ESPECIALIZADO EN GRAL.');
INSERT INTO `puesto` VALUES ('89', 'OFICIAL ESPECIALIZADO VIA');
INSERT INTO `puesto` VALUES ('90', 'OFICIAL SEAL');
INSERT INTO `puesto` VALUES ('91', 'OFICIAL TELEFONIA');
INSERT INTO `puesto` VALUES ('92', 'OFICIAL VIA');
INSERT INTO `puesto` VALUES ('93', 'OPERADOR PCP');
INSERT INTO `puesto` VALUES ('94', 'OPERADOR PCT');
INSERT INTO `puesto` VALUES ('95', 'OPERADOR PUESTO CONTROL TRENES');
INSERT INTO `puesto` VALUES ('96', 'OPERARIO DE CUADRILLA');
INSERT INTO `puesto` VALUES ('97', 'PANOLERO');
INSERT INTO `puesto` VALUES ('98', 'PATRULLERO DE VIAS');
INSERT INTO `puesto` VALUES ('99', 'PEON CAMBISTA');
INSERT INTO `puesto` VALUES ('100', 'Peon Desmalezado y Acarreo en');
INSERT INTO `puesto` VALUES ('101', 'PEON DESMALEZADO Y ACARREO GRA');
INSERT INTO `puesto` VALUES ('102', 'PEON GRAL. TAREAS FERROVIARIAS');
INSERT INTO `puesto` VALUES ('103', 'PEON LIMPIEZA;ACARREOyEN GRAL.');
INSERT INTO `puesto` VALUES ('104', 'PEON TAR.FERRO. Y DESMALEZADO');
INSERT INTO `puesto` VALUES ('105', 'PERSONAL CONTROL PUESTO FIJO');
INSERT INTO `puesto` VALUES ('106', 'SECRETARIA/O GERENCIA');
INSERT INTO `puesto` VALUES ('107', 'SEÑ. CABINA INTERMEDIA');
INSERT INTO `puesto` VALUES ('108', 'SEÑ. CABINA PRINCIPAL');
INSERT INTO `puesto` VALUES ('109', 'SEÑ. ENCARGADO CABINA PRINCIPA');
INSERT INTO `puesto` VALUES ('110', 'SEÑ. ENCARGADO DE CABINA \"U\"');
INSERT INTO `puesto` VALUES ('111', 'SEÑ. INSPECTOR/INSTRUCTOR');
INSERT INTO `puesto` VALUES ('112', 'SEÑALERO');
INSERT INTO `puesto` VALUES ('113', 'SEÑALERO ASPIRANTE');
INSERT INTO `puesto` VALUES ('114', 'SEÑALERO CABINA INTERMEDIA');
INSERT INTO `puesto` VALUES ('115', 'SEÑALERO CABINA PRINCIPAL');
INSERT INTO `puesto` VALUES ('116', 'SEÑALERO ENCARGADO CABINA PPAL');
INSERT INTO `puesto` VALUES ('117', 'SEÑALERO ENCARGADO DE CABINA U');
INSERT INTO `puesto` VALUES ('118', 'SEÑALERO INSPECTOR/ INSTRUCTOR');
INSERT INTO `puesto` VALUES ('119', 'SUB CAPATAZ VIA');
INSERT INTO `puesto` VALUES ('120', 'SUB. CAPATAZ DESMALEZADO');
INSERT INTO `puesto` VALUES ('121', 'SUB.CAPATAZ DE OBRA');
INSERT INTO `puesto` VALUES ('122', 'Sub.Capataz Desmalezado');
INSERT INTO `puesto` VALUES ('123', 'SUP.PERSONAL BIENES Y PERSONAS');
INSERT INTO `puesto` VALUES ('124', 'SUP.S Y T ALMACENES Y C. HERR.');
INSERT INTO `puesto` VALUES ('125', 'SUP.SEÑAL.MECANICO');
INSERT INTO `puesto` VALUES ('126', 'SUPERV. FISCALIZACION PASAJES');
INSERT INTO `puesto` VALUES ('127', 'SUPERV. GRAL. CONTROL CALIDAD');
INSERT INTO `puesto` VALUES ('128', 'Superv. Mantent.y Reparaciones');
INSERT INTO `puesto` VALUES ('129', 'SUPERV. TECNICO ADMINISTRATIVO');
INSERT INTO `puesto` VALUES ('130', 'SUPERVISOR C.C.P.');
INSERT INTO `puesto` VALUES ('131', 'SUPERVISOR CONTROL DE CALIDAD');
INSERT INTO `puesto` VALUES ('132', 'SUPERVISOR CONTROL DE CALIDDAD');
INSERT INTO `puesto` VALUES ('133', 'SUPERVISOR CONTROLADOR');
INSERT INTO `puesto` VALUES ('134', 'SUPERVISOR DE TURNO');
INSERT INTO `puesto` VALUES ('135', 'SUPERVISOR ELECTROMECANICO');
INSERT INTO `puesto` VALUES ('136', 'SUPERVISOR ESTACIONES');
INSERT INTO `puesto` VALUES ('137', 'SUPERVISOR FISCALIZAC.PASAJES');
INSERT INTO `puesto` VALUES ('138', 'SUPERVISOR INFRAESTRUCTURA');
INSERT INTO `puesto` VALUES ('139', 'SUPERVISOR MANT. ELECTRICO');
INSERT INTO `puesto` VALUES ('140', 'SUPERVISOR MANT. ELECTRONICO');
INSERT INTO `puesto` VALUES ('141', 'SUPERVISOR MANT.Y REPARACIONES');
INSERT INTO `puesto` VALUES ('142', 'SUPERVISOR MANTENIMIENTO');
INSERT INTO `puesto` VALUES ('143', 'SUPERVISOR MATERIAL RODANTE');
INSERT INTO `puesto` VALUES ('144', 'SUPERVISOR MECANICO');
INSERT INTO `puesto` VALUES ('145', 'SUPERVISOR OPERATIVO');
INSERT INTO `puesto` VALUES ('146', 'SUPERVISOR PCT');
INSERT INTO `puesto` VALUES ('147', 'Supervisor persona limpieza');
INSERT INTO `puesto` VALUES ('148', 'SUPERVISOR PERSONAL');
INSERT INTO `puesto` VALUES ('149', 'Supervisor Personal B Y P');
INSERT INTO `puesto` VALUES ('150', 'SUPERVISOR PROGRAM Y ESTADIST.');
INSERT INTO `puesto` VALUES ('151', 'SUPERVISOR PROGRAMACION');
INSERT INTO `puesto` VALUES ('152', 'SUPERVISOR PROGRAMACION Y EST.');
INSERT INTO `puesto` VALUES ('153', 'SUPERVISOR SE?AL. MECANICO');
INSERT INTO `puesto` VALUES ('154', 'SUPERVISOR SEÑALAMIENTO');
INSERT INTO `puesto` VALUES ('155', 'SUPERVISOR TELECOMUNICACIONES');
INSERT INTO `puesto` VALUES ('156', 'SUPERVISOR TURNO AT');
INSERT INTO `puesto` VALUES ('157', 'SUPV. MANTENIM. Y REPARAC. TMR');
INSERT INTO `puesto` VALUES ('158', 'SUPV. MATERIAL RODANTE DIESEL');
INSERT INTO `puesto` VALUES ('159', 'SUPV.CONTROL CALIDAD');
INSERT INTO `puesto` VALUES ('160', 'SUPV.MANT.MATL.RODANTE');
INSERT INTO `puesto` VALUES ('161', 'SUPV.MANTENIMI. Y REPARACIONES');
INSERT INTO `puesto` VALUES ('162', 'SUPV.PROGRAMACION Y ESTADISTIC');
INSERT INTO `puesto` VALUES ('163', 'TEC. TALLER LOCOMOTORAS');
INSERT INTO `puesto` VALUES ('164', 'TEC.MULTIPLE DE TELECOMUNICAC.');
INSERT INTO `puesto` VALUES ('165', 'TEC.MULTIPLE INFRA.EN SENALAM.');
INSERT INTO `puesto` VALUES ('166', 'TEC.SUP.DE TELECOMUNICACIONES');
INSERT INTO `puesto` VALUES ('167', 'TEC.SUP.TELECOMUNICACIONES');
INSERT INTO `puesto` VALUES ('168', 'TEC.TALLER COCHES');
INSERT INTO `puesto` VALUES ('169', 'TECNICO');
INSERT INTO `puesto` VALUES ('170', 'TECNICO CAMBISTA EST. TAPIALES');
INSERT INTO `puesto` VALUES ('171', 'TECNICO DE TALLER COCHES');
INSERT INTO `puesto` VALUES ('172', 'TECNICO ELECTRICISTA DE INFRA.');
INSERT INTO `puesto` VALUES ('173', 'TECNICO ELECTRONICO');
INSERT INTO `puesto` VALUES ('174', 'TECNICO EN GENERAL');
INSERT INTO `puesto` VALUES ('175', 'TECNICO EN INFORMATICO');
INSERT INTO `puesto` VALUES ('176', 'TECNICO EN TELECOMUNICACIONES');
INSERT INTO `puesto` VALUES ('177', 'TECNICO EN TELEFONIA');
INSERT INTO `puesto` VALUES ('178', 'TECNICO MANTENIMIENTO');
INSERT INTO `puesto` VALUES ('179', 'TECNICO MULTIPLE DE CATENARIAS');
INSERT INTO `puesto` VALUES ('180', 'TECNICO MULTIPLE M.RODANTE');
INSERT INTO `puesto` VALUES ('181', 'TECNICO MULTIPLE S.y T.,BAL,..');
INSERT INTO `puesto` VALUES ('182', 'TECNICO SEAL');
INSERT INTO `puesto` VALUES ('183', 'TECNICO TALLER LOCOMOTORAS');
INSERT INTO `puesto` VALUES ('184', 'CONDNICTOR DIESEL');
INSERT INTO `puesto` VALUES ('185', 'SEï¾‘. CABINA PRINCIPAL');
INSERT INTO `puesto` VALUES ('186', 'JEFE PCT');
INSERT INTO `puesto` VALUES ('187', 'SUP.SEï¾‘AL.MECANICO');
INSERT INTO `puesto` VALUES ('188', 'INSP. DE SEï¾‘ALAMIENTO');
INSERT INTO `puesto` VALUES ('189', 'SEï¾‘. ENCARGADO CABINA PRINCIPA');
INSERT INTO `puesto` VALUES ('190', 'SEï¾‘. INSPECTOR/INSTRUCTOR');
INSERT INTO `puesto` VALUES ('191', 'SEï¾‘. ENCARGADO DE CABINA \"U\"');
INSERT INTO `puesto` VALUES ('192', 'SUPERVISOR SEï¾‘ALAMIENTO');
INSERT INTO `puesto` VALUES ('193', 'INSTRUCTOR CONDNICCION');
INSERT INTO `puesto` VALUES ('194', 'AYUDANTE CONDNICTOR');
INSERT INTO `puesto` VALUES ('195', 'AYUDANTE CONDNICTOR HABILITADO');
INSERT INTO `puesto` VALUES ('196', 'SEï¾‘. CABINA INTERMEDIA');
INSERT INTO `puesto` VALUES ('197', 'SEï¾‘ALERO ASPIRANTE');
INSERT INTO `puesto` VALUES ('198', 'SEï¾‘ALERO CABINA PRINCIPAL');
INSERT INTO `puesto` VALUES ('199', 'SEï¾‘ALERO INSPECTOR/ INSTRUCTOR');
INSERT INTO `puesto` VALUES ('200', 'SEï¾‘ALERO ENCARGADO CABINA PPAL');
INSERT INTO `puesto` VALUES ('201', 'INSPECTOR SEï½¥ALAMIENTO');
INSERT INTO `puesto` VALUES ('202', 'SUPERVISOR SEï½¥AL. MECANICO');
INSERT INTO `puesto` VALUES ('203', 'SEï¾‘ALERO CABINA INTERMEDIA');
INSERT INTO `puesto` VALUES ('204', 'SEï¾‘ALERO ENCARGADO DE CABINA U');
INSERT INTO `puesto` VALUES ('205', 'SEï¾‘ALERO');
INSERT INTO `puesto` VALUES ('206', 'ANALISTA PLANEAM.ESTRATEGICO');
INSERT INTO `puesto` VALUES ('207', 'BOLETERO 1er. Aï¾‘O');
INSERT INTO `rol` VALUES ('1', 'Administrador', '0');
INSERT INTO `rol` VALUES ('2', 'Test', '0');
INSERT INTO `rol` VALUES ('3', 'Intermedio +', '0');
INSERT INTO `rol` VALUES ('4', 'Basico', '0');
INSERT INTO `sexo` VALUES ('1', 'F');
INSERT INTO `sexo` VALUES ('2', 'M');
INSERT INTO `tarea` VALUES ('1', 'Tarea 1', '1', '0');
INSERT INTO `tarea` VALUES ('2', 'Tarea 2', '2', '0');
INSERT INTO `tarea` VALUES ('3', 'Tarea 3', '1', '0');
INSERT INTO `tarea` VALUES ('4', 'Tarea 4', '3', '0');
INSERT INTO `tarea` VALUES ('5', 'Tarea 5', '1', '0');
INSERT INTO `tarea_hito` VALUES ('1', '1', '1', '2015-04-24');
INSERT INTO `tarea_hito` VALUES ('2', '2', '1', '2015-04-24');
INSERT INTO `tarea_hito` VALUES ('3', '4', '1', '2015-04-27');
INSERT INTO `tarea_hito` VALUES ('4', '3', '2', '2015-04-26');
INSERT INTO `tarea_hito` VALUES ('5', '5', '2', '2015-04-26');
INSERT INTO `tipo_acceso` VALUES ('1', 'Alta', '0');
INSERT INTO `tipo_acceso` VALUES ('2', 'Modificacion', '0');
INSERT INTO `tipo_acceso` VALUES ('3', 'Baja', '0');
INSERT INTO `tipo_acceso` VALUES ('4', 'Acceso', '0');
INSERT INTO `tipo_adjunto` VALUES ('1', 'PDF');
INSERT INTO `tipo_adjunto` VALUES ('2', 'Word');
INSERT INTO `tipo_adjunto` VALUES ('3', 'Excel');
INSERT INTO `tipo_adjunto` VALUES ('4', 'JPEG');
INSERT INTO `tipo_documento` VALUES ('1', 'DNI');
INSERT INTO `tipo_documento` VALUES ('2', 'Cedula');
INSERT INTO `tipo_documento` VALUES ('3', 'Pasaporte');
INSERT INTO `tipo_documento` VALUES ('4', 'LE');
INSERT INTO `tipo_documento` VALUES ('5', 'LC');
INSERT INTO `unidad_funcional` VALUES ('3', '1', '3', '14.00', 'A', '1', '45x20', '700000.00', 'observación', '1', '16');
INSERT INTO `unidad_funcional` VALUES ('4', '1', '3', '15.00', 'B', '1', '49x15', '700000.00', 'observación', '1', null);
INSERT INTO `unidad_funcional` VALUES ('5', '1', '3', '17.00', 'C', '1', '45x21', '800000.00', 'observación', '1', null);
INSERT INTO `unidad_funcional` VALUES ('6', '1', '1', '13.00', 'A', '1', '49x16', '550000.00', 'observación', '2', null);
INSERT INTO `unidad_funcional` VALUES ('7', '1', '2', '14.50', 'B', '2', '45x22', '600000.00', 'observación', '2', '16');
INSERT INTO `unidad_funcional` VALUES ('8', '1', '2', '14.40', 'C', '1', '49x17', '600000.00', 'observación', '2', '1');
INSERT INTO `unidad_funcional` VALUES ('9', '1', '2', '14.30', 'A', '2', '45x23', '600000.00', 'observación', '3', null);
INSERT INTO `unidad_funcional` VALUES ('10', '1', '2', '14.20', 'B', '1', '49x18', '600000.00', 'observación', '3', null);
INSERT INTO `unidad_funcional` VALUES ('11', '1', '1', '14.10', 'C', '1', '45x24', '450000.00', 'observación', '3', null);
INSERT INTO `unidad_funcional` VALUES ('12', '1', '1', '14.00', 'A', '2', '49x19', '450000.00', 'observación', '4', null);
INSERT INTO `unidad_funcional` VALUES ('13', '1', '1', '13.90', 'B', '1', '45x25', '450000.00', 'observación', '4', null);
INSERT INTO `unidad_funcional` VALUES ('14', '1', '2', '13.80', 'C', '1', '49x20', '580000.00', 'observación', '4', null);
INSERT INTO `unidad_funcional` VALUES ('15', '1', '2', '13.70', 'A', '2', '45x26', '670000.00', 'observación', '5', null);
INSERT INTO `unidad_funcional` VALUES ('16', '1', '1', '13.60', 'B', '1', '49x21', '570000.00', 'observación', '5', null);
INSERT INTO `unidad_funcional` VALUES ('17', '1', '2', '13.50', 'C', '1', '45x27', '670000.00', 'observación', '5', null);
INSERT INTO `unidad_funcional` VALUES ('18', '1', '3', '13.40', 'A', '1', '49x22', '900000.00', 'observación', '6', null);
INSERT INTO `unidad_funcional` VALUES ('19', '1', '3', '13.30', 'B', '2', '45x28', '900000.00', 'observación', '6', null);
INSERT INTO `unidad_funcional` VALUES ('20', '1', '3', '13.20', 'A', '2', '49x23', '900000.00', 'observación', '7', null);
INSERT INTO `unidad_funcional` VALUES ('21', '1', '3', '13.10', 'B', '1', '45x29', '900000.00', 'observación', '7', null);
INSERT INTO `usuario` VALUES ('152', 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@admin.com', '', '', '0');
INSERT INTO `usuario_rol` VALUES ('177', '152', '1', '5');
