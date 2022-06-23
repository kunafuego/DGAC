<?php
    
    function obtenerCiudades($tipo) {
        require("config/connection.php");
        
        if ($tipo == 'origen'){
            $query = "SELECT DISTINCT aerodromo_salida_id FROM propuestas WHERE estado = 'aceptado';";
            
        } elseif ($tipo == 'destino') {
            $query = "SELECT DISTINCT aerodromo_llegada_id FROM propuestas WHERE estado = 'aceptado';";
        }

        $result = $db -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        
        $id_aerodromos = [];
            foreach ($data as $d) {
                array_push($id_aerodromos, $d[0]);
        }
        
        // Para transformarlo en un string separado por comas
        $id_aerodromos = implode (", ", $id_aerodromos);

        $query2 = "SELECT nombre_ciudad FROM aerodromos WHERE id IN (" . $id_aerodromos . ");";
        $result2 = $db -> prepare($query2);
        $result2 -> execute();
        $data2 = $result2 -> fetchAll();
        
        $ciudades = [];
            foreach ($data2 as $d) {
                array_push($ciudades, $d[0]);
        }

        return $ciudades;
    }

?>