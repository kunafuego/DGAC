<?php include('../templates/header.html'); ?>

    <?php
        require("../config/connection.php");

        $fecha1= $_POST["fecha1"];
        $fecha2 = $_POST["fecha2"];

        if ($fecha1 == '' && $fecha2 == '') {
            $query = "SELECT propuestas.*
                  FROM propuestas
                  WHERE lower(estado) = 'pendiente';";
        } elseif ($fecha1 == '') {
            $query = "SELECT propuestas.*
                  FROM propuestas
                  WHERE lower(estado) = 'pendiente'
                    AND to_date('$fecha2','YYYYMMDD') <= fecha_llegada;";
        } elseif ($fecha2 == '') {
            $query = "SELECT propuestas.*
                  FROM propuestas
                  WHERE lower(estado) = 'pendiente'
                    AND to_date('$fecha1','YYYYMMDD') >= fecha_salida;";
        } else {
            $query = "SELECT propuestas.*
                  FROM propuestas
                  WHERE lower(estado) = 'pendiente'
                    AND to_date('$fecha1','YYYYMMDD') >= fecha_salida
                    AND to_date('$fecha2','YYYYMMDD') <= fecha_llegada;";
        }
        
        $result = $db -> prepare($query);
        $result -> execute();

        $data = $result -> fetchAll();
    ?>
    
    <form align="center" action="consultas/propuestas_pendientes.php" method="post">
        <input type="date" name="fecha1" placeholder="dd/mm/yyyy" value="">
        <input type="date" name="fecha2" placeholder="dd/mm/yyyy" value="">
        <input type="submit" name="buscar">
    </form>    

    <!-- Hay que verificar que los botones esten funcionando correctamente -->
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
                            '<form action="consultas/cambiar_estado_propuesta.php" method="get">
                                <input type="hidden" name="id" value="<?php echo $d[0] ?>">
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
                        <td>$d[10]</td>
                      </tr>";
            }
        ?>

    </table>
    <!--  -->
    </body>

    <?php include('../templates/footer.html'); ?>