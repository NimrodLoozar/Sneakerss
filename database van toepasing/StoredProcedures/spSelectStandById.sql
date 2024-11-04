/******************************************************
-- Versie:  01
-- Datum:   25-10-2024
-- Auteur:  Thomas Tadesse
******************************************************/

-- Selecteer de juiste database voor je stored procedure
use `astronomie`;

-- Verwijder de oude stored procedure
DROP PROCEDURE IF EXISTS spSelectStandById;

-- Verander even tijdelijk de opdrachtprompt naar //
DELIMITER //
CREATE PROCEDURE spSelectStandById(
    IN p_id INT
)
BEGIN
    SELECT * FROM stands
    WHERE id = p_id;
END //
DELIMITER ;


/************* debug code stored procedure **************

CALL spSelectStandById(1);

********************************************************/



