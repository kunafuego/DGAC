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
                <td> <input type="text name="integrante1"> </td>
                <td> <input type="text name="integrante2"> </td>
                <td> <input type="text name="integrante3"> </td>
                <td> <button type="submit" name="reservar"> </td>
                <input type="hidden" name="id_vuelo" value="'. <?php $_GET['id_vuelo'] ?> .'">
            </tr>
    </form>

    <?php 
    if (isset($_POST['reservar'])) {
        if (!isset($_POST['integrante1']) && !isset($_POST['integrante2']) && !isset($_POST['integrante3'])){
            echo myFunction(1);
        }
        else {
            $pasaportes = array();
            if (isset($_POST['integrante1'])){
                $pasaportes["i1"] = $_POST['integrante1'];
            }
            else {
                $pasaportes["i1"] = NULL;
            }
            if (isset($_POST['integrante2'])){
                $pasaportes["i2"] = $_POST['integrante2'];
            }
            else {
                $pasaportes["i2"] = NULL;
            }
            if (isset($_POST['integrante3'])){
                $pasaportes["i3"] = $_POST['integrante3'];
            }
            else {
                $pasaportes["i3"] = NULL;
            }
        $id_vuelo = $_POST['id_vuelo']
        chequear_integrantes($pasaportes, $id_vuelo);
        }
    }
    ?>

<script>
function myFunction(i) {
    if (i==1){
        alert("Debe ingresar al menos un pasaporte para poder realizar la reserva");
    }
    else if (i==2){
        alert("El pasaporte número 1 no es válido no es válido para poder realizar la reserva");
    }
    else if (i==3){
        alert("El pasaporte número 2 no es válido no es válido para poder realizar la reserva");
    }
    else if (i==4){
        alert("El pasaporte número 3 no es válido no es válido para poder realizar la reserva");
    }
    else if (i==5){
        alert("Uno de tus pasajeros iene un vuelo a la misma hora que el que quieres reservar");
    }
    
}
</script>

<?php include('../templates/header.html'); 

    function chequear_integrantes($pasaportes, $id_vuelo){
        $chequear_vuelos = true;
        $query = "SELECT pasajero.pasaporte FROM pasajeros;";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        if (in_array($pasaportes["i1"], $data[0]) == false && $pasaportes["i1"] != NULL){
            echo myFunction(2);
            $chequear_vuelos = false;
        }
        elseif (in_array($pasaportes["i2"], $data[0]) == false && $pasaportes["i2"] != NULL){
            echo myFunction(3);
            $chequear_vuelos = false;
        }
        elseif (in_array($pasaportes["i3"], $data[0]) == false && $pasaportes["i3"] != NULL){
            echo myFunction(4);
            $chequear_vuelos = false;
        }
        if (chequear_vuelos == true){
            chequear_vuelos($pasaportes, $id_vuelo)
        }
        }
        

    function chequear_vuelos($pasaportes, $id_vuelo){
        foreach ($pasaportes as $i => $value){
            $cruzado = false;
            if ($value != NULL){
            $query = "SELECT codigo_reserva FROM reservas WHERE pasaporte_comprador = $value;";
            $result = $db2 -> prepare($query);
            $result -> execute();
            $data = $result -> fetchAll();
    
            foreach($data[0] as $vuelo){
                $codigo_vuelo = substr($vuelo,0,-5);
                // Obtenemos fechas de los vuelos del comprador
                $query2 = "SELECT fecha_salida, fecha_llegada FROM vuelos WHERE codigo_vuelo = $codigo_vuelo;";
                $result2 = $db2 -> prepare($query);
                $result2 -> execute();
                $data2 = $result2 -> fetchAll();
                // Obtenemos fechas del veuelo que quiere comprar
                $query3 = "SELECT fecha_salida, fecha_llegada FROM vuelos WHERE id_vuelo = $id_vuelo;";
                $result3 = $db2 -> prepare($query3);
                $result3 -> execute();
                $data3 = $result3 -> fetchAll();
                // Chequear que las fechas no se entrecrucen
                // En caso de que se crucen seteamos $cruzado = true
            }
            if($cruzado == true){
                myFunction(5)
            }
            else{
                $consulta  = "SELECT * FROM generar_reserva($pasaportes, $id_vuelo);";
                $resultado = $db2 -> prepare($consulta);
                $resultado -> execute();
                $datos = $resultado -> fetchAll();
            }
            }
        }
        }
        ?>



</body>