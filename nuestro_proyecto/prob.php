<head>
<script>
function myFunction(i, codigo_de_vuelo = null, pasaportes = null) {
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
        var msg = '';
        for (const integrante of ['i1', 'i2', 'i3']){
            if (pasaportes[integrante] != '-'){
                msg += 'Se ha realizado con éxito la reserva del vuelo ' + String(codigo_de_vuelo) + ' Para el usuario de pasaporte ' + pasaportes[integrante] + '\n';
            }
        }
        console.log(msg);
    }
}
</script>
</head>
<?php $id_vuelo_int = 10;
            $pasaportes = array(
                "i1" => 'sdasd',
                "i2" => 'ASDLadl',
                "i3" => '-'
            );
            ?>
        <script>
            myFunction(4, <?php echo $id_vuelo_int ?>,<?php echo json_encode($pasaportes)?>);
        </script>