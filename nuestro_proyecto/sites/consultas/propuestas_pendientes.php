    
    <?php 

        function propuestasPendientes($fecha1, $fecha2){
            require("config/connection.php");

            if ($fecha1 == '' && $fecha2 == '') {
                $query = "SELECT propuestas.*
                    FROM propuestas
                    WHERE lower(estado) = 'pendiente';";
            } elseif ($fecha1 != '' && $fecha2 != '') {
                $query = "SELECT propuestas.*
                    FROM propuestas
                    WHERE lower(estado) = 'pendiente'
                        AND CAST('$fecha1' AS DATE) >= fecha_propuesta
                        AND CAST('$fecha2' AS DATE) <= fecha_propuesta;";
            } elseif ($fecha2 == '') {
                $query = "SELECT *
                    FROM propuestas
                    WHERE lower(estado) = 'pendiente'
                        AND CAST('$fecha1' AS DATE) <= fecha_propuesta;";
            } elseif ($fecha1 == '') {
                $query = "SELECT propuestas.*
                    FROM propuestas
                    WHERE lower(estado) = 'pendiente'
                        AND CAST('$fecha2' AS DATE) >= fecha_propuesta;";
            }
            
            $result = $db -> prepare($query);
            $result -> execute();

            $data = $result -> fetchAll();
            return displayPropuestasPendientes($data);
        }

        function displayPropuestasPendientes($data) { ?>
            <table class="table is-striped is-hoverable"> 
                <tr>
                    <th> modificar estado </th>
                    <th> id </th>
                    <th> estado </th>
                    <th> codigo_vuelo </th>
                    <th> fecha_salida </th>
                    <th> fecha_llegada </th>
                    <th> aerodromo_llegada_id </th>
                    <th> aerodromo_salida_id </th>
                    <th> codigo_aeronave </th>
                    <th> codigo_compania </th>
                    <th> fecha_propuesta </th>
                </tr>

            <?php
                foreach ($data as $d) {
                    echo "<tr>
                            <td>" .
                                '<form method="post">
                                    <input type="hidden" name="id" value="'. $d[0] .'">
                                    <input type="submit" name="nuevo_estado" value="aceptar">
                                    <input type="submit" name="nuevo_estado" value="rechazar">
                                </form>'
                            . "</td>
                            <td>$d[0]</td>
                            <td>$d[1]</td>
                            <td>$d[2]</td>
                            <td>$d[3]</td>
                            <td>$d[4]</td>
                            <td>$d[5]</td>
                            <td>$d[6]</td>
                            <td>$d[7]</td>
                            <td>$d[8]</td>
                            <td>$d[9]</td>
                        </tr>";
                }
            ?>

            </table>
        <?php }

    ?>