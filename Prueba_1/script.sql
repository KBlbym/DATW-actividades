CREATE DATABASE IF NOT EXISTS `ventaDeCoches`;
USE `ventaDeCoches`;

--CREAR TABLA Coche
CREATE TABLE IF NOT EXISTS `coche` (
    `id_coche` INT NOT NULL AUTO_INCREMENT,
    `marca` varchar(50)  NOT NULL,
    PRIMARY KEY (`id_coche`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Crear la TABLA  `modelo` SI NO EXISTE
CREATE TABLE IF NOT EXISTS `modelo` (
    `id_modelo` int NOT NULL AUTO_INCREMENT,
    `anyo_de_fabricacion` DATE NOT NULL,
    `modelo` varchar(50)  NOT NULL,
    `num_puertas` INT NOT NULL,
    `id_coche` INT NOT NULL,
    PRIMARY KEY (`id_modelo`),
    KEY `INDICE` (`id_coche`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




--CREAR Tabla matricula
--pasodo en que puede ver varios coche del mismo modelo con diferentes matriculas
CREATE TABLE IF NOT EXISTS `matricula` (
    `id_matricula` int NOT NULL AUTO_INCREMENT,
    `num_matricula` VARCHAR(10) NOT NULL,
    `color` VARCHAR(20) NOT NULL,
    `metros` INT NOT NULL,
    `precio` DECIMAL(6,2) NOT NULL,
    `isVendido` BOOLEAN NOT NULL,
    `id_modelo` INT NOT NULL,
    PRIMARY KEY (`id_matricula`),
    KEY `INDICE_MODELO` (`id_modelo`),
    UNIQUE KEY `Numero_Matricula` (`num_matricula`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--CREAR Tabla venta
CREATE TABLE IF NOT EXISTS `venta` (
    `id_venta` INT NOT NULL AUTO_INCREMENT,
    `fecha_de_venta` DATETIME  NOT NULL,
    `id_vendedor` INT,
    `id_cliente` INT,
    `id_matricula` INT NOT NULL,
    PRIMARY KEY (`id_venta`),
    KEY `INDICE_VENDIDOR` (`id_vendedor`),
    KEY `INDICE_Comprador` (`id_cliente`),
    KEY `INDICE_MATRICULA` (`id_matricula`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--CREAR TABLA vendedor
CREATE TABLE IF NOT EXISTS `vendedor` (
    `id_vendedor` int NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(30) NOT NULL,
    `identificador` VARCHAR(20) NOT NULL,
    `salarioBase` DECIMAL(5,2) NOT NULL,
    `aumentoBase` INT,
    `fecha_inicio` DATE NOT NULL,
    `comesion` INT,
    PRIMARY KEY (`id_vendedor`),
    UNIQUE KEY `Numero_identificador` (`identificador`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--CREAR TABLA cliente
CREATE TABLE IF NOT EXISTS `cliente` (
    `id_cliente` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(30) NOT NULL,
    `apellidos` VARCHAR(50) NOT NULL,
    `DNI` VARCHAR(9) NOT NULL,
    `id_direccion` INT NOT NULL,
    PRIMARY KEY (`id_cliente`),
    UNIQUE KEY `Numero_DNI` (`DNI`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


--CREAR TABLA direccion
CREATE TABLE IF NOT EXISTS `direccion` (
    `id_direccion` INT NOT NULL AUTO_INCREMENT,
    `tipo_via` VARCHAR(10) NOT NULL,
    `nombre_via` VARCHAR(15) NOT NULL,
    `numero` INT NOT NULL,
    `cp` INT(5) NOT NULL,
    `otra_info` VARCHAR(100),
    `id_municipio` INT NOT NULL,
    PRIMARY KEY (`id_direccion`),
    KEY `INDICE_municipio` (`id_municipio`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


--CREAR TABLA municipio
CREATE TABLE IF NOT EXISTS `municipio` (
    `id_municipio` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(20) NOT NULL,
    `id_provincia` INT NOT NULL,
    PRIMARY KEY (`id_municipio`),
    KEY `INDICE_Provinicia` (`id_provincia`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


--CREAR TABLA provincia
CREATE TABLE IF NOT EXISTS `provincia` (
    `id_provincia` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(20) NOT NULL,
    `id_pais` INT NOT NULL,
    PRIMARY KEY (`id_provincia`),
    KEY `INDICE_Pais` (`id_pais`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--CREAR TABLA pais
CREATE TABLE IF NOT EXISTS `pais` (
    `id_pais` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id_pais`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

---------------------------
--CREAR REalciones---------
---------------------------

--relacionar tabla modelo con marca de coche--
ALTER TABLE `modelo`
  ADD CONSTRAINT `FK_modelo_coche` 
  FOREIGN KEY (`id_coche`) 
  REFERENCES `coche` (`id_coche`) 
  ON DELETE CASCADE ON UPDATE CASCADE;
  --Si se borra una marca de coche se borrara todos los modelos de ese coche

  --relacionar tabla matricula con marca de modelo
  ALTER TABLE `matricula`
  ADD CONSTRAINT `FK_matricula_modelo` 
  FOREIGN KEY (`id_modelo`) 
  REFERENCES `modelo` (`id_modelo`)
  ON DELETE CASCADE ON UPDATE CASCADE;
  --Si se borra una modelo de coche se borrará todos los matriculas.
  --No tiene sentido que haya un coche con una matricula si no existe el modelo de ese coche.

--relacionar tabla venta con marca de matricula--
--Una vez realizada la venta no se puede borrar.
ALTER TABLE `venta`
  ADD CONSTRAINT `FK_venta_matricula` 
  FOREIGN KEY (`id_matricula`) 
  REFERENCES `matricula` (`id_matricula`) 
  ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_venta_vendedor` 
  FOREIGN KEY (`id_vendedor`) 
  REFERENCES `vendedor` (`id_vendedor`) 
  ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_venta_cliente` 
  FOREIGN KEY (`id_cliente`) 
  REFERENCES `cliente` (`id_cliente`) 
  ON DELETE SET NULL ON UPDATE CASCADE;

   --relacionar tabla cliente con direccion
  ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_cliente_direcion` 
  FOREIGN KEY (`id_direccion`) 
  REFERENCES `direccion` (`id_direccion`)
  ON DELETE NO ACTION ON UPDATE CASCADE;

--relacionar tabla direccion con municipio
--con on delete cascade si se borrar un municipio se borrar todas las direccion de esa municipio
--por lo tanto no permetemos que se borra un municipio si hay un direccion que le pertence
  ALTER TABLE `direccion`
  ADD CONSTRAINT `FK_direccion_municipio` 
  FOREIGN KEY (`id_municipio`) 
  REFERENCES `municipio` (`id_municipio`)
  ON DELETE NO ACTION ON UPDATE CASCADE;


  --relacionar tabla municipio con provincia
--con on delete cascade si se borrar un provincia se borrar todas las municipios de esa provencia
--por lo tanto no permetemos que se borra un provincia si hay un municipio que le pertence los mismo con el pais
  ALTER TABLE `municipio`
  ADD CONSTRAINT `FK_municipio_provincia` 
  FOREIGN KEY (`id_provincia`) 
  REFERENCES `provincia` (`id_provincia`)
  ON DELETE NO ACTION ON UPDATE CASCADE;




--relacionar tabla  provincia con el pais
  ALTER TABLE `provincia`
  ADD CONSTRAINT `FK_provincia_pais` 
  FOREIGN KEY (`id_pais`) 
  REFERENCES `pais` (`id_pais`)
  ON DELETE NO ACTION ON UPDATE CASCADE;



 
