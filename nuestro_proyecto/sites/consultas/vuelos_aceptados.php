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
                                AND CAST(aerodromo_salida_id AS varchar) IN ('$id_aerodromos_origen');";
                $result3 = $db2 -> prepare($query3);
                $result3 -> execute();
                $data = $result3 -> fetchAll();
            }
            
            return displayVuelosAceptados($data);
        }
    
        function displayVuelosAceptados($data) { ?>

            <label> SOBRE ESTOS VUELOS PUEDE HACER RESERVAS </label>
            <table class="table is-striped is-hoverable"> 
                <tr>
                    <th> reservar </th>
                    <th> id_vuelo </th>
                    <th> aerodromo_salida_id </th>
                    <th> aerodromo_llegada_id </th>
                    <th> codigo_vuelo </th>
                    <th> codigo_aeronave </th>
                    <th> codigo_compania </th>
                    <th> fecha_salida </th>
                    <th> fecha_llegada </th>
                    <th> precio </th>
                </tr>

                <?php
                    foreach ($data as $d) {
                        echo "<tr>
                                <td>" .
                                    '<form action="consultas/reservar.php" method="get">
                                        <input type="hidden" name="id_vuelo" value="'. $d[0] .'">
                                        <input type="submit" name="reservar" value="reservar">
                                    </form>'
                                . "</td>
                                <td>$d[0]</td>
                                <td>$d[1]</td>
                                <td>$d[2]</td>
                                <td>$d[4]</td>
                                <td>$d[5]</td>
                                <td>$d[6]</td>
                                <td>$d[7]</td>
                                <td>$d[8]</td>
                                <td>$d[12]</td>
                            </tr>";
                    }
                ?>

            </table>
        <?php }

    ?>
