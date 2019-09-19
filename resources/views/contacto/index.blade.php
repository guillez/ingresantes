@extends('adminlte::page')

@section('title', 'Formulario de Contacto')
@section('content_header','Formulario de Contacto')

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
    @include('alerts.success')
    @include('alerts.errors')
    
    <table class="table table-bordered table-hover" style="width:100%" id="info-table">
        <thead>
            <th width="30%">Apellido</th>
            <th width="30%">Nombre</th>
            <th>Carrera</th>
            <th>Sede</th>            
            <th>Acciones</th>
        </thead>
    </table>
    
@endsection

@section('js')
<script>
$(function() {
    $('#info-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 10,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        ajax: '{!! route('contacto.data') !!}',
        columns: [
            { data: 'apellido', name: 'apellido' },
            { data: 'nombre', name: 'nombre' },
            { data: 'carrera', name: 'carrera' },
            { data: 'sede', name: 'sede' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});
</script>
@endsection