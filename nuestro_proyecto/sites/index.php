<?php session_start();
    if (isset($_SESSION['username'])){
    }
?>

<?php
    include("templates/header.html");
    require("consultas/obtener_tipo_usuario.php"); #returnTipo()
    require("consultas/propuestas_pendientes.php"); #propuestasPendientes()
    require("consultas/vuelos.php"); #vuelos()
    require("consultas/reservas_actuales.php"); # reservasActuales
    require("consultas/vuelos_aceptados.php"); # vuelosAceptados
    require("consultas/obtener_ciudades.php"); # obtenerCiuadades
    require("consultas/cambiar_estado_propuesta.php"); # cambiarEstadoPropuesta()
?>

<!-- Para cerrar sesion -->


<!-- Logica principal -->
    <?php if (!isset($_SESSION['username'])) {?>
        <body class="login-body">
        <div class="container">
            <img src="assets/login_background.jpg">
            <div class="container2">
                <form align="center" action="views/login.php" method="post">
                    <input type="submit" value="Iniciar sesión" class="button1">
                </form>
                <form align="center" action="consultas/importar_usuarios.php" method="post">
                    <input type="submit" value="Importar Usuarios" class="button2">
                </form>
            </div>
        </div>

    <?php } elseif (returnTipo($_SESSION['username']) == 'Admin DGAC') { ?>
        <!-- Bienvenido a  -->
        <body class="table-body">
        <h2><span class="upper-left"> Bienvenido/a: <?php echo $_SESSION['username'] ?> </span></h2>

        <!-- cerrar sesion -->
        <form action="views/logout.php" method="get">
            <input type="submit" value="Cerrar sesion"  class="close-button">
        </form>

        <br>
        <h1> Buscador de Propuestas Pendientes </h1>
        <form id="buscador_propuestas" align="center" method="post">
            <input type="date" name="fecha1" placeholder="dd/mm/yyyy" value="">
            <input type="date" name="fecha2" placeholder="dd/mm/yyyy" value="">
            <input type="submit" name="buscar">
        </form> 

        <br>

        <?php 
            if (isset($_POST['buscar'])) {
                echo propuestasPendientes($_POST["fecha1"], $_POST["fecha2"]);
            } else {
                echo propuestasPendientes('', '');
            }
        ?>

        <?php
            if (isset($_POST['nuevo_estado'])) {
                cambiarEstadoPropuesta($_POST["id"], $_POST["nuevo_estado"]);
            }
        ?>

    <?php } elseif (returnTipo($_SESSION['username']) == 'Pasajero') { ?>
        <body class="table-body">
        <!-- cerrar sesion -->
        <form action="views/logout.php" method="get">
        <input type="submit" value="Cerrar sesion" class="close-button">
        </form>

        <!-- mostrar reservas actuales -->
        <?php echo reservasActuales($_SESSION['username']); ?>

        <!-- llamamos la funcion para listar las ciudades -->
        <?php 
            $origen = obtenerCiudades('origen'); 
            $destino = obtenerCiudades('destino');
        ?>

        <br>
        <label> BUSQUEDA DE NUEVOS VUELOS </label>
        <label> Se puede probar desde madrid a seul, falta agregar lo de las fechas a la consutla </label>
        <form align="center" method="post">
            <!-- ciudad origen -->
            <label for="origen">Escoja una ciudad de origen: </label>
            <select id="origen" name="origen" required>
                <?php
                    foreach ($origen as $ciudad_origen) {
                        // $ciudad_origen = htmlspecialchars($ciudad_origen);
                        echo "<option value='$ciudad_origen'>$ciudad_origen</option>";
                    }
                ?>
            </select>
            <!-- ciudad destino -->
            <label for="destino">Escoja una ciudad de destino: </label>
            <select id="destino" name="destino" required>
                <?php
                    foreach ($destino as $ciudad_destino) {
                        // $ciudad_destino = htmlspecialchars($ciudad_destino);
                        echo "<option value='$ciudad_destino'>$ciudad_destino</option>";
                    }
                ?>
            </select>
            <input type="date" id='f_despegue' name="f_despegue" placeholder="dd/mm/yyyy" required>
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
        
        <!-- Bienvenido a  -->
        <body class="table-body">
        <h2><span class="upper-left"> Bienvenido/a: <?php echo $_SESSION['username'] ?> </span></h2>

        <!-- cerrar sesion -->
        <form action="views/logout.php" method="get">
            <input type="submit" value="Cerrar sesion" class="close-button">
        </form>

        <br>
        <?php 
            echo vuelos($_SESSION['username']);
        ?>

    <?php } ?>

</body>

</html>