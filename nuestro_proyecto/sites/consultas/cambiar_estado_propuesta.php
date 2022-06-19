<?php
    require("../config/connection.php");

    $id = intval( $_POST["id"] );
    $nuevo_estado = $_POST ["nuevo_estado"]

    // Para la base de datos par
    $query =   "UPDATE planes_de_vuelo
                SET estado = $nuevo_estado
                WHERE id = $id;";

    $result = $db -> prepare($query);
    $result -> execute();

    // Para la base de datos impar
?>