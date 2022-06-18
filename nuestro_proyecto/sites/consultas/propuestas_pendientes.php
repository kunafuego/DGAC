<?php include('../templates/header.html'); ?>

<body>
    <?php
        require("../config/conection.php");

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


    <!-- Hay que agregar un boton que nos permita aceptar o rechazar cada propuesta de vuelo -->
    <table class="table is-striped is-hoverable"> 
        <tr>
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