
    <?php
    
        function Vuelos($compania) {
            require("config/connection.php");
            require ('obtener_nombre_aerodromo.php'); #obtenerNombreAerodromo

            // Obtener las vuelos rechazados
            $query = "SELECT * FROM vuelos WHERE estado = 'rechazado' AND codigo_compania = '$compania';";
            $result = $db2 -> prepare($query);
            $result -> execute();
            $rechazados = $result -> fetchAll();

            //Obtener los vuelos aceptados
            $query2 = "SELECT * FROM vuelos WHERE estado = 'aceptado' AND codigo_compania = '$compania';";
            $result2 = $db2 -> prepare($query2);
            $result2 -> execute();
            $aceptados = $result2 -> fetchAll();
            
            return displayVuelos($aceptados, $rechazados);
        }
    
        function displayVuelos($aceptados, $rechazados) { ?>

            <div class='columns'>
                <div class='column'>
                    <h1> VUELOS ACEPTADOS </h1>
                    <div class = 'tbl-header'>  
                        <table cellpadding="0" cellspacing="0" border="0"> 
                            <thread> 
                                <tr>
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
                                    foreach ($aceptados as $d) {
                                        $nombres_llegada = obtenerNombreAerodromo($d[2]);
                                        $nombres_salida = obtenerNombreAerodromo($d[1]);
                                        echo "<tr>
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
                </div>
                <div class='column'>
                    <h1> VUELOS RECHAZADOS </h1>
                    <div class = 'tbl-header'>  
                            <table cellpadding="0" cellspacing="0" border="0"> 
                                <thread> 
                                    <tr>
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
                                    foreach ($rechazados as $d) {
                                        $nombres_llegada = obtenerNombreAerodromo($d[1]);
                                        $nombres_salida = obtenerNombreAerodromo($d[2]);
                                        echo "<tr>
                                                <td>$d[0]</td>
                                                <td>$nombres_salida[0]</td>
                                                <td>$nombres_salida[1]</td>
                                                <td>$nombres_llegada[1]</td>
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
                </div>
            </div>
        <?php }

    ?>
