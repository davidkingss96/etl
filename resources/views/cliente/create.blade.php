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
                                <select class="form-select" aria-label="Default select example" name="origen">
                                    <option value="mysql">MySQL</option>
                                    <option value="csv">CSV</option>
                                    <option value="txt">TXT</option>
                                </select>
                            </div>

                            @include('cliente.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
