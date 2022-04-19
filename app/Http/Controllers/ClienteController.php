<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\CSVController;

/**
 * Class ClienteController
 * @package App\Http\Controllers
 */
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientesMysql = Cliente::get()->toArray();

        $clientesCSV = CSVController::leerClientes();
        
        $clientes = array_merge($clientesCSV, $clientesMysql);

        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = new Cliente();
        return view('cliente.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Cliente::$rules);
        if($request->origen == "mysql"){
            $cliente = Cliente::create($request->all());
        }else if($request->origen == "csv"){
            CSVController::crearCliente($request->all());
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(str_contains($id, "-")){
            $idExplode = explode("-", $id);
            $origen = $idExplode[1];
            if($origen == "csv"){
                $cliente = CSVController::verCliente($id);
            }else if($origen == "txt"){
                return "Leer como TXT";
            }
        }else{
            $cliente = Cliente::find($id);
        }
        

        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(str_contains($id, "-")){
            $idExplode = explode("-", $id);
            $origen = $idExplode[1];
            if($origen == "csv"){
                $cliente = CSVController::verCliente($id);
            }else if($origen == "txt"){
                return "Leer como TXT";
            }
        }else{
            $cliente = Cliente::find($id);
        }

        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        request()->validate(Cliente::$rules);

        if(str_contains($request->id, "-")){
            $idExplode = explode("-", $request->id);
            $origen = $idExplode[1];
            if($origen == "csv"){
                CSVController::editarCliente($request->all());
            }else if($origen == "txt"){
                return "Leer como TXT";
            }
        }else{
            $cliente->update($request->all());
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if(str_contains($id, "-")){
            $idExplode = explode("-", $id);
            $origen = $idExplode[1];
            if($origen == "csv"){
                $cliente = CSVController::updateDeleteRow($id);
            }else if($origen == "txt"){
                return "Leer como TXT";
            }
        }else{
            $cliente = Cliente::find($id)->delete();
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente deleted successfully');
    }
}
