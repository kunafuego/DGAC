CREATE OR REPLACE FUNCTION pass()

RETURNS text AS $$

DECLARE
  valor_contraseña VARCHAR(30);

BEGIN

        -- SELECT (floor(random() * (999999999-10000000 + 1) + 10000000))::varchar(30) INTO valor_contraseña;
    SELECT concat(repeat(length('VPA15631202')::text, floor(random()*10)::int),  repeat(length('DOMINGO AGUERO')::text, floor(random()*10)::int)) INTO valor_contraseña;
    RETURN valor_contraseña;

END 
$$ language plpgsql