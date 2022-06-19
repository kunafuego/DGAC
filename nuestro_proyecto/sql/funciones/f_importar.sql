CREATE OR REPLACE FUNCTION importar_usuario()

RETURNS void AS $$

DECLARE
  admin_usuario RECORD;
  compañia RECORD;
  pasajero RECORD;
  tupla_compañia RECORD;
  tupla_pasajero RECORD;

BEGIN
  -- Se buscan los tipos de usuarios

  SELECT * INTO admin_usuario FROM usuarios WHERE username = 'DGAC';
  SELECT * INTO compañia FROM usuarios where tipo = 'Compañía aérea' LIMIT 1;
  SELECT * INTO pasajero FROM usuarios where tipo = 'pasajero' LIMIT 1;

  -- Vemos si existe el admin
  raise notice 'Value: %', admin_usuario;
  IF admin_usuario IS NULL THEN
    INSERT INTO usuarios (username, tipo, contraseña) VALUES ('DGAC', 'Admin DGAC', 'admin');
  -- Debemos crear el usuario admin
  END IF;

  -- Vemos si existe la compañia
  IF compañia IS NULL THEN

    FOR tupla_compañia IN (SELECT * FROM compañias)

    LOOP
      -- Generar contraseña
      INSERT INTO usuarios (username, tipo, contraseña) VALUES (tupla_compañia.codigo_aerolinea, "Compañía aérea", contraseña)
    END LOOP
  END IF;  

  -- Vemos si pasajeros fue creado
  IF pasajero IS NULL THEN
  -- Se deben crear los pasajeros
  END IF

END 
$$ language plpgsql