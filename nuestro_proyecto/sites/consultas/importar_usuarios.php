<?php include('../templates/header.html'); ?>

    <?php
        require("../config/connection.php");
        $query = "SELECT importar_usuario();";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
    ?>

<?php include('../templates/footer.html') ?>
