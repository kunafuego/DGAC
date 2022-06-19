CREATE OR REPLACE FUNCTION fib (
    numero integer
) RETURNS integer AS $$

DECLARE 
    largo 
BEGIN
    IF numero < 2 THEN
        RETURN numero;
    END IF;
SET largo = 
RETURN fib(numero - 2) + fib(numero - 1);
END;
$$ language plpgsql