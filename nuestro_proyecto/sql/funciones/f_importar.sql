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
  
  IF  EXISTS(SELECT FROM pg_tables WHERE tablename='usuarios') THEN
	admin_usuario := TRUE;
	compañia := TRUE;
	pasajero := TRUE;
  ELSE 
	admin_usuario := NULL;
	compañia := NULL;
	pasajero := NULL;
	create table usuarios(
	id SERIAL PRIMARY KEY,
	username varchar(25),
	tipo varchar(45),
	contraseña varchar(50));
					
  END IF;


  IF admin_usuario IS NULL THEN
    INSERT INTO usuarios (username, tipo, contraseña) VALUES ('DGAC', 'Admin DGAC', 'admin');
  END IF;

  -- Vemos si existe la compañia
  IF compañia IS NULL THEN

    FOR tupla_compañia IN (SELECT * FROM aerolinea)

    LOOP
      -- Generar contraseña
      SELECT floor(random() * (999999999-100 + 1) + 100) INTO valor_contraseña;
      INSERT INTO usuarios (username, tipo, contraseña) VALUES (tupla_compañia.codigo_aerolinea, 'Compañía aérea', valor_contraseña);
    END LOOP;
  END IF;  

  -- Vemos si pasajeros fue creado
  IF pasajero IS NULL THEN
  -- Se deben crear los pasajeros
    FOR tupla_pasajero IN (SELECT * FROM pasajeros)

    LOOP
    -- Generar contraseña
    	SELECT concat(left(tupla_pasajero.pasaporte, floor(random()*10)::int),  left(tupla_pasajero.nombre, floor(random()*10)::int)) INTO valor_contraseña;
      INSERT INTO usuarios (username, tipo, contraseña) VALUES (tupla_pasajero.pasaporte, 'Pasajero', valor_contraseña);
  END LOOP;
  END IF;

END 
$$ language plpgsql