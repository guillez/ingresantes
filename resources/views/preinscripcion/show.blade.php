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
			<div class="form-group col-md-6"><strong>Nombre: </strong> {{ $preinscripcion->nombre }}</div>
			<div class="form-group col-md-6"><strong>Apellido: </strong> {{ $preinscripcion->apellido }}</div>	
			<div class="form-group col-md-6"><strong>Fecha de nacimiento: </strong> {{ $preinscripcion->fechanacimiento }}</div>					
			<div class="form-group col-md-6"><strong>Nro. documento: </strong> {{ $preinscripcion->dni }}</div>										
		</div>

        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN DE CONTACTO</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-6"><strong>E-mail: </strong> {{ $preinscripcion->email }}</div>
			<div class="form-group col-md-3"><strong>Telefono: </strong> 
			@if ($preinscripcion->telefonofijocar != 0)
				{{ $preinscripcion->telefonofijocar }}-{{ $preinscripcion->telefonofijonum }}
			@else
				{{ $preinscripcion->telefonofijonum }}
			@endif
			</div>
			<div class="form-group col-md-3"><strong>Celular: </strong> 
			@if ($preinscripcion->celularcar != 0)
				{{ $preinscripcion->celularcar }}-{{ $preinscripcion->celularnum }}
			@else
				{{ $preinscripcion->celularnum }}
			@endif
			</div>
		</div>	

        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN SOBRE LUGAR</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-6"><strong>Dirección: </strong> {{ $preinscripcion->direccion }}</div>	
			<div class="form-group col-md-6"><strong>Ciudad: </strong> {{ $ciudad }}</div>	
		</div>		

        <div class="panel-heading">
        <h3 class="panel-title">INFORMACIÓN ACADÉMICA</h3>
        </div>
        <div class="panel-body">    
			<div class="form-group col-md-6"><strong>Carrera de interés: </strong> {{ $carrera }}</div>	
			<div class="form-group col-md-6"><strong>Estudios previos: </strong> {{ $estudiosprevios }}</div>
			<div class="form-group col-md-6"><strong>¿Pertenece a la comunidad de la UCU?: </strong> {{ $perteneceucu }}</div>	
			<div class="form-group col-md-6"><strong>Sede de interés: </strong> {{ $sede }}</div>								
		</div>					
	</div>

	{{ Form::model($preinscripcion, array('action' => array('BasicPreInscripcionController@update', $preinscripcion->id), 'method' => 'delete', 'class' => 'delete')) }}
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