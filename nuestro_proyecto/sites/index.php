<?php session_start();
    if (isset($_SESSION['username'])){
        echo "Bienvenido/a: ";
        echo $_SESSION['username'];
    }
?>

<?php
    include("templates/header.html");
?>

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
    <?php } elseif ($_SESSION['tipo'] == 'admin') { ?>
        <form align="center" id="propuestas_form" action="consultas/propuestas_pendientes.php" method="post">
            <input type="hidden" name="fecha1" value="">
            <input type="hidden" name="fecha2" value="">
        </form>
        <script>
            document.getElementByID("propuestas_form").sumbit();
        </script>

    <?php } elseif ($_SESSION['tipo'] == 'pasajero') { ?>
        <!-- aqui va el codigo -->
    <?php } elseif ($_SESSION['tipo'] == 'compañia') { ?>
        <!-- aqui va el codigo -->
    <?php } ?>
    
</body>

</html>