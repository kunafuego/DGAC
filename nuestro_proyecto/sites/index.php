<?php session_start();
    
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
    require("consultas/obtener_nombre_pasajero.php"); # obtenerNombrePasajero()
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
        </body>

    <?php } elseif ($_SESSION['tipo'] == 'Admin DGAC') { ?>
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

    <?php } elseif ($_SESSION['tipo'] == 'Pasajero') { ?>
        <!-- Bienvenido a  -->
        <body class="table-body">
        <h2><span class="upper-left"> Bienvenido/a: <?php echo obtenerNombrePasajero($_SESSION['username']) ?> </span></h2>
        <h2><span class="upper-left2"> Pasaporte: <?php echo $_SESSION['username'] ?> </span></h2>

        <!-- cerrar sesion -->
        <form action="views/logout.php" method="get">
            <input type="submit" value="Cerrar sesion" class="close-button">
        </form>
        
        <br>
        <br>
        <br>
        <!-- mostrar reservas actuales -->
        <div class="row">
            <div class="column">
                <h1> MIS RESERVAS </h1>
                <?php echo reservasActuales($_SESSION['username']); ?>

                <!-- llamamos la funcion para listar las ciudades -->
                <?php 
                    $origen = obtenerCiudades('origen'); 
                    $destino = obtenerCiudades('destino');
                ?>

            </div>
            <div class="column">
                <h1> BUSQUEDA DE NUEVOS VUELOS </h1>
                <div class="container-reservas">
                    <img src="assets/login_background.jpg">
                    <div class="container-reservas2">
                        <form align="center" method="post">
                            <!-- ciudad origen -->
                            <br>
                            <h3 style="display: inline-block"><span for="origen"> Ciudad de origen: </span></h3>
                            <select id="origen" name="origen" required>
                                <?php
                                    foreach ($origen as $ciudad_origen) {
                                        // $ciudad_origen = htmlspecialchars($ciudad_origen);
                                        echo "<option value='$ciudad_origen'>$ciudad_origen</option>";
                                    }
                                ?>
                            </select>
                            <!-- ciudad destino -->
                            <h3 for="destino" style="display: inline-block"> Ciudad de destino: </h3>
                            <select id="destino" name="destino" required>
                                <?php
                                    foreach ($destino as $ciudad_destino) {
                                        // $ciudad_destino = htmlspecialchars($ciudad_destino);
                                        echo "<option value='$ciudad_destino'>$ciudad_destino</option>";
                                    }
                                ?>
                            </select>
                            <h3 for="f_despegue" style="display: inline-block"> Fecha de salida: </h3>
                            <input type="date" id='f_despegue' name="f_despegue" placeholder="dd/mm/yyyy" required>
                            <input type="submit" name="buscar" value="Mostrar vuelos" class="button">
                        </form> 
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>

        <h1> LISTADO DE NUEVOS VUELOS</h1>
        <?php 
            if (isset($_POST['buscar'])) {
                echo vuelosAceptados($_POST["origen"], $_POST["destino"], $_POST["f_despegue"]);
            } else {
                echo vuelosAceptados('', '', '');
            }
        ?>
        <br>
                      
    <?php } elseif ($_SESSION['tipo'] == 'Compañía aérea') { ?>
        
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

    <?php } else { ?>
        <!-- cerrar sesion -->
        <form action="views/logout.php" method="get">
            <input type="submit" value="Cerrar sesion" class="close-button">
        </form>
    <?php } ?>

</body>

</html>