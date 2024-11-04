/******************************************************
-- Versie:  01
-- Datum:   25-10-2024
-- Auteur:  Thomas Tadesse
******************************************************/

-- Selecteer de juiste database voor je stored procedure
use `astronomie`;

-- Verwijder de oude stored procedure
DROP PROCEDURE IF EXISTS spUpdateStandById;

-- Verander even tijdelijk de opdrachtprompt naar //
DELIMITER //
CREATE PROCEDURE spUpdateStandById(
    IN p_id INT,
    IN p_plain_id INT,
    IN p_stand_number VARCHAR(50),
    IN p_is_available TINYINT(1)
)
BEGIN
    UPDATE stands
    SET plain_id = p_plain_id,
        stand_number = p_stand_number,
        is_available = p_is_available
    WHERE id = p_id;
END //
DELIMITER ;


/************* debug code stored procedure **************

CALL spUpdateStandById(1, 1, 'A1', 1);

********************************************************/



