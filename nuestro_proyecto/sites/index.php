<?php session_start();
    if (isset($_SESSION['username'])){
        echo "Bienvenido/a: ";
        echo $_SESSION['username'];
    }
?>

<?php
    include("templates/header.html");
    require("consultas/obtener_tipo_usuario.php"); #returnTipo()
    require("consultas/propuestas_pendientes.php"); #propuestasPendientes()
    require("consultas/vuelos.php"); #vuelos()
    require("consultas/reservas_actuales.php"); # reservasActuales
    require("consultas/vuelos_aceptados.php"); # vuelosAceptados
?>

<!-- Para cerrar sesion -->
<form action="views/logout.php" method="get">
    <input type="submit" value="Cerrar sesion">
</form>

<!-- Logica principal -->
<body>
    <h1> Entrega 3 </h1>
    <br>
    <?php if (!isset($_SESSION['username'])) {?>
        <form align="center" action="views/login.php" method="get">
            <input type="submit" value="Iniciar sesión">
        </form>
        <form align="center" action="consultas/importar_usuarios.php" method="post">
            <input type="submit" value="Importar Usuarios">
        </form>
    <?php } elseif (returnTipo($_SESSION['username']) == 'Admin DGAC') { ?>
        <form align="center" method="post">
            <input type="date" name="fecha1" placeholder="dd/mm/yyyy" value="">
            <input type="date" name="fecha2" placeholder="dd/mm/yyyy" value="">
            <input type="submit" name="buscar">
        </form> 

        <?php 
            if (isset($_POST['buscar'])) {
                echo propuestasPendientes($_POST["fecha1"], $_POST["fecha2"]);
            } else {
                echo propuestasPendientes('', '');
            }
        ?>

    <?php } elseif (returnTipo($_SESSION['username']) == 'Pasajero') { ?>
        
        <!-- mostrar reservas actuales -->
        <?php echo reservasActuales($_SESSION['username']); ?>

        <!-- form con 3 subcampos, para ver los vuelos aceptados -->
        <!-- las ciudades tienen que ser con dropdown!!!!!! -->
        <br>
        <label> BUSQUEDA DE NUEVOS VUELOS </label>
        <form align="center" method="post">
            <input type="text" name="origen" placeholder="ciudad de origen" required>
            <input type="text" name="destino" placeholder="ciudad de destino" required>
            <input type="date" name="f_despegue" placeholder="dd/mm/yyyy" required>
            <input type="submit" name="buscar">
        </form> 

        <?php 
            if (isset($_POST['buscar'])) {
                echo vuelosAceptados($_POST["origen"], $_POST["destino"], $_POST["f_despegue"]);
            } else {
                echo vuelosAceptados('', '', '');
            }
        ?>

    <?php } elseif (returnTipo($_SESSION['username']) == 'Compañía aérea') { ?>
 
        <?php 
            echo vuelos();
        ?>

    <?php } ?>

</body>

</html>