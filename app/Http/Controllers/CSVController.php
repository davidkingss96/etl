<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVController extends Controller
{
    //Retorna array con la lista de clientes
    public function leerClientes(){
        $delimiter = ",";
        $csv = new CSVController;
        $data = $csv->csvToArray(storage_path('app/public/Clients.csv'));

        return($data);
    }

    public function maxId(){
        $csv = new CSVController;
        $data = $csv->leerClientes();
        $max = 0;
        foreach($data as $row){
            $id = explode("-", $row["id"])[0];
            if($id > $max){
                $max = $id;
            }
        }
        return $max + 1;
    }

    public function verCliente($id){
        $csv = new CSVController;
        $data = $csv->leerClientes();
        foreach($data as $row){
            if($row["id"] == $id){
                return (object) $row;
            }
        }
    }

    public function crearCliente($data){
        unset($data["origen"]);
        unset($data["_token"]);
        $csv = new CSVController;
        $dataTotal = $csv->leerClientes();
        $id = $csv->maxId() . "-csv";
        $data["id"] = $id;
        $fp = fopen(storage_path('app/public/Clients.csv'), 'w');
        $first = true;
        foreach ($dataTotal as $fields) {
            unset($fields["origen"]);
            if($first){
                fputcsv($fp, array_keys($fields));
                $first = false;
            }
            fputcsv($fp, $fields);
        }
        fputcsv($fp, $data);
    }

    public function editarCliente($data){
        $csv = new CSVController;
        $dataSinFila = $csv->deleteRow($data["id"]);
        unset($data["_method"]);
        unset($data["_token"]);
        array_unshift($dataSinFila, array_keys($data), $data);
        $fp = fopen(storage_path('app/public/Clients.csv'), 'w');
        foreach ($dataSinFila as $fields) {
            unset($fields["origen"]);
            fputcsv($fp, $fields);
        }
    }

    public function updateDeleteRow($id){
        $csv = new CSVController;
        $dataSinFila = $csv->deleteRow($id);
        $fp = fopen(storage_path('app/public/Clients.csv'), 'w');
        $first = true;
        foreach ($dataSinFila as $fields) {
            unset($fields["origen"]);
            if($first){
                fputcsv($fp, array_keys($fields));
                $first = false;
            }
            fputcsv($fp, $fields);
        }
    }

    public function deleteRow($id){
        $csv = new CSVController;
        $data = $csv->leerClientes();
        $data2 = array();
        foreach($data as $row){
            if($row["id"] != $id){
                array_push($data2, $row);
            }
        }
        return $data2;
    }

    public function csvToArray($path)
    {
        try{
            $csv = fopen($path, 'r');
            $rows = [];
            $header = [];
            $index = 0;
            while (($line = fgetcsv($csv)) !== FALSE) {
                if ($index == 0) {
                    $header = $line;
                    $index = 1;
                } else {
                    $row = [];
                    for ($i = 0; $i < count($header); $i++) {
                        $row[$header[$i]] = $line[$i];
                    }
                    $row["origen"] = "CSV";
                    array_push($rows, $row);
                }
            }
            return $rows;
        }catch (Exception $exception){
            return false;
        }
    }
}
