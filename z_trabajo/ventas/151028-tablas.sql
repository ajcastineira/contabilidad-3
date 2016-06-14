CREATE TABLE `tbventas_bancos` (
	`IdBanco` INT(11) NOT NULL,
	`Fecha` DATE NOT NULL,
	`Cantidad_distribuir` DOUBLE NULL DEFAULT NULL,
	`Distribuir` TINYINT(4) NULL DEFAULT NULL,
	`Cantidad` DOUBLE NULL DEFAULT NULL,
	`Cuenta` INT(9) NULL DEFAULT NULL,
	`Asiento` VARCHAR(10) NULL DEFAULT NULL,
	`Borrado` TINYINT(4) NULL DEFAULT NULL COMMENT '1= Valido, 0= Borrado',
	PRIMARY KEY (`IdBanco`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `tbventas_tarjetas` (
	`IdTarjeta` INT(11) NOT NULL,
	`Fecha` DATE NOT NULL,
	`TipoTarjeta` VARCHAR(15) NULL DEFAULT NULL,
	`Bruto` DOUBLE NULL DEFAULT NULL,
	`Comision` DOUBLE NULL DEFAULT NULL,
	`Liquido` DOUBLE NULL DEFAULT NULL,
	`CuentaTarjeta` INT(9) NULL DEFAULT NULL,
	`Asiento` VARCHAR(10) NULL DEFAULT NULL,
	`Borrado` TINYINT(4) NULL DEFAULT NULL COMMENT '1= Valido, 0= Borrado',
	PRIMARY KEY (`IdTarjeta`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

