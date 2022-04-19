@extends('layouts.app')

@section('template_title')
    Cliente
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Cliente') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        
										<th>Identificacion</th>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>Genero</th>
										<th>Fecha-Nacimiento</th>
										<th>Edad</th>
										<th>Clasificacion</th>
										<th>Origen</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            
											<td>{{ $cliente["identificacion"] }}</td>
											<td>{{ $cliente["nombre"] }}</td>
											<td>{{ $cliente["apellido"] }}</td>
											<td>{{ $cliente["genero"] }}</td>
											<td>{{ explode(" ", $cliente["fecha-nacimiento"])[0] }}</td>
											<td>{{ $cliente["edad"] }}</td>
											<td>{{ $cliente["clasificacion"] }}</td>
											<td>{{ isset($cliente["origen"]) ? $cliente["origen"] : "MySQL" }}</td>

                                            <td>
                                                <form action="{{ route('clientes.destroy',$cliente['id']) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('clientes.show',$cliente['id']) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('clientes.edit',$cliente['id']) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
