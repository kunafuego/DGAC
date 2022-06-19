<?php include('../templates/header.html'); ?>

    <?php
        require("../config/connection.php");

        $username = $_POST["username"];

        $query = "SELECT tipo FROM usuarios WHERE username == $username LIMIT 1;";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();

        // Verificar si funciona esto
        $_SESSION['tipo'] = $data[0][0];
    ?>

<?php include '../templates/footer.html' ?>
