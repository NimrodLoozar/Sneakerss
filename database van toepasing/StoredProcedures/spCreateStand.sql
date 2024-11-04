/******************************************************
-- Versie:  01
-- Datum:   25-10-2024
-- Auteur:  Thomas Tadesse
******************************************************/

-- Selecteer de juiste database voor je stored procedure
use `astronomie`;

-- Verwijder de oude stored procedure
DROP PROCEDURE IF EXISTS spCreateStand;

-- Verander even tijdelijk de opdrachtprompt naar //
DELIMITER //
CREATE PROCEDURE spCreateStand(
    IN p_plain_id INT,
    IN p_stand_number VARCHAR(50),
    IN p_is_available TINYINT(1)
)
BEGIN
    INSERT INTO stands (plain_id, stand_number, is_available)
    VALUES (p_plain_id, p_stand_number, p_is_available);
END //
DELIMITER ;


/************* debug code stored procedure **************

CALL spCreateStand(1, 'A1', 1);

********************************************************/



