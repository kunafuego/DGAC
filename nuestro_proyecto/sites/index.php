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
        <!-- aqui va el codigo -->
    <?php } elseif (returnTipo($_SESSION['username']) == 'Compañía aérea') { ?>
 
        <?php 
            echo vuelos();
        ?>

    <?php } ?>

</body>

</html>