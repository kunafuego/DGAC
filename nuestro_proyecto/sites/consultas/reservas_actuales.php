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
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0"> 
                    <thread>
                        <tr>
                            <th> Código Reserva </th>
                        </tr>
                    </thread>
                </table>
            </div>
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <?php
                            foreach ($reservas as $d) {
                                echo "<tr>
                                        <td>$d[1]</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php }

    ?>