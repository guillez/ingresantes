@extends('adminlte::page')

@section('title','Mostrar Pre-inscripción')
@section('content_header','Mostrar Pre-inscripción')

@section('content')
    @include('alerts.success')
    @include('alerts.errors')
    <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN PERSONAL</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-6"><strong>Nombre: </strong> {{ $contacto->nombre }}</div>
			<div class="form-group col-md-6"><strong>Apellido: </strong> {{ $contacto->apellido }}</div>										
		</div>

        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN DE CONTACTO</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-6"><strong>E-mail: </strong> {{ $contacto->email }}</div>
			<div class="form-group col-md-3"><strong>Telefono: </strong> 
			@if ($contacto->telefonofijocar != 0)
				{{ $contacto->telefonofijocar }}-{{ $contacto->telefonofijonum }}
			@else
				{{ $contacto->telefonofijonum }}
			@endif
			</div>
			<div class="form-group col-md-3"><strong>Celular: </strong> 
			@if ($contacto->celularcar != 0)
				{{ $contacto->celularcar }}-{{ $contacto->celularnum }}
			@else
				{{ $contacto->celularnum }}
			@endif
			</div>
		</div>	

        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN SOBRE LUGAR</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-6"><strong>Dirección: </strong> {{ $contacto->direccion }}</div>	
			<div class="form-group col-md-6"><strong>Ciudad: </strong> {{ $ciudad }}</div>	
		</div>		

        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN ACADÉMICA</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-12"><strong>Carrera de interés: </strong> {{ $carrera }}</div>								  
			<div class="form-group col-md-12"><strong>Consulta: </strong> {{ $contacto->consulta }}</div>								
		</div>							
	</div>

	{{ Form::model($contacto, array('action' => array('BasicContactoController@update', $contacto->id), 'method' => 'delete', 'class' => 'delete')) }}
	<div class="form-group col-md-12" align="center">
	{!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'confirmation', 'data-title' => 'Esta seguro?', 'autocomplete' => 'off']) !!}
	</div>
	{{ Form::close() }}
@endsection

@section('js')
<script>
$('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
});
</script> 
@endsection