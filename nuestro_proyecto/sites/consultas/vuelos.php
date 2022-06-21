
    <?php
    
        function vuelos() {
            require("config/connection.php");

            // Obtener las vuelos rechazados
            $query = "SELECT * FROM vuelos WHERE estado = 'rechazado';";
            $result = $db2 -> prepare($query);
            $result -> execute();
            $rechazados = $result -> fetchAll();

            //Obtener los vuelos aceptados
            $query2 = "SELECT * FROM vuelos WHERE estado = 'aceptado';";
            $result2 = $db2 -> prepare($query2);
            $result2 -> execute();
            $aceptados = $result2 -> fetchAll();
            
            return displayVuelos($aceptados, $rechazados);
        }
    
        function displayVuelos($aceptados, $rechazados) { ?>

            <div class='columns'>
                <div class = 'column'>  
                    <label> VUELOS ACEPTADOS </label>
                    <table class="table is-striped is-hoverable"> 
                        <tr>
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
                            foreach ($aceptados as $d) {
                                echo "<tr>
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
                </div>
                <div class='column'>
                    <label> VUELOS RECHAZADOS </label>
                    <table class="table is-striped is-hoverable"> 
                        <tr>
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
                            foreach ($rechazados as $d) {
                                echo "<tr>
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
                </div>
            </div>
        <?php }

    ?>
