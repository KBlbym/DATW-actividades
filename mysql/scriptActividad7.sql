CREATE DATABASE IF NOT EXISTS `actividad7_ciclismo`;
USE `actividad7_ciclismo`;

-- Crear la TABLA  `persona` SI NO EXISTE
CREATE TABLE IF NOT EXISTS `personas` (
    `id_persona` int NOT NULL AUTO_INCREMENT,
    `fecha_naci` DATETIME NOT NULL,
    `nombre` varchar(50)  NOT NULL,
    `role` VARCHAR(30) NOT NULL,
    `id_nacionalidad` INT NOT NULL,
    PRIMARY KEY (`id_persona`),
    KEY `INDICE` (`id_nacionalidad`)
);

--CREAR TABLA NACIONALIDAD
CREATE TABLE IF NOT EXISTS `nacionalidades` (
    `id_nacionalidad` INT NOT NULL AUTO_INCREMENT,
    `pais` varchar(50)  NOT NULL,
    PRIMARY KEY (`id_nacionalidad`)
);


--CREAR Tabla Equipo
CREATE TABLE IF NOT EXISTS `contratos` (
    `id_contrato` int NOT NULL AUTO_INCREMENT,
    `fecha_inicio` DATETIME NOT NULL,
    `fecha_fin` DATETIME NOT NULL,
    `id_equipo` INT NOT NULL,
    `id_persona` INT NOT NULL,
    PRIMARY KEY (`id_contrato`),
    KEY `INDICE_PERSONA` (`id_persona`),
    KEY `INDICE_EQUIPO` (`id_equipo`)
);

--CREAR Tabla Equipo
CREATE TABLE IF NOT EXISTS `equipos` (
    `id_equipo` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50)  NOT NULL,
    `id_nacionalidad` INT NOT NULL,
    PRIMARY KEY (`id_equipo`),
    KEY `INDICE_NACIONALIDAD` (`id_nacionalidad`)
);

--CREAR TABLA PRUEBA
CREATE TABLE IF NOT EXISTS `pruebas` (
    `id_prueba` int NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(30) NOT NULL,
    `anyo` INT NOT NULL,
    `kms_totales` INT NOT NULL,
    `num_etapas` INT NOT NULL,
    `id_persona` INT NOT NULL,
    PRIMARY KEY (`id_prueba`),
    KEY `INDICE_PERSONA` (`id_persona`)
);

--CREAR TABLA EQUIPO_PRUEBA
CREATE TABLE IF NOT EXISTS `equipo_prueba` (
    `id_equipo` int NOT NULL,
    `id_prueba` int NOT NULL,
    `puesto` INT NOT NULL,
    KEY `Indice_equipo` (`id_equipo`),
    KEY `Indice_prueba` (`id_prueba`)
);

--------------------
--CREAR RELACIONES--
--------------------

--ralacionar la tabla personas con nacionalidades
ALTER TABLE `personas`
ADD CONSTRAINT `fk_persona_nacionalidad`
    FOREIGN KEY (`id_nacionalidad`)
    REFERENCES `nacionalidades` (`id_nacionalidad`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

--ralacionar la tabla contratos con equipos y personas
ALTER TABLE `contratos`
ADD CONSTRAINT `fk_contrato_persona`
    FOREIGN KEY (`id_persona`)
    REFERENCES `personas` (`id_persona`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
ADD CONSTRAINT `fk_contrato_equipo`
    FOREIGN KEY (`id_equipo`)
    REFERENCES `equipos` (`id_equipo`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

--ralacionar la tabla equipos con nacionalidades
ALTER TABLE `equipos`
ADD CONSTRAINT `fk_equipo_nacionalidad`
    FOREIGN KEY (`id_nacionalidad`)
    REFERENCES `nacionalidades` (`id_nacionalidad`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

--ralacionar la tabla prueba con persona
ALTER TABLE `pruebas`
ADD CONSTRAINT `fk_prueba_persona`
    FOREIGN KEY (`id_persona`)
    REFERENCES `personas` (`id_persona`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

--ralacionar la tabla equipos con prueba mucho a mucho
ALTER TABLE `equipo_prueba`
ADD CONSTRAINT `FK_equipo` 
    FOREIGN KEY (`id_equipo`) 
    REFERENCES `equipos` (`id_equipo`) 
    ON DELETE CASCADE
    ON UPDATE CASCADE,
ADD CONSTRAINT `FK_prueba`
    FOREIGN KEY (`id_prueba`) 
    REFERENCES `pruebas` (`id_prueba`)
    ON DELETE CASCADE 
    ON UPDATE CASCADE;


