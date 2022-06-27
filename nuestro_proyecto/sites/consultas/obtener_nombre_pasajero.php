<?php
    
    function obtenerNombrePasajero($pasaporte) {
        require("config/connection.php");
        
        $query = "SELECT nombre FROM pasajeros WHERE pasaporte = '$pasaporte';";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        
        $nombre = $data[0][0];
        
        return $nombre;
    }

?>