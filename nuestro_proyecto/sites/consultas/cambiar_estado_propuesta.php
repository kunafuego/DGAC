<?php
    require("../config/connection.php");

    $id = intval( $_POST["id"] );
    $nuevo_estado = $_POST ["nuevo_estado"]

    // Para la base de datos par
    $query =   "UPDATE planes_de_vuelo
                SET estado = $nuevo_estado
                WHERE id = $id;";

    $result = $db -> prepare($query);
    $result -> execute();

    // Buscamos los datos del plan de vuelo
    $query2 =   "SELECT *
                FROM planes_de_vuelo
                WHERE id = $id;";

    $result2 = $db -> prepare($query2);
    $result2 -> execute();
    $data2 = $result2 -> fetchAll();

    $aerodromo_salida_id = $data2['aerodromo_salida_id']
    $aerodromo_llegada_id = $data2['aerodromo_llegada_id']
    $ruta_id = $data2['ruta_id']
    $codigo_vuelo = $data2['codigo_vuelo']
    $codigo_aeronave = $data2['codigo_aeronave']
    $codigo_compania = $data2['codigo_compania']
    $fecha_salida = $data2['fecha_salida']
    $fecha_llegada = $data2['fecha_llegada']
    $velocidad = $data2['velocidad']
    $altitud = $data2['altitud']
    $estado = 'aceptado'

    // Buscamos el nombre de la compañia 
    $query3 =   "SELECT nombre_compania
                FROM companias
                WHERE codigo = $codigo_compania;";

    $result3 = $db -> prepare($query3);
    $result3 -> execute();
    $data3 = $result3 -> fetchAll();

    $nombre_compania = $data3['nombre_compania']

    // Buscamos un id que no haya sido utilizado en los vuelos
    $query4 =   "SELECT CAST(v1.id_vuelo as INT) + 1 as start
                 FROM vuelos as v1
                 LEFT OUTER JOIN vuelos as v2 on CAST(v1.id_vuelo as INT) + 1 = CAST(v2.id_vuelo as INT)
                 WHERE v2.id_vuelo is null;";

    $result4 = $db2 -> prepare($query4);
    $result4 -> execute();
    $data4 = $result4 -> fetchAll();

    $id_vuelo = $data4['start']

    // Buscamos el precio del vuelo, segun la ruta y la aeronave
    $query5 =   "SELECT precio
                 FROM vuelos
                 WHERE ruta_id = $ruta_id AND codigo_aeronave = $codigo_aeronave
                 LIMIT 1;";

    $result5 = $db2 -> prepare($query5);
    $result5 -> execute();
    $data5 = $result5 -> fetchAll();

    $precio = $data5['precio']
    
    // Agregamos el vuelo, con los datos obtenidos
    $query6 =   "INSERT INTO vuelos(id_vuelo, aerodromo_salida_id, aerodromo_llegada_id, ruta_id, codigo_vuelo, codigo_aeronave, codigo_compania, fecha_salida, fecha_llegada, velocidad, altitud, estado, precio, nombre_compania)
                 VALUES ($id_vuelo, $aerodromo_salida_id, $aerodromo_llegada_id, $ruta_id, $codigo_vuelo, $codigo_aeronave, $codigo_compania, $fecha_salida, $fecha_llegada, $velocidad, $altitud, $estado, $precio, $nombre_compania);";

    $result6 = $db2 -> prepare($query6);
    $result6 -> execute();
?>