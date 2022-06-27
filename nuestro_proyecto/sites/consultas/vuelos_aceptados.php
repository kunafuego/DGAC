<?php
    
        function vuelosAceptados($origen, $destino, $f_despegue) {
            require("config/connection.php");
            
            if ($origen == '' && $destino == '' && $f_despegue == '') {
                $query = "SELECT * FROM vuelos WHERE estado = 'aceptado';";
                $result = $db2 -> prepare($query);
                $result -> execute();
                $data = $result -> fetchAll();
            } else {
                // Buscamos los aerodromos donde este esa ciudad de origen
                $query1 = "SELECT id_aerodromo
                            FROM aerodromos
                            WHERE ciudad = '$origen';";
                $result1 = $db2 -> prepare($query1);
                $result1 -> execute();
                $data1 = $result1 -> fetchAll();

                // Buscamos los aerodromos donde este esa ciudad de destino
                $query2 = "SELECT id_aerodromo
                            FROM aerodromos
                            WHERE ciudad = '$destino';";
                $result2 = $db2 -> prepare($query2);
                $result2 -> execute();
                $data2 = $result2 -> fetchAll();
                
                // Creamos una lista para los id de los aerodromos
                $id_aerodromos_origen = [];
                    foreach ($data1 as $d) {
                    array_push($id_aerodromos_origen, $d[0]);
                }

                $id_aerodromos_destino = [];
                    foreach ($data2 as $d) {
                    array_push($id_aerodromos_destino, $d[0]);
                }

                // Transformamos las listas to string
                $id_aerodromos_origen = implode(", ", $id_aerodromos_origen);
                $id_aerodromos_destino = implode(", ", $id_aerodromos_destino);
                
                // Buscamos los vuelos que nos sirvan
                // AND CAST('$f_despegue' AS DATE) = CONVERT(DATE, fecha_salida)
                
                $query3 = "SELECT * 
                            FROM vuelos 
                            WHERE estado = 'aceptado'
                                AND CAST(aerodromo_llegada_id AS varchar) IN ('$id_aerodromos_destino')
                                AND CAST(aerodromo_salida_id AS varchar) IN ('$id_aerodromos_origen')
                                AND CAST(CAST('$f_despegue' AS DATE) AS VARCHAR) = CAST(CAST(fecha_salida as DATE) as VARCHAR);";
                $result3 = $db2 -> prepare($query3);
                $result3 -> execute();
                $data = $result3 -> fetchAll();
            }
            
            return displayVuelosAceptados($data);
        }
    
        function displayVuelosAceptados($data) { ?>

            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0"> 
                    <thread>
                        <tr>
                            <th> reservar </th>
                            <th> id vuelo </th>
                            <th> aerodromo salida </th>
                            <th> ciudad salida </th>
                            <th> aerodromo llegada </th>
                            <th> ciudad llegada</th>
                            <th> codigo vuelo </th>
                            <th> codigo aeronave </th>
                            <th> codigo compania </th>
                            <th> fecha salida </th>
                            <th> fecha llegada </th>
                            <th> precio </th>
                        </tr>
                    </thread>
                </table>
            </div>
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <?php
                            require ('obtener_nombre_aerodromo.php'); #obtenerNombreAerodromo
                            foreach ($data as $d) {
                                $nombres_llegada = obtenerNombreAerodromo($d[2]);
                                $nombres_salida = obtenerNombreAerodromo($d[1]);
                                echo "<tr>
                                        <td>" .
                                            '<form action="consultas/reservar.php" method="get">
                                                <input type="hidden" name="id_vuelo" value="'. $d[0] .'">
                                                <input type="submit" name="reservar" value="reservar" class="accept-button">
                                            </form>'
                                        . "</td>
                                        <td>$d[0]</td>
                                        <td>$nombres_salida[0]</td>
                                        <td>$nombres_salida[1]</td>
                                        <td>$nombres_llegada[0]</td>
                                        <td>$nombres_llegada[1]</td>
                                        <td>$d[4]</td>
                                        <td>$d[5]</td>
                                        <td>$d[6]</td>
                                        <td>$d[7]</td>
                                        <td>$d[8]</td>
                                        <td>$d[12]</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php }

    ?>
