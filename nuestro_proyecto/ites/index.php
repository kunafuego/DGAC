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
    <?php
        if (!isset($_SESSION['username'])) {
    ?>
        <form align="center" action="views/login.php" method="get">
            <input type="submit" value="Iniciar sesión">
        </form>
        <form align="center" action="" method="post">
            <input type="submit" value="Importar Usuarios">
        </form>
    <?php } elseif ($_SESSION['tipo'] == 'pasajero') { ?>

    <?php } elseif ($_SESSION['tipo'] == 'admin') { ?>

    <?php } elseif ($_SESSION['tipo'] == 'compañia') { ?>

    <?php } ?>
    
</body>

</html>