
<?php
   
    function returnTipo($username, $passwordd) {
        require("../config/connection.php");

        $query = "SELECT tipo, CAST(contraseña as text) FROM usuarios WHERE username = '$username' LIMIT 1;";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        
        // Verificar si funciona esto
        if ($data[0]['tipo'] == null){
            return [];
        } else {
            $tipo = $data[0]['tipo'];
            $contrasena = $data[0]['contraseña'];
        }
        

        if ($contrasena == $passwordd) {
            return $tipo;
        } else {
            return [];
        }
    }

?>


