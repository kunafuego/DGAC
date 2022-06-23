<?php
    function cambiarEstadoPropuesta($id, $nuevo_estado) {
        require("config/connection.php");

        if ($nuevo_estado == 'aceptar') {
            $nuevo_estado = 'aceptado';
        } elseif ($nuevo_estado == 'rechazar') {
            $nuevo_estado = 'rechazado';
        }

        // Para la base de datos par
        $query =   "UPDATE propuestas
                    SET estado = '$nuevo_estado'
                    WHERE id = '$id';";
        $result = $db -> prepare($query);
        $result -> execute();


        // Buscamos los datos en el plan de vuelo de la propuesta
        $query2 =   "SELECT *
                    FROM planes_de_vuelo
                    WHERE propuesta_id = '$id';";
        $result2 = $db -> prepare($query2);
        $result2 -> execute();
        $data2 = $result2 -> fetchAll();

        $aerodromo_salida_id = $data2[0]['aerodromo_salida_id'];
        $aerodromo_llegada_id = $data2[0]['aerodromo_llegada_id'];
        $ruta_id = $data2[0]['ruta_id'];
        $codigo_vuelo = $data2[0]['codigo_vuelo'];
        $codigo_aeronave = $data2[0]['codigo_aeronave'];
        $codigo_compania = $data2[0]['codigo_compania'];
        $fecha_salida = $data2[0]['fecha_salida'];
        $fecha_llegada = $data2[0]['fecha_llegada'];
        $velocidad = $data2[0]['velocidad'];
        $altitud = $data2[0]['altitud'];
        $estado = $nuevo_estado;


        // Buscamos el nombre de la compañia 
        $query3 =   "SELECT nombre
                    FROM companias
                    WHERE codigo = '$codigo_compania';";
        $result3 = $db -> prepare($query3);
        $result3 -> execute();
        $data3 = $result3 -> fetchAll();

        $nombre_compania = $data3[0]['nombre'];


        // Buscamos un id que no haya sido utilizado en los vuelos
        $query4 =   "SELECT CAST(v1.id_vuelo as INT) + 1 as start
                    FROM vuelos as v1
                    LEFT OUTER JOIN vuelos as v2 on CAST(v1.id_vuelo as INT) + 1 = CAST(v2.id_vuelo as INT)
                    WHERE v2.id_vuelo is null;";
        $result4 = $db2 -> prepare($query4);
        $result4 -> execute();
        $data4 = $result4 -> fetchAll();

        $id_vuelo = $data4[0]['start'];


        // Calculo del precio
        // Buscamos una ruta y el precio de esta con el mismo codigo de aeronave
        $query5 =   "SELECT ruta_id, precio
                    FROM vuelos
                    WHERE codigo_aeronave = '$codigo_aeronave' LIMIT 1;";
        $result5 = $db2 -> prepare($query5);
        $result5 -> execute();
        $data5 = $result5 -> fetchAll();

        $ruta_id2 = $data5[0]['ruta_id'];
        $precio2 = $data5[0]['precio'];

        // Buscamos la cardinalidad de esa ruta y la de nuestra ruta
        // Nuestra ruta
        $query6 =   "SELECT count(cardinalidad) as cardinalidad
                    FROM compuesta_de
                    WHERE ruta_id = '$ruta_id';";
        $result6 = $db -> prepare($query6);
        $result6 -> execute();
        $data6 = $result6 -> fetchAll();

        $cardinalidad = $data6[0]['cardinalidad'];

        // Ruta que encontramos con el mismo avion
        $query7 =  "SELECT count(cardinalidad) as cardinalidad
                    FROM compuesta_de
                    WHERE ruta_id = '$ruta_id2';";
        $result7 = $db -> prepare($query7);
        $result7 -> execute();
        $data7 = $result7 -> fetchAll();

        $cardinalidad2 = $data7[0]['cardinalidad'];

        // Definimos el precio como
        $precio = round($precio2 * $cardinalidad / $cardinalidad2);

        // Agregamos el vuelo, con los datos obtenidos
        $query8 =   "INSERT INTO vuelos(id_vuelo, aerodromo_salida_id, aerodromo_llegada_id, ruta_id, codigo_vuelo, codigo_aeronave, codigo_compania, fecha_salida, fecha_llegada, velocidad, altitud, estado, precio, nombre_compania)
                     VALUES ('$id_vuelo', '$aerodromo_salida_id', '$aerodromo_llegada_id', '$ruta_id', '$codigo_vuelo', '$codigo_aeronave', '$codigo_compania', '$fecha_salida', '$fecha_llegada', '$velocidad', '$altitud', '$estado', '$precio', '$nombre_compania');";

        $result8 = $db2 -> prepare($query8);
        $result8 -> execute();

    }
?>