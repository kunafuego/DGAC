CREATE OR REPLACE FUNCTION importar_usuario()

RETURNS void AS $$

DECLARE
  admin_usuario RECORD;
  compañia RECORD;
  pasajero RECORD;
  tupla_compañia RECORD;
  tupla_pasajero RECORD;
  valor_contraseña VARCHAR(40);

BEGIN
  -- Se buscan los tipos de usuarios

  SELECT * INTO admin_usuario FROM usuarios WHERE username = 'DGAC';
  SELECT * INTO compañia FROM usuarios where tipo = 'Compañía aérea' LIMIT 1;
  SELECT * INTO pasajero FROM usuarios where tipo = 'pasajero' LIMIT 1;

  IF admin_usuario IS NULL THEN
    INSERT INTO usuarios (username, tipo, contraseña) VALUES ('DGAC', 'Admin DGAC', 'admin');
  -- Debemos crear el usuario admin
  END IF;

  -- Vemos si existe la compañia
  IF compañia IS NULL THEN

    FOR tupla_compañia IN (SELECT * FROM aerolinea)

    LOOP
      -- Generar contraseña
      SELECT floor(random() * (999999999-10000000 + 1) + 10000000) INTO valor_contraseña;
      INSERT INTO usuarios (username, tipo, contraseña) VALUES (tupla_compañia.codigo_aerolinea, 'Compañía aérea', valor_contraseña);
    END LOOP;
  END IF;  

  -- Vemos si pasajeros fue creado
  IF pasajero IS NULL THEN
  -- Se deben crear los pasajeros
    FOR tupla_pasajero IN (SELECT * FROM pasajeros)

    LOOP
    -- Generar contraseña
    SELECT concat(repeat(length(tupla_pasajero.pasaporte)::text, floor(random()*10)::int),  repeat(length(tupla_pasajero.nombre)::text, floor(random()*10)::int)) INTO valor_contraseña;
      INSERT INTO usuarios (username, tipo, contraseña) VALUES (tupla_pasajero.pasaporte, 'Pasajero', valor_contraseña);
  END LOOP;
  END IF;

END 
$$ language plpgsql