CREATE OR REPLACE FUNCTION generar_reserva(i1 text, i2 text, i3 text, id_vuelo_reserva integer)

RETURNS void AS $$

DECLARE
  nueva_reserva_id integer;
  max_reserva integer;
  codigo_vuelo_reserva text;
  codigo_reserva text;
  nombre_comprador text;
  nacionalidad_comprador text;
  fecha_nacimiento_comprador date;
  integrantes text[] := ARRAY[i1,
                              i2,
                              i3];
  integrante text;
BEGIN

    FOREACH integrante IN ARRAY integrantes
    LOOP
      IF integrante != '-' THEN
        -- Se buscan los atributos que debe tener la reserva para ese id_vuelo
        -- generar el codigo_reserva con el codigo_vuelo del id_vuelo
        SELECT MAX(CAST(reserva_id AS INT)) INTO max_reserva FROM reservas;
        nueva_reserva_id := max_reserva + 1;
        SELECT codigo_vuelo INTO codigo_vuelo_reserva FROM vuelos WHERE CAST(id_vuelo AS INT) = id_vuelo_reserva;
        codigo_reserva := CONCAT(codigo_vuelo_reserva, '-', CAST(nueva_reserva_id AS text));
        SELECT nombre INTO nombre_comprador FROM pasajeros WHERE pasaporte = integrante;
        SELECT nacionalidad INTO nacionalidad_comprador FROM pasajeros WHERE pasaporte = integrante;
        SELECT fecha_nacimiento INTO fecha_nacimiento_comprador FROM pasajeros WHERE pasaporte = integrante;
        -- Generar reserva
        -- Agregar 
        INSERT INTO reservas VALUES ( CAST(nueva_reserva_id AS VARCHAR(4)), 
                                      codigo_reserva, 
                                      integrante, 
                                      nombre_comprador, 
                                      nacionalidad_comprador, 
                                      fecha_nacimiento_comprador);
      END IF;
    END LOOP;

END 
$$ language plpgsql