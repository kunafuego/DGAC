<?php
    
    function obtenerNombreAerodromo($id) {
        require("config/connection.php");
        
        $query = "SELECT nombre, nombre_ciudad FROM aerodromos WHERE id = '$id';";
        $result = $db -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        
        $data = [$data[0][0], $data[0][1]];
        
        return $data;
    }

?>