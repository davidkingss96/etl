<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\TXTController;
use App\Http\Controllers\Clientes;

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

        $clientesTXT = TXTController::leerClientes();
        
        $clientes = array_merge($clientesCSV, $clientesTXT, $clientesMysql);

        $clientes = Clientes::agregarEdad($clientes);

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
        $request->request->set('nombre', strtoupper($request->nombre));
        $request->request->set('apellido', strtoupper($request->apellido));
        if($request->origen == "mysql"){
            $cliente = Cliente::create($request->all());
        }else if($request->origen == "csv"){
            CSVController::crearCliente($request->all());
        }else if($request->origen == "txt"){
            TXTController::crearCliente($request->all());
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
                $cliente = TXTController::verCliente($id);
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
                $cliente = TXTController::verCliente($id);
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
        $request->request->set('nombre', strtoupper($request->nombre));
        $request->request->set('apellido', strtoupper($request->apellido));
        if(str_contains($request->id, "-")){
            $idExplode = explode("-", $request->id);
            $origen = $idExplode[1];
            if($origen == "csv"){
                CSVController::editarCliente($request->all());
            }else if($origen == "txt"){
                TXTController::editarCliente($request->all());
            }
        }else{
            $data = $request->all();
            $cliente = Cliente::find($request->id);
            $cliente->identificacion = $request->identificacion;
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->genero = $request->genero;
            $cliente->{'fecha-nacimiento'} = $request->{'fecha-nacimiento'};
            $cliente->save();
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
                $cliente = TXTController::updateDeleteRow($id);
            }
        }else{
            $cliente = Cliente::find($id)->delete();
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente deleted successfully');
    }
}
