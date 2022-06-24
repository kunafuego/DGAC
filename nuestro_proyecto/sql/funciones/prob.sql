CREATE OR REPLACE FUNCTION generar_reserva(i1 text, i2 text, i3 text, id_vuelo integer)

RETURNS void AS $$

DECLARE
  reserva_id integer;
  max_reserva integer;
  codigo_vuelo text;
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
        max_reserva := '4981';
        reserva_id := CAST(max_reserva AS INT) + 1;
        codigo_vuelo := 'LAW3477';
        codigo_reserva := CONCAT(codigo_vuelo, '-', CAST(reserva_id AS text));
        nombre_comprador := 'Suzanne Goodman';
        nacionalidad_comprador := 'Chilena';
        fecha_nacimiento_comprador := '1987-11-16';
        -- Generar reserva
        -- Agregar 
        INSERT INTO reservas VALUES ( reserva_id, 
                                      codigo_reserva, 
                                      integrante, 
                                      nombre_comprador, 
                                      nacionalidad_comprador, 
                                      fecha_nacimiento_comprador);
      END IF;
    END LOOP;

END 
$$ language plpgsql