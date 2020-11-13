--
-- Base de datos: `matricula_scpt si no existe`
--
CREATE DATABASE IF NOT EXISTS `matricula_scpt`;

--Usar la base de datos matricula_scpt
USE `matricula_scpt`;
------------------------------------

-- Crear la TABLA  `alumno` SI NO EXISTE

CREATE TABLE IF NOT EXISTS `alumno` (
  `id_alumno` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_alumno` varchar(7)  NOT NULL,
  `nombre` varchar(50)  NOT NULL,
  `apellido_1` varchar(50)  NOT NULL,
  `apellido_2` varchar(50),
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `codigo_alumno` (`codigo_alumno`)
);

--INSERTAR DATOS EN LA TABLA ALUMNO
-- INSERT INTO `alumno` (`id_alumno`, `codigo_alumno`, `nombre`, `apellido_1`, `apellido_2`) VALUES
-- (1, 'GO123', 'khalifa', 'BOULBAYEM', NULL),
-- (2, 'GO124', 'Ayose', 'Andrue', NULL),
-- (3, 'GO125', 'Luis', 'Hernandez', NULL),
-- (4, 'GO126', 'Fatima', 'Mendes', NULL);


--CREAR TABLA CURSO
CREATE TABLE IF NOT EXISTS `curso` (
    `id_curso` int NOT NULL AUTO_INCREMENT,
    `codigo_curso` varchar(5) NOT NULL,
    `nombre` varchar(50) NOT NULL,
    `especialidad` varchar(50) NOT NULL,
    `grupo` varchar(50) NOT NULL,
    `id_docente` int NOT NULL,
    PRIMARY KEY (`id_curso`),
    UNIQUE KEY `CODIGO_CURSO` (`codigo_curso`),
    KEY `INDICE` (`id_docente`)
);

--CREAR TABLA ALUMNO_CURSO
CREATE TABLE IF NOT EXISTS `alumno_curso` (
  `id_alumno` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  KEY `Indice_alumno` (`id_alumno`),
  KEY `Indice_curso` (`id_curso`)
);

CREATE TABLE IF NOT EXISTS `docente` (
  `Id_docente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido_1` varchar(50)  NOT NULL,
  `apellido_2` varchar(50),
  `oficina` varchar(6)  NOT NULL,
  PRIMARY KEY (`Id_docente`)
);

--INSERTAR DATOS EN DOCENTE
-- INSERT INTO `docente` (`Id_docente`, `nombre`, `apellido_1`, `apellido_2`, `oficina`) VALUES
-- (1, 'Rayco', 'Guerra', 'Damaso', 'BG123'),
-- (2, 'Julian', 'Dominguez', 'Alvarez', 'BG124'),
-- (3, 'Antonio', 'Machado',  'Ruiz', 'BG125'),
-- (4, 'Jose Luis', 'Andres', 'Luis', 'BG126');

--Crear relaciones
ALTER TABLE `alumno_curso`
  ADD CONSTRAINT `FK_Alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `curso`
  ADD CONSTRAINT `FK_Curso_Docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`Id_docente`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;