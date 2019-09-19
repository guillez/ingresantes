@extends('layouts.app')

@section('title', 'Formulario de Pre-Inscripción')

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
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('content')

{{ Form::open([
    'route' => 'preinscripcion.store',
    'class' => 'ui-form',
    'method' => 'POST',
    'id'=>'formIns',
    'name'=>'formIns'       
]) }}
    {!! Form::hidden('estado', 0) !!}
    <div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading" align="center">
            <img src="/img/Formulario_PreInscripcion.png" alt="Formulario de PreInscripción"> 
        </div>     
        <div class="panel-heading">
            <h3 class="panel-title">Completá el formulario y nos comunicaremos con vos a la brevedad.</h3>
        </div>    
        @include('alerts.success')
        @include('alerts.errors')
        <div class="panel-heading">
            <h3 class="panel-title">INFORMACIÓN PERSONAL</h3>
        </div>
        <div class="panel-body">
            <div class="form-group col-md-3">
            {!! Form::label('nombre', 'Nombre:', ['class' => 'control-label']) !!}            
            {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-3">
            {!! Form::label('apellido', 'Apellido:', ['class' => 'control-label']) !!}
            {!! Form::text('apellido', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-3">
            {!! Form::label('fechanacimiento', 'Fecha de nacimiento:', ['class' => 'control-label ']) !!}
                <div class="input-group date">
                {!! Form::text('fechanacimiento', '', ['id' => 'datepicker', 'class' => 'form-control datepicker']) !!}<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div> 

            <div class="form-group col-md-3">
            {!! Form::label('dni', 'Número de documento:', ['class' => 'control-label']) !!}
            {!! Form::text('dni',  null, ['class' => 'form-control']) !!}
            </div>                 
        </div>
        <div class="panel-heading">
            <h3 class="panel-title">INFORMACIÓN DE CONTACTO</h3>
        </div>    
        <div class="panel-body">
            <div class="form-group col-md-6">
            {!! Form::label('email', 'E-mail:', ['class' => 'control-label']) !!}            
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-1">
            {!! Form::label('telefonofijocar', 'Teléfono:', ['class' => 'control-label']) !!}
            {!! Form::text('telefonofijocar', null, ['class' => 'form-control', 'maxlength' => '5']) !!}
            </div>     
            <div class="form-group col-md-2">
            {!! Form::label('telefonofijonum', '&nbsp;', ['class' => 'control-label']) !!}
            {!! Form::text('telefonofijonum', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
            </div>            
            <div class="form-group col-md-1">
            {!! Form::label('celularcar', 'Celular:', ['class' => 'control-label']) !!}
            {!! Form::text('celularcar', null, ['class' => 'form-control']) !!}
            </div>   
            <div class="form-group col-md-2">
            {!! Form::label('celularnum', '&nbsp;', ['class' => 'control-label']) !!}
            {!! Form::text('celularnum', null, ['class' => 'form-control']) !!}
            </div>               
        </div>
        <div class="panel-heading">
            <h3 class="panel-title">INFORMACIÓN SOBRE LUGAR</h3>
        </div>    
        <div class="panel-body">
            <div class="form-group col-md-3">
            {!! Form::label('direccion', 'Dirección:', ['class' => 'control-label']) !!}            
            {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-3">
            {!! Form::label('fk_pais_id', 'País:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_pais_id',$paises,null,['id'=>'fk_pais_id', 'class' => 'form-control']) !!}           
            </div>

            <div class="form-group col-md-3">
            {!! Form::label('fk_provincia_id', 'Provincia:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_provincia_id',$provincias,null,['id'=>'fk_provincia_id', 'class' => 'form-control']) !!}           
            </div>

            <div class="form-group col-md-3">
            {!! Form::label('fk_ciudad_id', 'Ciudad:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_ciudad_id',$ciudades,null,['id'=>'fk_ciudad_id', 'class' => 'form-control']) !!}           
            </div>            
        </div>
        <div class="panel-heading">
            <h3 class="panel-title">INFORMACIÓN ACADÉMICA</h3>
        </div>    
        <div class="panel-body">
            <div class="form-group col-md-3">
            {!! Form::label('fk_planestudio_id', 'Carrera de interés:', ['class' => 'control-label']) !!} 
            {!! Form::select('fk_planestudio_id',$carreras,null,['id'=>'fk_planestudio_id', 'class' => 'form-control']) !!}           
            </div>

            <div class="form-group col-md-3">
            {!! Form::label('fk_estudioprevio_id', 'Estudios previos:', ['class' => 'control-label']) !!}
            {!! Form::select('fk_estudioprevio_id',$estudiosprevios,null,['id'=>'fk_estudioprevio_id', 'class' => 'form-control']) !!}   
            </div> 
            
            <div class="form-group col-md-3">
            {!! Form::label('perteneceucu', '¿Pertenece a la comunidad UCU?:', ['class' => 'control-label']) !!}
            {!! Form::select('perteneceucu',$perteneceucu,null,['class' => 'form-control']) !!} 
            </div> 

            <div class="form-group col-md-3">
            {!! Form::label('fk_sede_id', 'Sede de interés:', ['class' => 'control-label']) !!}
            {!! Form::select('fk_sede_id',$sedes,null,['id'=>'fk_sede_id', 'class' => 'form-control']) !!} 
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
$("#datepicker").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true
});

$(function() {
    // Validacion de formulario Orden de Pago
    $('#formIns').validate({
        ignore: "not:hidden",
        errorClass: "error",      
        rules: {
            nombre: { required: true },
            apellido: { required: true },
            fechanacimiento: { required: true, dateFormat: true },
            dni: { required: true, digits: true },
            email: { required: true, email: true },
            telefonofijonum: { required: true, digits: true },
            celularnum: { required: true, digits: true },
            direccion: { required: true }
        },
        messages: {
            nombre: { required: "Requerido" },
            apellido: { required: "Requerido" },
            fechanacimiento: { required: "Requerido" },
            dni: { required: "Requerido", digits: "Debe ser númerico" },
            email: { required: "Requerido", email: "Debe ser formato e-mail" },
            telefonofijonum: { required: "Requerido", digits: "Debe ser númerico" },
            celularnum: { required: "Requerido", digits: "Debe ser númerico" },
            direccion: { required: "Requerido" }
        }
    });

    $('#fk_planestudio_id').on('change', function() {
        $.get('../../preinscripcion/getsedes/'+$("#fk_planestudio_id").val(), function(res, sta){
            $("#fk_sede_id").empty();      
            res.forEach(element => {
                $("#fk_sede_id").append(`<option value=${element.idsede}> ${element.nombre} </option>`);
            });
        });
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
$.validator.addMethod("dateFormat",
   function(value, element) {
        // put your own logic here, this is just a (crappy) example
        return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
    },
    "Debe ser formato dd-mm-aaaa");
</script>
@endsection