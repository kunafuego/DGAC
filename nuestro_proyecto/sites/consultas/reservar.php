
<head>
<script>
function myFunction(i) {
    if (i == 1){
        alert("Debe ingresar al menos un pasaporte para poder realizar la reserva");
    }
    else if (i == 2){
        alert("Uno de los pasajeros inscritos no es válido");
    }
    else if (i == 3){
        alert("Uno de tus pasajeros tiene un vuelo a la misma hora que el que quieres reservar");
    }
    else if (i == 4){
        alert("Reserva Realizada con éxito, se añadieron las reservas para el vuelo ");
    }
}
</script>
</head>

<?php 

function chequear_integrantes($pasaportes, $id_vuelo){
    require("../config/connection.php");
    $query = "SELECT pasaporte FROM pasajeros;";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $data = $result -> fetchAll();
    $i1_ok = false;
    $i2_ok = false;
    $i3_ok = false; 
    $str_integrantes= ['i1', 'i2', 'i3'];
    foreach($str_integrantes as $integrante){
        if ($pasaportes[$integrante] == ""){
            $pasaportes[$integrante] = "-";
        }
    }
    foreach($data as $d){
        if ($pasaportes["i1"] == $d[0] || $pasaportes["i1"] == '-'){
            $i1_ok = true;
        }
        if ($pasaportes["i2"] == $d[0] || $pasaportes["i2"] == '-'){
            $i2_ok = true;
        }
        if ($pasaportes["i3"] == $d[0] || $pasaportes["i3"] == '-'){
            $i3_ok = true;
        }
    }
    if ($i1_ok == true && $i2_ok == true && $i3_ok == true){
        chequear_vuelos($pasaportes, $id_vuelo);
    }
    else{?>
        <script>
        myFunction(2);
        </script>
        <?php
    }
}
    

function chequear_vuelos($pasaportes, $id_vuelo){
    require("../config/connection.php");
    $cruzado = false;
    foreach ($pasaportes as $i => $value){
        if ($value != '-'){
        // Obtenemos los codigos de vuelo de los vuelos que tiene reserva
        $query = "SELECT codigo_reserva FROM reservas WHERE pasaporte_comprador = '$value';";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        // Para cada uno de estos vuelos, chequearemos que no se entrecrucen las fechas
        foreach($data as $vuelo){
            $codigo_vuelo = substr($vuelo[0],0,-5);
            // Obtenemos fechas de los vuelos del comprador
            $query2 = "SELECT fecha_salida, fecha_llegada FROM vuelos WHERE codigo_vuelo = '$codigo_vuelo';";
            $result2 = $db2 -> prepare($query2);
            $result2 -> execute();
            $data2 = $result2 -> fetchAll();
            $fecha_salida1 = $data2[0][0];
            $fecha_llegada1 = $data2[0][1];
            // Obtenemos fechas del veuelo que quiere comprar
            $query3 = "SELECT fecha_salida, fecha_llegada FROM vuelos WHERE CAST(id_vuelo AS INT) = $id_vuelo;";
            $result3 = $db2 -> prepare($query3);
            $result3 -> execute();
            $data3 = $result3 -> fetchAll();
            $fecha_salida2 = $data3[0][0];
            $fecha_llegada2 = $data3[0][1];
            // Chequear que las fechas no se entrecrucen
            if (($fecha_salida1 <= $fecha_salida2 && $fecha_llegada1 >= $fecha_salida2) || ($fecha_salida1 >= $fecha_salida2 && $fecha_salida1 <= $fecha_llegada2)){
                $cruzado = true;
            }
        }}
    }
    if($cruzado == true){
        ?>
        <script>
        myFunction(3);
        </script>
        <?php    
    }
    else{
        $id_vuelo_int =  intval($id_vuelo);
        $consulta  = "SELECT * FROM generar_reserva('{$pasaportes['i1']}','{$pasaportes['i2']}','{$pasaportes['i3']}',$id_vuelo_int);";
        $resultado = $db2 -> prepare($consulta);
        $resultado -> execute();
        $datos = $resultado -> fetchAll();
        ?>
         <script>
        myFunction(4);
        </script>
         <?php
        header('Refresh: 0; url = ../index.php')
    }
}
    
include('../templates/header.html'); ?>
<body>
    <h3> Ingrese los tres pasaportes de quienes desea hacer la reserva </h3>
    <br>
    <form class="form" role="form" method="post">
        <table class="table is-struped is-hoverable">
            <tr> 
                <th> Pasaporte Integrante 1 </th>
                <th> Pasaporte Integrante 2 </th>
                <th> Pasaporte Integrante 3 </th>
                <th> Enviar </th>
            </tr>
            <tr> 
                <td> <input type="text" name="integrante1"> </td>
                <td> <input type="text" name="integrante2"> </td>
                <td> <input type="text" name="integrante3"> </td>
                <td> <input type="submit" name="reservar_vuelo" value="Reservar Vuelo"> </td>
                <input type="hidden" name="id_vuelo" value="<?php echo $_GET["id_vuelo"] ?>">
            </tr>
        </form>
</body>
        
        <?php 
    if (isset($_POST['reservar_vuelo'])) {
        if ($_POST['integrante1'] == '-' && $_POST['integrante2'] == '-' && $_POST['integrante3']== '-'){
            ?>
            <script>
            myFunction(1);
            </script>
            <?php        
        }
        else {
            $pasaportes = array(
                "i1" => $_POST['integrante1'],
                "i2" => $_POST['integrante2'],
                "i3" => $_POST['integrante3']
            );
            $id_vuelo = $_POST['id_vuelo'];
            chequear_integrantes($pasaportes, $id_vuelo);
        }
    }
    ?>


