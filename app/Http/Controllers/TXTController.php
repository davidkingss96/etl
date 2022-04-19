<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TXTController extends Controller
{
    public function leerClientes(){
        $delimiter = ",";
        $txt = new TXTController;
        $data = $txt->txtToArray(storage_path('app/public/Clients.txt'));

        return($data);
    }

    public function maxId(){
        $txt = new TXTController;
        $data = $txt->leerClientes();
        $max = 0;
        foreach($data as $row){
            $id = explode("-", $row["id"])[0];
            if($id > $max){
                $max = $id;
            }
        }
        return $max + 1;
    }

    public function updateDeleteRow($id){
        $csv = new TXTController;
        $dataSinFila = $csv->deleteRow($id);
        $fp = fopen(storage_path('app/public/Clients.txt'), 'w');
        $first = true;
        foreach ($dataSinFila as $fields) {
            unset($fields["origen"]);
            if($first){
                fwrite($fp, implode("|", array_keys($fields)));
                fwrite ($fp, "\n");
                $first = false;
            }
            fwrite($fp, implode("|", $fields));
            fwrite ($fp, "\n");
        }
    }

    public function editarCliente($data){
        $txt = new TXTController;
        $dataSinFila = $txt->deleteRow($data["id"]);
        unset($data["_method"]);
        unset($data["_token"]);
        array_unshift($dataSinFila, array_keys($data), $data);
        $fp = fopen(storage_path('app/public/Clients.txt'), 'w');
        foreach ($dataSinFila as $fields) {
            unset($fields["origen"]);
            fwrite($fp, implode("|", $fields));
            fwrite ($fp, "\n");
        }
    }

    public function deleteRow($id){
        $txt = new TXTController;
        $data = $txt->leerClientes();
        $data2 = array();
        foreach($data as $row){
            if($row["id"] != $id){
                array_push($data2, $row);
            }
        }
        return $data2;
    }


    public function verCliente($id){
        $txt = new TXTController;
        $data = $txt->leerClientes();
        foreach($data as $row){
            if($row["id"] == $id){
                return (object) $row;
            }
        }
    }

    public function crearCliente($data){
        unset($data["origen"]);
        unset($data["_token"]);
        $txt = new TXTController;
        $dataTotal = $txt->leerClientes();
        $id = $txt->maxId() . "-txt";
        $data["id"] = $id;
        $fp = fopen(storage_path('app/public/Clients.txt'), 'w');
        $first = true;
        foreach ($dataTotal as $fields) {
            unset($fields["origen"]);
            if($first){
                fwrite($fp, implode("|", array_keys($fields)));
                fwrite ($fp, "\n");
                $first = false;
            }
            fwrite($fp, implode("|", $fields));
            fwrite ($fp, "\n");
        }
        fwrite($fp, implode("|", $data));
        fwrite ($fp, "\n");
    }

    public function txtToArray($path)
    {
        try{
            $txt = fopen($path, 'r');
            $rows = [];
            $header = [];
            $index = 0;
            while (($line = fgetcsv($txt, 0, "|")) !== FALSE) {
                if ($index == 0) {
                    $header = $line;
                    $index = 1;
                } else {
                    $row = [];
                    for ($i = 0; $i < count($header); $i++) {
                        if(count($line) > 1){
                            $row[$header[$i]] = $line[$i];
                        }
                    }
                    if(!empty($row)){
                        $row["origen"] = "TXT";
                        array_push($rows, $row);
                    }
                }
            }
            return $rows;
        }catch (Exception $exception){
            return false;
        }
    }
}
