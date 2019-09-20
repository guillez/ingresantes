@extends('layouts.app')

@section('title', 'Formulario de Contacto')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : ''))

@section('content')

{{ Form::open([
    'route' => 'contacto.store',
    'class' => 'ui-form',
    'method' => 'POST',
    'id'=>'formIns',
    'name'=>'formIns'       
]) }}
    {!! Form::hidden('estado', 0) !!}
    <div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading" align="center">
            <img src="/img/Formulario_Contacto.png" alt="Formulario de Contacto"> 
        </div>     
        <div class="panel-heading">
            <h3 class="panel-title">Completá el formulario y recibí información sobre tu carrera.</h3>
        </div>    
        @include('alerts.success')
        @include('alerts.errors')
        <div class="panel-body">
            <div class="form-group col-md-6">
            {!! Form::label('nombre', 'Nombre:', ['class' => 'control-label']) !!}            
            {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-6">
            {!! Form::label('apellido', 'Apellido:', ['class' => 'control-label']) !!}
            {!! Form::text('apellido', null, ['class' => 'form-control']) !!}
            </div>   

            <div class="form-group col-md-4">
            {!! Form::label('email', 'E-mail:', ['class' => 'control-label']) !!}            
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-1">
            {!! Form::label('telefonofijocar', 'Teléfono:', ['class' => 'control-label']) !!}
            {!! Form::text('telefonofijocar', null, ['class' => 'form-control', 'maxlength' => '5']) !!}
            </div>     

            <div class="form-group col-md-3">
            {!! Form::label('telefonofijonum', '&nbsp;', ['class' => 'control-label']) !!}
            {!! Form::text('telefonofijonum', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
            </div>       

            <div class="form-group col-md-1">
            {!! Form::label('celularcar', 'Celular:', ['class' => 'control-label']) !!}
            {!! Form::text('celularcar', null, ['class' => 'form-control']) !!}
            </div>  

            <div class="form-group col-md-3">
            {!! Form::label('celularnum', '&nbsp;', ['class' => 'control-label']) !!}
            {!! Form::text('celularnum', null, ['class' => 'form-control']) !!}
            </div>   

            <div class="form-group col-md-4">
            {!! Form::label('fk_pais_id', 'País:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_pais_id',$paises,null,['id'=>'fk_pais_id', 'class' => 'form-control']) !!}           
            </div>

            <div class="form-group col-md-4">
            {!! Form::label('fk_provincia_id', 'Provincia:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_provincia_id',$provincias,null,['id'=>'fk_provincia_id', 'class' => 'form-control']) !!}           
            </div>

            <div class="form-group col-md-4">
            {!! Form::label('fk_ciudad_id', 'Ciudad:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_ciudad_id',$ciudades,null,['id'=>'fk_ciudad_id', 'class' => 'form-control']) !!}           
            </div> 
                
            <div class="form-group col-md-6">
            {!! Form::label('fk_planestudio_id', 'Carrera de interés:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_planestudio_id',$carreras,null,['id'=>'fk_planestudio_id', 'class' => 'form-control']) !!}           
            </div>
            <div class="form-group col-md-6">
            {!! Form::label('consulta', 'Consulta:', ['class' => 'control-label']) !!} 
            {!! Form::textarea('consulta', null, ['id'=>'consulta', 'class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}         
            </div>                 
        </div>

        <div class="panel-body">
            <div class="form-group col-md-12" align="center">  
                <button type="submit" name="action" value="save" class="btn btn-warning">Enviar</button>
            </div>   
            <div class="form-group col-md-12" align="center">Se enviará una copia de tus respuestas por correo electrónico a la dirección de e-mail que has proporcionado en el presente formulario.</div>               
        </div>    
    </div>
    </div>
{{ Form::close() }}
@endsection
@section('adminlte_js')
<script>
$(function() {
    // Validacion de formulario Orden de Pago
    $('#formIns').validate({
        ignore: "not:hidden",
        errorClass: "error",      
        rules: {
            nombre: { required: true },
            apellido: { required: true },
            email: { required: true, email: true },
            telefonofijonum: { required: true, digits: true },
            celularnum: { required: true, digits: true },
            consulta: { required: true }
        },
        messages: {
            nombre: { required: "Requerido" },
            apellido: { required: "Requerido" },
            email: { required: "Requerido", email: "Debe ser formato e-mail" },
            telefonofijonum: { required: "Requerido", digits: "Debe ser númerico" },
            celularnum: { required: "Requerido", digits: "Debe ser númerico" },
            consulta: { required: "Requerido" }            
        }
    });

    $('#fk_pais_id').on('change', function() {
        $.get('../../preinscripcion/getprovincias/'+$("#fk_pais_id").val(), function(res, sta){
            $("#fk_provincia_id").empty();      
            res.forEach(element => {
                $("#fk_provincia_id").append(`<option value=${element.idprovincia}> ${element.descripcion} </option>`);
            });
            $.get('../../preinscripcion/getciudades/'+$("#fk_provincia_id").val(), function(res, sta){
                $("#fk_ciudad_id").empty();      
                res.forEach(element => {
                    $("#fk_ciudad_id").append(`<option value=${element.idciudad}> ${element.descripcion} </option>`);
                });
            });            
        });
    });

    $('#fk_provincia_id').on('change', function() {
        $.get('../../preinscripcion/getciudades/'+$("#fk_provincia_id").val(), function(res, sta){
            $("#fk_ciudad_id").empty();      
            res.forEach(element => {
                $("#fk_ciudad_id").append(`<option value=${element.idciudad}> ${element.descripcion} </option>`);
            });
        });
    });
});

$(document).ready(function() {
    $.get('../../preinscripcion/getsedes/'+$("#fk_planestudio_id").val(), function(res, sta){
        $("#fk_sede_id").empty();      
        res.forEach(element => {
            $("#fk_sede_id").append(`<option value=${element.idsede}> ${element.nombre} </option>`);
        });
    });    
    
    $('#fk_pais_id').val(1);
    $.get('../../preinscripcion/getprovincias/'+$("#fk_pais_id").val(), function(res, sta){
        $("#fk_provincia_id").empty();      
        res.forEach(element => {
            $("#fk_provincia_id").append(`<option value=${element.idprovincia}> ${element.descripcion} </option>`);
        });
        $('#fk_provincia_id').val(5);
        $.get('../../preinscripcion/getciudades/'+$("#fk_provincia_id").val(), function(res, sta){
            $("#fk_ciudad_id").empty();      
            res.forEach(element => {
                $("#fk_ciudad_id").append(`<option value=${element.idciudad}> ${element.descripcion} </option>`);
            });
            $('#fk_ciudad_id').val(734);                   
        });        
    }); 
});
</script>
@endsection