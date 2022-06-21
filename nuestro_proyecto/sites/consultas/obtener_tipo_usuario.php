
<?php
   
    function returnTipo($username) {
        require("config/connection.php");

        $query = "SELECT * FROM usuarios WHERE username = '$username' LIMIT 1;";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();

        // Verificar si funciona esto
        $tipo = $data[0]['tipo'];
        return $tipo;
    }

?>


