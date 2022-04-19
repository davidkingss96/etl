@extends('layouts.app')

@section('template_title')
    Create Cliente
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Cliente</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('clientes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                {{ Form::label('origen') }}
                                <select class="form-select" aria-label="Default select example" name="origen" id="origen" onchange="updateGeneros()">
                                    <option value="mysql">MySQL</option>
                                    <option value="csv">CSV</option>
                                    <option value="txt">TXT</option>
                                </select>
                            </div>

                            @include('cliente.form')

                        </form>

                        <script>
                        function updateGeneros(){
                            var origen = document.getElementById("origen").value;
                            switch(origen){
                                case "txt":
                                    updateSelect("Masculino", "Femenino");
                                    break;
                                case "csv":
                                    updateSelect("Hombre", "Mujer");
                                    break;
                                default:
                                    updateSelect("Macho", "Hembra");
                                    break;
                            }
                        }

                        function updateSelect(h, m){
                            var selectobject = document.getElementById("genero");
                            removeOptions(selectobject)
                            var option = new Option(h, h);
                            var option1 = new Option(m, m);
                            selectobject.appendChild(option);
                            selectobject.appendChild(option1);
                        }

                        function removeOptions(selectElement) {
                            var i, L = selectElement.options.length - 1;
                            for(i = L; i >= 0; i--) {
                                selectElement.remove(i);
                            }
                        }
                            
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
