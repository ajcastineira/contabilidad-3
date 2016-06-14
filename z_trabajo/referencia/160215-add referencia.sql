ALTER TABLE `tbmispedidos`
	ADD COLUMN `Referencia` VARCHAR(70) NULL DEFAULT NULL AFTER `CC_Trans`;

ALTER TABLE `tbmisfacturas`
	ADD COLUMN `Referencia` VARCHAR(70) NULL AFTER `asiento`;

ALTER TABLE `tbmisfacturas`
	ADD COLUMN `CC_Trans` VARCHAR(30) NULL DEFAULT NULL AFTER `Referencia`;
