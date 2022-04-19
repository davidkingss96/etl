@extends('layouts.app')

@section('template_title')
    Update Cliente
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Cliente</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('clientes-test') }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('cliente.form')

                        </form>
                        <script>
                        var origen = (document.getElementById("id").value).split("-");
                        
                        if(origen[1] == "csv"){
                            updateSelect("Hombre", "Mujer");
                        }else if(origen[1] == "txt"){
                            updateSelect("Masculino", "Femenino");
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
