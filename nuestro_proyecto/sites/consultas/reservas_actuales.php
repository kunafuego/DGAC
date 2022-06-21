<?php
    
        function reservasActuales($pasaporte) {
            require("config/connection.php");

            $query = "SELECT * FROM reservas WHERE pasaporte_comprador = '$pasaporte';";
            $result = $db2 -> prepare($query);
            $result -> execute();
            $reservas = $result -> fetchAll();
            
            return displayReservas($reservas);
        }
    
        function displayReservas($reservas) { ?>

            <label> MIS RESERVAS </label>
            <table class="table is-striped is-hoverable"> 
                <tr>
                    <th> codigo_reserva </th>
                </tr>

                <?php
                    foreach ($reservas as $d) {
                        echo "<tr>
                                <td>$d[1]</td>
                            </tr>";
                    }
                ?>

            </table>
        <?php }

    ?>