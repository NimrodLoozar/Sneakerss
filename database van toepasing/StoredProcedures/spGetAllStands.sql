/******************************************************
-- Versie:  01
-- Datum:   25-10-2024
-- Auteur:  Thomas Tadesse
******************************************************/

-- Selecteer de juiste database voor je stored procedure
use `astronomie`;

-- Verwijder de oude stored procedure
DROP PROCEDURE IF EXISTS spGetAllStands;

-- Verander even tijdelijk de opdrachtprompt naar //
DELIMITER //
CREATE PROCEDURE spGetAllStands()
BEGIN
    SELECT * FROM stands;
END //
DELIMITER ;


/************* debug code stored procedure **************

CALL spGetAllStands();

********************************************************/



