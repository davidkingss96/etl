<div class="box box-info padding-1">
    <div class="box-body">
        <div style="display:none">
            {{Form::text('id', $cliente->id, ['id' => 'id'])}}
        </div>
        <div class="form-group">
            {{ Form::label('identificacion') }}
            {{ Form::text('identificacion', $cliente->identificacion, ['class' => 'form-control' . ($errors->has('identificacion') ? ' is-invalid' : ''), 'placeholder' => 'Identificacion']) }}
            {!! $errors->first('identificacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $cliente->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('apellido') }}
            {{ Form::text('apellido', $cliente->apellido, ['class' => 'form-control' . ($errors->has('apellido') ? ' is-invalid' : ''), 'placeholder' => 'Apellido']) }}
            {!! $errors->first('apellido', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('genero') }}
            <select class="form-select" aria-label="Default select example" name="genero" id="genero">
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
        </div>
        <div class="form-group">
            {{ Form::label('fecha-nacimiento') }}
            {{ Form::date('fecha-nacimiento', $cliente->{"fecha-nacimiento"}, ['class' => 'form-control' . ($errors->has('fecha-nacimiento') ? ' is-invalid' : '')]) }}
            {!! $errors->first('fecha-nacimiento', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>