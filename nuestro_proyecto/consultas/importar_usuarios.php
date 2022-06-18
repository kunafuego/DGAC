<?php include('../templates/header.html'); ?>

    <?php
        require("../config/conection.php");
        $query = "SELECT * FROM importar_usuario;";
        $result = $db -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
    ?>

// <section class="section">
//     <?php
//         foreach ($data as $d) {
//             echo "<h1>EL ganador es: $d[0] !</h1> <p> Venció a su contrincante luego de $d[1] ataques </p>";
//         }
//     ?>
// </section>

<?php include '../templates/footer.html' ?>
