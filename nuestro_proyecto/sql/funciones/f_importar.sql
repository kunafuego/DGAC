CREATE OR REPLACE FUNCTION importar_usuario
  (p1_id integer, p2_id integer, OUT w_name varchar, OUT attacks integer)
  -- Arriba se espesificó que se entrega w_name como OUTput
  -- Esto permite retornar output en formato de tabla
  LANGUAGE plpgsql AS $$
DECLARE
  admin_usuario RECORD;
  compañia RECORD;
  pasajero RECORD;
  tupla_compañia RECORD;
  tupla_pasajero RECORD;

BEGIN
  -- Se buscan los tipos de usuarios

  SELECT * INTO admin_usuario FROM usuarios WHERE username = "DGAC";
  SELECT * INTO compañia FROM usuarios where tipo = "compañia" LIMIT 1;
  SELECT * INTO pasajero FROM usuarios where tipo = "pasajero" LIMIT 1;

  -- Vemos si existe el admin
  IF admin_usuario IS NULL THEN

  -- Debemos crear el usuario admin
  END IF;

  -- Vemos si existe la compañia
  IF compañia IS NULL THEN
  FOR tupla_compañia IN (SELECT * FROM compañias)
  -- Debemos crear a los usuarios de las compañias
  END IF;  

  -- Vemos si pasajeros fue creado
  IF pasajero IS NULL THEN
  -- Se deben crear los pasajeros
  END IF

END 
$$