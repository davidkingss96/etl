<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Clientes extends Controller
{
    public function agregarEdad($data){
        $data1 = array();
        foreach($data as $row){
            $nacimiento = new \DateTime($row["fecha-nacimiento"]);
            $hoy = new \DateTime();
            $edad = $hoy->diff($nacimiento)->y;
            $row["edad"] = $edad;
            $row["clasificacion"] = Clientes::clasificar($edad);
            array_push($data1, $row);
        }
        return $data1;
    }

    public function clasificar($clienteEdad){
        if($clienteEdad < 8){
            return "Niño";
        }else if($clienteEdad <= 16){
            return "Adolecente";
        }else if($clienteEdad <= 36){
            return "Casi Cucho";
        }else{
            return "Cucho";
        }
    }
}
