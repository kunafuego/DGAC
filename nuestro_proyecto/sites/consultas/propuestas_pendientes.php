    
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
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0"> 
                    <thread>
                        <tr>
                            <th> modificar estado </th>
                            <th> codigo vuelo </th>
                            <th> fecha salida </th>
                            <th> fecha llegada </th>
                            <th> aerodromo salida </th>
                            <th> ciudad salida </th>
                            <th> aerodromo llegada </th>
                            <th> ciudad llegada</th>
                            <th> codigo aeronave </th>
                            <th> codigo compania </th>
                            <th> fecha propuesta </th>
                        </tr>
                    </thread>
                </table>
            </div>
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <?php
                            require ('obtener_nombre_aerodromo.php'); # obtenerNombreAerodromo
                            foreach ($data as $d) {
                                $nombres_llegada = obtenerNombreAerodromo($d[5]);
                                $nombres_salida = obtenerNombreAerodromo($d[6]);
                                echo "<tr>
                                        <td>" .
                                            '<form method="post">
                                                <input type="hidden" name="id" value="'. $d[0] .'">
                                                <button name="nuevo_estado" value="aceptar" class="accept-button"> &#10004 </button>
                                                <button name="nuevo_estado" value="rechazar" class="decline-button"> &#10006 </button>
                                            </form>'
                                        . "</td>
                                        <td>$d[2]</td>
                                        <td>$d[3]</td>
                                        <td>$d[4]</td>
                                        <td>$nombres_salida[0]</td>
                                        <td>$nombres_salida[1]</td>
                                        <td>$nombres_llegada[0]</td>
                                        <td>$nombres_llegada[1]</td>
                                        <td>$d[7]</td>
                                        <td>$d[8]</td>
                                        <td>$d[9]</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php }

    ?>