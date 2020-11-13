DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertData`(IN tableName VARCHAR (100))
BEGIN
	SET @table = tableName;
	SET @query = CONCAT('INSERT INTO ', @table, );
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$