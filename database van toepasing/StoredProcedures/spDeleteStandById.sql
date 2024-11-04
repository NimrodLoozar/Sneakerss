/******************************************************
-- Versie:  01
-- Datum:   25-10-2024
-- Auteur:  Thomas Tadesse
******************************************************/

-- Selecteer de juiste database voor je stored procedure
use `astronomie`;

-- Verwijder de oude stored procedure
DROP PROCEDURE IF EXISTS spDeleteStandById;

-- Verander even tijdelijk de opdrachtprompt naar //
DELIMITER //
CREATE PROCEDURE spDeleteStandById(
    IN p_id INT
)
BEGIN
    DELETE FROM stands
    WHERE id = p_id;
END //
DELIMITER ;


/************* debug code stored procedure **************

CALL spDeleteStandById(2);

********************************************************/



