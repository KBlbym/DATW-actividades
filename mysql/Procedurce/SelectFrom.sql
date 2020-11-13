
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectFrom`(IN tableName VARCHAR (100))
BEGIN
	SET @table = tableName;
	SET @query = CONCAT('SELECT * FROM ', @table);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$
